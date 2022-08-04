<script src="<?php echo site_url('private/js/ngscript/dueCollectCtrl.js')?>"></script>
<style>
    .action-btn a{
        margin-right: 0;
        margin: 3px 0;
    }
    .checkbox{
        margin: 0!important;
    }
    
    @media print{
        aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        table tr th,table tr td{font-size: 12px;}
    }
</style>

<div class="container-fluid" ng-controller="dueCollectCtrl">
    <div class="row">
    	<?php  echo $this->session->flashdata('confirmation'); ?>
    	<div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Due Collect </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
            </div>
            <!--pre><?php //echo $result['voucher_no'];?></pre-->
            <div class="panel-body" ng-cloak>
                <!-- Print banner -->
                <!--<img class="img-responsive print-banner hide" src="<?php //echo site_url($banner_info[0]->path); ?>"> -->
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
                
                <h4 class="text-center hide" style="margin-top: 0px;">Due Collect</h4>
                
                <div class="row">
                    <div class="col-xs-4 print-font">
                        <?php
                            $address = "N/A";
                            if($result['sap_type'] != "cash" ) {
                                $where = array('code' => $result['party_code']);
                                $party_info = $this->action->read('parties', $where);
                        ?>
                        <label>Name : <?php if ($party_info != null) { echo filter($party_info[0]->name);}else{echo "N/A";} ?></label> <br>
                        <label style="width: 100%;"> Mobile : <?php if ($party_info != null) { echo $party_info[0]->mobile;}else{echo "N/A";} ?> </label>
                        <!-- <label style=" margin-bottom: 10px;">Address: </label> -->
                        <?php } else {
                                $cdata = json_decode($result['address'], true);
                                //$address = $cdata['address'];
                        ?>
                        <label>Name : <?php echo filter($result['party_code']); ?></label> <br>
                        <label>Mobile : <?php echo $cdata['mobile']; ?></label><br>
                        <?php } ?>
                    </div>
                    <div class="col-xs-4 print-font">
                        <label style="margin-bottom: 10px;">
                        Voucher No : <?php echo $result['voucher_no']; ?>
                        </label> <br>
                        <?php
                            $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result['voucher_no']));
                        ?>
                        <label style="margin-bottom: 10px;">
                        Sales Man : <?php echo (isset($info[0]->meta_value) ? $info[0]->meta_value : ''); ?>
                        </label>
                    </div>
                    <div class="col-xs-4 print-font">
                        <label>Date : <?php echo $result['sap_at']; ?></label> <br>
                        
                    </div>
                </div>

                <div class="col-md-12">&nbsp;</div>

            <?php echo form_open(); ?>

                <table class="table table-bordered">
                    <tr>
                        <th>Voucher No</th>
                        <th>Grand Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                    </tr>
                    <tr>
                        <td><?php echo $result['voucher_no']; ?></td>
                        <td><?php echo $result['total_bill']; ?></td>
                        <td><?php echo $result['paid']; ?></td>
                        <td><?php echo $result['due']; ?></td>
                    </tr>
                </table>
                <!-- hidden field -->
                <input type="hidden" ng-init="grandTotal=<?php echo $result['total_bill']; ?>">
                <input type="hidden" ng-init="previousRemission=<?php echo $result['remission']; ?>">
                <input type="hidden" name="previous_paid" value="<?php echo $result['paid']; ?>">
                <input type="hidden" name="party_code" value="<?php echo $result['party_code']; ?>">
                <input type="hidden" name="total_bill" value="<?php echo $result['total_bill']; ?>">
                <input type="hidden" name="voucher_no" value="<?php echo $result['voucher_no']; ?>">
                
                <div class="col-md-8 col-md-offset-1 row">
                    <div class="col-md-12">
                      <label class="col-md-3 control-label"> Previous Paid </label>
                      <div class="col-md-8">
                        <input type="number"  ng-init="previousPaid=<?php echo $result['paid']; ?>" ng-model="previousPaid"  class="form-control" step="any" readonly>
                      </div>
                    </div><br><br>

                    <div class="col-md-12">
                      <label class="col-md-3 control-label"> Paid </label>
                      <div class="col-md-8">
                        <input type="number" name="paid" ng-model="paid" class="form-control" step="any">
                      </div>
                    </div><br><br>

                    <div class="col-md-12">
                      <label class="col-md-3 control-label"> Total Paid </label>
                      <div class="col-md-8">
                        <input type="number" name="total_paid" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                      </div>
                    </div><br><br>

                    <div class="col-md-12">
                      <label class="col-md-3 control-label"> Remission </label>
                      <div class="col-md-8">
                        <input type="number" name="remission"  ng-model="remission" class="form-control" step="any">
                      </div>
                    </div><br><br>

                    <div class="col-md-12">
                      <label class="col-md-3 control-label"> Total Remission </label>
                      <div class="col-md-8">
                        <input type="number" name="total_remission" ng-value="getTotalRemissionFn()" class="form-control" step="any" readonly>
                      </div>
                    </div><br><br>


                    <div class="col-md-12">
                      <label class="col-md-3 control-label"> Due </label>
                      <div class="col-md-8">
                        <input type="number" name="due" ng-value="getTotalDueFn()" class="form-control" step="any" readonly>
                      </div>
                    </div><br><br>
                    
                    <div class="col-md-12">
                      <label class="col-md-3 control-label"> Next Promise Date </label>
                      <div class="col-md-8">
                        <div class="input-group date" id="datetimepicker">
                          <input type="text" name="promise_date" value="<?php echo $result['promise_date']; ?>" class="form-control" placeholder="YYYY-MM-DD">
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </div><br><br>
                </div>

                <div class="col-md-12" style="margin-left: 57%;">
                      <input type="submit" name="save" value="Collect" class="btn btn-primary" >
                </div>
            <?php form_close(); ?>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>

    
      $(document).ready(function(){
        $('#datetimepicker').datetimepicker({
          format: 'YYYY-MM-DD'
        });
      });

    $(document).ready(function(){

        $("#check_all").on('change', function(event) {
            event.preventDefault();
            if($(this).is(":checked")==true){
                $('input[name="mobile[]"]').prop("checked",true);
            }else{
                $('input[name="mobile[]"]').prop("checked",false);
            }
        });

        $('#zilla').on('change', function(event) {
            var zila = $(this).val();
            $.ajax({
                url: '<?php echo site_url("client/client/ajax_return_upazila"); ?>',
                type: 'POST',
                data: {zila: zila},
            })
            .done(function(response) {
           // alert(1);
            //console.log(response);
                $('#upazilla').html(response);
            });

        });
    });
</script>
