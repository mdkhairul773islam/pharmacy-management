<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    .right{
        display: inline-block;
        float: right;
    }
    p span .sms{
        border: 1px solid transparent;
        width: 40px;
    }
    .action-btn a{
        margin-right: 0;
        margin: 3px 0;
    }
    .checkbox{
        margin: 0!important;
    }
    .hide {
        display:none !important;
    }
    @media print{
        aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        table tr th,table tr td{font-size: 12px;}
    }
</style>


<div class="container-fluid" ng-controller="CustomSMSCtrl">
    <div class="row">
    	<?php  echo $this->session->flashdata('confirmation'); ?>
    	<div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Party Due</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
            </div>

            <div class="panel-body" ng-cloak>
                <!--print header start-->
    		    <?php $this->load->view('print');?>
    		    <!--print header end-->
                
                <h4 class="text-center hide" style="margin-top: 0px;">All Party Due</h4>
                <?php echo form_open() ;?>
                
                <div class="row"> 

                    <div class="form-group">
                        
                        <div class="col-md-3">
                            <?php $allClients = $this->action->read('saprecords',array('trash' => 0,'status' => 'sale','party_code !=' => '')); ?>
                            <select name="party_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                                <option value="" selected disabled>-- Select Client Name --</option>
                                <?php foreach ($allClients as $key => $client) { ?>
                                <option value="<?php echo $client->party_code; ?>" >
                                    <?php 
                                        $obj = json_decode($client->address);
                                        $mobile = (isset($obj->mobile) ? ($obj->mobile !='' ? ' - '.$obj->mobile:'') : '');
                                        echo filter($client->party_code.$mobile); 
                                    ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>    
                        
                        <div class="col-md-3">
                            <!-- <label class="col-md-3 control-label">Form</label> -->
                            <div class="input-group" id="datetimepickerFrom">
                                <input type="text" name="date[from]" placeholder="From" class="form-control" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>   

                        <div class="col-md-3">
                            <!-- <label class="col-md-3 control-label">To</label> -->
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" placeholder="To" class="form-control" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>  


                        <div>
                            <div class="btn-group">
                                <input class="btn btn-primary" type="submit" name="show" value="Search">
                            </div>
                        </div>

                    </div>
                </div>
                
                <?php form_close();?>
                
                <?php if ($result != null) { ?>
                <?php echo $confirmation;?>
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                       <th>Promise Date</th>
                        <th width="120">Name</th>
                        <th>
                            <div class="checkbox">
                                <label><input type="checkbox" id="check_all" class="sms_check" checked=""><strong>Mobile</strong></label>        
                            </div>
                        </th>
                        <th>Address</th>
                        <th>Voucher</th>
                        <th>Grand Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th class="none" width="220px">Action</th>
                    </tr>
                    
                    <?php
                        $total_due = 0.00;
                        $counter = 1;
                        foreach ($result as $index => $value) {
                            $name = $value['party_code'];
                            $obj = json_decode($value['address']);
                            $mobile = $obj->mobile;
                            $address = (isset($obj->address) ? $obj->address : ''); 
                    ?>
                    
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $value['sap_at']; ?></td>
                            <td><?php echo $value['promise_date']; ?></td>
                            <td><?php echo filter($name); ?></td>
                            <td>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="mobile[]" value="<?php echo $mobile; ?>" class="sms_check" checked=""><?php echo $mobile; ?></label>              
                                </div>
                            </td>
                            <td><?php echo $address; ?></td>
                            <td><?php echo $value['voucher_no']; ?></td>
                            <td><?php echo $value['total_bill']; ?></td>
                            <td><?php echo $value['paid']; ?></td>
                            <td><?php echo $value['due'];$total_due += $value['due']; ?></td>
                            <td class="none">
                                <a title="Collect" class="btn btn-primary" href="<?php echo site_url('due_list/due_list/due_collect/'.$value['voucher_no']); ?>">
                                Due Collect
                                </a>
                                
                                <a title="View" class="btn btn-primary" href="<?php echo site_url('sale/viewSale?vno=' .$value['voucher_no']); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>                                
                                
                            </td>
                            
                        </tr>
                    <?php  } ?>
                    <tr>
                        <td colspan="9" style="text-align: right"><strong>Total Due = </strong></td>
                        <td><b><?php echo $total_due; ?> TK </b></td>
                        <td class="none">&nbsp;</td>
                    </tr>
                </table>
                <?php echo form_open() ;?>
                 <div class="form-group">
                    <label class="control-label col-md-2 no-padding">Message </label>
                    <div class="col-md-12 no-padding">
                        <hr class="none" style="border-bottom: 2px solid #00A8FF; margin-top: 0;">
                        <textarea name="message" ng-model="msgContant" class="form-control" cols="30" rows="5" placeholder="Your Message..." ></textarea>
                    </div>
                </div>
                
                <div class="clearfix">
                    <p class="right">
                        <span><strong>Total Characters: </strong>
                            <input name="total_characters" ng-model="totalChar" class="sms" type="text" >
                        </span>
                        &nbsp;
                        <span><strong>Total Messages: </strong>
                            <input class="sms" name="total_messages" ng-model="msgSize" type="text" >
                        </span>
                    </p>
                </div>
                
                <div class="col-md-12 text-right no-padding" style="margin: 15px 0;">
                    <input type="submit" class="btn btn-primary" name="send" value="Send" >
                </div>
                <?php form_close();?>
            <?php }else{ ?>
                    <h3 class="text-center text-danger">No records found.</h3>
            <?php  } ?>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>

<script>
    $(document).ready(function(){

        $("#check_all").on('change', function(event) {
            event.preventDefault();
            if($(this).is(":checked")==true){
                $('input[name="mobile[]"]').prop("checked",true);
            }else{
                $('input[name="mobile[]"]').prop("checked",false);
            }
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>