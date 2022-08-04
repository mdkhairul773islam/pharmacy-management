<?php
class Order_list extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="order_list_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        $where = ['products.status'=>'available'];
        $select= 'products.*, order_list.*';
        
        if($_POST && isset($_POST['search'])){
            foreach($_POST['search'] as $key=>$row){
                if($row!=''){
                    $where['products.'.$key] = $row;
                }
            }
        }
        $this->data['items'] = get_join('order_list', 'products', 'order_list.product_code=products.product_code', $where, $select, 'order_list.product_code');
        
        $this->data['allCategory']    = get_result('category');
        $this->data['allSubcategory'] = get_result('subcategory');
        $this->data['allProduct']     = get_result('stock', ['trash' => 0], ['name', 'batch_no', 'code', 'subcategory'], 'code');
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/order_list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    
    
    // store data
    public function store($productCode = NULL){
        
        if ($productCode!=null) {
            $productInfo = get_result('products', ['product_code' => $productCode, 'status' => 'available'], ['product_code'], 'product_code');
            
            if(!empty($productInfo)){
                $data = [
                    'date'         => date("Y-m-d"),
                    'product_code' => $productCode
                ];
    
                $status = save_data('order_list', $data);
                
                if($status == 'success'){
                    // show flash message
                    $msg = [
                        'title' => 'success',
                        'emit'  => 'Order successfully completed.',
                        'btn'   => true
                    ];
                    $this->session->set_flashdata("confirmation", message("success", $msg));
                }
            }
        }

        redirect("stock/order_list", "refresh");
    }
}