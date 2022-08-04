<?php
class Closing_report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index(){
        
        $this->data['meta_title'] = 'Balance Report';
        $this->data['active']     = 'data-target="report_menu"';
        $this->data['subMenu']    = 'data-target="closing_report"';
        
        $this->data['saleIncome']       = NULL;
        $this->data['clientPayment']    = NULL;
        $this->data['dueCollection']    = NULL;
        $this->data['allCost']          = NULL;
        $this->data['otherIncome']      = NULL;
        $this->data['purchase']         = NULL;
        $this->data['supplierPayment']  = NULL;
        $this->data['bankIncome']       = NULL;
        $this->data['bankCost']         = NULL;
        $this->data['cashtoTT']         = NULL;
        $this->data['confirmation']     = NULL;
        
        
        $where = array();
        $dueWhere = array();
        $loanWhere = array();
        $whereSap = array();
        $bankWhere = array();
        $cashTTwhere = array();
        $clientWhere = array();
        $refillWhere = array();
        $supplierWhere = array();
        $PaymentWhere = array();
        $bankWhereTT = array();
        
        
        if(isset($_POST['show'])){
            
            if(isset($_POST['date'])){
                $where['date'] = $this->input->post('date');
                $dueWhere['date'] = $this->input->post('date');
                $loanWhere['date'] = $this->input->post('date');
                $whereSap['sap_at'] = $this->input->post('date');
                $bankWhere['transaction_date'] = $this->input->post('date');
                $cashTTwhere['transaction_at'] = $this->input->post('date');
                $clientWhere['transaction_at'] = $this->input->post('date');
                $supplierWhere['transaction_at'] = $this->input->post('date');
                $PaymentWhere['transaction_at'] = $this->input->post('date');
                $bankWhereTT['transaction_date'] = $this->input->post('date');
                
                $this->data['fromDate'] = $this->input->post('date');
                $this->data['toDate'] = $this->input->post('date');
            }
        }else{
            $where['date'] = date('Y-m-d');
            $dueWhere['date'] = date('Y-m-d');
            $loanWhere['date'] = date('Y-m-d');
            $whereSap['sap_at'] = date('Y-m-d');
            $bankWhere['transaction_date'] = date('Y-m-d');
            $cashTTwhere['transaction_at'] = date('Y-m-d');
            $clientWhere['transaction_at'] = date('Y-m-d');
            $supplierWhere['transaction_at'] = date('Y-m-d');
            $PaymentWhere['transaction_at'] = date('Y-m-d');
            $bankWhereTT['transaction_date'] = date('Y-m-d');
        }

        //All cost
        $where['trash'] = 0;
        $this->data['allCost'] =  $this->action->readGroupBy('cost','cost_field',$where);

        //Other Income
        $this->data['otherIncome'] = $this->action->readGroupBy('income','field',$where);

        //Bank Income
        $bankWhere['transaction_type'] = 'BTC';
        $this->data['bankIncome'] = $this->action->read('transaction', $bankWhere);

        //Bank Cost
        $bankWhere['transaction_type'] = 'CTB';
        $this->data['bankCost'] = $this->action->read('transaction', $bankWhere);
        
        $bankWhereTT['transaction_type'] = 'cash_to_bank';
        $this->data['bankCostCashTT'] = $this->action->read('transaction', $bankWhereTT);
        
        // Sale Income
        $whereSap['trash'] = 0;
        $whereSap['status'] = 'sale';
        $this->data['saleIncome'] = $this->action->read('saprecords',$whereSap);
        
        // Due Collection
        $this->data['dueCollection'] = $this->action->readGroupBy('due_collect','voucher_no',$dueWhere);

        // Purchase Cost
        $whereSap['status'] = 'purchase';
        $this->data['purchase'] = $this->action->read('saprecords',$whereSap);
        
        
        // Cash to TT 
        $cashTTwhere['transaction_via'] = 'cash_to_tt';
        $cashTTwhere['transaction_by'] = 'supplier';
        $cashTTwhere['trash'] = 0;
        //$this->data['cashtoTT'] = $this->action->read('partytransaction',$cashTTwhere);
        
        
        // Supplier Payment
        $PaymentWhere['transaction_by'] = 'supplier';
        $PaymentWhere['relation'] = 'transaction';
        $PaymentWhere['trash'] = '0';
        $this->data['supplierPayment'] = $this->action->read('partytransaction',$PaymentWhere);
        
        // Client Payment
        $PaymentWhere['transaction_by'] = 'client';
        $this->data['clientPayment'] = $this->action->read('partytransaction',$PaymentWhere);
        
        
        // close blance
        if(isset($_POST['close_balance'])){
            
            $data = array(
                'date' => $this->input->post('date'),
                'closing_balance' => $this->input->post('closing_balance')
            );
            
            $where = array('date' => $this->input->post('date'));
            
            if($this->action->exists('closing_balance', $where)){
                
                $status = $this->action->update('closing_balance', $data, $where);
                
                $msg = array(
                    'title' => 'Added',
                    'emit' => 'Balance Successfully Closed',
                    'btn' => true
                );
                
            }else{
                
                $status = $this->action->add('closing_balance', $data);
                
                $msg = array(
                    'title' => 'Added',
                    'emit' => 'Balance Successfully Closed',
                    'btn' => true
                );
            }
            
            
                // send sms
                $num = $this->data['mobile'];
                $content = "Closing Balance:  ".$this->input->post('closing_balance')." Tk \n Date: " .$this->input->post('date'). " \n Regards JB Medicine";

                $message = send_sms($num, $content);
                 $insert = array(
                 	'delivery_date'     => date('Y-m-d'),
                 	'delivery_time'     => date('H:i:s'),
                 	'mobile'            => $num,
                 	'message'           => $content,
                 	//'total_characters'  => $this->input->post('total_characters'),
                 	//'total_messages'    => $this->input->post('total_messages'),
                 	'delivery_report'   => $message
                 );
                 $this->action->add('sms_record', $insert);


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
        //sms end
            
            $confirm = message($status, $msg);
            $this->session->set_flashdata('confirmation', $confirm);
            redirect('report/closing_report', 'refresh');
            
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/balance_nav', $this->data);
        $this->load->view('components/report/closing_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    
    
    public function closing(){
        $this->data['meta_title']  = 'Balance Report';
        $this->data['active']      = 'data-target="report_menu"';
        $this->data['subMenu']     = 'data-target="closing"';
        $this->data['closingInfo'] = null;
        
        $this->data['closingInfo'] = $this->action->read('closing_balance', array(), 'desc');
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/balance_nav', $this->data);
        $this->load->view('components/report/closing_record', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
 }
