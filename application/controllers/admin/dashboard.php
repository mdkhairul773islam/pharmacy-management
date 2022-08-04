<?php
class Dashboard extends Admin_controller{

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'dashboard';
        $this->data['active'] = 'data-target="dashboard"';
        $this->data['subMenu'] = 'data-target=""';

        $today = date("Y-m-d");
        
        $this->data['totalClient'] = $this->data['totalManufacturer'] = $this->data['totalProduct'] = $this->data['totalInvoice'] = 0;
        
        //Client
        $this->data['total_client'] = $this->action->read("parties");
        foreach($this->data['total_client'] as $key => $value){
            if($value->code != null){
                $this->data['totalClient']+=$key;
            }
        }
        
        //Manufacturer
        $this->data['total_manufacturer'] = $this->action->read("subcategory");
        foreach($this->data['total_manufacturer'] as $key => $value){
            if($value->subcategory != null){
                $this->data['totalManufacturer']+=$key;
            }
        }
        
        //Product
        $this->data['total_product'] = $this->action->read("products");
        foreach($this->data['total_product'] as $key => $value){
            if($value->product_code != null){
                $this->data['totalProduct']+=$key;
            }
        }
        
        //Invoice
        $this->data['total_invoice'] = $this->action->read("saprecords");
        foreach($this->data['total_invoice'] as $key => $value){
            if($value->voucher_no != null){
                $this->data['totalInvoice']+=$key;
            }
        }

        //Todays Details Start here

        //Purchase
        $where  = array(
            "sap_at" => $today,
            "status" => "purchase",
            'trash'  => 0
        );
        $this->data['total_purchase'] = $this->action->read_sum("saprecords", "total_bill", $where);

        $purchase_paid = get_sum("saprecords", "paid", $where);
        $purchase_paid = (!empty($purchase_paid) ? $purchase_paid : 0);

        //Today's Sale Return
        $where["status"]          = "sale";
        $total_sale = get_sum("saprecords", "total_bill", $where);
        $this->data['total_sale'] = (!empty($total_sale) ? $total_sale : 0);

        // get todays sale paid
        $where["status"]          = "sale";
        $sale_paid = get_sum("saprecords", "paid", $where);
        $sale_paid = (!empty($sale_paid) ? $sale_paid : 0);

        // Collection and Paid
        $transaction_paid         = get_sum("partytransaction", "credit", ['transaction_at' => $today, 'transaction_by' => 'client', 'remark' => 'transaction', 'trash' => 0]);
        $transaction_paid         = (!empty($transaction_paid) ? $transaction_paid : 0);

        $dueCollection            = get_sum("due_collect", "paid", ['date' => $today]);
        $dueCollection            = (!empty($dueCollection) ? $dueCollection : 0);
        $this->data["total_paid"] = $sale_paid + $transaction_paid + $dueCollection;
        

        $this->data['todays_due'] =  $this->data['total_sale'] - $this->data["total_paid"];
        
        // Sale Return
        $today_sale_return = $this->action->readGroupBy("sale_return", "return_amount",array('trash'=>0));
        $this->data['totalSaleReturn'] = 0.00;
        foreach ($today_sale_return as $key => $value) {
            $this->data['totalSaleReturn'] += $value->return_amount;
        }
        

        //Bank Diposit
        $where = array(
            "transaction_date" => $today,
            "transaction_type" => "Credit"
        );
        $this->data['bank_diposit'] = $this->action->read_sum('transaction',"amount",$where);

        //Bank Withdraw
        $where ["transaction_type"] = "Debit";
        $this->data['bank_withdraw'] = $this->action->read_sum('transaction','amount',$where);
        
        //Bank To Cash
        $where ["transaction_type"] = "BTC";
        $this->data['bank_to_cash'] = $this->action->read_sum('transaction','amount',$where);
        
        //Cash To Bank
        $where ["transaction_type"] = "CTB";
        $this->data['cash_to_bank'] = $this->action->read_sum('transaction','amount',$where);
        
        //Bank To TT
        $where ["transaction_type"] = "bank_to_TT";
        $this->data['bankToTT'] = $this->action->read_sum('transaction','amount',$where);
        
        //Cash To TT
        $where = array('trash'=> 0,"transaction_at" => $today);
        $where ["transaction_via"] = "cash_to_tt";
        $this->data['cashToTT'] = $this->action->read_sum('partytransaction','debit',$where);
        

