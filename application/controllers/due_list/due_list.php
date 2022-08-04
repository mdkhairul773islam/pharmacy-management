<?php 

class Due_list extends Admin_Controller{
	
	function __construct(){
        parent::__construct();
        $this->load->model('action');
	}
	
	
    /**
     * Fetch all voucher which has due amount
     * @return Data array
     */
    public function index() {
        $this->data['meta_title'] = 'Cash Client Due';
        $this->data['active']     = 'data-target="due_list_menu"';
        $this->data['subMenu']    = 'data-target="cash"';
        $this->data['result']     = null;
        $this->data['confirmation']     = null;
        
        $where = array('trash' => 0 ,"sap_type" => 'cash');
        
        if($this->input->post('show')){
            if(isset($_POST['party_code']) && $_POST['party_code'] != ''){
                $where['party_code'] = $_POST['party_code'];
            }
            foreach ($_POST['date'] as $key => $value) {
                if($value != NULL && $key == "from"){
                    $where['promise_date >='] = $value;
                }
				
                if($value != NULL && $key == "to"){
                    $where['promise_date <='] = $value;
                }
            }
            
        }
        
        $allVoucher = $this->action->read('saprecords',$where);

        foreach ($allVoucher as $key => $value) {

            //read info from due_collection table
            $balanceInfo = get_cash_voucher_due($value->voucher_no);

            if ($balanceInfo['due'] > 0) {
                $this->data['result'][$key]['voucher_no']   = $value->voucher_no;
                $this->data['result'][$key]['party_code']   = $value->party_code;
                $this->data['result'][$key]['address']      = $value->address;
                $this->data['result'][$key]['total_bill']   = $value->total_bill;
                $this->data['result'][$key]['paid']         = $balanceInfo['paid'];
                $this->data['result'][$key]['due']          = $balanceInfo['due'];
                $this->data['result'][$key]['sap_at']       = $value->sap_at;
                $this->data['result'][$key]['promise_date'] = $value->promise_date;
            }
        }
        
        // send data
        if(isset($_POST['send'])){
           $content = $this->input->post('message')." Regards JB Medicine";

           foreach($_POST['mobile'] as $key => $num) {
                 $message = send_sms($num, $content);
                 $insert = array(
                 	'delivery_date'     => date('Y-m-d'),
                 	'delivery_time'     => date('H:i:s'),
                 	'mobile'            => $num,
                 	'message'           => $this->input->post('message')." Regards JB Medicine",
                 	'total_characters'  => $this->input->post('total_characters'),
                 	'total_messages'    => $this->input->post('total_messages'),
                 	'delivery_report'   => $message
                 );
                 $this->action->add('sms_record', $insert);
           }

		   if($message){
			   $options = array(
				   "title"  => "success",
				   "emit"   => "Your Message has been Successfully Sent!",
				   "btn"    => true
			   );
		       $this->data['confirmation'] = message('success', $options);
		   } else {
			   $options = array(
				 "title"  => "warning",
				 "emit"   => "Oops! Something went Wrong!Try again Please.",
				 "btn"    => true
			 );
		       $this->data['confirmation'] = message('warning', $options);
		   }
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/due_list/nav', $this->data);
        $this->load->view('components/due_list/client', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function due_collection_list()
    {
        $this->data['meta_title']   = 'Cash Client Due';
        $this->data['active']       = 'data-target="due_list_menu"';
        $this->data['subMenu']      = 'data-target="collection_list"';

        $where = [];

        if (!empty($_POST['show'])){

            if ($_POST['voucher_no']){
                $where['due_collect.voucher_no'] = $_POST['voucher_no'];
            }

            if ($_POST['dateFrom']){
                $where['due_collect.date >='] = $_POST['dateFrom'];
                $where['due_collect.date <='] = date('Y-m-d');
            }

            if ($_POST['dateTo']){
                $where['due_collect.date <='] = $_POST['dateTo'];
            }

        }else{

            $where['due_collect.date'] = date('Y-m-d');
        }

        $select = ['due_collect.*', 'saprecords.party_code', 'saprecords.address'];

        $this->data['results'] = get_join('due_collect', 'saprecords', 'due_collect.voucher_no=saprecords.voucher_no', $where, $select);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/due_list/nav', $this->data);
        $this->load->view('components/due_list/due-collection-list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function invoice($id = null)
    {
        $this->data['meta_title']   = 'Cash Client Due';
        $this->data['active']       = 'data-target="due_list_menu"';
        $this->data['subMenu']      = 'data-target="collection_list"';


        $select = ['due_collect.*', 'saprecords.sap_at', 'saprecords.party_code', 'saprecords.address'];
        $this->data['info'] = get_row_join('due_collect', 'saprecords', 'due_collect.voucher_no=saprecords.voucher_no', ['due_collect.id' => $id], $select);



        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/due_list/nav', $this->data);
        $this->load->view('components/due_list/due-invoice', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    public function delete($id = null)
    {
        delete_data('due_collect', ['id' => $id]);

        $msg = [
            "title" => "delete",
            "emit"  => "Due collection successfully deleted.",
            "btn"   => true
        ];

        $this->session->set_flashdata('confirmation', message('danger', $msg));
        redirect('due_list/due_list/due_collection_list', 'refresh');
    }
    
    public function credit(){
        $this->data['meta_title'] = 'Credit Client Due';
        $this->data['active']     = 'data-target="due_list_menu"';
        $this->data['subMenu']    = 'data-target="credit"';
        $this->data['result']     = null;
        
        
         $where = array(
            'type' => 'client',
            'trash' => 0,
            'status' => 'active'
        );
        
        $this->data['client_list'] = $this->action->read('parties',$where);
        
        
        
        $allClients = $this->getParty('client');

        
        foreach ($allClients as $key => $value) {
            $initial_balance = $value->initial_balance;
            //read transaction records
            $where = array('party_code' => $value->code,'trash' => 0);
            $transactionRec = $this->action->read('partytransaction',$where);
            $total_credit = $total_debit = $balance = 0.00;
            if ($transactionRec != null) {
                foreach($transactionRec as $row){
                    $total_debit += $row->debit;
                    $total_credit += $row->credit;
                }
                $balance = $total_debit - $total_credit + $initial_balance;
            }else{
                $balance = $initial_balance;
            }

            if ($balance > 0 ) {
                $this->data['result'][$key]['name'] = $value->name;
                $this->data['result'][$key]['code'] = $value->code;
                $this->data['result'][$key]['mobile'] = $value->mobile;
                $this->data['result'][$key]['address'] = $value->address;
                $this->data['result'][$key]['balance'] = $balance;
                $this->data['result'][$key]['type'] = 'Receivable';
                
                if(isset($_POST['show'])){
                    $this->data['result'];
                }
                
            }
        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/due_list/nav', $this->data);
        $this->load->view('components/due_list/credit_client', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
        
    }


    public function due_collect($vno=null){
        
        $this->data['meta_title'] = 'Due Collect';
        $this->data['active']     = 'data-target="due_list_menu"';
        $this->data['subMenu']    = 'data-target="client"';
        $this->data['result'] = [];
        
        $voucher_no = $vno;
        $where = array('voucher_no' => $voucher_no);
        $voucher = $this->action->read('saprecords',$where);
        
        //read from due_collection `table`
        $due_paid = 0;
        $where = array('voucher_no' => $vno);
        $due_paid_sum = $this->action->read_sum('due_collect', 'paid', $where);
        $due_remission_sum = $this->action->read_sum('due_collect', 'remission', $where);
        
        
        $due_paid = $due_paid_sum[0]->paid + $due_remission_sum[0]->remission;
        $paid = $voucher[0]->paid + $due_paid_sum[0]->paid;
        
        $this->data['result']['voucher_no'] = $voucher[0]->voucher_no;
        $this->data['result']['sap_type']   = $voucher[0]->sap_type;
        $this->data['result']['party_code'] = $voucher[0]->party_code;
        $this->data['result']['address']    = $voucher[0]->address;
        $this->data['result']['sap_at']     = $voucher[0]->sap_at;
        $this->data['result']['remission']  = ($due_remission_sum[0]->remission !=null)? $due_remission_sum[0]->remission:0.00;
        $this->data['result']['total_bill'] = $voucher[0]->total_bill; 
        $this->data['result']['paid']       = $paid;
        $this->data['result']['due']        = $voucher[0]->total_bill - $paid;
        $this->data['result']['promise_date'] = $voucher[0]->promise_date;
        
        
        
        if ($this->input->post('save')) {
            
            $data = array(
                'date'          => date('Y-m-d'),
                'voucher_no'    => $this->input->post('voucher_no'),
                'party_code'    => $this->input->post('party_code'),
                'total_bill'    => $this->input->post('total_bill'),
                'previous_paid' => $this->input->post('previous_paid'),
                'paid'          => $this->input->post('paid'),
                'due'           => $this->input->post('due'),
                'remission'     => $this->input->post('remission')
            );
            
            // add record to due_collect table
            $this->action->add('due_collect', $data);
            
            //update promise date
            $where = array('voucher_no' => $this->input->post('voucher_no'));
            $data = array('promise_date' => $this->input->post('promise_date'));
            $this->action->update('saprecords', $data, $where);
            
            /*
            //update bill in saprecords
            $data = array(
                'paid'      => $this->input->post('total_paid'),
                'remission' => $this->input->post('total_remission'),
                'due'       => $this->input->post('due')
            );
            $where = array('voucher_no' => $this->input->post('voucher_no'));
            $this->action->update('saprecords',$data,$where);
            */
            
            // update partyTransaction
            $data = array('debit' => $this->input->post('total_paid'));
            $where = array('relation' => 'sales:'.$this->input->post('voucher_no'));
            $this->action->update('partytransaction', $data, $where);

            $options = array(
                "title" => "Success",
                "emit"  => "Due Successfully Collect !",
                "btn"   => true
            );
            $this->data['confirmation'] = message("success",$options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('due_list/due_list','refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header',$this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/due_list/due_collect', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');

    }

    public function supplier() {
        $this->data['meta_title']   = 'All Supplier Dues';
        $this->data['active']       = 'data-target="due_list_menu"';
        $this->data['subMenu']      = 'data-target="supplier"';
        $this->data['result'] = null;

        $allParties = $this->getParty('supplier');
        
        if($allParties != null){
        
            foreach ($allParties as $key => $value) {
                $initial_balance = $value->initial_balance;
                //read transaction records
                $where = array('party_code' => $value->code,'trash' => 0);
                $transactionRec = $this->action->read('partytransaction',$where);
                $total_credit = $total_debit = $balance = 0.00;
                if ($transactionRec != null) {
                    foreach($transactionRec as $row){
                        $total_debit += $row->debit;
                        $total_credit += $row->credit;
                    }
                    $balance = $total_debit - $total_credit + $initial_balance;
                }else{
                    $balance = $initial_balance;
                }
    
                if ($balance < 0 ) {
                    $this->data['result'][$key]['name'] = $value->name;
                    $this->data['result'][$key]['code'] = $value->code;
                    $this->data['result'][$key]['mobile'] = $value->mobile;
                    $this->data['result'][$key]['address'] = $value->address;
                    $this->data['result'][$key]['balance'] = abs($balance);
                    $this->data['result'][$key]['type'] = 'Payable';
                }
            }
        
        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/due_list/nav', $this->data);
        $this->load->view('components/due_list/supplier', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    /**
     * fetch data from `parties` table
     * @param  [type] string
     * @return [type] data array
     */
    private function getParty($type){
        
        if(!empty($_POST['party_code'])){
             $where = array(
            'type'  => $type,
            'code' => $_POST['party_code'],
            'trash' => 0,
            'status' => 'active'
        );
        }else{
             $where = array(
            'type' => $type,
            'trash' => 0,
            'status' => 'active'
        );
        }
    
        $result = $this->action->read('parties',$where);
        return $result;
    }

}