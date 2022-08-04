<?php
class net_profit extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="net_profit_menu"';
    }

    public function index(){
        $this->data['meta_title'] = 'Profit Report';
        $this->data['active']     = 'data-target="net_profit_menu"';
        $this->data['subMenu']    = 'data-target=""';
        $this->data['resultInfo'] = null;
        
        $where = array(
            "sapitems.trash"  => 0,
            "sapitems.status" =>"sale",
            'sapitems.sap_at' => date("Y-m-d")
        );
        
        
        if(isset($_POST['show'])){
            unset($where['sapitems.sap_at']);
            
            if(isset($_POST['search'])){
                foreach ($_POST['search'] as $key => $value) {
                    if($value != NULL){
                        $where['sapitems.'.$key] = $value;
                    }
                }
            }

            if(isset($_POST['date'])){
                foreach ($_POST['date'] as $key => $value) {
                    if($value != NULL && $key == "from"){
                        $where['sapitems.sap_at >='] = $value;
                    }

                    if($value != NULL && $key == "to"){
                        $where['sapitems.sap_at <='] = $value;
                    }
                }
            }
        }
        
        $select = "
            saprecords.sap_at as date, 
            saprecords.voucher_no, 
            saprecords.total_discount,
            saprecords.paid,
            saprecords.due,
            SUM(sapitems.sale_price * sapitems.quantity) as sale_price, 
            SUM(sapitems.purchase_price * sapitems.quantity) as purchase_price,
            SUM(sapitems.quantity) total_quantity,
        ";
        
        $this->data['resultInfo']= get_join('saprecords', 'sapitems', 'saprecords.voucher_no=sapitems.voucher_no', $where, $select, 'sapitems.voucher_no');
        
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/net_profit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

 }
