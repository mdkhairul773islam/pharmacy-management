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
                    <h1>View Sales Item Report </h1>
                </div>
            </div>
            <div class="panel-body" >
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">Sales Item</label> -->
                    <div class="col-md-3">
                        <select name="search[product_code]" class="selectpicker form-control"  data-show-subtext="true" data-live-search="true">
                            <option selected disabled>-- Select Sales Item --</option>
                            <?php foreach ($productionItems as $value) { ?>
                            <option value="<?php echo $value->product_code; ?>"><?php echo filter($value->product_name); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- <label class="col-md-2 control-label">From</label> -->
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control"  placeholder="From ( YYYY-MM-DD )">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <!-- <label class="col-md-2 control-label">To</label> -->
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To ( YYYY-MM-DD )">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" value="Show" name="find" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
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
                
                <h4 class="hide text-center" style="margin-top: 0px;">All Sales Report</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Sale Price</th>
                        <th>Amount (TK)</th>
                        
                    </tr>
                    <?php if($results !=null){
                        $total_amount = 0;
                        $total_quantity = 0;
                        foreach ($results as $key => $value) {
                            $amount = $value->quantity*$value->sale_price;
                            $where = array('product_code' => $value->product_code);
                            $productInfo = $this->action->read("products",$where);
                            $total_quantity += $value->quantity;
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->sap_at; ?></td>
                        <td><?php echo $value->voucher_no; ?></td>
                        <td><?php echo ($productInfo)? filter($productInfo[0]->product_name):""; ?></td>
                        <td><?php echo ($productInfo)? filter($productInfo[0]->unit):""; ?></td>
                        <td><?php echo $value->quantity; ?></td>
                        <td><?php echo $value->sale_price; ?></td>
                        <td><?php echo $amount; ?></td>
                    </tr>
                    <?php
                    $total_amount += $amount;
                    } ?>
                    <tr>
                        <td colspan="5"><span class="pull-right"><strong>Total</strong></span></td>
                        <td><?php echo $total_quantity; ?> Qty</td>
                        <td></td>
                        <td><?php echo $total_amount; ?> Tk</td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
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