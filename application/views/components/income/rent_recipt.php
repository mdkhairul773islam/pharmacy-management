<style>
    .table>tbody>tr>td {padding: 2px;}
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
        border: 1px solid transparent;
        left: 0px;
        position: absolute;
        top: 0px;
        width: 100%;
        }
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered, .print-font { font-size: 14px !important; }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Rent Recipt</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner -->
                <!--<img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">-->
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
                <div class="row">
                    <div class="col-xs-8 print-font">
                        <label>Received By : <?php echo $rentInfo[0]->received_by; ?></label>
                    </div>

                    <div class="col-xs-4 print-font">
                        <label>Given By : <?php echo $rentInfo[0]->remark; ?></label>
                    </div>
                </div><br>
                
                <table class="table table-bordered text-center">
                    <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Amount (TK)</th>
                    </tr>

                    <tr>
                        <td><?php echo $rentInfo[0]->date; ?></td>
                        <td><?php echo $rentInfo[0]->year; ?></td>
                        <td><?php echo $rentInfo[0]->month; ?></td>
                        <td><?php echo $rentInfo[0]->amount.' TK'; ?></td>
                    </tr>
                </table>

                <div class="col-sm-6 col-xs-6">
                    <h4 style="margin-top: 40px;" class="text-left print-font">
                        ------------------------------ <br>
                        Signature of Proprietor
                    </h4>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <h4 style="margin-top: 40px;" class="text-right print-font">
                        ------------------------------ <br>
                        Signature of Lessee
                    </h4>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){$("#inword").html(inWorden(<?php echo $gtotal; ?>));});
</script>