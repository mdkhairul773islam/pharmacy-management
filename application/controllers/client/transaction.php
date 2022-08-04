<?php
/**
* Working with client transaction
* Methods():
*   index: Add transactional record to database
*   edit_transaction : Edit transaction record
*   partyTransactionMeta: Add Additional transaction record to database
**/
class Transaction extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="transaction"';
        $this->data['confirmation'] = null;

        if(isset($_POST['save'])) {
            
            
            if(isset($_POST['send_sms'])){
                //Sending SMS Start
                
                $content = "Dear Customer, Your payment tk ".$this->input->post('payment')." has being completed successfully. Regards JB Medicine";
                $num = $this->input->post("mobile");
                $message = send_sms($num, $content);
    
                $insert = array(
                    'delivery_date'     => date('Y-m-d'),
                    'delivery_time'     => date('H:i:s'),
                    'mobile'            => $num,
                    'message'           => $content,
                    'total_characters'  => strlen($content),
                    'total_messages'    => message_length(strlen($content),$message),
                    'delivery_report'   => $message
                );
    
                if($message){
                    $this->action->add('sms_record', $insert);
                    $this->data['confirmation'] = message('success', array());
                } else {
                    $this->data['confirmation'] = message('warning', array());
                }
                
                //Sending SMS End
            
            }
            
            
            
            // fetch last insert record and increase by 1.
            $where = array('party_code' => $this->input->post('code'));
            $last_sl = $this->action->read_limit('partytransaction',$where,'desc',1);
            $voucher_sl = ($last_sl)? ($last_sl[0]->serial+1) : 1;
            
            $data = array(
                'transaction_at'     => $this->input->post('created_at'),
                'party_code'         => $this->input->post('code'),
                'credit'             => $this->input->post('payment') + $this->input->post('remission'),
                'transaction_via'    => $this->input->post('payment_type'),
                'remission'          => $this->input->post('remission'),
                'transaction_by'     => 'client',
                'relation'           => 'transaction',
                'serial'             => $voucher_sl,
                'remark'             => 'transaction',
                'comment'            => $this->input->post('comment'),
            );

            $options = array(
                'title' => 'success',
                'emit'  => 'Client Transaction Successfully Saved!',
                'btn'   => true
            );

            
            $tid = $this->action->addAndGetId('partytransaction', $data);
            // save additional transaction info
            if ($this->input->post('payment_type') == 'cheque') {
                $this->partyTransactionMeta($tid);
            }
            $this->session->set_flashdata('confirmation', message("success",$options));
            $lastId = $this->action->read('partytransaction',array(),'DESC');
            
            redirect('client/all_transaction/view/' . $lastId[0]->id, 'refresh');
        }

        // Get all client parties name
        $where = array(
            "type"   => "client", 
            "status" => "active", 
            "trash"  => 0
        );

        $this->data['allClient'] = $this->action->readGroupBy('parties', 'name', $where, "id", "asc");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/transaction', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    /**
     * Edit transaction
     * table : partytransaction
     * Strategy : Update column credit using table id
     *
     */
    public function edit_transaction($id = null) {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = null;

        // Get transaction Info
        $where = array("id" => $id);
        $this->data['records'] = $this->action->read('partytransaction', $where);

        // get party info 
        $where = array('code' => $this->data['records'][0]->party_code);
        $this->data['partyinfo'] = $this->action->read("parties",$where);

        // Calculate Balance from partytrasaction table.
        // Final balance = total_debit - total_credit + initial_balance.
        // Final Balance (+ve) = Receivable and (-ve) = Payable
        $where = array(
            'party_code' => $this->data['records'][0]->party_code,
            'trash' => 0
        );
        $transactionRec = $this->retrieve->read('partytransaction',$where);
        $total_credit = $total_debit = 0.0;
        if ($transactionRec != null) {
            foreach ($transactionRec as $key => $row) {
                $total_credit += $row->credit;
                $total_debit += $row->debit;
            }
            $balance = $total_debit -  $total_credit + $this->data['partyinfo'][0]->initial_balance;
        }else{
            $balance = $this->data['partyinfo'][0]->initial_balance;
        }
        $balance_status = ($balance >= 0) ?  "Receivable" : "Payable";

        $this->data['current_balance'] = $balance;
        $this->data['current_sign'] = $balance_status;


        //Update start from here
        if(isset($_POST['update'])) {
            $where = array("id" => $id);
            $data = array(
                "transaction_at"  => $this->input->post("date"),
                "change_at"       => date('Y-m-d'),
                "credit"          => $this->input->post("payment"),
                "transaction_via" => $this->input->post("payment_type"),
                "remark"          => $this->input->post("remark")
            );

            // Save additional transactional info
            if ($this->input->post('payment_type') == 'cheque') {
                $this->partyTransactionMeta($id);
            }
            $msg_array = array(
              "title" => "Success",
              "emit"  => "Transaction Successfully Updated",
              "btn"   => true
            );
            $this->data["confirmation"] = message($this->action->update("partytransaction",$data,$where),$msg_array);
            
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);

            redirect('client/transaction/edit_transaction/' . $id, 'refresh');
        }
        // Update end here

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/edit_transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * Save cheque info
     * Table: partytransactionmeta
     * Strategy: partytransaction's table auto increament id
     *  save into transaction_id column and other info as meta_key and meta_value
     */
    private function partyTransactionMeta($id) {
        if(isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'transaction_id' => $id,
                    'meta_key'       => $key,
                    'meta_value'     => $value
                );
                $this->action->add('partytransactionmeta', $data);
            }
        }
        return true;
    }
}
