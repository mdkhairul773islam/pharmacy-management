<?php
class Unit extends Admin_Controller {
     function __construct() 
         {
            parent::__construct();
            $this->holder();
            $this->load->model('action');
            $this->load->helper('url');
         }

        public function index() {
        $this->data['meta_title'] = 'unit';
        $this->data['active'] = 'data-target="product_menu"';
        $this->data['subMenu'] = 'data-target="unit"';
        $this->data['confirmation'] = null;

        $this->data['unit'] = $this->action->read('unit'); 
        
        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/unit/all', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }

    public function add() {  
        $this->data['confirmation'] = null;     
        $data = array(
            'unit' => trim($this->input->post('unit')),
        );

        $msg_array = array(
            'title' => 'success',
            'emit'  => 'Data Successfully Saved!',
            'btn'   => true
         );
        $this->data['confirmation'] = message($this->action->add('unit',$data),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('unit/unit','refresh');

    }



     public function edit_unit($id = NULL) {       
        $this->data['meta_title'] = 'Edit';
        $this->data['active'] = 'data-target="unit_menu"';
        $this->data['designation'] = null;
        
        
        $this->data['unit'] = $this->action->read("unit", array('id' => $id));
        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/unit/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function edit($id=NULL) {  

        $this->data['confirmation'] = null;

        if(isset($_POST['update'])){

            $id = trim($this->input->post('id'));
            
                $data = array(
                    'unit' => trim($this->input->post('unit')),
                );
                $options = array(
                'title' => 'update',
                'emit'  => 'Data Successfully Updated!',
                'btn'   => true
                );

                $status = $this->action->update('unit', $data, array('id' => $id));
                $this->data['confirmation'] = message($status, $options);
                
          }
           
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('unit/unit','refresh');

    }


   public function delete($id=NULL) {  
      $this->data['confirmation'] = null;     
       
       $msg_array=array(
            'title'=>'delete',
            'emit'=>'Data Successfully Deleted!',
            'btn'=>true
         );

        

        $this->data['confirmation']=message($this->action->deleteData('unit',array('id'=> $id)),$msg_array);  
        
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('unit/unit','refresh');

    }


  private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
 

}

?>