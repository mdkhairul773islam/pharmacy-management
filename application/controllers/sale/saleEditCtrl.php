<?php

class SaleEditCtrl extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        if (!empty($_GET['vno'])) {

            $vno = $this->input->get('vno');

            // get voucher info
            $this->data['voucherInfo'] = $voucherInfo = get_row('saprecords', ['voucher_no' => $vno, 'trash' => 0]);

            // get party info
            $partyInfo = [];
            if ($voucherInfo->sap_type == 'cash'){

                $info = json_decode($voucherInfo->address);
                
                $address = '';
                if(!empty($address)){
                    $address = $info->address;
                }else{
                    $address = '';
                }
                
                $partyInfo = [
                    'name'    => filter($voucherInfo->party_code),
                    'mobile'  => $info->mobile,
                    'address' => $address,
                ];
            }else{

                $info = get_row('parties', ['code' => $voucherInfo->party_code], ['name', 'mobile', 'address']);

                $partyInfo = [
                    'name'    => $info->name,
                    'mobile'  => $info->mobile,
                    'address' => $info->address,
                ];
            }

            $this->data['partyInfo'] = $partyInfo;
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/edit-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // update data
    public function update()
    {
        if (isset($_POST['update'])) {

            // update sale record
            foreach ($_POST['id'] as $key => $value){

                // update sap items
                $data = [
                    'sap_at'     => $this->input->post('date'),
                    'sale_price' => $_POST['sale_price'][$key],
                    'quantity'   => $_POST['quantity'][$key],
                    'profit'     => $_POST['profit'][$key],
                    'discount'   => $_POST['discount'][$key],
                ];
                
                
                if($_POST['product_code'][$key] ==20140){
                    $data['name'] = $_POST['product_name'][$key];
                }    
                
                save_data('sapitems', $data, ['id' => $value]);


                // update stock
                $where = ['id' => $_POST['stock_id'][$key]];

                $stockInfo = get_row('stock', $where, 'quantity');

                // set the quantity
                $newQuantity = $_POST['quantity'][$key] - $_POST['old_quantity'][$key];
                $quantity    = $stockInfo->quantity - $newQuantity;

                save_data('stock', ['quantity' => $quantity], $where);
            }

            // get party balnce
            $party_balance = ($_POST['current_sign'] == 'Receivable' ? $_POST['current_balance'] : -$_POST['current_balance']);

            // get voucher due
            $due = $this->input->post('grand_total') - $this->input->post('paid');


            // update sap records
            $data = [
                'sap_at'         => $this->input->post('date'),
                'change_at'      => date('Y-m-d'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_bill'     => $this->input->post('grand_total'),
                'total_discount' => $this->input->post('total_discount'),
                'party_balance'  => $party_balance,
                'paid'           => $this->input->post('paid'),
                'due'            => $due
            ];
            save_data('saprecords', $data, ['voucher_no' => $_POST['voucher_no'], 'trash' => 0]);

            $this->handelPartyTransaction();
            $this->sapmeta();

            $msg = [
                'title' => 'Updated',
                'emit'  => 'Sale successfully changed!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));

            redirect("sale/saleEditCtrl?vno=" . $_POST['voucher_no'], 'refresh');
        }

        redirect('sale/searchSale', 'refresh');
    }

    // handle party transaction
    private function handelPartyTransaction()
    {
        $data = [
            'transaction_at' => $this->input->post('date'),
            'change_at'      => date('Y-m-d'),
            'credit'         => $this->input->post('paid'),
            'debit'          => $this->input->post('grand_total'),
        ];

        save_data('partytransaction', $data, ['relation' => 'sales:' . $_POST['voucher_no'], 'trash' => 0]);
    }

    private function sapmeta()
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {

                $where = [
                    'voucher_no' => $this->input->post('voucher_no'),
                    'meta_key'   => $key,
                ];
                save_data('sapmeta', ['meta_value' => $value], $where);
            }
        }
    }

}
