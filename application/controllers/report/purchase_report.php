<?php
class Purchase_report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="report_menu"';
    }

    public function index(){

		$this->data['subMenu'] = 'data-target="purchase_report"';

        //Today's Data
        $where = array('sap_at' => date("Y-m-d"));
        $where["saprecords.trash"] = 0;
        $where["saprecords.status"] = 'purchase';
        $joinCond = "saprecords.party_code = parties.code";
        
        $this->data['result'] = $this->action->joinAndRead("saprecords", "parties", $joinCond, $where);

        if(isset($_POST['show'])){
            $where = array();
            foreach($_POST['search'] as $key => $val){
                if($val != null){
                    $where["saprecords.".$key] = $val;
                }
            }

            foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['saprecords.sap_at >'] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['saprecords.sap_at <'] = $val;
                }
            }
        }
        $where["saprecords.trash"] = 0;
        $where["saprecords.status"] = 'purchase';
        $joinCond = "saprecords.party_code = parties.code";
        
        $this->data['result'] = $this->action->joinAndRead("saprecords", "parties", $joinCond, $where);


        // get all Supplier
        $this->data['allParty'] = $this->getAllparty();;

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/purchase_nav', $this->data);
        $this->load->view('components/report/purchase_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);

    }


    private function getAllparty(){
        $where = array(
            "type"   => "supplier",
            "status" => "active",
            "trash"   => 0
        );
        $party = $this->action->read("parties", $where);
        return $party;
    }
 }