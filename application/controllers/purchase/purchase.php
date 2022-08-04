<?php

class Purchase extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');

        // get all product
        $this->data['allProduct'] = get_result('products', ['status' => 'available'], ['product_code', 'product_name', 'product_cat']);

        // get all supplier
        $this->data['allParty'] = get_result('parties', ['type' => 'supplier', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);
    }

    // show create form
    public function index()
    {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // store data
    public function store()
    {
        if (isset($_POST['save'])) {

            // insert purchase items
            foreach ($_POST['product_name'] as $key => $value) {

                $data                   = [];
                $data['sap_at']         = $this->input->post('date');
                $data['voucher_no']     = $this->input->post('voucher_no');
                $data['product_code']   = $_POST['product_code'][$key];
                $data['purchase_price'] = $_POST['purchase_price'][$key];
                $data['sale_price']     = $_POST['sale_price'][$key];
                $data['quantity']       = $_POST['quantity'][$key];
                $data['unit']           = $_POST['unit'][$key];
                $data['status']         = 'purchase';

                // save item and return id
                $id = save_data('sapitems', $data, '', true);

                // handle stock
                $this->handelStock($key, $id);

                // handle order
                $this->handelOrder($key);
            }

            // get current balance
            $party_balance = ($_POST['current_sign'] == 'Receivable' ? $_POST['current_balance'] : -$_POST['current_balance']);

            // get voucher due
            $due = $this->input->post('grand_total') - $this->input->post('paid');


            // save sap record
            $data = [
                'sap_at'         => $this->input->post('date'),
                'voucher_no'     => $this->input->post('voucher_no'),
                'party_code'     => $this->input->post('party_code'),
                'total_bill'     => $this->input->post('grand_total'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_discount' => $this->input->post('total_discount'),
                'transport_cost' => $this->input->post('transport_cost'),
                'party_balance'  => $party_balance,
                'paid'           => $this->input->post('paid'),
                'due'            => ($due > 0 ? $due : 0),
                'method'         => $this->input->post('method'),
                'status'         => 'purchase',
            ];

            save_data('saprecords', $data);

            // handle party transaction
            $this->handelPartyTransaction();

            // handle meta info
            $this->sapmeta();

            // show flash message
            $msg = [
                'title' => 'success',
                'emit'  => 'Purchase successfully completed.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message("success", $msg));
        }

        redirect("purchase/purchase", "refresh");
    }

    // save party transaction info
    private function handelPartyTransaction()
    {

        // fetch last insert record and increase by 1.
        $where      = array('party_code' => $this->input->post('party_code'));
        $last_sl    = $this->action->read_limit('partytransaction', $where, 'desc', 1);
        $voucher_sl = ($last_sl) ? ($last_sl[0]->serial + 1) : 1;

        $data = [
            'transaction_at'  => $this->input->post('date'),
            'party_code'      => $this->input->post('party_code'),
            'credit'          => $this->input->post('grand_total'),
            'debit'           => $this->input->post('paid'),
            'transaction_via' => $this->input->post('method'),
            'relation'        => 'purchase:' . $this->input->post('voucher_no'),
            'remark'          => 'purchase',
            'status'          => 'purchase',
            'serial'          => $voucher_sl
        ];

        save_data('partytransaction', $data);
    }

    // save stock data
    private function handelStock($index, $id)
    {
        // get stock info
        $data = [
            'item_id'        => $id,
            'code'           => $_POST['product_code'][$index],
            'name'           => $_POST['product_name'][$index],
            'category'       => $_POST['product_cat'][$index],
            'subcategory'    => $_POST['subcategory'][$index],
            'batch_no'       => $_POST['batch_no'][$index],
            'expire_date'    => $_POST['expire_date'][$index],
            'unit'           => $_POST['unit'][$index],
            'quantity'       => $_POST['quantity'][$index],
            'purchase_price' => $_POST['purchase_price'][$index],
            'sell_price'     => $_POST['sale_price'][$index],
            'generic_name'   => $_POST['generic_name'][$index],
        ];
        save_data('stock', $data);
    }

    // save stock data
    private function handelOrder($index) {
        $where = array("product_code" =>$_POST['product_code'][$index]);
        $orderInfo = get_result('order_list', $where, ['product_code']);
        
        if(!empty($orderInfo)){
            $this->action->deleteData('order_list', $where);
        }
    }

    // save purchase meta info
    private function sapmeta()
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'voucher_no' => $this->input->post('voucher_no'),
                    'meta_key'   => $key,
                    'meta_value' => $value
                );
                $this->action->add('sapmeta', $data);
            }
        }
        $data['voucher_no'] = $this->input->post('voucher_no');
        $data['meta_key']   = 'purchase_by';
        $data['meta_value'] = $this->data['name'];
        $this->action->add('sapmeta', $data);
    }

    // show all purchase
    public function show_purchase()
    {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['result']     = null;

        // get all data
        $this->data['result'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // search all purchase
    private function search()
    {
        $where = ['saprecords.status' => 'purchase', 'saprecords.trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where["saprecords." . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $key => $val) {
                    if (!empty($val) && $key == 'from') {
                        $where['saprecords.sap_at >='] = $val;
                    }

                    if (!empty($val) && $key == 'to') {
                        $where['saprecords.sap_at <='] = $val;
                    }
                }
            }
        } else {
            $where['saprecords.sap_at'] = date('Y-m-d');
        }

        $joinCond = 'saprecords.party_code=parties.code';
        $select   = ['saprecords.*', 'parties.name', 'parties.mobile'];
        return get_join('saprecords', 'parties', $joinCond, $where, $select, '', 'saprecords.id', 'desc');
    }

    // show invoice
    public function invoice()
    {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        if (!empty($_GET['vno'])) {

            $vno = $_GET['vno'];

            $where = [
                'saprecords.voucher_no' => $vno,
                'saprecords.status'     => 'purchase',
                'saprecords.trash'      => 0
            ];

            $select                    = ['saprecords.*', 'parties.name', 'parties.mobile', 'parties.address'];
            $this->data['voucherInfo'] = get_row_join('saprecords', 'parties', 'saprecords.party_code = parties.code', $where, $select);

            $this->data['itemsInfo'] = get_join('sapitems', 'stock', 'sapitems.id=stock.item_id', ['sapitems.voucher_no' => $vno, 'sapitems.trash' => 0]);

        } else {
            redirect("purchase/purchase/show_purchase", "refresh");
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // delete purchase
    public function delete()
    {
        if (!empty($_GET['vno'])) {

            $vno = $_GET['vno'];

            // update stock
            custom_query("UPDATE stock SET trash=1 WHERE trash=0 AND item_id IN (SELECT id FROM sapitems WHERE voucher_no='$vno' AND trash=0)", "", false);

            $data = ['trash' => 1];

            // update saprecords, sapitems and sapmeta
            $where = [
                'voucher_no' => $vno,
                'status'     => 'purchase',
                'trash'      => 0
            ];
            save_data('sapitems', $data, $where);
            save_data('saprecords', $data, $where);
            save_data('sapmeta', $data, ['voucher_no' => $vno, 'trash' => 0]);

            // update party transaction
            save_data('partytransaction', $data, ['relation' => 'purchase:' . $vno, 'trash' => 0]);


            $mag = [
                'title' => 'delete',
                'emit'  => 'Purchase successfully deleted.',
                'btn'   => true
            ];

            $this->session->set_flashdata('deleted', message('danger', $mag));
        }

        redirect("purchase/purchase/show_purchase", "refresh");
    }

    // item wise search
    public function itemWise()
    {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
        $this->data['subMenu']    = 'data-target="wise"';
        $this->data['results']    = null;


        if (isset($_POST['show'])) {

            $where = [
                'product_code' => $_POST['product_code'],
                'status'       => 'purchase',
                'trash'        => 0,
            ];

            $this->data['results'] = get_result('sapitems', $where, ['sap_at', 'voucher_no', 'product_code', 'quantity', 'unit']);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/itemWise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
}
