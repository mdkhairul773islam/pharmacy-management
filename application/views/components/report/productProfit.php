<?php
    $footer_info=json_decode($meta->footer,true);
    $header_info=json_decode($meta->header,true);
?>
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
    .hide h2{
        padding-left: 40px;
    }
    .hide h4{
        padding: 3px 0;
        padding-left: 40px;
    }

</style>

<div class="container-fluid">
    <div class="row">

    <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Profit Report</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <?php
                    $attribute = array('class' => 'form-horizontal');
                    echo form_open('', $attribute);
                ?>

                <div class="form-group">
                    <!--<div class="col-md-3">-->
                    <!--    <select name="search[product_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >-->
                    <!--        <option value="" selected disabled>-- Product Name --</option>-->
                    <!--        <?php foreach ($allProducts as $key => $product) { ?>-->
                    <!--        <option value="<?php echo $product->product_code; ?>"><?php echo $product->product_name; ?>-->
                    <!--        </option>-->
                    <!--        <?php } ?>-->
                    <!--    </select>-->
                    <!--</div>-->

                    <!--<div class="col-md-3">
                        <input type="number" name="search[voucher_no]" class="form-control" placeholder="Voucher No.">
                    </div>-->

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control"  placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
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
        
        <?php if($profitInfo && $costInfo) { ?>

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
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <caption class="text-center"><strong style="font-size: 18px;">Total Sale</strong></caption>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <!--<th>Invoice No</th>-->
                            <th>Amount</th>
                        </tr>
                        <?php $totalProfit = 0.00;
                        foreach($profitInfo as $key => $value){?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value->sap_at; ?></td>
                            <!--<td><?php // echo $value->voucher_no; ?></td>-->
                            <td><?php echo $value->total_profit; $totalProfit += $value->total_profit ?> TK</td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3">Total</th>
                            <th><?php echo $totalProfit; ?> Tk</th>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <caption class="text-center"><strong style="font-size: 18px;">Total Cost</strong></caption>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Cost Field</th>
                            <th>Amount</th>
                        </tr>
                        <?php   $totalAmount = 0.00;
                                foreach($costInfo as $key => $value){?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value->date; ?></td>
                            <td><?php echo filter($value->cost_field); ?></td>
                            <td><?php echo $value->amount; $totalAmount +=$value->amount; ?> TK</td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3">Total</th>
                            <th><?php echo $totalAmount; ?> Tk</th>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-8 col-md-offset-2">
                    <?php $netProfit = $totalProfit - $totalAmount; ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Total Profit</th>
                            <th>Total Cost</th>
                            <th>Net Profit</th>
                        </tr>
                        <tr>
                            <th><?php echo $totalProfit; ?> Tk</th>
                            <th><?php echo $totalAmount; ?> Tk</th>
                            <th style="<?php if($netProfit < 0){echo 'color: red'; }else{echo 'color: green'; } ?>"><?php echo $netProfit; ?></th>
                        </tr>
                    </table>
                </div>
            </div>
        
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<?php } ?>

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