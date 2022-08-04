<?php

class ChangeQuery extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }
    
    public function index() {
    	
    	echo "<pre>";
    	$records = $this->action->read("partybalance");
    	// print_r($records);
    	echo "<pre>";
    	
    	foreach($records as $key => $row) {
    		$where = array('id' => $row->id);
    		
    		if($row->balance > 0){
    			$newData = array(
    				"initial_balance" => (0 - $row->initial_balance),
    				"balance" => (0 - $row->balance)
    			);
    			
    			$this->action->update("partybalance", $newData, $where);
    		} 
    		
    		if($row->balance < 0) {
    			$newData = array(
    				"initial_balance" => (0 - $row->initial_balance),
    				"balance" => (0 - $row->balance)
    			);
    			
    			$this->action->update("partybalance", $newData, $where);
    		} 
    		
    		
    		
    	}
    	
    }

}
