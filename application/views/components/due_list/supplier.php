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
                    <h1 class="pull-left">View All Supplier</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!--print header start-->
    		    <?php $this->load->view('print');?>
    		    <!--print header end-->
    		    
                <h4 class="text-center hide" style="margin-top: 0px;">All Supplier</h4>
                <!-- <div class="row md15">
                    <?php
                    echo $this->session->flashdata('deleted');
                    $attr = array("class" => "form-horizontal");
                    echo form_open("", $attr);
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Supplier Name </label>
                        <div class="col-md-4">
                            <select name="party_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>--Select---</option>
                                <?php// if($allParty != null){ foreach($allParty as $key => $row){ ?>
                                <option value="<?php// echo $row->code; ?>">
                                    <?php //echo filter($row->name); ?>
                                </option>
                                <?php// }} ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="btn-group">
                                <input type="submit" name="show" value="Show" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                    
                    <?php echo form_close(); ?>
                </div> -->
            <?php if($result != null){ ?>
                <div class="row md15">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 50px;">SL</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Balance</th>
                                <th>Type</th>
                            </tr>
                            <?php $counter = 1; $total = 0.00; foreach ($result as $key => $value) { ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $value['mobile']; ?></td>
                                <td><?php echo $value['address']; ?></td>
                                <td><?php echo $value['balance']; $total += $value['balance'];  ?></td>
                                <td><?php echo $value['type']; ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="4" class="text-right">Total </th>
                                <th><?php echo $total;?> Tk</th>
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