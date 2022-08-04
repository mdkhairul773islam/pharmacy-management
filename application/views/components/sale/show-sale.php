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
    }
</style>
<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Sale</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">Voucher No </label> -->
                    <div class="col-md-3">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                    </div>
                    
                    <div class="col-md-3">
                        <select name="search[voucher_no]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Select Manufacturer --</option>
                            <?php foreach ($allProduct as $key => $value) { 
                                $allSubcategories = $this->action->read('products', array('product_code' => $value->product_code));
                            ?>
                            <option value="<?php echo $value->voucher_no; ?>" >
                                <?php echo filter($allSubcategories[0]->subcategory); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- <label class="col-md-2 control-label">Client's Name</label> -->
                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Select Client's Name --</option>
                            <?php foreach ($allClients as $key => $client) { ?>
                            <option value="<?php echo $client->code; ?>" >
                                <?php echo filter($client->name)." ( ".$client->address." ) "; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div><br/><br/>

                    <!-- <label class="col-md-2 control-label">From </label> -->
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <!-- <label class="col-md-2 control-label">To </label> -->
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="btn-group">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php if($result != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner -->
                <!--<img class="img-responsive print-banner hide" src="<?php //echo site_url($banner_info[0]->path); ?>">-->
                <!-- Banner Start Here -->
                <?php
                    $footer_info=json_decode($meta->footer,true);
                    $header_info=json_decode($meta->header,true);
                ?>
                <style>
                    .hide h2{
                            padding-left: 40px;
                    }
                    .hide h4{
                        padding: 3px 0;
                        padding-left: 40px;
                    }
                </style>
                <div class="row hide">
                    <div class="view-profile col-md-12 row">
                        <div class="col-sm-4 col-xs-4 col-sm-offset-1 col-xs-offset-1">
                            <img width="200" style="margin-top: 20px" src="<?php echo site_url($footer_info['footer_img']); ?>">
                        </div>
                        <div class="col-sm-7 col-xs-7">
                            <h2 class="text-left title" style="margin-top: 10px; font-weight: bold;">
                                <?php echo $header_info['site_name']; ?>
                            </h2>
                            
                            <h4 class="text-left" style="margin: 0;">
                                <?php echo $footer_info['addr_address']; ?>
                            </h4>
                            
                            <h4 class="text-left" style="margin: 0;">
                                Mobile: <?php echo $footer_info['addr_moblile']; ?>
                            </h4>
                            
                            <h4 class="text-left" style="margin: 0;">
                                Email: <?php echo $footer_info['addr_email']; ?>
                            </h4>
                        </div>                          
                    </div><hr>
                </div>
                <!-- Banner End Here -->
                <h4 class="text-center hide" style="margin-top: 0px;">All Sale</h4>
                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th width="90">Date</th>
                        <th>Client's Name</th>
                        <th width="100">Voucher No</th>
                        <th width="100">Manufacturer</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th width="210px" class="none">Action</th>
                    </tr>
                    <?php
                    $total_bill = 0.0;
                    $total_discount = 0.00;
                    $amount = $total_paid = $total_due = 0.00;
                    foreach($result as $key => $row){
                        //$due = $row->total_bill - $row->paid;
                    ?>
                    <tr>
                        <td style="width: 50px;"> <?php echo ($key + 1); ?> </td>
                        <td> <?php echo $row->sap_at; ?> </td>
                        <td>
                            <?php
                            if($row->sap_type != "cash" ){
                                $where = array('trash'=>0, 'code' => $row->party_code);
                                $party_info = $this->action->read('parties', $where);
                                if ($party_info != null) {
                                    echo filter($party_info[0]->name);}else{echo "N/A";
                                } } else {
                                    echo filter($row->party_code);
                                }
                            ?>
                        </td>
                        <td><?php echo $row->voucher_no; ?> </td>
                        <td>
                            <?php 
                            $sap_where = array('voucher_no' => $row->voucher_no);
                            $sap_info = $this->action->read('sapitems', $sap_where);
                            if($sap_info){
                                $manufacturer_where = array('product_code' => $sap_info[0]->product_code);
                                $product_info = $this->action->read('products', $manufacturer_where);
                                if($product_info){echo filter($product_info[0]->subcategory);}else{echo '';}; 
                            }
                            ?> 
                        </td>
                        <td><?php echo $row->total_quantity; ?> </td>
                        <td>
                            <?php
                            $total = $row->total_bill;
                            $total_bill += $total;
                            echo  f_number($total);
                            ?>
                        </td>
                        <td><?php
                            $tempDiscount = ($row->total_quantity) > 0 ? $row->total_discount : 0.00;
                            $total_discount += $tempDiscount;
                            echo $tempDiscount;
                            ?>
                        </td>
                        <td>
                            <?php
                                if($row->sap_type == 'cash'){
                                    $due_paid = $due = 0.00;
                                    $where = array('voucher_no' => $row->voucher_no);
                                    $due_paid_sum = $this->action->read_sum('due_collect','paid',$where);
                                    $due_remission_sum = $this->action->read_sum('due_collect','remission',$where);
                                    
                                    $total_paid += $row->paid + $due_paid_sum[0]->paid;
                                    echo $row->paid + $due_paid_sum[0]->paid;
                                }else{
                                    $total_paid += $row->paid;
                                    echo $row->paid;
                                }
                            ?>
                        </td>
                        
                        <td>
                            <?php
                                if($row->sap_type =='cash'){
                                    $due = $row->total_bill - ( $row->paid + $due_paid_sum[0]->paid + $due_remission_sum[0]->remission);
                                    echo f_number($due);
                                    $total_due += $due;
                                }else{
                                    echo f_number($row->due); 
                                    $total_due += $row->due;
                                }
                            ?>
                        </td>
                        <td class="none">
                            <a title="View" class="btn btn-primary" href="<?php echo site_url('sale/viewSale?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a title="Edit" class="btn btn-warning" href="<?php echo site_url('sale/saleEditCtrl?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                             <a title="Return" class="btn btn-info" href="<?php echo site_url('sale/saleReturnCtrl?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-share" aria-hidden="true"></i>
                            </a>
                            <?php if($privilege !='user'){ ?>
                            <a onclick="return confirm('Are you sure want to delete this Sale?');" title="Delete" class="btn btn-danger" href="<?php echo site_url('sale/deleteSale?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="6" class="text-right"><strong>Total</strong> </td>
                    <th><?php echo f_number($total_bill); ?> TK</th>
                    <th><?php echo f_number($total_discount); ?> TK</th>
                    <th><?php echo f_number($total_paid); ?> TK</th>
                    <td><strong><?php echo f_number($total_due); ?> TK</strong> </td>

                    <th class="none">&nbsp;</th>
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
$('#datetimepickerFrom').datetimepicker({
    format: 'YYYY-MM-DD',
    useCurrent: false
});
$('#datetimepickerTo').datetimepicker({
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