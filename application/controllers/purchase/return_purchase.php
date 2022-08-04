<?php

class Return_purchase extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        if (!empty($_GET['vno'])) {

            // get voucher info
            $this->data['voucherInfo'] = $voucherInfo = get_row('saprecords', ['voucher_no' => $_GET['vno'], 'trash' => 0]);

            // get party info
            $this->data['partyInfo'] = get_row('parties', ['code' => $voucherInfo->party_code], ['name', 'mobile', 'address']);

        } else {
            redirect("purchase/purchase/show_purchase", "refresh");
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // update data
    public function update()
    {
        if (isset($_POST['update'])) {

            // update purchase record
            foreach ($_POST['id'] as $key => $value) {

                if ($_POST['old_quantity'] != $_POST['new_quantity']) {

                    // update sap items
                    $data = [
                        'sap_at'          => $this->input->post('date'),
                        'quantity'        => $_POST['new_quantity'][$key],
                        'return_quantity' => $_POST['return_quantity'][$key],
                        'purchase_price'  => $_POST['purchase_price'][$key],
                    ];
                    save_data('sapitems', $data, ['id' => $value]);

                    // update stock
                    $data = [
                        //'batch_no'       => $_POST['batch_no'][$key],
                        //'expire_date'    => $_POST['expire_date'][$key],
                        'quantity'       => $_POST['new_quantity'][$key],
                        'purchase_price' => $_POST['purchase_price'][$key],
                    ];
                    save_data('stock', $data, ['item_id' => $value]);
                }
            }

            // get current balance
            $party_balance = ($_POST['current_sign'] == 'Receivable' ? $_POST['current_balance'] : -$_POST['current_balance']);

            // get voucher due
            $due = $this->input->post('grand_total') - $this->input->post('paid');

            // update bill record
            $data = [
                'sap_at'         => $this->input->post('date'),
                'change_at'      => date('Y-m-d'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_bill'     => $this->input->post('grand_total'),
                'due'            => $due,
                'total_discount' => $this->input->post('total_discount'),
                'transport_cost' => $this->input->post('transport_cost'),
                'party_balance'  => $party_balance,
                'paid'           => $this->input->post('paid')
            ];

            $where = [
                'voucher_no' => $this->input->post('voucher_no'),
                'trash'      => 0
            ];
            save_data('saprecords', $data, $where);

            // handle party transaction
            $this->handelPartyTransaction();

            $mag = [
                'title' => 'Updated',
                'emit'  => 'Purchase return successfully.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $mag));
            redirect("purchase/return_purchase?vno=" . $this->input->post('voucher_no'), "refresh");
        }

        redirect("purchase/purchase/show_purchase", "refresh");
    }

    // update party transaction
    private function handelPartyTransaction()
    {
        $data = [
            'change_at' => $this->input->post('date'),
            'credit'    => $this->input->post('grand_total'),
            'debit'     => $this->input->post('paid'),
        ];

        $where = [
            'relation' => 'purchase:' . $this->input->post('voucher_no'),
            'trash'    => 0
        ];
        save_data('partytransaction', $data, $where);
    }
}
