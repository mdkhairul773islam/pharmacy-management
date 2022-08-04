<script src="<?php echo site_url('private/js/ngscript/PurchaseEntry.js?') . time(); ?>"></script>


<style>
    .table2 tr td {
        padding: 0 !important;
    }

    .table2 tr td input {
        border: 1px solid transparent;
    }

    .new-row-1 .col-md-4 {
        margin-bottom: 8px;
    }

    .table tr th.th-width {
        width: 110px !important;
    }

    .red, .red:focus {
        border-color: red;
    }

    .green, .green:focus {
        border-color: green;
    }
    .mb_1{
        margin-bottom: 15px;
    }
</style>
<div class="container-fluid" ng-controller="PurchaseEntry" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Purchase</h1>
                </div>
            </div>
            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('purchase/purchase/store', $attr);
                ?>
                <div class="row">

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"
                                   placeholder="Date" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <input type="text" name="voucher_no" placeholder="Voucher No" class="form-control" required
                               ng-class="{'red': voucher_validation}" ng-model="voucher_no" ng-change="voucherExistsFn(voucher_no)">
                    </div>

                    <!--<div class="col-md-3 mb_1">
                        <input type="text" name="batch_no" placeholder="Batch No" class="form-control" required
                               ng-class="{'red': batch_validation}" ng-model="batch_no" ng-change="batchExistsFn(batch_no)">
                    </div>-->

                    <div class="col-md-3">
                        <select name="party_code" ng-change="setPartyfn(party_code)" ng-model="party_code"
                                class="selectpicker form-control" data-show-subtext="true" data-live-search="true"
                                required>
                            <option value="" selected disabled>-- Supplier Name --</option>
                            <?php if (!empty($allParty)) {
                                foreach ($allParty as $key => $row) { ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <input id="productList" style="width:100%;" placeholder="type product name"/>
                    </div>
                </div>

                <div class="row">
                    
                </div>
                <hr>
                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Product Name</th>
                        <th>Batch No</th>
                        <th>Expiry Date</th>
                        <th width="80px">Unit</th>
                        <th class="th-width">Quantity</th>
                        <th style="width: 133px;">Purchase Price</th>
                        <th class="th-width">Total</th>
                        <th width="50px">Action</th>
                    </tr>
                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" tabindex="-1" name="product_name[]" class="form-control"  ng-model="item.product_name" readonly>
                            <input type="hidden" tabindex="-1" name="product_code[]" value="{{ item.product_code }}">
                            <input type="hidden" tabindex="-1" name="product_cat[]" value="{{ item.product_cat }}">
                            <input type="hidden" tabindex="-1" name="subcategory[]" value="{{ item.subcategory }}">
                            <input type="hidden" tabindex="-1" name="sale_price[]" value="{{ item.sale_price }}">
                            <input type="hidden" tabindex="-1" name="generic_name[]" value="{{ item.generic_name }}">
                        </td>
                        <td>
                            <input type="text" name="batch_no[]" class="form-control" ng-model="item.batch_no">
                        </td>
                        <td>
                            <input type="date" name="expire_date[]" class="form-control" ng-model="item.expire_date">
                        </td>
                        <td>
                            <input type="text" tabindex="-1" name="unit[]" class="form-control" ng-model="item.unit" readonly>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1" ng-model="item.quantity">
                        </td>
                        <td>
                            <input type="number" name="purchase_price[]" class="form-control" min="0" ng-model="item.price" step="any">
                        </td>
                        <td>
                            <input type="text" tabindex="-1" name="subtotal[]" class="form-control" ng-model="item.subtotal" ng-value="setSubtotalFn($index)" readonly>
                        </td>
                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>



                <div class="row">
                    <div class="col-md-offset-6 col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total </label>
                            <div class="col-md-8">
                                <input type="hidden" name="total_quantity" ng-value="getTotalQuantityFn()">
                                <input type="number" name="total" class="form-control" ng-value="getTotalFn()"
                                       step="any" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_discount" ng-model="amount.totalDiscount"
                                       class="form-control" step="any" max="{{ getTotalFn() }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Transport Cost </label>
                            <div class="col-md-8">
                                <input type="number" name="transport_cost" ng-model="amount.transport_cost"
                                       class="form-control" step="any">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Grand Total </label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()"
                                       class="form-control" step="any" min="0" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="previous_balance" ng-model="partyInfo.balance"
                                               class="form-control" step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="previous_sign" ng-value="partyInfo.sign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="amount.paid" class="form-control"
                                               step="any">
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" class="form-control">
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bKash">bKash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="current_balance" ng-value="getCurrentTotalFn()"
                                               class="form-control" step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="partyInfo.csign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group pull-right">
                            <input type="submit" name="save" value="Save" class="btn btn-primary"
                                   ng-disabled="validation">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>

<script>

    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
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

    // For the testing purpose we are making a huge array of demo data
    function dropdownData() {

        var id_arr = new Array();
        var text_arr = new Array();
        <?php
        $sl = 1;
        foreach($allProduct as $row){
        ?>
        id_arr["<?php echo $sl; ?>"] = "<?php echo $row->product_code; ?>";
        text_arr["<?php echo $sl; ?>"] = "<?php echo $row->product_name . "-" . filter($row->product_cat); ?>";

        <?php $sl++;  } ?>
        return _.map(_.range(1,<?php echo count($allProduct) + 1; ?>), function (i) {
            return {
                id: id_arr[i],
                text: text_arr[i],
            };
        });
    }
</script>