        //Total Cost $ Income
        $where = array(
            "date" => $today,
            "trash" => 0
        );
        $this->data['total_cost'] = $this->action->read_sum('cost','amount', $where);
        $this->data['total_income'] = $this->action->read_sum('income','amount', $where);
        $this->data['total_rent'] = $this->action->read_sum('rent','amount', $where);
        
        
        // Client Collection
        $transactionWhere = array('transaction_at' => $today,'trash' => 0,'transaction_by' => 'client');
        $this->data['client_collection'] = $this->action->read_sum('partytransaction','credit',$transactionWhere);
        
        
        // Supplier paid
        $transactionWhere = array('transaction_at' => $today,'trash' => 0,'transaction_by' => 'supplier');
        $this->data['supplier_paid'] = $this->action->read_sum('partytransaction','debit',$transactionWhere);
        
        //Todays Details End here------------------------------------------------
        
        
        
        
        
        
        
        
        
        
        //Entire Details Start here-----------------------------------------------
        

        //Purchase
        $where = array(
            "status" => "purchase"
        );
        $this->data['entire_purchase'] = $this->action->read_sum("saprecords", "total_bill", $where);

        //Sale
        $where["status"] = "sale";
        $this->data['entire_sale'] = $this->action->read_sum("saprecords", "total_bill", $where); 

        //Total Cost
        $where = array("trash" => 0);
        $this->data['entire_cost'] = $this->action->read_sum('cost','amount',$where);

        //Parties
        $where = array("trash" => 0);
        $party = $this->action->read('parties',$where);

        $client = 0;
        $supplier = 0;
        foreach ($party as $key => $value) {
            if($value->type=="client"){
                $client += 1;
            }else{
                $supplier += 1;
            }
        }

        $this->data["client"] = $client;
        $this->data["supplier"] = $supplier;

        //Entire Details End here------------------------------------------------


        //customer balance
        $payableBalance = $receivableBalance = 0.00;
        $joincond = "partybalance.code = parties.code";
        $where = array('parties.type' => 'client');
        $balance = $this->action->joinAndRead('partybalance', 'parties', $joincond, $where);
        
        foreach ($balance as $key => $value) {
            if ($value->balance > 0) {
                $payableBalance += $value->balance;
            }else {
                $receivableBalance += abs($value->balance);
            }
        }
   
        //Getting Total Information
        //Stock
        $this->data["stock_raw"] = $this->action->get_stock("raw");
        $this->data["stock_finish"] = $this->action->get_stock("finish_product");
		
		
		$where = array("status" => 'available');
		$this->data["product_quantity"] = $this->getQuantity('products', $where);

        // due calculation  
        $client_due = $supplier_due = array();
        $from = "parties";
        $join = "partybalance";
        $join_cond = "parties.code = partybalance.code";  
                
        $whereC = array(
          "parties.type" => "client",
          "partybalance.balance >"  => 0
        ); 
        
         $whereS = array(
          "parties.type" => "supplier",
          "partybalance.balance <"  => 0
        ); 
        
        $clientDueInfo = $this->action->joinAndRead($from,$join,$join_cond,$whereC);
        $supplierDueInfo = $this->action->joinAndRead($from,$join,$join_cond,$whereS);
        
        foreach($clientDueInfo as $key=>$value){
          $client_due[] = $value->balance;          
        } 
        
       foreach($supplierDueInfo as $key=>$value){
          $supplier_due[] = $value->balance;         
        }      
        
        $clientCollection = $this->data['client_collection'][0]->credit;
        $supplier_payment = $this->data['supplier_paid'][0]->debit;
        $cost             = $this->data['total_cost'][0]->amount;
        
        $this->data['cash'] = ($this->data['total_paid'] + $clientCollection) - ($supplier_payment + $cost + $purchase_paid);
        
        $this->data['opening_balance']  = get_result('closing_balance', ['date'=>date('Y-m-d', strtotime(date('Y-m-d').' -1 days'))]);
        
        $this->data['clientTotalDue'] = array_sum($client_due);
        $this->data['supplierTotalDue'] = array_sum($supplier_due);
        
        

        $this->load->view('admin/includes/header', $this->data);
        $this->load->view('admin/includes/aside', $this->data);
        $this->load->view('admin/includes/headermenu', $this->data);
       // $this->load->view('admin/includes/dashboard_nav', $this->data);
        $this->load->view('admin/dashboard', $this->data);
        $this->load->view('admin/includes/footer');
    }
	
	private function getQuantity($table, $where) {
		$data = $this->action->read($table, $where);
		$counter = 0;
		
        foreach ($data as $key => $row) {
            $counter += 1;
        }
		
		return $counter;
	}

    private function holder(){
        if($this->uri->segment(1) != $this->session->userdata('holder')){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
