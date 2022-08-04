<?php

class Stock extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="raw_stock_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->data['allProduct']     = get_result('stock', ['trash' => 0], ['name', 'batch_no', 'code', 'subcategory'], 'code');
        $this->data['allCategory']    = get_result('category');
        $this->data['allSubcategory'] = get_result('subcategory');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/stock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    public function onscroll_load_all_data()
    {
        // $where = ['quantity >' => 0, 'trash' => 0];
        
        $where = ['trash' => 0];

        if (isset($_POST['find'])){

            if ($_POST['code'] != null) {
                $where["code"] = $_POST['code'];
            }
            if ($_POST['category'] != null) {
                $where["category"] = $_POST['category'];
            }
            if ($_POST['subcategory'] != null) {
                $where["subcategory"] = $_POST['subcategory'];
            }
        }

        $pageSize = $_POST['pageSize'];

        if ($_POST['pageNumber'] == 0) {
            $pageNumber = $_POST['pageNumber'];
        } else {
            $pageNumber = $_POST['pageNumber'] * $pageSize;
        }

        //base loop
        $getData = get_result('stock', $where, '', '', '', '', $pageSize, $pageNumber);

        $total_row = count($getData);
        $data      = [];
        $i         = 0;
        $sl        = $pageNumber + 1;
        $privilege = $this->data['privilege'];
        $current_date = date('Y-m-d');
        if ($total_row > 0) {
            foreach ($getData as $value) {
                if($value->expire_date > $current_date){
                    $product     = get_result('products', ['product_code'=>$value->code]); 
                    
                    $data[$i]['sl']          = $sl;
                    $data[$i]['name']        = filter($value->name);
                    $data[$i]['batch_no']    = filter($value->batch_no);
                    $data[$i]['expire_date'] = $value->expire_date;
                    $data[$i]['mrp']         = ($product ? $product[0]->mrp : 00);
    
                    $category             = filter($value->category);
                    $data[$i]['category'] = wordwrap($category, 15, "<br>\n", TRUE);
    
                    $data[$i]['manufacturer'] = filter($value->subcategory);
                    $data[$i]['quantity']     = $value->quantity;
    
    
                    if ($privilege == 'user' || $privilege == 'admin') {
                        if ($value->subcategory == 'bego_pharmaceuticals_(ay)') {
                            $purchase_price = "Hidden";
                        } else {
                            $purchase_price = $value->purchase_price;
                        }
                    } else {
                        $purchase_price = $value->purchase_price;
                    }
                    $data[$i]['purchase_price'] = $purchase_price;
    
    
                    if ($privilege == 'user' || $privilege == 'admin') {
                        if ($value->subcategory == 'bego_pharmaceuticals_(ay)') {
                            $sell_price = "Hidden";
                        } else {
                            $sell_price = $value->sell_price;
                        }
                    } else {
                        $sell_price = $value->sell_price;
                    }
    
                    $data[$i]['sell_price'] = $sell_price;
    
                    if ($privilege == 'user' || $privilege == 'admin') {
                        if ($value->subcategory == 'bego_pharmaceuticals_(ay)') {
                            $sell = "Hidden";
                        } else {
                            $sell = $value->purchase_price * $value->quantity;
                        }
                    } else {
                        $sell = $value->purchase_price * $value->quantity;
                    }
    
                    $data[$i]['sale_amount'] = number_format($value->sell_price * $value->quantity, 2);
                    $data[$i]['amount']      = $sell;
    
    
                    $i++;
                    $sl++;
                }    
            }
            echo json_encode($data);
        } else {
            echo false;
        }


    }


    public function begoStock()
    {
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="raw_stock_menu"';
        $this->data['subMenu']      = 'data-target="begoStock"';
        $this->data['confirmation'] = null;

        $this->data['result'] = $this->action->readOrderBy("stock", 'name', array('subcategory' => 'bego_pharmaceuticals_(ay)'));

        //$where = array('subcategory'=>'bego_pharmaceuticals_(ay)');
        $where = array();

        $this->data['productInfo'] = $this->action->readGroupBy("stock", "code", array('subcategory' => 'bego_pharmaceuticals_(ay)'));
        $this->data['category']    = $this->action->read_distinct("category", $where, "category");
        $this->data['subcategory'] = $this->action->read_distinct("subcategory", $where, "subcategory");

        $this->data['godown'] = $this->action->readGroupBy("godowns", "name", $where);

        if (isset($_POST['show'])) {
            $where = array();

            if (isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $val) {
                    if ($val != null) {
                        $where["stock." . $key] = $val;
                    }
                }
            }
            $this->data['result'] = $this->action->readOrderBy("stock", 'name', $where);
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/begoStock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    public function pdf()
    {
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="raw_stock_menu"';
        $this->data['subMenu']      = 'data-target="begoStock"';
        $this->data['confirmation'] = null;

        $where = [];
        
        $this->data['allCategory']    = get_result('category');
        $this->data['allSubcategory'] = get_result('subcategory');
        
        $this->data['godown'] = $this->action->readGroupBy("godowns", "name", $where);

        if (isset($_POST['find'])) {
            if (isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $val) {
                    if ($val != null) {
                        $where[$key] = $val;
                    }
                }
            }
        }
        
        $this->data['stocks'] = get_result('stock', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/stock_pdf', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
}