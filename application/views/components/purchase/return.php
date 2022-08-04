<script src="<?php echo site_url('private/js/ngscript/returnPurchaseCtrl.js') ?>"></script>
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
        width: 100px !important;
    }
</style>
<div class="container-fluid" ng-controller="returnPurchaseCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Return Purchase Voucher Wise</h1>
                </div>
            </div>
            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('purchase/return_purchase/update', $attr);
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="date" class="form-control" value="<?php echo $voucherInfo->sap_at; ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="voucher_no" class="form-control" ng-init="voucher_no='<?php echo $voucherInfo->voucher_no; ?>'"
                               ng-model="voucher_no" ng-value="voucher_no" readonly>
                    </div>
                </div>

                <hr>

                <!-- product table -->
                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Product Name</th>
                        <th>Batch No</th>
                        <th>Expiry Date</th>
                        <th width="80px">Unit</th>
                        <th class="th-width">Qty.</th>
                        <th class="th-width">Return</th>
                        <th class="th-width">New Qty.</th>
                        <th style="width: 133px;">P.Price</th>
                        <th class="th-width">Old Total</th>
                        <th class="th-width">Total</th>
                    </tr>
                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" tabindex="-1" name="product_name[]" class="form-control"
                                   ng-model="item.product_name" readonly>
                            <input type="hidden" tabindex="-1" name="id[]" value="{{ item.id }}">
                            <input type="hidden" tabindex="-1" name="product_code[]" value="{{ item.product_code }}">
                            <input type="hidden" tabindex="-1" name="product_cat[]" value="{{ item.product_cat }}">
                            <input type="hidden" tabindex="-1" name="subcategory[]" value="{{ item.subcategory }}">
                            <input type="hidden" tabindex="-1" name="sale_price[]" value="{{ item.sale_price }}">
                            <input type="hidden" tabindex="-1" name="old_quantity[]" value="{{item.old_quantity}}">
                        </td>
                        <td>
                            <input type="text" name="batch_no[]" class="form-control" ng-value="item.batch_no" readonly>
                        </td>
                        <td>
                            <input type="text" name="expire_date[]" class="form-control" ng-value="item.expire_date" readonly>
                        </td>
                        <td>
                            <input type="text" tabindex="-1" name="unit[]" class="form-control" ng-model="item.unit"
                                   readonly>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="0"
                                   ng-value="item.quantity" readonly>
                        </td>
                        <td>
                            <input type="number" name="return_quantity[]" class="form-control" min="0"
                                   ng-model="item.return_quantity">
                        </td>

                        <td>
                            <input type="number" name="new_quantity[]" class="form-control" min="0" ng-value="getNewQuantityFn($index)" readonly>
                        </td>
                        <td>
                            <input type="number" name="purchase_price[]" class="form-control" min="0"
                                   ng-model="item.price" step="any">
                        </td>
                        <td>
                            <input type="text" tabindex="-1" name="old_subtotal[]" class="form-control"
                                   ng-model="item.old_subtotal" ng-value="setOldSubtotalFn($index)" readonly>
                        </td>
                        <td>
                            <input type="text" tabindex="-1" name="subtotal[]" class="form-control"
                                   ng-model="item.subtotal" ng-value="setSubtotalFn($index)" readonly>
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Name </label>
                            <div class="col-md-8">
                                <input type="text"  class="form-control" value="<?php echo $partyInfo->name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Mobile </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" value="<?php echo $partyInfo->mobile; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Address </label>
                            <div class="col-md-8">
                                <textarea class="form-control"  rows="4" readonly><?php echo $partyInfo->address; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
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
                                <input type="number" name="total_discount" ng-model="total_discount"
                                       class="form-control" step="any" max="{{ getTotalFn() }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Transport Cost </label>
                            <div class="col-md-8">
                                <input type="number" name="transport_cost" ng-model="transport_cost"
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
                                        <input type="number" name="paid" ng-model="payment" class="form-control"
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
                            <input type="submit" name="update" value="Update" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    // linking between two date
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD',
    });
</script>