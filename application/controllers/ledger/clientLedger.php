<?php
class ClientLedger extends Admin_Controller {

    function __construct() {
        parent::__construct();

         $this->load->model('action');
         $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title']   = 'Client Ledger';
        $this->data['active']       = 'data-target="ledger"';
        $this->data['subMenu']      = 'data-target="client-ledger"';
        $this->data['width']        = 'width';

        $this->data['resultset']    = null;
        $this->data['partyCode'] 	= '';
    	$this->data['fromDate'] 	= '';
    	$this->data['toDate'] 		= '';
    	$this->data['partyBalance'] = 0.00;
    	$this->data['totalCommissionAmoint'] = 0.00;

        // Get all parties name
        $this->data['info'] = $this->getAllClient();
        $this->data['defaultData'] = $this->getDefaultData();

        //Get Data After Submit Query Start here
        if(isset($_POST['show'])) {
            $where = array("trash" =>0);
            $this->data['brandExists'] = "no";

            if($this->input->post('search') != NULL) {
                foreach ($this->input->post('search') as $key => $value) {
                    $where[$key] = $value;
                }
            }

            if($this->input->post('date') != NULL) {
                foreach($_POST['date'] as $key => $value) {
                    if($value != NULL) {
                        if($key == "from"){$where["transaction_at >="] = $value;$this->data['fromDate'] = $value;}
                        if($key == "to"){$where["transaction_at <="] = $value;$this->data['toDate'] = $value;}
                    }
                }
            }

            $this->data['resultset'] = $this->action->read('partytransaction', $where);

		if($this->data['resultset'] != null) {
			foreach ($this->data['resultset'] as $key => $row) {
				if($row->remark == 'sale') {
					$relationList = explode(':', $row->relation);
					$where = array('voucher_no' => $relationList[1]);
					$items = $this->action->read('sapitems', $where);

					$amount = metadata('sapmeta', array('voucher_no' => $relationList[1], 'meta_key' => 'commission_amount'));
					$comm = ($amount != null) ? $amount : 0.00;

					foreach ($items as $item) {
						$this->data['totalCommissionAmoint'] += $comm * $item->quantity;
					}
				}
			}
		}

            $this->data['partyCode'] = $_POST['search']['party_code'];

	    $where = array('code' => $_POST['search']['party_code']);
	    if(isset($_POST['search']['party_brand'])) {
	            if($_POST['search']['party_brand'] != null) {
	            	$where['brand'] = $_POST['search']['party_brand'];
	            }
            }

            $this->data['partyBalance'] = $this->action->read('partybalance', $where);

            // print_r($where);
            // print_r($this->data['partyBalance']);

	    $where = array('code' => $_POST['search']['party_code']);
            $this->data['partyInfo'] = $this->action->read('parties', $where);

            $this->data['partyBrand'] = null;
            if (isset($_POST['search']['party_brand'])) {
                $this->data['partyBrand'] = $_POST['search']['party_brand'];
            }
        }
        // Get Data After Submit Query End here


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/client-ledger', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    // Get the default data
    public function getDefaultData() {
        $data = array();
        $allClient = $this->getAllClient();

        // get Client transaction
        foreach ($allClient as $key => $value) {
         
            // set the client information
            $data[$key]['code']        = $value->code;
            $data[$key]['name']        = $value->name;
            $data[$key]['address']     = $value->address;
            $data[$key]['credit_limit']= $value->credit_limit;
            $data[$key]['init']        = $value->initial_balance;
            $data[$key]['init_status'] = ($value->initial_balance >= 0 )? "Receivable":"Payable";
            $data[$key]['quantity']    = 0.00;
            $data[$key]['debit']       = 0.00;
            $data[$key]['credit']      = 0.00;

            $data[$key]['opening_balance'] = $value->initial_balance;

            $where = array(
                "party_code" => $value->code,
                "trash" => 0
            );
            $allTransaction = $this->action->read('partytransaction', $where);

            if($allTransaction != null) {
                foreach ($allTransaction as $records) {
                    $data[$key]['debit'] += $records->debit;
                    $data[$key]['credit'] += $records->credit;
                    $data[$key]['comment'] = $records->comment;
                }
            }
        }

        return $data;
    }

    // get all client
    private function getAllClient(){
        $where = array(
            "type" => "client",
            "trash" => 0
        );
        $result = $this->action->read('parties', $where);
        return $result;
    }



}
