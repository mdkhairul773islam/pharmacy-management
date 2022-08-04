<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel {
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
                    <h1>View Sales Report</h1>
                </div>
            </div>
            <div class="panel-body" ng-cloak>
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">Voucher No</label> -->
                    <div class="col-md-3">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No.">
                    </div>
                    
                    <div class="col-md-3">
                        <select name="search[voucher_no]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Select Manufacturer --</option>
                            <?php foreach ($allProduct as $key => $value) { 
                                $allSubcategories = $this->action->read('products', array('product_code' => $value->product_code));
                            ?>
                            <option value="<?php echo $value->voucher_no; ?>" >
                                <?php echo (isset($allSubcategories[0]->subcategory) ? filter($allSubcategories[0]->subcategory) :''); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- <label class="col-md-2 control-label">Client's Name</label> -->
                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Client's Name --</option>
                            <?php foreach ($allClients as $key => $client) { ?>
                            <option value="<?php echo $client->code; ?>" >
                                <?php echo filter($client->name)." ( ".$client->address." ) "; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div><br/><br/>

                    <!-- <label class="col-md-2 control-label">From</label> -->
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control"  placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <!-- <label class="col-md-2 control-label">To</label> -->
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
        
        <?php if ($result !=null) { ?>
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
                        <th>Client Name</th>
                        <th>Address</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Due</th>
                    </tr>
                    <?php
                    
                    $amount = 0.00;
                    $total_paid = $total_due = 0.00;
                    foreach($result as $key => $row){
                        $due = $row->total_bill - $row->paid;

                    ?>
                    <tr>
                        <td style="width: 50px;"> <?php echo ($key + 1); ?> </td>
                        <td> <?php echo $row->sap_at; ?> </td>
                        <td> <?php echo $row->voucher_no; ?> </td>
                        <td>
                            <?php
                                if($row->sap_type != "cash" ){
                                    $where = array('trash'=>0, 'code' => $row->party_code);
                                    $party_info = $this->action->read('parties', $where);
                                    if ($party_info != null) {
                                        echo filter($party_info[0]->name);}else{echo "N/A";
                                    }
                                }else {
                                    echo filter($row->party_code);
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($row->sap_type != "cash" ){
                                    $where = array('trash'=>0, 'code' => $row->party_code);
                                    $party_info = $this->action->read('parties', $where);
                                    if ($party_info != null) {
                                        echo filter($party_info[0]->address);}else{echo "N/A";
                                    }
                                } else{
                                    $json_address = json_decode($row->address,true);
                                    (!empty($json_address['address']) ? filter($json_address['address']) : '');
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                            $total =($row->total_bill);
                            $amount += $total;
                            echo  f_number($total);
                            ?>
                        </td>
                        <td><?php echo f_number($row->paid); $total_paid += $row->paid;?></td>
                        <td><?php echo f_number($due); $total_due += $due;?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="5" class="text-right"><strong>Total</strong> </td>
                        <td><strong><?php echo f_number($amount); ?> TK</strong> </td>
                        <td><strong><?php echo f_number($total_paid); ?> TK</strong> </td>
                        <td><strong><?php echo f_number($total_due); ?> TK</strong> </td>
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