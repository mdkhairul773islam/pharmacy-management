<style>
    .deshitem {margin-bottom: 15px !important;} 
    .privilege tr th {white-space: nowrap;}
    .view {color: green;}
    .edit {color: #EC971F;}
    .checkbox-inline, .checkbox label, .radio label {font-weight: bold;padding-left: 0;}
    .checkbox label:after, .radio label:after {content: '';display: table;clear: both;}
    .checkbox .cr, .radio .cr {
        border: 1px solid #a9a9a9;
        display: inline-block;
        border-radius: .25em;
        position: relative;
        width: 1.3em;
        float: left;
        height: 1.3em;
        margin-right: 5px;
    }
    .checkbox-inline, .radio-inline+.radio-inline {
        margin-right: 10px !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
    }
    .radio .cr {border-radius: 50%;}
    .checkbox .cr .cr-icon, .radio .cr .cr-icon {
        position: absolute;
        font-size: .8em;
        line-height: 0;
        top: 50%;
        left: 20%;
    }
    .radio .cr .cr-icon {margin-left: 0.04em;}
    .checkbox label input[type="checkbox"], .radio label input[type="radio"] {display: none;}
    .checkbox label input[type="checkbox"] + .cr > .cr-icon, .radio label input[type="radio"] + .cr > .cr-icon {
        transform: scale(3) rotateZ(-20deg);
        opacity: 0;
        transition: all .3s ease-in;
    }
    .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon, .radio label input[type="radio"]:checked + .cr > .cr-icon {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }
    .checkbox label input[type="checkbox"]:disabled + .cr, .radio label input[type="radio"]:disabled + .cr {opacity: .5;}
    #progress {display: none;}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Set Privilege</h1>
                    <img id="progress" class="pull-right" src="#" alt=""></span>
                </div>
            </div>

            <div class="panel-body">
                <form action="" class="row">
                    <div class="col-md-4">
                        <label class="control-label">Privilege <span class="req">*</span></label>
                        <div class="form-group">
                            <select name="privilege" id="privilege" class="form-control" required>
                                <option value="">Select Menu</option>
                                <?php foreach ($privileges as $privilege) { ?>
                                    <option value="<?php echo $privilege->privilege; ?>">
                                        <?php echo filter($privilege->privilege); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="control-label">User Name<span class="req">*</span></label>
                        <div class="form-group">
                            <select name="user_id" id="user_id" class="form-control" required> </select>
                        </div>
                        <div class="col-md-12">
                            <hr style="margin-bottom: 0">
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive privilege">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="active">
                                <th rowspan="2" width="200" style="vertical-align: middle;">Menu Item
                                </th>
                                <th colspan="3">Navbar Items</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Dashboard Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="dashboard">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Dashboard</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="today_purchase">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            TODAY'S Purchase
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="today_sale">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            TODAY'S SALE
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="tody_due">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            TODAY'S DUE
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="tody_paid">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            TODAY'S PAID
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="tt">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            BANK TO TT
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="supplier_paid">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Supplier Paid
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="bank_withdraw">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Bank Withdraw
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="ClientCollection">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Client Collection
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="bank_deposit">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            BANK DEPOSIT
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="cash_tt">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Cash To T.T
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="today_cost">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            TODAY'S COST
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="today_income">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Today's Income
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="customar">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Customar
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="manufacturer">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Manufacturer
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="product">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Product
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="invoice">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Invoice
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Row Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-item="menu" value="category_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Category</span>
                                      </label>
                                    </div>
                                </th>
                                
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="category_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add Category
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="category_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;View Category 
                                      </label>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row End here -->
                            
                            
                            <!-- Row Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-item="menu" value="subCategory_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Brand</span>
                                      </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="subCategory_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add New
                                      </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="subCategory_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;View Brand
                                      </label>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row End here -->
                            
                            
                            
                            <!-- Row Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-item="menu" value="product_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Product</span>
                                      </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="product_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add Product
                                      </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="product_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;All Product 
                                      </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="product_menu" data-item="action" value="unit">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Unit 
                                      </label>
                                    </div>
                                    
                                </td>
                            </tr>
                            <!-- Row End here -->
                            
                            
                            
                            <!-- Row Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-item="menu" value="supplier-menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Supplier</span>
                                      </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="supplier-menu" data-item="action" value="add">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add Supplier
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="supplier-menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;All Supplier 
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="supplier-menu" data-item="action" value="transaction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add Transaction
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="supplier-menu" data-item="action" value="all-transaction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;All Transaction
                                      </label>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row End here -->
                            
                            
                            
                            <!-- Row Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-item="menu" value="client_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Client</span>
                                      </label>
                                    </div>
                                </th>
                                
                                <td colspan="3" width="320">
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="client_menu" data-item="action" value="add">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add New
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="client_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;View All 
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="client_menu" data-item="action" value="transaction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add Transaction
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="client_menu" data-item="action" value="all-transaction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;All Transaction
                                      </label>
                                    </div>
                                    
                                </td>
                            </tr>
                            <!-- Row End here -->
                            
                            
                            
                            <!-- Row Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-item="menu" value="purchase_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Purchase</span>
                                      </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add Purchase
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;All Purchase
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="wise">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Item Wise
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="return">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;Add Purchase Return
                                      </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="all_return">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        &nbsp;All Purchase Return
                                      </label>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row End here -->
                            
                            
                            
                            <!-- Row Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-item="menu" value="raw_stock_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Stock</span>
                                      </label>
                                    </div>
                                </th>
                                <tdcolspan="3" width="320"></td>
                            </tr>
                            
                            
                            <!--Short List-->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="short_list_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Short List</span>
                                        </label>
                                    </div>
                                </th>
                                <tdcolspan="3" width="320"></td>
                            </tr>
                            
                            
                            <!-- Order List Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="order_list_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Order List</span>
                                        </label>
                                    </div>
                                </th>
                                <tdcolspan="3" width="320"></td>
                            </tr>
                            
                            
                            <!-- Expired List Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="order_list_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Expired List</span>
                                        </label>
                                    </div>
                                </th>
                                <tdcolspan="3" width="320"></td>
                            </tr>
                            
                            
                            <!-- Sale Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                      <label>
                                        <input type="checkbox" data-item="menu" value="sale_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Sale</span>
                                      </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Cash Sale
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="credit_sale">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Credit Sale
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="new_sale">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            New Sale
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View Sales
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="wise">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Search Items Wise
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Income Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="income_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Income</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="income_menu" data-item="action" value="field">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Field of Income
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="income_menu" data-item="action" value="new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            New Income
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="income_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Income
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Expenditure Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="cost_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Expenditure</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="cost_menu" data-item="action" value="field">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Field of Expenditure
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="cost_menu" data-item="action" value="new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            New Expenditure
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="cost_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Expenditure
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Due List Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="due_list_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Due List</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="due_list_menu" data-item="action" value="cash">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Cash Party Due
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="due_list_menu" data-item="action" value="credit">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Credit Party Due
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="due_list_menu" data-item="action" value="supplier">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Supplier Due
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Banking Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="bank_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Banking</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="add-bank">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Bank
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Account
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="all-acc">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Account
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="add">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Transaction
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Bank ledger
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Ledger Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Ledger</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="ledger" data-item="action" value="company-ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Supplier
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="ledger" data-item="action" value="client-ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Client
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Report Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="report_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Report</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="purchase_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Purchase Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="sales_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Sale Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="income_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Income Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="cost_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Expenditure Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="balance_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Balance Sheet
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Profit & Loss Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="net_profit_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Profit & Loss</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320"></td>
                            </tr>
                            
                            
                            <!-- Settings Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="theme_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Settings</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="theme_menu" data-item="action" value="logo">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Banner / Icon
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="theme_menu" data-item="action" value="tools">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Theme Tools
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Privilege Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="privilege-menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Privilege</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320"></td>
                            </tr>
                            
                            
                            <!-- Data Backup Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="backup_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Data Backup</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="backup_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Export Data
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // get all users
        $('select#privilege').on("change", function () {
            var data = [];
            var obj = {'privilege': $(this).val()};

            $.ajax({
                type: "POST",
                url: "<?php echo site_url("ajax/retrieveBy/users"); ?>",
                data: "condition=" + JSON.stringify(obj)
            }).done(function (response) {
                var items = $.parseJSON(response);
                data.push('<option value="">-- Select --</option>');
                $.each(items, function (i, el) {
                    data.push('<option value="' + el.id + '">' + el.username + '</option>');
                });
                $('select#user_id').html(data);
            });
        });
        $("#check_view").on('change', function (event) {
            if ($(this).is(":checked")) {
                $('input[type="checkbox"][value="view"]').prop({checked: true});
            } else {
                $('input[type="checkbox"][value="view"]').prop({checked: false});
            }
        });
        $("#check_edit").on('change', function (event) {
            if ($(this).is(":checked")) {
                $('input[type="checkbox"][value="edit"]').prop({checked: true});
            } else {
                $('input[type="checkbox"][value="edit"]').prop({checked: false});
            }
        });
        $("#check_delete").on('change', function (event) {
            if ($(this).is(":checked")) {
                $('input[type="checkbox"][value="delete"]').prop({checked: true});
            } else {
                $('input[type="checkbox"][value="delete"]').prop({checked: false});
            }
        });
        //Getting All Menu Name It's Just for use the data
        var input = $('input[type="checkbox"][data-item="menu"]');
        var list = [];
        $.each(input, function (index, el) {
            list.push($(el).val());
        });
        // console.log(list);
        //Set Privilege Data Start
        $('input[type="checkbox"]').on('change', function (event) {
            if ($('select[name="privilege"]').val() != "" && $('select[name="user_id"]').val() != "") {
                $("#progress").fadeIn(300);
                //Collecting all data start here
                var access_item = {};
                var input = $('input[type="checkbox"]');
                $.each(input, function (index, el) {
                    if ($(el).is(":checked")) {
                        //access_item.push($(el).val());
                        if ($(el).data("item") == "menu") {
                            //action data collection Start here
                            var ac_el = $('input[data-menu="' + $(el).val() + '"]');
                            var action_data = [];
                            $.each(ac_el, function (ac_i, ac_el) {
                                if ($(ac_el).is(":checked")) {
                                    action_data.push($(ac_el).val());
                                }
                            });
                            //action data collection End here
                            access_item[$(el).val()] = action_data;
                        }
                    }
                });
                //console.log(access_item);
                var access = JSON.stringify(access_item);
                //console.log(access);
                var privilege_name = $('select[name="privilege"]').val();
                var user_id = $('select[name="user_id"]').val();
                //Collecting All data end here
                //Sending Request Start here
                $.ajax({
                    url: '<?php echo site_url("privilege/privilege/set_privilege_ajax"); ?>',
                    type: 'POST',
                    data: {
                        privilege_name: privilege_name,
                        user_id: user_id,
                        access: access
                    }
                })
                .done(function (response) {
                    //console.log(response);
                    $("#progress").fadeOut(300);
                });
                //Sending Request End here
            } else {
                alert("Please select a Privilege and User Name.");
                return false
            }
        });
        //Set Privilege Data End
        //Get Privilege Data Start
        $('select[name="user_id"]').on('change', function (event) {
            $('input[type="checkbox"]').prop({checked: false});
            //Sending Request Start here
            var user_id = $(this).val();
            var privilege_name = $('#privilege').val();
            $.ajax({
                url: '<?php echo site_url("privilege/privilege/get_privilege_ajax"); ?>',
                type: 'POST',
                data: {user_id: user_id, privilege_name: privilege_name}
            }).done(function (response) {
                if (response != "error") {
                    var data = $.parseJSON(response);
                    access = $.parseJSON(data.access);
                    //console.log(access);
                    $.each(access, function (access_index, access_val) {
                        //console.log(access_index);
                        //data-item="menu" value="theme_ettings"
                        $('input[data-item="menu"][value="' + access_index + '"]').prop({checked: true});
                        $.each(access_val, function (action_in, action_val) {
                            $('input[data-item="action"][data-menu="' + access_index + '"][value="' + action_val + '"]').prop({checked: true});
                        });
                        //$('input[name="'+el.module_name+'"][value="'+access_val+'"]').prop({checked: true});
                    });
                }
            });
            //Sending Request End here
        });
        //Get Privilege Data End
    });
</script>