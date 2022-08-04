<!-- Select Option 2 Stylesheet -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
    }
    .wid-100{width: 100px;}
    #loading{text-align: center;}
    #loading img{display: inline-block;}

</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Bego Stock</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                echo $this->session->flashdata('deleted');
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <div class="col-md-3">
                        <select name="search[code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>-- Select Name --</option>
                            <?php if($productInfo != null){ foreach($productInfo as $key => $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="search[category]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>-- Category --</option>
                            <?php if($category != null){ foreach($category as $key => $row){ ?>
                            <option value="<?php echo $row->category; ?>">
                                <?php echo filter($row->category); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <!--<div class="col-md-3">
                        <select name="search[subcategory]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>-- Manufacturer --</option>
                            <?php /* if($subcategory != null){ foreach($subcategory as $key => $row){ ?>
                            <option value="<?php echo $row->subcategory; ?>">
                                <?php echo filter($row->subcategory); ?>
                            </option>
                            <?php }}*/ ?>
                        </select>
                    </div>-->

                    <div class="btn-group">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Bego Stock</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <!--<img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>" >-->
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

                <h4 class="hide text-center" style="margin-top: 0px;">Stock</h4>
                 <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 40px;">SL</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Manufacturer</th>
                            <th>Quantity</th>
                            <th>Purchase Price</th>
                            <th>Sell Price</th>
                            <th>Amount</th>
                        </tr>
                        <?php 
                        $totalSellPrice = 0.00;
                        $total_pcs = 0.00;
                        foreach ($result as $key => $value){ 
                        $sell =  ($value->purchase_price * $value->quantity); 
                        
                        ?>
                        <style>.red{ color: red;}.blue{ color: #00A8FF;}</style>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo filter($value->name); ?></td>
                            <td><?php echo filter($value->category); ?></td>
                            <td><?php echo filter($value->subcategory); ?></td>
                            <td <?php if($value->quantity < 1){ echo "class='red'";}else if($value->quantity > 0 && $value->quantity < 6){ echo "class='blue'";}; ?>>
                                <b><?php echo $value->quantity . " " . $value->unit; $total_pcs += $value->quantity; ?></b></td>
                                
                            <td>
                            <?php 
                                $privilege = $this->session->userdata('privilege');
                                //echo $privilege;
                                if($privilege == 'user' || $privilege == 'admin'){
                                    if($value->subcategory == 'bego_pharmaceuticals_(ay)'){
                                        echo "Hidden";
                                    }else{
                                        echo $value->purchase_price;
                                    }
                                }else{
                                    echo $value->purchase_price;
                                }
                            ?>
                            </td>
                            
                            <td>
                            <?php
                                if($privilege == 'user' || $privilege == 'admin'){
                                    if($value->subcategory == 'bego_pharmaceuticals_(ay)'){
                                        echo "Hidden";
                                    }else{
                                        echo $value->sell_price;
                                    }
                                }else{
                                    echo $value->sell_price;
                                }
                            ?>
                            </td>
                            
                            <td>
                            <?php
                                if($privilege == 'user' || $privilege == 'admin'){
                                    if($value->subcategory == 'bego_pharmaceuticals_(ay)'){
                                        echo "Hidden";
                                    }else{
                                        echo $sell;
                                    }
                                }else{
                                    echo $sell;
                                }
                            ?>
                            </td>
                            
                        </tr>
                        <?php 
                            $totalSellPrice += $sell;
                            
                        } ?>
                        <tr>
                            <td colspan="4"><b class="pull-right">Total = </b></td>
                            <td><b><?php echo $total_pcs.' Pcs'; ?></b></td>
                            <td></td>
                            <td></td>
                            <td><b><?php echo $totalSellPrice.' TK'; ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<!-- Select Option 2 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>