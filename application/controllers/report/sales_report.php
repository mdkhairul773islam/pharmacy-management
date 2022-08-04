<?php
class Sales_report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="report_menu"';
    }

    public function index(){

        $this->data['subMenu'] = 'data-target="sales_report"';
        $this->data['result']  = null;

        $where = array(
            'type'    => 'client',
            'status'  => 'active',
            'trash'   => 0
        );
        $this->data['allClients'] = $this->action->read('parties', $where);
        
        // Today's Data
        $where = array('status' => 'sale','sap_at' => date("Y-m-d"),'trash' =>0);
        $this->data['result'] = $this->action->read('saprecords', $where);

        $where = array('status' => 'sale','trash'=> 0);
        if(isset($_POST['show'])){

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
            $this->data['result'] = $this->action->read('saprecords', $where);       
        }
        
        $this->data['allProduct'] = $this->action->readGroupBy('sapitems','product_code');
        //print_r($this->data['allProduct']);


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);

    }

    public function sales_report_item(){

        $this->data['subMenu'] = 'data-target="sales_report_item"';

        $where = array('status' =>'available');
        $this->data['productionItems'] = $this->action->read('products',$where);
        
        // Today's Data
        $where = array('sap_at' => date("Y-m-d"), 'status' => 'sale', 'trash' =>0);
        $this->data['results'] = $this->action->read('sapitems', $where);

        $where = array('status' => 'sale', 'trash' =>0);

        if (isset($_POST['find'])) {
            
            if(isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if($value != NULL) {
                        $where[$key] = $value;
                    }
                }
            }

            foreach ($_POST['date'] as $key => $value) {
                if($value != NULL && $key == "from"){
                    $where['sap_at >='] = $value;
                }
                
                if($value != NULL && $key == "to"){
                    $where['sap_at <='] = $value;
                }
            }
            // Fetch saprecords Info
            $this->data['results'] = $this->action->read('sapitems', $where);
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales_report_item', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);

    }
    public function sales_return_report(){

        $this->data['subMenu'] = 'data-target="sales_return_report"';




        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales_return_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);

    }
     

 }