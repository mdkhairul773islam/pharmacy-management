<?php class Expired_list extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }

    public function index(){
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="expired_list_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        $where = ['products.status'=>'available', 'stock.quantity > ' => 0, 'stock.trash' => 0, 'stock.expire_date < '=> date('Y-m-d')];
        if(!empty($_POST['find'])){
            foreach($_POST['search'] as $key=>$row){
                if($row!=''){
                    $where['stock.'.$key] = $row;
                }
            }
        }
        
        $items = get_join('stock', 'products', 'stock.code=products.product_code', $where, 'products.*, stock.*, SUM(stock.quantity) as quantityd', 'stock.code', 'stock.id', 'DESC');
        
        $lists =  [];
        $index = 0;
        foreach($items as $key=>$value){
            $item = get_result('stock', ['code'=>$value->code, 'trash'=>0]);
            if(count($item) > 1){
                $is_save = false;
                foreach($item as $key2=>$value2){
                    if(strtotime(date('Y-m-d')) < strtotime($value2->expire_date)){
                        $is_save = true;
                    }
                } 
                if($is_save != true){
                    $index++;
                    $lists[$index] = $value;
                }
            }else{
                $index++;
                $lists[$index] = $value;
            }
        }
        
        $this->data['items'] = $lists;
        
        $this->data['allProduct']     = get_result('stock', ['trash' => 0], ['name', 'batch_no', 'code', 'subcategory'], 'code');
        $this->data['allCategory']    = get_result('category');
        $this->data['allSubcategory'] = get_result('subcategory');
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/expired_list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    
    
    public function delete_expired_data(){
        if (!empty($_GET['batch_no'])){

            $batch_no = $this->input->get('batch_no');
            $where = [
                        'batch_no'      => $batch_no
                     ];
            $data = ['trash' => 1];         
            save_data('stock', $data, $where);
            
            $msg = [
                'title' => 'delete',
                'emit'  => 'Data delete successfully!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
            redirect('stock/expired_list');
                    
        }
    }
    
    
    
}