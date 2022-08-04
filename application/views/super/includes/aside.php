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
    .aside-nav{
        margin-top: 65px;
        z-index: -3;
    }
    @media screen and (max-width: 768px){
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
			<a style="font-size: 23px !important;" href="<?php echo site_url('super/dashboard'); ?>">Admin <span>Panel</span></a>
		</h3>
    </div>

    <nav class="aside-nav">
        <ul class="sidebar-nav">
            <li id="dashboard">
                <a href="<?php echo site_url('super/dashboard'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Dashboard
                </a>
            </li>
            
            <li id="category_menu">
                <a href="#category" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Category
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="category" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('category/category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('category/category/allCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="subCategory_menu">
                <a href="#subCategory" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Manufacturer
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="subCategory" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('subCategory/subCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('subCategory/subCategory/allsubCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="product_menu">
                <a href="#product" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Product
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="product" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('product/product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Product
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('product/product/allProduct'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Product
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('unit/unit');?>">
                            <i class="fa fa-angle-right"></i>
                             Unit
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="fixed_assate_menu">
                <a href="#fixed_assate" data-toggle="collapse">
                    <i class="fa fa-bar-chart"></i> Fixed Assate
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="fixed_assate" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Fixed Assate
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/newfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Fixed Assate
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/allfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Fixed Assate
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="supplier-menu">
                <a href="#company" data-toggle="collapse">
                    <i class="fa fa-building-o"></i> Supplier
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="company" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('supplier/supplier');?>">
                            <i class="fa fa-angle-right"></i>
                            Add Supplier
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Supplier
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier Payment
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Payment
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="client_menu">
                <a href="#client" data-toggle="collapse">
                    <i class="fa fa-users"></i> Client
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="client" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('client/client');?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/client/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/all_transaction/collection_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Collection Report
                        </a>
                    </li>
                </ul>
            </li>

            <li id="purchase_menu">
                <a href="#purchase" data-toggle="collapse">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Purchase
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="purchase" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('purchase/purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Purchase
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/show_purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase_return'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Purchase Return
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase_return/allReturn'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase Return
                        </a>
                    </li>
                </ul>
            </li>

            <li id="raw_stock_menu">
                <a href="<?php echo site_url('stock/stock'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Stock
                </a>
            </li>
            
            <li id="short_list_menu">
                <a href="<?php echo site_url('stock/short_list'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Short List
                </a>
            </li>
            
            <li id="order_list_menu">
                <a href="<?php echo site_url('stock/order_list'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Order List
                </a>
            </li>
            
            <li id="expired_list_menu">
                <a href="<?php echo site_url('stock/expired_list'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Expired List
                </a>
            </li>
            
            <li id="damages_menu">
                <a href="#damages" data-toggle="collapse">
                    <i class="fa fa-trash" aria-hidden="true"></i> Damage Product
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="damages" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('damages/damages'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('damages/damages/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>

            <li id="sale_menu">
                <a href="#sales" data-toggle="collapse">
                    <i class="fa fa-shopping-cart"></i> Sale
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sales" class="sidebar-nav collapse">
                    <?php /*
                        <li>
                        <a href="<?php echo site_url('sale/sale');?>">
                            <i class="fa fa-angle-right"></i>
                            Cash sale
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/credit');?>">
                            <i class="fa fa-angle-right"></i>
                            Credit sale
                        </a>
                    </li>
                    */?>
                    <li>
                        <a href="<?php echo site_url('sale/new_sale');?>">
                            <i class="fa fa-angle-right"></i>
                            New sale
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/searchSale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/sale/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Search Item Wise
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="income_menu">
                <a href="#income" data-toggle="collapse">
                    <i class="fa fa-money"></i> Income
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="income" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('income/income'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Income
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('income/income/newIncome'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Income
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('income/income/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Income
                        </a>
                    </li>
                </ul>
            </li>

            <li id="cost_menu">
                <a href="#cost" data-toggle="collapse">
                    <i class="fa fa-money"></i> Expenditure
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="cost" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('cost/cost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Expenditure
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cost/cost/newcost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Expenditure
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cost/cost/allcost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Expenditure
                        </a>
                    </li>
                </ul>
            </li>

            <li id="due_list_menu">
                <a href="#due_list" data-toggle="collapse">
                    <i class="fa fa-male"></i> Due List
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="due_list" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('due_list/due_list');?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Client
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/due_collection_list'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Due Collection List
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/credit');?>">
                            <i class="fa fa-angle-right"></i>
                            Credit Client
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier Due
                        </a>
                    </li>
                </ul>
            </li>

            <li id="bank_menu">
                <a href="#bank" data-toggle="collapse">
                    <i class="fa fa-university"></i> Banking
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="bank" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Account
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/all_account'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Account
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/ledger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Bank Ledger
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="ledger">
                <a href="#ledger-menu" data-toggle="collapse">
                    <i class="fa fa-money"></i> Ledger
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="ledger-menu" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('ledger/companyLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('ledger/clientLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Client
                        </a>
                    </li>
                </ul>
            </li>

            <li id="report_menu">
                <a href="#report" data-toggle="collapse">
                    <i class="fa fa-money"></i> Report
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="report" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('report/purchase_report');?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/sales_report');?>">
                            <i class="fa fa-angle-right"></i>
                            Sales Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/income_report');?>">
                            <i class="fa fa-angle-right"></i>
                            Income Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/cost_report');?>">
                            <i class="fa fa-angle-right"></i>
                            Expenditure Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/balance_report');?>">
                            <i class="fa fa-angle-right"></i>
                           Balance Sheet
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="net_profit_menu">
                <a href="<?php echo site_url('report/net_profit');?>">
                    <i class="fa fa-money"></i>
                    Profit & Loss
                </a>
            </li>
            
            <li id="theme_menu">
                <a href="<?php echo site_url('theme/themeSetting');?>">
                    <i class="fa fa-cog"></i>
                    Settings
                </a>
            </li>
            
            <li id="privilege-menu">
                <a href="<?php echo site_url('privilege/privilege');?>">
                    <i class="fa fa-user-plus"></i>
                    Set Privilege
                </a>
            </li>
            
            <li id="backup_menu">
                <a href="<?php echo site_url('data_backup'); ?>">
                    <i class="fa fa-database"></i>
                    Data Backup
                </a>
            </li>

            <li>&nbsp;</li>
            <li>&nbsp;</li>

        </ul>
    </nav>
</aside>
