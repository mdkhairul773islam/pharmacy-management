<?php
class Product extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->library('upload');
    }

    public function index() {
        $this->data['meta_title'] = 'Product';
        $this->data['active'] = 'data-target="product_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        //get all category
        $this->data['allCategory'] = $this->action->read('category');
        
        //get all subcategory
        $this->data['allSubcategory'] = $this->action->read('subcategory');
        
            
        if ($this->input->post('product_add')) {
            
            /*$config['upload_path'] = './public/product';
            $config['allowed_types'] = 'png|jpg|gif|jpeg';
            $config['max_size'] = '10240';
            $config['file_name'] ="product".rand(1111,9999);
            $config['overwrite']=false;   
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload("photo")){
                $upload_data=$this->upload->data();
                $img = "public/product/".$upload_data['file_name'];
            }
            else{
                $msg_array=array(
                "title"=>"Error",
                "emit"=>$this->upload->display_errors(),
                "btn"=>true
                );
                $this->data['confirmation']=message("warning",$msg_array);
            }*/
            
            $data = array(
                'product_name'   => $this->input->post('product_name'),
                'generic_name'   => $this->input->post('generic_name'),
                'pack_size'      => $this->input->post('pack_size'),
                'product_code'   => $this->input->post('product_code'),
                'product_cat'    => $this->input->post('category'),
                'subcategory'    => $this->input->post('sub_category'),
                'purchase_price' => $this->input->post('purchase_price'),
                'sale_price'     => $this->input->post('sale_price'),
                'unit'           => $this->input->post('unit'),
                'mrp'           => $this->input->post('mrp'),
                'self_name'      => $this->input->post('self_name'),
                'low_level'      => $this->input->post('low_level'),
                'status'         => $this->input->post('status'),
                'discount'         => $this->input->post('discount'),
                //'path'           => $img
            );

            $exists_data = array('product_code'  => $this->input->post('product_code'));

            if($this->action->exists("products",$exists_data)){
                $options = array(
                    "title" => "warning",
                    "emit"  => "This Product already Exists!",
                    "btn"   => true
                );
              $this->data['confirmation'] = message("warning",$options);
            }else{
                $options = array(
                    "title" => "Success",
                    "emit"  => "Product Successfully Added!",
                    "btn"   => true
                );
                $this->data['confirmation'] = message($this->action->add("products", $data), $options);
                $this->session->set_flashdata('confirmation',$this->data['confirmation']);
                redirect('product/product','refresh');
           }
        }
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function allProduct() {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer',$this->data);
    }

    public function edit($id=null) {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['id'] = $id;
        $where = array('id' => $id );


        //get all category
        $this->data['allCategory'] = $this->action->read('category');
        
        //get all subcategory
        $this->data['allSubcategory'] = $this->action->read('subcategory');

        if ($this->input->post('update')) {
            
            $data = array(
                'product_name'   => $this->input->post('product_name'),
                'generic_name'   => $this->input->post('generic_name'),
                'pack_size'      => $this->input->post('pack_size'),
                'product_cat'    => $this->input->post('category'),
                'subcategory'    => $this->input->post('sub_category'),
                'purchase_price' => $this->input->post('purchase_price'),
                'sale_price'     => $this->input->post('sale_price'),
                'unit'           => $this->input->post('unit'),
                'mrp'            => $this->input->post('mrp'),
                'self_name'      => $this->input->post('self_name'),
                'low_level'      => $this->input->post('low_level'),
                'discount'       => $this->input->post('discount'),
                'status'         => $this->input->post('status')
            );
            
            /*$config['upload_path'] = './public/product';
            $config['allowed_types'] = 'png|jpg|gif|jpeg';
            $config['max_size'] = '10240';
            $config['file_name'] ="product".rand(1111,9999);
            $config['overwrite']=false;   
            
            $this->upload->initialize($config);
            $img = null;
            if ($this->upload->do_upload("photo")){
                $upload_data=$this->upload->data();
                $img = "public/product/".$upload_data['file_name'];
            }
            else{
                $msg_array=array(
                "title"=>"Error",
                "emit"=>$this->upload->display_errors(),
                "btn"=>true
                );
                $this->data['confirmation']=message("warning",$msg_array);
            }
            
            if($img != null) {
                $data = array(
                    'product_name'   => $this->input->post('product_name'),
                    'generic_name'   => $this->input->post('generic_name'),
                    'pack_size'      => $this->input->post('pack_size'),
                    'product_code'   => $this->input->post('product_code'),
                    'product_cat'    => $this->input->post('category'),
                    'subcategory'    => $this->input->post('sub_category'),
                    'purchase_price' => $this->input->post('purchase_price'),
                    'sale_price'     => $this->input->post('sale_price'),
                    'unit'           => $this->input->post('unit'),
                    'low_level'      => $this->input->post('low_level'),
                    'status'         => $this->input->post('status'),
                    'path'           => $img
                );
            } else {
               $data = array(
                    'product_name'   => $this->input->post('product_name'),
                    'generic_name'   => $this->input->post('generic_name'),
                    'pack_size'      => $this->input->post('pack_size'),
                    'product_cat'    => $this->input->post('category'),
                    'subcategory'    => $this->input->post('sub_category'),
                    'purchase_price' => $this->input->post('purchase_price'),
                    'sale_price'     => $this->input->post('sale_price'),
                    'unit'           => $this->input->post('unit'),
                    'low_level'      => $this->input->post('low_level'),
                    'status'         => $this->input->post('status')
                );
            }*/
            
            $msg_array=array(
                'title' =>'update',
                'emit'  =>'Product Successfully Updated!',
                'btn'   =>true
            );
            
            // Update info in `stock` table
            $stock_data = array(
                'name'          => $this->input->post('product_name'),
                'category'      => $this->input->post('category'),
                'subcategory'   => $this->input->post('sub_category'),
                'purchase_price'=> $this->input->post('purchase_price'),
                'sell_price'    => $this->input->post('sale_price')
            );
            $stock_where = array('code' => $this->input->post('product_code'));
            $this->action->update('stock', $stock_data, $stock_where);
            // Update stock info end here
            
            $this->data['confirmation'] = message($this->action->update('products',$data,$where),$msg_array);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('product/product/allProduct','refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function delete($id = NULL){

        $where = array("id" =>$id);

        //$data = array("trash" => 1 );

        $msg_array=array(
            "title" =>"delete",
            "emit"  =>"Product Successfully Deleted",
            "btn"   =>true
        );

        $this->data['confirmation'] = message($this->action->deleteData('products',$where),$msg_array);
        $this->session->set_flashdata("confirmation",$this->data['confirmation']);

        redirect("product/product/allProduct","refresh");
    }
}
