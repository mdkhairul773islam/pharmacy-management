<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important;}

        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide{display: block !important;}
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search By DO Number</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">DO Number</label>
                    <div class="col-md-4">
                        <select name="search[do_no]" class="form-control">
                            <option value="" selected disabled>&nbsp;</option>
                            <?php foreach ($allDONumbers as $key => $do) { ?>
                            <option value="<?php echo $do; ?>"><?php echo $do; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


        <!--pre><?php //print_r($result); ?></pre-->
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
                
                <h4 class="text-center hide" style="margin-top: 0px;">All sales</h4>

                <strong><?php echo count($result); ?> results found</strong>
                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>DO No</th>
                        <th>Company</th>
                        <th>Customer's Name</th>
                        <th>Quantity (Bag)</th>
                    </tr>

                    <?php 
                    $totalQuantity = 0;
                    foreach($result as $key => $row) { 
                    ?>
                    <tr>
                        <td style="width: 50px;"><?php echo $row['sl']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['voucherNo']; ?></td>
                        <td><?php echo $row['doNo']; ?></td>
                        <td><?php echo $row['company']; ?></td>
                        <td><?php echo $row['partyName']; ?></td>
                        <td>
                        <?php 
                        $totalQuantity += $row['quantity'];
                        echo $row['quantity']; 
                        ?>
                        </td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td colspan="6" class="text-right">Total</td>
                        <td><?php echo $totalQuantity; ?></td>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
