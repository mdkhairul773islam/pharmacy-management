<?php
/**
* View Client transactional Histroy
* Methods():
*   index: View all transactional record
*   view: view particular transactional record
*   delete_transaction : Delete transactional record
*
**/
class All_transaction extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title']   = 'All Transaction';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = $this->data['transactionInfo'] = null;
        
        //Todays data
        $cond = array("trash" => 0, "relation" => 'transaction' ,'transaction_at'=>date("Y-m-d"));
        $this->data['transactionInfo'] = $this->action->read('partytransaction', $cond, $by='desc');

        // Get all parties name
        $where = array("type" => "client","trash" =>0,"status" =>"active");
        $this->data['info'] = $this->action->readGroupBy('parties', 'name', $where, 'id', 'asc');

        $where = array("trash" => 0, "relation" => 'transaction' );

        if(isset($_POST['show'])) {

            if($this->input->post('search') != NULL){
                foreach ($this->input->post('search') as $key => $value) {
                    $where[$key] = $value;
                }
            }

            if($this->input->post('date') != NULL){
                foreach($_POST['date'] as $key => $value) {
                    if($value != NULL){
                        if($key == "from"){$where["transaction_at >="] = $value;}
                        if($key == "to"){$where["transaction_at <="] = $value;}
                    }
                }
            }
            $this->data['transactionInfo'] = $this->action->read('partytransaction', $where,$by='desc');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/allTransaction', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    public function view($id=null) {
        $this->data['meta_title']   = 'Voucher';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = $this->data['transactionInfo'] = null;

        //uniq Id
        $this->data['party_code'] = supplierUniqueId('parties');
        // Get transactions Info
        $where = array("id" => $id);
        $this->data['records'] = $this->action->read("partytransaction",$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/view', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function collection_report() {
        $this->data['meta_title']   = 'Collection Report';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="collection-report"';
        $this->data['confirmation'] = $this->data['transactionInfo'] = null;
        
        //Todays data
        $cond = array("trash" => 0, "relation" => 'transaction' ,'transaction_at'=>date("Y-m-d"));
        $this->data['transactionInfo'] = $this->action->read('partytransaction', $cond, $by='desc');

        // Get all parties name
        $where = array("type" => "client","trash" =>0,"status" =>"active");
        $this->data['info'] = $this->action->readGroupBy('parties', 'name', $where, 'id', 'asc');

        $where = array("trash" => 0, "relation" => 'transaction' );

        if(isset($_POST['show'])) {

            if($this->input->post('search') != NULL){
                foreach ($this->input->post('search') as $key => $value) {
                    $where[$key] = $value;
                }
            }

            if($this->input->post('date') != NULL){
                foreach($_POST['date'] as $key => $value) {
                    if($value != NULL){
                        if($key == "from"){$where["transaction_at >="] = $value;}
                        if($key == "to"){$where["transaction_at <="] = $value;}
                    }
                }
            }
            $this->data['transactionInfo'] = $this->action->read('partytransaction', $where,$by='desc');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/collection_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    /**
     * delete transaction info
     * table : partytransaction
     * Strategy : update coloumn trash 0 to 1 by column id
     *
     */
    public function delete_transaction($id) {
        
        $where = array("id" => $id);
        $data = array('trash' => 1);
        $transactionRec = $this->action->update('partytransaction',$data, $where);
        $msg = array(
            "title" =>"Deleted",
            "emit"  =>"Transaction Successfully Deleted",
            "btn"   =>true
        );
        $this->session->set_flashdata('confirmation', message("danger", $msg));

        redirect('client/all_transaction', 'refresh');
    }


}
