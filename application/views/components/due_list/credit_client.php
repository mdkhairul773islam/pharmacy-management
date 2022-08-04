<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    @media print{
        aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        table tr th,table tr td{font-size: 12px;}
    }
    .md15 {
        padding: 0 15px !important;
    }
    .Receivable{
        color: green;
        font-weight: bold;
    }
    .Payable{
        color: red;
        font-weight: bold;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Credit Party </h1>
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
                <h4 class="text-center hide" style="margin-top: 0px;">All Party</h4>
                
                <div class="row md15">
                    <?php
                    echo $this->session->flashdata('deleted');
                    $attr = array("class" => "form-horizontal");
                    echo form_open("", $attr);
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Clinet Name </label>
                        <div class="col-md-4">
                            <select name="party_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>--Select---</option>
                                <?php if($client_list != null){ foreach($client_list as $key => $row){ ?>
                                <option value="<?php echo $row->code; ?>">
                                    <?php echo filter($row->name); ?>
                                </option>
                                <?php }} ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="btn-group">
                                <input type="submit" name="show" value="Show" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                    
                    <?php echo form_close(); ?>
                </div> 
            <?php if($result != null){ ?>
                <div class="row md15">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 50px;">SL</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Due</th>
                                <th>Type</th>
                            </tr>
                            <?php $counter = 1;$total = 0.00; foreach ($result as $key => $value) {
                                
                            ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $value['mobile']; ?></td>
                                <td><?php echo $value['address']; ?></td>
                                <td><?php echo $value['balance']; $total += $value['balance']; ?></td>
                                <td><?php echo $value['type']; ?></td>
                            </tr>
                            <?php }  ?>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th><?php echo $total; ?> Tk</th>
                                <th>&nbsp;</th>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            <?php }else{ ?> 
                <h2 class="text-center">No Records Found</h2>
            <?php } ?>
            </div>
        
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>