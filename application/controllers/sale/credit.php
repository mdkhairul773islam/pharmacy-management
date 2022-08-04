<?php

class Credit extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');

        // get all product
        $this->data['allProduct'] = get_result('stock', ['quantity >' => 0, 'trash' => 0], ['id', 'code', 'quantity', 'unit', 'name', 'batch_no', 'category', 'subcategory', 'generic_name'], '', 'name', 'asc');

        // get all supplier
        $this->data['allClient'] = get_result('parties', ['type' => 'client', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);
    }

    // show create form
    public function index()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        // get lase sale voucher no
        $this->data['last_voucher'] = get_last('saprecords', ['status' => 'sale'], 'voucher_no');
        
        $this->data['allParty'] = get_result('parties', ['trash'=>0]);
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        // $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/credit_sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // store data
    public function store()
    {
        if (!empty($_POST['save'])) {
            

            $party_balance = ($_POST['current_sign'] == 'Receivable' ? $_POST['current_balance'] : -$_POST['current_balance']);

            $due = $this->input->post('grand_total') - $this->input->post('paid');

            $data = [
                'sap_at'         => $this->input->post('date'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_bill'     => $this->input->post('grand_total'),
                'total_discount' => $this->input->post('total_discount'),
                'total_profit'   => $this->input->post('total_profit'),
                'party_balance'  => $party_balance,
                'paid'           => $this->input->post('paid'),
                'due'            => $due,
                'promise_date'   => (!empty($this->input->post('promise_date')) ? $this->input->post('promise_date') : null),
                'method'         => $this->input->post('method'),
                'status'         => 'sale',
                'sap_type'       => $this->input->post('stype'),
                'paid_type'      => $this->input->post('paid_type'),
            ];
            

            if ($this->input->post('stype') == "cash") {
                $data['address']    = json_encode($_POST['partyInfo']);
                $data['party_code'] = str_replace(" ", "_", trim($_POST['client_name']));
            } else {
                $data['party_code'] = $this->input->post('party_code');
            }

            // save record and return id
            $id = save_data('saprecords', $data, '', true);

            // generate voucher no
            $this->data['voucher_no'] = $voucher_no = get_voucher($id, 6);

            // update voucher no
            save_data('saprecords', ['voucher_no' => $voucher_no], ['id' => $id]);

            // insert sale item product records
            foreach ($_POST['id'] as $key => $value) {

                $data = [
                    'sap_at'         => $this->input->post('date'),
                    'stock_id'       => $value,
                    'voucher_no'     => $this->data['voucher_no'],
                    'product_code'   => $_POST['product_code'][$key],
                    'purchase_price' => $_POST['purchase_price'][$key],
                    'sale_price'     => $_POST['sale_price'][$key],
                    'quantity'       => $_POST['quantity'][$key],
                    'discount'       => $_POST['discount'][$key],
                    'profit'         => $_POST['profit'][$key],
                    'unit'           => $_POST['unit'][$key],
                    'status'         => 'sale',
                    'sap_type'       => $this->input->post('stype')
                ];

                if (save_data('sapitems', $data)) {
                    $this->handelStock($key);
                }
            }

            $this->handelPartyTransaction();
            $this->sapmeta();

            $msg = [
                'title' => 'success',
                'emit'  => 'Sale successfully Completed!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));

            redirect('sale/viewSale?vno=' . $this->data['voucher_no'], 'refresh');
        }

        redirect('sale/sale', 'refresh');
    }

    // handle stock
    private function handelStock($index)
    {
        $where = [
            'id' => $_POST['id'][$index],
        ];

        // get the product stock
        $stockInfo = get_row('stock', $where, 'quantity');

        // set the quantity
        $quantity = $stockInfo->quantity - $_POST['quantity'][$index];

        save_data('stock', ['quantity' => $quantity], $where);
    }

    // handle party transaction
    private function handelPartyTransaction()
    {
        $data = [
            'transaction_at'  => $this->input->post('date'),
            'credit'          => $this->input->post('paid'),
            'debit'           => $this->input->post('grand_total'),
            'transaction_via' => $this->input->post('method'),
            'relation'        => 'sales:' . $this->data['voucher_no'],
            'remark'          => 'sale',
            'status'          => 'sale',
        ];

        // fetch last insert record and increase by 1.
        if ($this->input->post('stype') != "cash") {
            $where      = array('party_code' => $this->input->post('code'));
            $last_sl    = $this->action->read_limit('partytransaction', $where, 'desc', 1);
            $voucher_sl = ($last_sl) ? ($last_sl[0]->serial + 1) : 1;

            $data['party_code'] = $this->input->post('party_code');
            $data['serial']     = $voucher_sl;
        } else {
            $data['party_code'] = str_replace(" ", "_", trim($_POST['client_name']));
            $data['serial']     = 1;
        }

        save_data('partytransaction', $data);
    }

    // store meta info
    private function sapmeta()
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'voucher_no' => $this->data['voucher_no'],
                    'meta_key'   => $key,
                    'meta_value' => $value
                );
                $this->action->add('sapmeta', $data);
            }
        }
        $data['voucher_no'] = $this->data['voucher_no'];
        $data['meta_key']   = 'sale_by';
        $data['meta_value'] = $this->data['name'];
        $this->action->add('sapmeta', $data);
    }

    // item wise search
    public function itemWise()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="wise"';
        $this->data['confirmation'] = null;
        $this->data['result']       = null;

        // get all product
        $this->data['productList'] = get_result('stock', ['trash' => 0], ['id', 'code', 'name', 'batch_no', 'category', 'subcategory'], '', 'name', 'asc');

        // product wise search
        if (isset($_POST['show'])) {

            $where                 = [
                'sapitems.status' => 'sale',
                'sapitems.trash' => 0,
            ];

            if (!empty($_POST['stock_id'])){
                $where['sapitems.stock_id'] = $_POST['stock_id'];
            }

            $select = ['sapitems.*', 'stock.name', 'stock.batch_no', 'stock.category', 'stock.subcategory'];
            $this->data['results'] = get_join('sapitems', 'stock', 'sapitems.stock_id=stock.id', $where, $select);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/itemWise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // send sms
    private function sendSMS()
    {
        if (isset($_POST['send_sms'])) {

            // make a product and quantity string
            $productArray = array();
            foreach ($_POST['product'] as $key => $value) {
                $productArray[] = $value . "(" . $_POST['quantity'][$key] . " " . $_POST['quantity'][$key] . " )";
            }

            $productStr = implode(', ', $productArray);

            //Sending SMS Start
            $sign    = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
            $content = "Your have purchased products of Tk: " . $this->input->post('grand_total') . ", Your Previous Balance was: " . $this->input->post('previous_balance') . " [ " . $this->input->post('previous_sign') . " ] " . ", Your current Balance is " . $this->input->post('current_balance') . " [ " . $this->input->post('current_sign') . " ] " . " . Regards JB Medicine";

            $num     = ($this->input->post('stype') == 'credit') ? $this->input->post("mobile") : $this->input->post("mobile_number");
            $message = send_sms($num, $content);

            if ($message) {

                $insert = [
                    'delivery_date'    => date('Y-m-d'),
                    'delivery_time'    => date('H:i:s'),
                    'mobile'           => $num,
                    'message'          => $content,
                    'total_characters' => strlen($content),
                    'total_messages'   => message_length(strlen($content), $message),
                    'delivery_report'  => $message
                ];

                save_data('sms_record', $insert);
            }
        }
    }
}
