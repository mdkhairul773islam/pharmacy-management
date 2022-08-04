<?php
class Client_profit extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

        $this->data['meta_title'] = 'Report';
        $this->data['active'] = 'data-target="report-menu"';
    }
    
    public function index(){
        $this->data['meta_title'] = 'Profit Report';
        $this->data['active']     = 'data-target="report_menu"';
        $this->data['subMenu']    = 'data-target="client_profit"';
        $this->data['resultInfo'] = null;
        
        $where = array(
            "trash"  => 0,
            "status" =>"sale"
        );

        $this->data['allClients'] = $this->action->read('parties',array('trash' => 0, 'type' => 'client'));
        
        $con = array('sap_at' => date("Y-m-d"), 'trash' => 0);
        $this->data['resultInfo'] = $this->action->read('saprecords', $con);

        if(isset($_POST['show'])){
            
            if(isset($_POST['search'])){
                foreach ($_POST['search'] as $key => $value) {
                    
                    if($value != NULL){
                        $where[$key] = $value;
                    }
                }
            }

            if(isset($_POST['date'])){
                foreach ($_POST['date'] as $key => $value) {
                    if($value != NULL && $key == "from"){
                        $where['sap_at >='] = $value;
                    }

                    if($value != NULL && $key == "to"){
                        $where['sap_at <='] = $value;
                    }
                }
            }
            $this->data['resultInfo'] = $this->action->read('saprecords', $where);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/profit_nav', $this->data);
        $this->load->view('components/report/client_profit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
}
