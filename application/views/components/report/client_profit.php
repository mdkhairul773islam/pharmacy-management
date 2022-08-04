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
        .hide {display: block !important;}
        .title {font-size: 25px;}
    }
</style>

<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Profit/Loss Report</h1>
                </div>
            </div>
            <div class="panel-body" ng-cloak>
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">Product Name</label> -->
                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Client Name --</option>
                            <?php foreach ($allClients as $key => $client) { ?>
                            <option value="<?php echo $client->code; ?>"><?php echo $client->name; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- <label class="col-md-2 control-label">Voucher No.</label> -->
                    <div class="col-md-3">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No.">
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
                <!--print header start-->                    		    
                <?php $this->load->view('print');?>                    		    
                <!--print header end-->

                <h4 class="hide text-center" style="margin-top: 0px;"> Profit/Loss Report</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th>Voucher No</th>
                        <th>Quantity</th>
                        <th>Purchase price</th>
                        <th>Sales Price</th>
                        <th>Profit</th>
                        <th>Loss</th>
                    </tr>
           
                    <?php 

                    $totalLoss = $totalProfit =  $totalQuantity = $totalPurchase = $totalSale = 0;
                    $vouchar_purchase = $vouchar_sale = $vouchar_profit = $vouchar_loss = $vouchar_quantity = 0;
                    $counter = 1;
                    foreach ($resultInfo as $key => $value) {
                        
                        $sapitemsInfo = $this->action->read('sapitems', array('voucher_no' => $value->voucher_no, 'trash' => 0));
                        
                        $vouchar_purchase = $this->action->read_sum('sapitems', 'purchase_price', array('voucher_no' => $value->voucher_no, 'trash' => 0));
                        $vouchar_sale = $this->action->read_sum('sapitems', 'sale_price', array('voucher_no' => $value->voucher_no, 'trash' => 0));
                        $vouchar_quantity = $this->action->read_sum('sapitems', 'quantity', array('voucher_no' => $value->voucher_no, 'trash' => 0));

                        // dectect profit or loss
                        $loss = $profit = 0.00;
                        
                        if ($vouchar_purchase[0]->purchase_price > $vouchar_sale[0]->sale_price) {
                            $loss = $vouchar_purchase[0]->purchase_price - $vouchar_sale[0]->sale_price;
                        }else{
                            $profit = $vouchar_sale[0]->sale_price - $vouchar_purchase[0]->purchase_price;
                        }
                        
                        // count total accounce
                        $totalLoss += $loss;
                        $totalProfit += $profit;
                        $totalPurchase += $vouchar_purchase[0]->purchase_price;
                        $totalSale += $vouchar_sale[0]->sale_price;
                        $totalQuantity += $vouchar_quantity[0]->quantity;
                        
                        foreach ($sapitemsInfo as $key => $val) {
                            // read product name by code
                            $where = array('code' => $value->party_code, 'trash' => 0 );
                            $nameInfo = $this->action->read('parties', $where);
                        }
                    ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo (isset($nameInfo[0]->name)) ? filter($nameInfo[0]->name) : ''; ?></td>
                        <td><?php echo (isset($nameInfo[0]->address)) ? filter($nameInfo[0]->address) : ''; ?></td>
                        <td><?php echo $value->voucher_no; ?></td>
                        <td><?php echo $vouchar_quantity[0]->quantity; ?></td>
                        <td><?php echo $vouchar_purchase[0]->purchase_price; ?></td>
                        <td><?php echo $vouchar_sale[0]->sale_price; ?></td>
                        <td><?php echo $profit; ?></td>
                        <td><?php echo $loss; ?></td>
                    </tr>
                    <?php } ?>

                    <tr class="bg-info" style="font-weight: bold;">
                        <td colspan="5" class="text-center">Total <small> (profit & loss)</small></td>
                        <td >
                            <?php echo $totalPurchase;?> Tk
                        </td>
                        <td >
                            <?php echo $totalSale;?> Tk
                        </td>
                        <td >
                            <?php echo $totalProfit;?> Tk
                        </td>
                        <td>
                            <?php echo $totalLoss;?> Tk
                        </td>
                    </tr>
                </table>
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

