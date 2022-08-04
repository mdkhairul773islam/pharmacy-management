<?php

class SearchSale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['result']     = null;

        //Today's Data
        $where = array('sap_at' => date("Y-m-d"));
        $where['status'] = 'sale';
        $where['trash']  = 0;
        $this->data['result'] = $this->action->readGroupBy('saprecords', 'voucher_no', $where);

        if(isset($_POST['show'])){
            $where = array();

            foreach($_POST['search'] as $key => $val) {
                if($val != null){
                    $where[$key] = $val;
                }
            }

            foreach($_POST['date'] as $key => $val) {
                if($val != null && $key == 'from') {
                    $where['sap_at >='] = $val;
                }

                if($val != null && $key == 'to') {
                    $where['sap_at <='] = $val;
                }
            }
        }

        $where['status'] = 'sale';
        $where['trash']  = 0;
        $this->data['result'] = $this->action->readGroupBy('saprecords', 'voucher_no', $where);

        $where = array(
            'type'    => 'client',
            'status'  => 'active',
            'trash'   => 0
        );
        $this->data['allClients'] = $this->action->read('parties', $where);
        
        $this->data['allProduct'] = $this->action->readGroupBy('sapitems','product_code');
    
        
        //print_r($this->data['allProduct']);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/show-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function searchSale() {
        $where = array();

        foreach($_POST['search'] as $key => $val) {
            if($val != null){
                $where[$key] = $val;
            }
        }

        foreach($_POST['date'] as $key => $val) {
            if($val != null && $key == 'from') {
                $where['sale_at >='] = $val;
            }

            if($val != null && $key == 'to') {
                $where['sale_at <='] = $val;
            }
        }

        $where['status'] = 'sale';
        $where['trash'] = 0;
        return $this->action->readGroupBy('saprecords', 'voucher_no', $where);
    }

}
