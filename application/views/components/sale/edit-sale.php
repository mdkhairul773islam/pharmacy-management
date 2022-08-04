<script src="<?php echo site_url('private/js/ngscript/EditSaleEntryCtrl.js?') . time(); ?>"></script>
<style>
    .table2 tr td {
        padding: 0 !important;
    }

    .table2 tr td input {
        border: 1px solid transparent;
    }

    .table tr th.th-width {
        width: 100px !important;
    }
</style>

<div class="container-fluid" ng-controller="EditSaleEntryCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Sale Voucher</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale/saleEditCtrl/update', $attr);
                ?>

                <input type="hidden" name="voucher_no" ng-init="voucher_no='<?php echo $voucherInfo->voucher_no; ?>'"
                       ng-model="voucher_no" ng-value="voucher_no">

                <div class="col-md-5">
                    <label class="col-md-2">Date</label>
                    <div class="form-group col-md-8">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" value="<?php echo $voucherInfo->sap_at; ?>" class="form-control"
                                   placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <label class="col-md-6">Voucher No: <?php echo $voucherInfo->voucher_no; ?></label>

                <hr style="margin-top: 6px;">


                <!-- all input hidden file -->
                <input type="hidden" name="party_code" ng-value="info.partyCode">
                <input type="hidden" name="sap_type" ng-value="info.sapType">

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th style="width:275px;">Product Name</th>
                        <th width="80px">Unit</th>
                        <th width="80px">Stock</th>
                        <th width="80px">Old Qty.</th>
                        <th width="80px">New Qty.</th>
                        <th width="100px">Sale Price</th>
                        <th width="100px">Discount</th>
                        <th width="100px">Old Total</th>
                        <th width="100px">Total</th>
                    </tr>
                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" name="product_name[]" class="form-control" ng-model="item.product_name" >
                            <input type="hidden" name="id[]" ng-value="item.id">
                            <input type="hidden" name="stock_id[]" ng-value="item.stock_id">
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="profit[]" ng-value="getProfitFn($index)" readonly>
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control" ng-model="item.unit" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
                        </td>
                        <td>
                            <input type="text" name="old_quantity[]" class="form-control" ng-model="item.old_quantity" step="any" readonly>
                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" ng-model="item.quantity" min="0" step="any" autocomplete="off">
                        </td>
                        <td>
                            <input type="number" name="sale_price[]" 
                            class="form-control" 
                            ng-model="item.sale_price"
                            min="<?= $this->session->userdata['privilege'] =='user' ? '{{ item.min_sale_price }}' : '' ?>"
                            step="any" autocomplete="off">
                            <input type="hidden" name="purchase_price[]" ng-value="item.purchase_price" step="any">
                        </td>
                        <td>
                            <input type="number" name="discount[]" class="form-control" min="0" ng-model="item.discount"
                                   step="any" autocomplete="off">
                        </td>
                        <td>
                            <input type="number" class="form-control" ng-value="setOldSubtotalFn($index)" readonly>
                            <input type="hidden" ng-value="purchaseSubtotalFn($index)" step="any">
                        </td>

                        <td>
                            <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                        </td>
                    </tr>
                </table>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Client</label>
                            <div class="col-md-8">
                                <input type="text" value="<?php echo $partyInfo['name']; ?>"
                                       class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Mobile </label>
                            <div class="col-md-8">
                                <input type="text" value="<?php echo $partyInfo['mobile']; ?>"
                                       class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Address</label>
                            <div class="col-md-8">
                                        <textarea class="form-control"
                                                  readonly><?php echo $partyInfo['address']; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <input type="hidden" name="total_profit" ng-value="totalProfitFn()" class="form-control" step="any" readonly>
                        <!--<div class="form-group">
                            <label class="col-md-4 control-label"> Total Profit </label>
                            <div class="col-md-8">
                                <input type="number" name="total_profit" ng-value="totalProfitFn()" class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Quantity </label>
                            <div class="col-md-8">
                                <input type="number" name="total_quantity" ng-value="getTotalQtyFn()" class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total </label>
                            <div class="col-md-8">
                                <input type="number" name="total" ng-value="getTotalFn()" class="form-control"
                                       step="any" readonly>
                                <input type="hidden" name="purchase_total" ng-value="getPurchaseTotalFn()"
                                       class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Discount</label>
                            <div class="col-md-8">
                                <input type="number" name="total_discount" ng-model="total_discount"
                                       class="form-control" step="any">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Grand Total</label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()"
                                       class="form-control" step="any" readonly>
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
                            <label class="col-md-4 control-label">Paid <span class="req">*</span></label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="payment" class="form-control"
                                               step="any">
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" class="form-control" ng-init="transactionBy='cash'"
                                                ng-model="transactionBy" required>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bKash">bKash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- for selecting cheque -->
                        <div ng-if="transactionBy == 'cheque'">
                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Bank Name <span class="req">*</span>
                                </label>
                                <div class="col-md-8">
                                    <select name="meta[bankname]" class="form-control">
                                        <option value="" selected disabled>&nbsp;</option>
                                        <?php foreach (config_item("banks") as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Branch Name <span class="req">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" name="meta[branchname]" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Cheque No <span class="req">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" name="meta[chequeno]" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Pass Date <span class="req">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" name="meta[passdate]" placeholder="YYYY-MM-DD"
                                           class="form-control">
                                    <input type="hidden" name="meta[status]" value="pending">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <!--label class="col-md-4 control-label">Current Balance </label-->
                            <label class="col-md-4 control-label">Due</label>
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

                        <div class="form-group" ng-if="promise_date">
                            <label class="col-md-4 control-label">Promise Date</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="date" name="promise_date" value="<?php echo $voucherInfo->promise_date; ?>" placeholder="YYYY-MM-DD"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group pull-right">
                    <input type="submit" name="update" value="Update" class="btn btn-primary">
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
