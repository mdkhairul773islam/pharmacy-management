<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css"/>

<script src="<?php echo site_url('private/js/ngscript/NewSaleEntryCtrl.js?') . time(); ?>"></script>

<style>
    .company_title {display: block !important;}
    .content-fixed-nav {padding-left: 15px;}
    .table2 tr td {padding: 0 !important;}
    .table2 tr td input {border: 1px solid transparent;}
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
    #page-content-wrapper {background: #ECEFF4;}
    .select2-choice {border-radius: 0 !important;}
    .custom_sale_table .form-control {height: 30px;}
    .custom_sale_table tr td {line-height: 18px !important;}
    .custom_sale_table .btn {padding: 4px 12px !important;}
    .screen_list {display: flex !important;}
    .full_screen_btn {
        background: #28A9E0;
        border-radius: 50%;
        text-align: center;
        font-size: 20px;
        border: none;
        color: #fff;
        width: 38px;
        height: 38px;
        outline: none;
        box-shadow: none;
    }
    .title_select {
        border: 1px solid #28A9E0;
        display: flex;
    }
    .title_select label {
        border: 1px solid #ccc;
        line-height: 40px;
        padding: 0 12px;
        margin: 0;
    }
    .select2-choice {
        text-transform: capitalize !important;
        line-height: 31px !important;
        font-size: 15px !important;
        height: 42px !important;
    }
    .select2-choice>span:first-child, .select2-chosen {
        padding: 5px 12px !important;
    }
    .select2-container {
        overflow: hidden !important;
        height: 42px;
    }
    .select2-container .select2-choice .select2-arrow b {background-position: 0 6px;}
    .title_date {border: 1px solid #28A9E0;}
    .title_date .form-control {
        line-height: 42px !important;
        height: 42px !important;
    }
    .select2-results .select2-result-label {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .title_date .input-group-addon {border-radius: 0 !important;}
    .table_style {
        height: 70vh !important;
        height: 100%;
        overflow: auto;
    }
    .custom_placeholder {position: relative;}
    .custom_placeholder span {
        position: absolute;
        right: 1px;
        background: #ddd;
        top: 1px;
        height: 32px;
        line-height: 32px;
        padding: 0 5px;
        font-size: 14px;
        min-width: 26px;
        text-align: center;
    }
    .d-none {display: none;}
    .submit_but_custom {padding-left: 0;}
    .submit_but_custom .btn {
        width: 100%;
        height: 54px;
        font-size: 19px;
        padding: 0;
        text-transform: uppercase;
        outline: none;
    }
    .developed_part .time {
        padding: 27px 12px;
        background: #ddd;
        text-align: center;
    }
    .developed_part .time h3 {
        font-weight: bold;
        font-size: 29px;
        color: #28A9E0;
        margin: 0;
    }
    .developed_part .developed {
        background: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .developed_part .developed>a {
        display: inline-block;
        padding: 5px 12px;
    }
    .developed_part .developed img {
        max-width: 162px;
        min-height: 75px;
        width: 100%;
    }
    .developed_part .developed h4 {
        position: absolute;
        color: #286090;
        top: -5px;
        left: 5px;
        font-weight: 700;
        font-size: 15px;
    }
    .page_ctrl {
        min-height: calc(100vh - 97px);
        margin-bottom: 0;
    }
    .page_ctrl.active {min-height: 100vh;}
    .page_ctrl.active .panel-body {padding: 30px 15px 15px;}
    .page_ctrl.active .developed_part .time {padding: 20px 12px;}
    .page_ctrl.active .developed_part .time h3 {font-size: 40px;}
    @media print {
        .content-fixed-nav {display: none;}
    }
    @media screen and (min-width: 991px) {
        .desktop_padding {padding-left: 5% !important;}
    }
    @media screen and (max-width: 991px) {
        .table_style {height: auto !important;}
    }
</style>
<div class="container-fluid" id="screen_area" ng-controller="NewSaleEntryCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel page_ctrl panel-default">
            <div class="panel-body" ng-cloak>
                <div class="row">
                    
                    <form action="<?php echo site_url('sale/new_sale/store');?>" method="post">
                        <div class="col-md-7">
                         <!-- horizontal form -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group title_select" style="margin-bottom:0;">
                                        <!--<label>Product</label>-->
                                        <input id="productList" class="form-control" placeholder="type product name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <div class="input-group date title_date" id="datetimepicker">
                                            <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" placeholder="YYYY-MM-DD" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin: 10px 0;">
                            <div class="table_style">
                                <table class="table table-bordered table2 custom_sale_table">
                                    <tr>
                                        <th style="width: 40px">SL</th>
                                        <th style="width:200px;">Product Name</th>
                                        <th width="60px">Manufacturer</th>
                                        <th width="60px">Self</th>
                                        <th width="50px">Stock</th>
                                        <th width="50px">Qty</th>
                                        <th width="60px">Price</th>
                                        <!--<th width="50px">Dis</th>-->
                                        <th width="60px">Total</th>
                                        <th width="50px">Action</th>
                                    </tr>
                                    <tr ng-repeat="item in cart">
                                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                                        <td>
                                            <input type="text" name="product_name[]" class="form-control" ng-model="item.product_name" >
                                            <input type="hidden" name="id[]" ng-value="item.id">
                                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                                        </td>
                                        <td>
                                            <input type="text" name="manufacturer[]" class="form-control" ng-value="item.subcategory" >
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" ng-value="item.self_name" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="quantity[]" class="form-control" ng-model="item.quantity" min="1"
                                                   max="{{item.stock_qty}}" step="any" autocomplete="off">
                                            <input type="hidden" name="unit[]" class="form-control" ng-model="item.unit" readonly>
                                            <input type="hidden" class="form-control" name="profit[]" ng-value="getProfitFn($index)" readonly>
                                        </td>
                                        <td>  
                                            
                                            <input type="number" name="sale_price[]" class="form-control" ng-model="item.sale_price" min="<?= $this->session->userdata['privilege'] =='user' ? '{{ item.min_sale_price }}' : '' ?>"
                                                   step="any" autocomplete="off">
                                                   
                                            <input type="hidden" name="purchase_price[]" ng-value="item.purchase_price" step="any">
                                            <input type="hidden" name="discount[]" class="form-control" min="0" ng-model="item.discount" step="any" autocomplete="off">
                                        </td>
                                        <!--<td>
                                            <input type="number" name="discount[]" class="form-control" min="0" ng-model="item.discount" step="any" autocomplete="off">
                                        </td>-->
                                        <td>
                                            <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                                            <input type="hidden" ng-value="purchaseSubtotalFn($index)" step="any">
                                        </td>
                                        <td class="text-center">
                                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                                <i class="fa fa-times fa-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-md-5 desktop_padding">
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label">Sale Type</label>
                                    <div class="col-md-8" ng-init="stype='cash';">
                                        <select name="stype" class="form-control" ng-model="stype" ng-change="getsaleType(stype)" required>
                                            <option value="cash">Cash</option>
                                            <option value="credit">Credit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div ng-if="active==true">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label">Client Name</label>
                                        <div class="col-md-8">
                                            <input type="text" name="client_name" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label">Mobile</label>
                                        <div class="col-md-8">
                                            <input type="text" name="partyInfo[mobile]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div ng-if="active==false">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label">Client Name</label>
                                        <div class="col-md-8">
                                            <select name="party_code" ng-model="party_code" ng-change="getClientInfo(party_code)" class="form-control">
                                                <option value="">--Select Client--</option>
                                                <?php if(!empty($allParty)){ foreach($allParty as $key => $party){ ?>
                                                <option value="<?php echo $party->code; ?>"><?php echo $party->name."-".$party->address; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr style="margin: 10px 0 12px;">
                            <div class="form-group d-none">
                                <div class="row">
                                    <label class="col-md-4 control-label">Total Profit</label>
                                    <div class="col-md-8">
                                        <input type="number" name="total_profit" ng-value="totalProfitFn()" class="form-control" step="any" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label">Total Qty</label>
                                    <div class="col-md-8">
                                        <input type="number" name="total_quantity" ng-value="getTotalQtyFn()" class="form-control" step="any" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label">Discount</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-xs-6" style="padding-right: 0;">
                                                <div class="custom_placeholder">
                                                    <input type="number" ng-model="total_discount" class="form-control" step="any">
                                                    <input type="hidden" ng-value="total_discount_m" name="total_discount">
                                                    <span>Tk</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="custom_placeholder">
                                                    <input type="number" name="discount_percentege" ng-model="discount_percentege" value="0" class="form-control" step="any">
                                                    <span>%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label">Total</label>
                                    <div class="col-md-8">
                                        <input type="number" name="total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                                        <input type="hidden" name="purchase_total" ng-value="getPurchaseTotalFn()" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div ng-if="active==false" class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label">Previous Balance</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <input type="number" name="previous_balance" ng-model="balance" class="form-control" step="any" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="previous_sign" ng-value="sign" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label">Paid Type</label>
                                    <div class="col-md-8">
                                        <select name="paid_type" class="form-control">
                                            <option value="cash">Cash</option>
                                            <option value="bkash">bKash</option>
                                            <option value="nagad">Nagad</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label" style="font-size:24px;">Paid</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="number" name="paid" ng-model="payment" class="form-control" step="any" style="background: #00cc00; height: 45px; color: #fff; font-size: 25px;">
                                            </div>
                                            <div class="col-md-5 d-none">
                                                <select name="method" class="form-control" ng-init="transactionBy='cash'" ng-model="transactionBy" required>
                                                    <option value="cash">Cash</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="bKash">bKash</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- for selecting cheque -->
                            <div ng-if="transactionBy == 'cheque'">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label">Bank Name <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <select name="meta[bankname]" class="form-control">
                                                <option value="" selected disabled>&nbsp;</option>
                                                <?php foreach (config_item("banks") as $key => $value) { ?>
                                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label">Branch Name <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="meta[branchname]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label">Cheque No <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="meta[chequeno]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label">Pass Date <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="meta[passdate]" placeholder="YYYY-MM-DD"
                                                   class="form-control">
                                            <input type="hidden" name="meta[status]" value="pending">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label" style="font-size:24px;" >{{ status }}</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="number" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly style="background: #E5C410; height: 45px; color: #fff; font-size: 25px;">
                                            </div>
                                            <div class="col-md-5 d-none">
                                                <input type="text" name="current_sign" ng-value="c_sign" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group d-none" ng-if="promise_date">
                                <div class="row">
                                    <label class="col-md-4 control-label">Promise Date</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="date" name="promise_date" placeholder="YYYY-MM-DD" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 control-label" style="font-size: 24px;">Grand Total</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <input type="number" name="grand_total" ng-model="g_total"  ng-value="getGrandTotalFn()" class="form-control" step="any" readonly style="font-size: 32px; background: red; height: 54px; color: #fff;">
                                            </div>
                                            <div class="col-xs-4 submit_but_custom">
                                                <input type="submit" name="save" value="Save" class="btn btn-primary" ng-init="isDisabled=false;" ng-hide="isDisabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group pull-right">
                                <p ng-bind="message" style="font-weight:bold;color:red;font-size:18px;"></p>
                            </div>
                            
                            <!--developed part-->
                            <div class="developed_part">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="time">
                                            <h3>
                                                <span id="h"><?php echo date('h');?></span>:<span id="i"><?php echo date('i');?></span>:<span id="s"><?php echo date('s');?></span><span id="a" style="font-size: 17px;"> <?php echo date('a');?></span>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-xs-6" style="padding-left: 0;">
                                        <div class="developed">
                                            <a href="http://www.freelanceitlab.com/" target="_blank">
                                                <h4>Software By</h4>
                                                <img src="<?php echo site_url('private/images/logo.png');?>" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
<script src="<?php echo site_url('private/js/screen.js');?>"></script>
<script>
    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
    (function () {
        // initialize select2 dropdown
        $('#productList').select2({
            data: dropdownData(),
            placeholder: 'search',
            multiple: false,
            // creating query with pagination functionality.
            query: function (data) {
                var pageSize,
                    dataset,
                    that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function (e) {
                        return e.text.toUpperCase().indexOf(data.term.toUpperCase()) >= 0;
                    });
                } else if (data.term === '') {
                    results = that.data;
                }
                data.callback({
                    results: results.slice((data.page - 1) * pageSize, data.page * pageSize),
                    more: results.length >= data.page * pageSize,
                });
            },
        });
    })();


    function dropdownData() {

        var id_arr = new Array();
        var text_arr = new Array();
        <?php
        $sl = 1;
        if (!empty($allProduct)){ foreach($allProduct as $row){
        ?>
        id_arr["<?php echo $sl; ?>"] = "<?php echo $row->id; ?>";
        text_arr["<?php echo $sl; ?>"] = "<?php echo $row->name ."-" . filter($row->category)." (". filter($row->generic_name) . ")- (".number_format($row->quantity)."-".$row->unit.")"; ?>";

        <?php $sl++;  } } ?>
        return _.map(_.range(1,<?php echo count($allProduct) + 1; ?>), function (i) {
            return {
                id: id_arr[i],
                text: text_arr[i],
            };
        });
    }

</script>