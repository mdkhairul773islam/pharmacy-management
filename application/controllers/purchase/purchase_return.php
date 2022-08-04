<?php

class Purchase_return extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');

        // get all product
        $this->data['allProduct'] = get_result('stock', ['quantity >' => 0, 'trash' => 0], ['id', 'code', 'name', 'category']);

        // get all supplier
        $this->data['allParty'] = get_result('parties', ['type' => 'supplier', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);
    }

    public function index()
    {

        $this->data['meta_title']   = 'Purchase Return';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="return"';
        $this->data['confirmation'] = null;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/product_wise_return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // store data
    public function store()
    {
        if (isset($_POST['save'])) {

            $this->data['voucher_no'] = $voucher_no = floor(microtime(true));

            // get current balance
            $previous_balance = ($_POST['previous_sign'] == 'Receivable' ? $_POST['previous_balance'] : -$_POST['previous_balance']);
            $current_balance  = ($_POST['current_sign'] == 'Receivable' ? $_POST['current_balance'] : -$_POST['current_balance']);

            foreach ($_POST['product_name'] as $key => $value) {

                $data = [
                    'date'             => $this->input->post('date'),
                    'voucher_no'       => $voucher_no,
                    'party_code'       => $this->input->post('party_code'),
                    'stock_id'         => $_POST['id'][$key],
                    'product_code'     => $_POST['product_code'][$key],
                    'quantity'         => $_POST['quantity'][$key],
                    'unit'             => $_POST['unit'][$key],
                    'purchase_price'   => $_POST['purchase_price'][$key],
                    'previous_balance' => $previous_balance,
                    'current_balance'  => $current_balance,
                    'grand_total'      => $_POST['grand_total'],
                    'status'           => 'purchase_return',
                ];

                if (save_data('purchase_return', $data)) {
                    $this->handelStock($key);
                }
            }

            // handle party transaction
            $this->handelPartyTransaction();

            // handle meta info
            $this->sapmeta();

            // show flash message
            $msg = [
                'title' => 'success',
                'emit'  => 'Purchase return successfully completed.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message("success", $msg));
        }

        redirect("purchase/purchase_return", "refresh");
    }

    // handle party transaction
    private function handelPartyTransaction()
    {
        $data = [
            'transaction_at' => $this->input->post('date'),
            'party_code'     => $this->input->post('party_code'),
            'debit'          => $this->input->post('grand_total'),
            'relation'       => 'purchase_return:' . $this->data['voucher_no'],
            'remark'         => 'purchase_return',
            'status'         => 'purchase_return'
        ];

        save_data('partytransaction', $data);
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

    // handle sap meta
    private function sapmeta()
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = [
                    'voucher_no' => $this->data['voucher_no'],
                    'meta_key'   => $key,
                    'meta_value' => $value
                ];
                save_data('sapmeta', $data);
            }
        }
        $data['voucher_no'] = $this->data['voucher_no'];
        $data['meta_key']   = 'purchase_return_by';
        $data['meta_value'] = $this->data['name'];
        save_data('sapmeta', $data);
    }


    // show return voucher
    public function view()
    {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all_return"';
        $this->data['confirmation'] = null;

        $where                         = array('voucher_no' => $this->input->get('vno'));
        $this->data['purchase_record'] = $this->action->read('purchase_return', $where);

        $where = array(
            "sapitems.voucher_no" => $this->input->get('vno'),
            'sapitems.status'     => 'purchase'
        );

        $joinCond                    = "sapitems.product_code = products.product_code";
        $this->data['purchase_info'] = $this->action->joinAndRead("products", "sapitems", $joinCond, $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/return_view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function allReturn()
    {
        $this->data['meta_title']   = 'Purchase Return';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all_return"';
        $this->data['confirmation'] = null;

        $where = ['trash' => 0];

        if (isset($_POST['show'])) {

            foreach ($_POST['search'] as $key => $val) {
                if (!empty($val)) {
                    $where[$key] = $val;
                }
            }

            foreach ($_POST['date'] as $key => $val) {
                if (!empty($val) && $key == 'from') {
                    $where['date >='] = $val;
                }

                if (!empty($val) && $key == 'to') {
                    $where['date <='] = $val;
                }
            }
        }else{
            $where['date'] = date('Y-m-d');
        }

        $this->data['results'] = get_result('purchase_return', $where, '', 'voucher_no');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/all_return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // delete purchase
    public function delete()
    {
        if (!empty($_GET['vno'])) {

            $vno = $_GET['vno'];

            $data = ['trash' => 1];

            // update purchase_return
            $where = [
                'voucher_no' => $vno,
                'trash'      => 0
            ];

            $info = get_result('purchase_return', $where, ['stock_id', 'quantity']);

            if (!empty($info)) {
                foreach ($info as $item) {

                    // stock where
                    $stockWhere = ['id' => $item->stock_id, 'trash' => 0];

                    // get stock quantity
                    $stockInfo = get_row('stock', $stockWhere, 'quantity');

                    // update stock
                    if (!empty($stockInfo)) {

                        $quantity = $stockInfo->quantity + $item->quantity;

                        save_data('stock', ['quantity' => $quantity], $stockWhere);
                    }
                }
            }

            save_data('purchase_return', $data, $where);
            save_data('sapmeta', $data, $where);

            // update party transaction
            save_data('partytransaction', $data, ['relation' => 'purchase_return:' . $vno, 'trash' => 0]);


            $mag = [
                'title' => 'delete',
                'emit'  => 'Purchase return successfully deleted.',
                'btn'   => true
            ];

            $this->session->set_flashdata('deleted', message('danger', $mag));
        }

        redirect("purchase/purchase_return/allReturn", "refresh");
    }
}
