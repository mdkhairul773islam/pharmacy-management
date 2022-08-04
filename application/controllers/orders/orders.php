<?php

class Orders extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Orders';
        $this->data['active']       = 'data-target="orders_menu"';
        $this->data['subMenu']      = 'data-target="orders"';
        $this->data['confirmation'] = null;

        $where = array();

        $this->data['productInfo'] = $this->action->readGroupBy("stock", "code", $where);

        $this->data['category'] = $this->action->read_distinct("category", $where, "category");

        $this->data['subcategory'] = $this->action->read_distinct("subcategory", $where, "subcategory");

        $this->data['godown'] = $this->action->readGroupBy("godowns", "name", $where);

        if(isset($_POST['show'])){
            $where = array();

            if(isset($_POST['search'])){
                foreach($_POST['search'] as $key => $val){
                    if($val != null){
                        $where["stock.".$key] = $val;
                    }
                }
            }
        }

        $this->data['result'] = $this->action->readOrderBy("stock", 'name', $where);
        
        //print_r($this->data['result']);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        // $this->load->view('components/orders/orders', $this->data);
        $this->load->view('components/orders/orders', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
}