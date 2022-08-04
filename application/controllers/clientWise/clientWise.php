<?php
class ClientWise extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->library('upload');
    }

    public function index() {
        $this->data['meta_title'] = 'clientWise';
        $this->data['active'] = 'data-target="wiseProduct_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        // Get all client parties name
        $where = array(
            "type"   => "client", 
            "status" => "active", 
            "trash"  => 0
        );

        $this->data['allClient'] = $this->action->readGroupBy('parties', 'name', $where, "id", "asc");
        
        $where1 = array("status" => "available");
        $this->data['allProducts'] = $this->action->read("products", $where1);
            
        if ($this->input->post('save')) {

            $data = array(
                'date'           => date('Y-m-d'),
                'client_code'    => $this->input->post('client'),
                'product_code'   => $this->input->post('product'),
                'price'          => $this->input->post('price')
            );

            $options = array(
                "title" => "Success",
                "emit"  => "Client Wise Successfully Added!",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add("clientWiseProduct", $data), $options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('clientWise/clientWise','refresh');
           
        }
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/clientWise/nav', $this->data);
        $this->load->view('components/clientWise/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function allProduct() {
        $this->data['meta_title']   = 'clientWise';
        $this->data['active']       = 'data-target="wiseclientWise_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = $this->data['getData'] = null;
        // Get all client parties name
        $where = array(
            "type"   => "client", 
            "status" => "active", 
            "trash"  => 0
        );

        $this->data['allClient'] = $this->action->readGroupBy('parties', 'name', $where, "id", "asc");
        
        $this->data['getData'] = $this->action->read('clientWiseProduct');
        
        if($this->input->post('client_code')){
            $this->data['getData'] = $this->action->read('clientWiseProduct',array('client_code'=>$this->input->post('client_code')));
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/clientWise/nav', $this->data);
        $this->load->view('components/clientWise/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer',$this->data);
    }

    public function edit($id=null) {
        $this->data['meta_title']   = 'clientWise';
        $this->data['active']       = 'data-target="wiseProduct_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array('id' => $id );
        
        // Get all client parties name
        $where1 = array(
            "type"   => "client", 
            "status" => "active", 
            "trash"  => 0
        );

        $this->data['allClient'] = $this->action->readGroupBy('parties', 'name', $where1, "id", "asc");
        
        $where2 = array("status" => "available");
        $this->data['allProducts'] = $this->action->read("products", $where2);
        

        if ($this->input->post('update')) {
            
            $data = array(
                'client_code'    => $this->input->post('client'),
                'product_code'   => $this->input->post('product'),
                'price'          => $this->input->post('price')
            );

            $options = array(
                "title" => "Success",
                "emit"  => "Client Wise Successfully Update!",
                "btn"   => true
            );
            
            
            $this->data['confirmation'] = message($this->action->update('clientWiseProduct',$data,$where),$options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('clientWise/clientWise/allProduct','refresh');
        }
        
        $this->data['getData'] = $this->action->read('clientWiseProduct', $where);
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/clientWise/nav', $this->data);
        $this->load->view('components/clientWise/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function delete($id = NULL){
        $where = array("id" =>$id);
        $msg_array=array(
            "title" =>"delete",
            "emit"  =>"Successfully Deleted",
            "btn"   =>true
        );

        $this->data['confirmation'] = message($this->action->deleteData('clientWiseProduct',$where),$msg_array);
        $this->session->set_flashdata("confirmation",$this->data['confirmation']);

        redirect("clientWise/clientWise/allProduct","refresh");
    }
}
