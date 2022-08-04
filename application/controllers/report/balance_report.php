<?php
class Balance_report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index(){
        $this->data['meta_title'] = 'Balance Report';
        $this->data['active']     = 'data-target="report_menu"';
        $this->data['subMenu']    = 'data-target="balance"';
        
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
        $this->data['fixed_assate']     = NULL;
        
        $where = array();
        $whereSap = array();
        $bankWhere = array();
        $dueWhere = array();
        $cashTTwhere = array();
        $PaymentWhere = array();
        $Fixed_assateWhere = array();

        if(isset($_POST['show'])){
            $where = array();
            $whereSap = array();
            $bankWhere = array();
            $bankWhereTT = array();
            $dueWhere = array();
            $cashTTwhere = array();
            $PaymentWhere = array();
            $Fixed_assateWhere = array();
        
            foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['date >='] = $val;
                    $dueWhere['date >='] = $val;
                    $whereSap['sap_at >='] = $val;
                    $bankWhere['transaction_date >='] = $val;
                    $bankWhereTT['transaction_date >='] = $val;
                    $cashTTwhere['transaction_date >='] = $val;
                    $PaymentWhere['transaction_at >='] = $val;
                    $Fixed_assateWhere['date >='] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['date <='] = $val;
                    $dueWhere['date <='] = $val;
                    $whereSap['sap_at <='] = $val;
                    $bankWhere['transaction_date <='] = $val;
                    $bankWhereTT['transaction_date <='] = $val;
                    
                    $cashTTwhere['transaction_date <='] = $val;
                    $PaymentWhere['transaction_at <='] = $val;
                    $Fixed_assateWhere['date <='] = $val;
                }
            }
        }else{
            $where = array('date' => date('Y-m-d'));
            $whereSap = array('sap_at' => date('Y-m-d'));
            $bankWhere = array('transaction_date' => date('Y-m-d'));
            $bankWhereTT = array('transaction_date' => date('Y-m-d'));
            $dueWhere = array('date' => date('Y-m-d'));
            $cashTTwhere = array('transaction_date' => date('Y-m-d'));
            $PaymentWhere = array('transaction_at' => date('Y-m-d'));
            $Fixed_assateWhere = array('date' => date('Y-m-d'));
        }

        //All cost
        $where['trash'] = 0;
        $this->data['allCost'] =  $this->action->readGroupBy('cost','cost_field',$where);

        //Other Income
        $this->data['otherIncome'] = get_result('income', $where);

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
        // Fixed Asset 
        $this->data['fixed_assate'] = $this->action->read('fixed_assate', $Fixed_assateWhere);
        
        
        
        
        // close blance
        if (isset($_POST['close_balance'])) {
            if ($_POST['date']) {
            
                $data = array(
                    'date' => $this->input->post('date'),
                    'opening_balance' => $this->input->post('opening_balance'),
                    'closing_balance' => $this->input->post('closing_balance')
                );
                
                $where = ['date' => $_POST['date']];
            
                if (check_exists('closing_balance', $where)) {
                    $status = $this->action->update('closing_balance', $data, $where);
                    $msg = array(
                        'title' => 'Added',
                        'emit' => 'Balance Successfully Closed',
                        'btn' => true
                    );
                }
                else {
                    $status = $this->action->add('closing_balance', $data);
                    $msg = array(
                        'title' => 'Added',
                        'emit' => 'Balance Successfully Closed',
                        'btn' => true
                    );
                }
            } 
            else {
                $status = 'warning';
                $msg = array(
                    'title' => 'Warning',
                    'emit' => 'Both date are not same...!',
                    'btn' => true
                );
            }
            $confirm = message($status, $msg);
            $this->session->set_flashdata('confirmation', $confirm);
            redirect('report/balance_report', 'refresh');
        }
        
        
        
        
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
       // $this->load->view('components/report/report_nav', $this->data);
        $this->load->view('components/report/balance_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
 }
