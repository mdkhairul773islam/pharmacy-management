<?php
class SubCategory extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    
    public function index() {
        $this->data['meta_title']   = 'Subcategory';
        $this->data['active']       = 'data-target="subCategory_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        $this->data['categories'] = $this->action->read('category');
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/subCategory/nav', $this->data);
        $this->load->view('components/subCategory/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function addsubCategory() {  
        $this->data['confirmation'] = null;   

        $data = array(
            'date'          => date('Y-m-d'),
            //'category'    => $this->input->post('category'),
            'subcategory'   => $this->input->post('subcategory'),
            'slug'          => str_replace(' ', "_", trim($this->input->post('subcategory')))
        );

        $options = array(
            'title' => 'success',
            'emit'  => 'Brand Successfully Saved!',
            'btn'   => true
        );

        $where = array(
            'category'   => $this->input->post('category'),
            'subcategory'=> str_replace(' ',"_", $this->input->post('subcategory'))
        );

        //chack sub category table
        if(!$this->action->exists('subcategory',$where)){
            $this->data['confirmation'] = message($this->action->add('subcategory',$data),$options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        }else{
            $this->data['confirmation'] = message('warning',$option);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        }

        redirect('subCategory/subCategory','refresh');
    }
    

    public function allsubCategory() {
        $this->data['meta_title'] = 'Subcategory';
        $this->data['active'] = 'data-target="subCategory_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/subCategory/nav', $this->data);
        $this->load->view('components/subCategory/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function editsubCategory() {       
        $this->data['active']       = 'data-target="subCategory_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['category']     = null;

        $this->data['categories']   = $this->action->read('category');

        $where = array('id' => $this->input->get('id'));
        $this->data['subcategory']  = $this->action->read('subcategory', $where);    

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/subCategory/nav', $this->data);
        $this->load->view('components/subCategory/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    

    public function edit() {
        $this->data['confirmation'] = null;   

        $data = array(
            //'category'    => $this->input->post('category'),
            'subcategory'   => $this->input->post('subcategory')
        );

        $msg_array = array(
            'title' => 'update',
            'emit'  => 'Brand Successfully Updated!',
            'btn'   => true
        );

        $this->data['confirmation'] = message($this->action->update('subcategory', $data, array('id' => $this->input->get('id'))), $msg_array);
        
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('subCategory/subCategory/allsubCategory', 'refresh');
    }


    public function deletesubCategory($id=NULL) {
      $this->data['confirmation'] = null;     

        $msg_array = array(
            'title' => 'delete',
            'emit'  => 'Brand Successfully Deleted!',
            'btn'   => true
        );

        $this->data['confirmation'] = message($this->action->deleteData('subcategory',array('id'=>$id)),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('subCategory/subCategory/allsubCategory','refresh');
    }
    

    private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
}
