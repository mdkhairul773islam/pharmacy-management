<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{
            display: block !important;
        }
        .title{
            font-size: 25px;
        }
    }

</style>

<div class="container-fluid">
    <div class="row">

    <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Profit & Loss</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <?php
                    $attribute = array('class' => 'form-horizontal');
                    echo form_open('', $attribute);
                ?>

                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">Voucher No.</label> -->
                    <div class="col-md-3">
                        <input type="number" name="search[voucher_no]" class="form-control" placeholder="Voucher No.">
                    </div>

                    <!-- <label class="col-md-2 control-label">From</label> -->
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control"  placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <!-- <label class="col-md-2 control-label">To</label> -->
                        <div class="input-group date" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

    <?php if ($resultInfo !=null) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left"> Show Result </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">      
                        <?php $this->load->view('print');?>   
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="hide text-center" style="margin-top: 0px;"> Profit/Loss Report</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40">SL</th>
                                <th>Date</th>
                                <th>Voucher</th>
                                <th>Purchase</th>
                                <th>Sale</th>
                                <th>Qty</th>
                                <th>Discount</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Profit</th>
                                <th>Loss</th>
                            </tr>
        
                            <?php
                            $totalProfit = $totalLoss =  $totalQuantity = $totalPurchase = $totalSale = $total_paid = $total_due = $total_discount = 0;
                            foreach ($resultInfo as $key => $value) {
                                $profitor = ($value->sale_price - $value->purchase_price)-$value->total_discount;
                                $totalProfit += ($profitor > 0 ? $profitor : 0);
                                $totalLoss   += ($profitor < 0 ? $profitor : 0);
                                $total_discount += $value->total_discount;
                                $totalPurchase += $value->purchase_price;
                                $totalSale += $value->sale_price;
                                $total_paid += $value->paid;
                                $total_due += $value->due;
                                $totalQuantity += $value->total_quantity;
                            ?>
        
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo $value->voucher_no; ?></td>
                                <td><?php echo $value->purchase_price; ?></td>
                                <td><?php echo $value->sale_price; ?></td>
                                <td><?php echo $value->total_quantity; ?></td>
                                <td><?php echo $value->total_discount; ?></td>
                                <td><?php echo $value->paid; ?></td>
                                <td><?php echo $value->due; ?></td>
                                <td><?php echo ($profitor > 0 ? $profitor : 0);?></td>
                                <td><?php echo ($profitor < 0 ? abs($profitor) : 0);?></td>
                            </tr>
                            <?php } ?>
        
                            <tr class="bg-info" style="font-weight: bold;">
                                <td class="text-center" colspan="3">Total </td>
                                <td>
                                    <?php echo  $totalPurchase;?> Tk
                                </td>
                                <td>
                                    <?php echo  $totalSale;?> Tk
                                </td>
                                <td>
                                    <?php echo $totalQuantity;?> 
                                </td>
                                <td>
                                    <?php echo $total_discount;?> Tk
                                </td>
                                <td>
                                    <?php echo $total_paid;?> Tk
                                </td>
                                <td>
                                    <?php echo $total_due;?> Tk
                                </td>
                                <td>
                                    <?php echo $totalProfit;?> Tk
                                </td>
                                <td>
                                    <?php echo abs($totalLoss);?> Tk
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>


<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });

</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

