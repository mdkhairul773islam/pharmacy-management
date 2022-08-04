<style>
    ul li a span.icon {
        margin-right: 10px;
        float: right;
    }
    .aside-head {
        position: fixed;
        z-index: 2;
        width: 150px;
    }
    .sidebar-brand {
        transition: all 0.4s ease-in-out;
        position: absolute;
        width: 250px;
        z-index: 2;
    }
    .sidebar-brand.sidebar-slide {
        transition: all 0.4s ease-in-out;
        transform: translateX(-100%);
    }
    .aside-nav {
        margin-top: 65px;
        z-index: -3;
    }
    @media screen and (max-width: 768px) {
        .sidebar-brand {
            transition: all 0.4s ease-in-out;
            transform: translateX(-100%);
        }
        .sidebar-brand.sidebar-slide {
            transition: all 0.4s ease-in-out;
            transform: translateX(0%);
        }
    }
</style>


<!-- Sidebar wrapper -->
<aside id="sidebar-wrapper">
    <div class="sidebar-nav">
        <h3 class="sidebar-brand <?php if($this->data['width'] == 'full-width') {echo 'sidebar-slide';} ?>">
			<a style="font-size: 23px !important;" href="<?php echo site_url('user/dashboard'); ?>">User <span>Panel</span></a>
		</h3>
    </div>

    <nav class="aside-nav">
        <ul class="sidebar-nav">
            <?php if(ck_menu("dashboard")){ ?>
            <li id="dashboard">
                <a href="<?php echo site_url('user/dashboard'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Dashboard
                </a>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("category_menu")){ ?> 
            <li id="category_menu">
                <a href="#category" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Category
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="category" class="sidebar-nav collapse">
                    <?php if(ck_action("category_menu","add-new")){ ?>
                    <li>
                        <a href="<?php echo site_url('category/category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("category_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('category/category/allCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("subCategory_menu")){ ?> 
            <li id="subCategory_menu">
                <a href="#subCategory" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Manufacturer
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="subCategory" class="sidebar-nav collapse">
                    <?php if(ck_action("subCategory_menu","add-new")){ ?>
                    <li>
                        <a href="<?php echo site_url('subCategory/subCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("subCategory_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('subCategory/subCategory/allsubCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("product_menu")){ ?> 
            <li id="product_menu">
                <a href="#product" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Product
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="product" class="sidebar-nav collapse">
                    <?php if(ck_action("product_menu","add-new")){ ?>
                    <li>
                        <a href="<?php echo site_url('product/product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Product
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("product_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('product/product/allProduct'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Product
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("fixed_assate_menu")){ ?> 
            <li id="fixed_assate_menu">
                <a href="#fixed_assate" data-toggle="collapse">
                    <i class="fa fa-bar-chart"></i> Fixed Assate
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="fixed_assate" class="sidebar-nav collapse">
                    <?php if(ck_action("fixed_assate_menu","field")){ ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Fixed Assate
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("fixed_assate_menu","new")){ ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/newfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Fixed Assate
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("fixed_assate_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/allfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Fixed Assate
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("supplier-menu")){ ?>
            <li id="supplier-menu">
                <a href="#company" data-toggle="collapse">
                    <i class="fa fa-building-o"></i> Supplier
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="company" class="sidebar-nav collapse">
                    <?php if(ck_action("supplier-menu","add")){ ?>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier');?>">
                            <i class="fa fa-angle-right"></i>
                            Add Supplier
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("supplier-menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Supplier
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("supplier-menu","transaction")){ ?>
                    <li>
                        <a href="<?php echo site_url('supplier/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier Payment
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("supplier-menu","all-transaction")){ ?>
                    <li>
                        <a href="<?php echo site_url('supplier/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Payment
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("client_menu")){ ?>
            <li id="client_menu">
                <a href="#client" data-toggle="collapse">
                    <i class="fa fa-users"></i> Client
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="client" class="sidebar-nav collapse">
                    <?php if(ck_action("client_menu","add")){ ?>
                    <li>
                        <a href="<?php echo site_url('client/client');?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("client_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('client/client/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("client_menu","transaction")){ ?>
                    <li>
                        <a href="<?php echo site_url('client/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("client_menu","all-transaction")){ ?>
                    <li>
                        <a href="<?php echo site_url('client/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("client_menu","collection-report")){ ?>
                    <li>
                        <a href="<?php echo site_url('client/all_transaction/collection_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Collection Report
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("purchase_menu")){ ?>
            <li id="purchase_menu">
                <a href="#purchase" data-toggle="collapse">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Purchase
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="purchase" class="sidebar-nav collapse">
                    <?php if(ck_action("purchase_menu","add-new")){ ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Purchase
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("purchase_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/show_purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("purchase_menu","wise")){ ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("purchase_menu","return")){ ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase_return'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Purchase Return
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("purchase_menu","all_return")){ ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase_return/allReturn'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase Return
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("raw_stock_menu")){ ?>
            <li id="raw_stock_menu">
                <a href="<?php echo site_url('stock/stock'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Stock
                </a>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("short_list_menu")){ ?>
            <li id="short_list_menu">
                <a href="<?php echo site_url('stock/short_list'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Short List
                </a>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("order_list_menu")){ ?>
            <li id="order_list_menu">
                <a href="<?php echo site_url('stock/order_list'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Order List
                </a>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("order_list_menu")){ ?>
            <li id="expired_list_menu">
                <a href="<?php echo site_url('stock/expired_list'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Expired List
                </a>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("order_list_menu")){ ?>
            <li id="damages_menu">
                <a href="#damages" data-toggle="collapse">
                    <i class="fa fa-trash" aria-hidden="true"></i> Damage Product
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="damages" class="sidebar-nav collapse">
                    <?php if(ck_action("damages_menu","add-new")){ ?>
                    <li>
                        <a href="<?php echo site_url('damages/damages'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("damages_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('damages/damages/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("sale_menu")){ ?>
            <li id="sale_menu">
                <a href="#sales" data-toggle="collapse">
                    <i class="fa fa-shopping-cart"></i> Sale
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sales" class="sidebar-nav collapse">
                    <?php /* if(ck_action("sale_menu","add-new")){ ?>
                    <li>
                        <a href="<?php echo site_url('sale/sale');?>">
                            <i class="fa fa-angle-right"></i>
                            Cash New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("sale_menu","credit_sale")){ ?>
                    <li>
                        <a href="<?php echo site_url('sale/credit'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Credit Sale
                        </a>
                    </li>
                    <?php } */ ?>
                    
                    <?php if(ck_action("sale_menu","new_sale")){ ?>
                    <li>
                        <a href="<?php echo site_url('sale/new_sale');?>">
                            <i class="fa fa-angle-right"></i>
                            New sale
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("sale_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('sale/searchSale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("sale_menu","wise")){ ?>
                    <li>
                        <a href="<?php echo site_url('sale/sale/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Search Item Wise
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("income_menu")){ ?>
            <li id="income_menu">
                <a href="#income" data-toggle="collapse">
                    <i class="fa fa-money"></i> Income
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="income" class="sidebar-nav collapse">
                    <?php if(ck_action("income_menu","field")){ ?>
                    <li>
                        <a href="<?php echo site_url('income/income'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Income
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("income_menu","new")){ ?>
                    <li>
                        <a href="<?php echo site_url('income/income/newIncome'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Income
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("income_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('income/income/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Income
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("cost_menu")){ ?>
            <li id="cost_menu">
                <a href="#cost" data-toggle="collapse">
                    <i class="fa fa-money"></i> Expenditure
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>

                <ul id="cost" class="sidebar-nav collapse">
                    <?php if(ck_action("cost_menu","field")){ ?>
                    <li>
                        <a href="<?php echo site_url('cost/cost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Expenditure
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("cost_menu","new")){ ?>
                    <li>
                        <a href="<?php echo site_url('cost/cost/newcost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Expenditure
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("cost_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('cost/cost/allcost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Expenditure
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("due_list_menu")){ ?>
            <li id="due_list_menu">
                <a href="#due_list" data-toggle="collapse">
                    <i class="fa fa-male"></i> Due List
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="due_list" class="sidebar-nav collapse">
                    <?php if(ck_action("due_list_menu","cash")){ ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list');?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Client
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("due_list_menu","collection_list")){ ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/due_collection_list'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Due Collection List
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("due_list_menu","credit")){ ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Credit Client
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("due_list_menu","supplier")){ ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier Due
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("bank_menu")){ ?>
            <li id="bank_menu">
                <a href="#bank" data-toggle="collapse">
                    <i class="fa fa-university"></i> Banking
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="bank" class="sidebar-nav collapse">
                    <?php if(ck_action("bank_menu","add-bank")){ ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/add_bank'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Bank 
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("bank_menu","add-new")){ ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Account
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("bank_menu","all-acc")){ ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/all_account'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Account
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("bank_menu","add")){ ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("bank_menu","ledger")){ ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/ledger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Bank Ledger
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("ledger")){ ?>
            <li id="ledger">
                <a href="#ledger-menu" data-toggle="collapse">
                    <i class="fa fa-money"></i> Ledger
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="ledger-menu" class="sidebar-nav collapse">
                    <?php if(ck_action("ledger","company-ledger")){ ?>
                    <li>
                        <a href="<?php echo site_url('ledger/companyLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("ledger","client-ledger")){ ?>
                    <li>
                        <a href="<?php echo site_url('ledger/clientLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Client
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("report_menu")){ ?>
            <li id="report_menu">
                <a href="#report" data-toggle="collapse">
                    <i class="fa fa-money"></i> Report
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="report" class="sidebar-nav collapse">
                    <?php if(ck_action("report_menu","purchase_report")){ ?>
                    <li>
                        <a href="<?php echo site_url('report/purchase_report');?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("report_menu","sales_report")){ ?>
                    <li>
                        <a href="<?php echo site_url('report/sales_report');?>">
                            <i class="fa fa-angle-right"></i>
                            Sales Report
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("report_menu","income_report")){ ?>
                    <li>
                        <a href="<?php echo site_url('report/income_report');?>">
                            <i class="fa fa-angle-right"></i>
                            Income Report
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("report_menu","cost_report")){ ?>
                    <li>
                        <a href="<?php echo site_url('report/cost_report');?>">
                            <i class="fa fa-angle-right"></i>
                            Expenditure Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if(ck_action("report_menu","balance_report")){ ?>
                    <li>
                        <a href="<?php echo site_url('report/balance_report');?>">
                            <i class="fa fa-angle-right"></i>
                           Balance Sheet
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("net_profit_menu")){ ?>
            <li id="net_profit_menu">
                <a href="<?php echo site_url('report/net_profit');?>">
                    <i class="fa fa-money"></i>
                    Profit & Loss
                </a>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("theme_menu")){ ?>
            <li id="theme_menu">
                <a href="<?php echo site_url('theme/themeSetting');?>">
                    <i class="fa fa-cog"></i>
                    Settings
                </a>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("privilege-menu")){ ?>
            <li id="privilege-menu">
                <a href="<?php echo site_url('privilege/privilege');?>">
                    <i class="fa fa-user-plus"></i>
                    Set Privilege
                </a>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("backup_menu")){ ?>
            <li id="backup_menu">
                <a href="<?php echo site_url('data_backup'); ?>">
                    <i class="fa fa-database"></i>
                    Data Backup
                </a>
            </li>
            <?php } ?>

            <li>&nbsp;</li>
            <li>&nbsp;</li>

        </ul>
    </nav>
</aside>
