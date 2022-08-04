<?php
class Client extends Admin_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
        $this->load->library('upload');
    }
    public function index() {
        $this->data['meta_title']   = 'add';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        //Get party Unique Id
        $this->data['party_id'] = generateUniqueId('parties', 4);

        if(isset($_POST['add'])) {
            
            //Image Upload Start here
            if ($_FILES["attachFile"]["name"]!=null or $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/client';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="client_".rand(1111,99999);
                $config['overwrite']=true;

                $this->upload->initialize($config);

                if ($this->upload->do_upload("attachFile")){
                    $upload_data = $this->upload->data();
                    $photo = "public/client/".$upload_data['file_name'];
                }else{
                    $photo = '';
                }
            }else{
                $photo = '';
            }
            
            $data = array(
                'opening'        => $this->input->post('date'),
                'code'           => $this->input->post('code'),
                'name'           => $this->input->post('name'),
                'contact_person' => $this->input->post('contact_person'),
                'mobile'         => $this->input->post('contact'),
                'address'        => $this->input->post('address'),
                'type'           => "client",
                'initial_balance'=> ($_POST['status'] == 'payable') ? (0 - $this->input->post('balance')) : $this->input->post('balance'),
                'credit_limit'   => $this->input->post('credit_limit'),
                'path'           => $photo
            );
            $options = array(
                'title' => 'success',
                'emit'  => 'Client Successfully Saved!',
                'btn'   => true
            );

            // insert data into parties table
            $this->data['confirmation'] = message($this->action->add('parties', $data), $options);
            $this->session->set_flashdata("confirmation",$this->data["confirmation"]);
            redirect("client/client","refresh");
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function view_all() {
        $this->data['meta_title'] = 'all';
        $this->data['active']     = 'data-target="client_menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $where =  array("type" => "client","trash" => 0);

        $partyInfo = $this->action->read('parties',$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function preview() {
        $this->data['meta_title'] = 'view';
        $this->data['active']     = 'data-target="client_menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $where= array('code' => $this->input->get('partyCode'));
        $this->data['partyInfo'] = $this->action->read("parties",$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/preview', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function edit() {
        $this->data['meta_title']   = 'edit';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array("code" => $this->input->get("partyCode"));
        $this->data['info'] = $this->action->read("parties", $where);

        if(isset($_POST['update'])) {
            
            //Image Upload Start here
            if ($_FILES["attachFile"]["name"]!=null or $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/client';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="client_".rand(1111,99999);
                $config['overwrite']=true;

                $this->upload->initialize($config);

                if ($this->upload->do_upload("attachFile")){
                    $upload_data = $this->upload->data();
                    $photo = "public/client/".$upload_data['file_name'];
                }else{
                    $photo = $this->data['info'][0]->path;
                }
            }else{
                $photo = $this->input->post('old_image');
            }
            
            if ($this->input->post('status') == 'receivable') {
                $initial_balance = $this->input->post('initial_balance');
            }else{
                $initial_balance = 0 - $this->input->post('initial_balance');
            }
            $data = array(
                'opening'        => $this->input->post('date'),
                'name'           => $this->input->post('name'),
                'contact_person' => $this->input->post('contact_person'),
                'mobile'         => $this->input->post('contact'),
                'address'        => $this->input->post('address'),
                'initial_balance'=> $initial_balance,
                'credit_limit'   => $this->input->post('credit_limit'),
                'path'           => $photo

            );
            $options = array(
                'title' => 'success',
                'emit'  => 'Client Successfully Update!',
                'btn'   => true
            );
           
            $this->data['confirmation'] = message($this->action->update('parties', $data,$where), $options);
            $this->session->set_flashdata("confirmation",$this->data["confirmation"]);
            redirect("client/client/view_all","refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    /**
     * table: partytransaction,partytransactionmeta,saprecords,sapitems,parties
     *
     * update sapmeta table using voucher-number from saprecords 
     * update sapitems table using voucher-number from saprecords 
     * update saprecords table using party-code
     *
     * update partytransactionmeta table using transaction_id from partytransaction:id 
     * update partytransaction table using party_code 
     *
     * update partybalance table using code 
     * update partymeta table using party_code
     * update parties table using code 
     * 
     */
    public function delete($id) {
        $data = array('trash' => 1);

        // update sapmeta, sapitems and saprecords table using voucher-number from saprecords 
        $where = array('party_code' => $id);
        $sapRec = $this->action->read('saprecords', $where);

        if($sapRec != null) {
            foreach ($sapRec as $key => $value) {
                $where = array('voucher_no' => $value->voucher_no);

                // update sapmeta
                $this->action->update('sapmeta', $data, $where);

                // update sapitems
                //$where = array('party_code' => $id);
                $this->action->update('sapitems', $data, $where);
            }

            // update saprecords
            $where = array('party_code' => $id);
            $this->action->update('saprecords', $data, $where);
        }

        // update partytransactionmeta table using transaction_id from partytransaction:id 
        $transactionRec = $this->action->read('partytransaction', $where);
        if($transactionRec != null) {
            foreach ($transactionRec as $key => $value) {
                $where = array('transaction_id' => $value->id);
                $this->action->update('partytransactionmeta', $data, $where);
            }
        }

        // update partytransaction table using party_code 
        $where = array('party_code' => $id);
        $this->action->update('partytransaction', $data, $where);

       
        // update parties table using code
        $where = array('code' => $id);
        $this->action->update('parties', $data, $where);

        $option = array(
            "title" => "Deleted",
            "emit"  => "Client Successfully Deleted!",
            "btn"   => true
        );
        
        $this->session->set_flashdata('confirmation', message("danger", $option));

        redirect('client/client/view_all', 'refresh');
    }

}
