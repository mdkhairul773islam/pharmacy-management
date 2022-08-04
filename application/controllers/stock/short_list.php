<?php

class Short_list extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="short_list_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        $where = ['products.status'=>'available', 'stock.trash'=>0, 'products.low_level > '=>'sum(stock.quantity)'];
        $select= 'products.*, stock.*, SUM(stock.quantity) as quantity';
        
        if($_POST && isset($_POST['search'])){
            foreach($_POST['search'] as $key=>$row){
                if($row!=''){
                    $where['stock.'.$key] = $row;
                }
            }
        }
        
        $this->data['items'] = get_join('stock', 'products', 'stock.code=products.product_code', $where, $select, 'products.product_code');
        
        $this->data['allProduct']     = get_result('stock', ['trash' => 0], ['name', 'batch_no', 'code', 'subcategory'], 'code');
        $this->data['allCategory']    = get_result('category');
        $this->data['allSubcategory'] = get_result('subcategory');
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/short_list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
}