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
        .panel .hide {
            display: block !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Search Expired List</h1>
                </div>
            </div>
            <div class="panel-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <select name="search[name]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                    <option value="" selected >-- Product --</option>
                                    <?php if(!empty($allProduct)){ foreach($allProduct as $key => $row){ ?>
                                    <option value="<?php echo $row->name; ?>">
                                        <?php echo filter($row->name); ?>
                                    </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <select name="search[category]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                    <option value="" selected >-- Category --</option>
                                    <?php if(!empty($allCategory)){ foreach($allCategory as $key => $row){ ?>
                                    <option value="<?php echo $row->slug; ?>">
                                        <?php echo filter($row->category); ?>
                                    </option>
                                    <?php }} ?>
                                </select>
                            </div>
        
                            <div class="col-md-3">
                                <select name="search[subcategory]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                    <option value="" selected >-- Manufacturer --</option>
                                    <?php if(!empty($allSubcategory)){ foreach($allSubcategory as $key => $row){ ?>
                                    <option value="<?php echo $row->slug; ?>">
                                        <?php echo filter($row->subcategory); ?>
                                    </option>
                                    <?php }} ?>
                                </select>
                            </div>
        
                            <div class="btn-group">
                                <input type="submit" name="find" value="Show" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Expired List</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <!--print header start-->
    			    <?php $this->load->view('print');?>
    			    <!--print header end-->

                    <hr class="hide" style="border-bottom: 1px solid #ccc;">
                    <?php 
                            
                            //print_r($_POST);
                            if(!empty($_POST)){
                                
                                if(!empty($_POST['search']['name'])){
                                    $products = 'Products:'.filter($_POST['search']['name']);
                                }else{
                                    $products = '';
                                }
                                
                                if(!empty($_POST['search']['category'])){
                                    $category = 'Category:'.filter($_POST['search']['category']);
                                }else{
                                    $category = '';
                                }
                                
                                if(!empty($_POST['search']['subcategory'])){
                                    $subcategory = 'Manufacturer:'.filter($_POST['search']['subcategory']);
                                }else{
                                    $subcategory = '';
                                }
                            }
                            
                        ?>
                        <?php
                            if(!empty($_POST)){
                        ?>
                             <h3>
                                 <b>
                                    <?php echo $products.'&nbsp;'.$category.'&nbsp;'.$subcategory.'&nbsp;'; ?>&nbsp;
                                 </b>    
                            </h3>
                        <?php
                            }
                        ?>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th width="40px">SL</th>
                            <th>Code</th>
                            <th>Expired</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Manufacturer</th>
                            <th>Stock Limit</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php if($items) foreach($items as $key=>$value){ ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value->code; ?></td>
                            <td><?php echo $value->expire_date; ?></td>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo $value->category; ?></td>
                            <td><?php echo filter($value->subcategory); ?></td>
                            <td><?php echo $value->low_level; ?></td>
                            <td> <?php echo $value->quantity; ?></td>
                            <td><?php echo filter($value->status); ?></td>
                            <td>
                                <a onclick="return confirm('Are you sure want to delete this Data?');" title="Delete" class="btn btn-danger" href="<?php echo site_url('stock/expired_list/delete_expired_data?batch_no=' . $value->batch_no); ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    $(".status").on('change',  function(event) {
        var status = $(this).val();
        var id = $(this).data("id");
        $.ajax({
            url: '<?php //echo site_url("order/order/ajax_change_status"); ?>',
            type: 'POST',
            data: {status: status, id: id},
        })
        .done(function(response) {
            if(response=="success"){
                alert("Status Changed Successfully..!");
            }
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>