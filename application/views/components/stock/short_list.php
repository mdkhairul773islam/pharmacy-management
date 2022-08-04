<script src="<?php echo site_url('private/js/ngscript/productAddCtrl.js') ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <?php
            echo $confirmation;
            echo $this->session->flashdata("confirmation");
        ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Search Short List</h1>
                </div>
            </div>
            <div class="panel-body">
                <form action="" method="POST">
                    <div class="row none">
                        <div class="form-group">
                            <div class="col-md-3">
                                <select name="search[name]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                    <option value="" selected >Select Product</option>
                                    <?php if(!empty($allProduct)){ foreach($allProduct as $key => $row){ ?>
                                    <option value="<?php echo $row->name; ?>">
                                        <?php echo filter($row->name); ?>
                                    </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="search[category]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                    <option value="" selected >Select Category</option>
                                    <?php if(!empty($allCategory)){ foreach($allCategory as $key => $row){ ?>
                                    <option value="<?php echo $row->slug; ?>">
                                        <?php echo filter($row->category); ?>
                                    </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="search[subcategory]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                    <option value="" selected >Select Manufacturer</option>
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
                    <!--<h1 class="pull-left">Short List</h1>-->
                    <button class="btn btn-success" onclick="exportTableToCSV('short_list(<?=date('Y-m-d')?>).csv')">Export Short List To CSV File</button>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <!--print header start-->
    			    <?php $this->load->view('print');?>
    			    <!--print header end-->

                    <hr class="hide" style="border-bottom: 1px solid #ccc;">
                    
                    <?php  if(!empty($_POST)){
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
                    }} ?>
                    <?php if(!empty($_POST)){ ?>
                        <h3><?php echo $products.'&nbsp;'.$category.'&nbsp;'.$subcategory.'&nbsp;'; ?></h3>
                    <?php } ?>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40px">SL</th>
                            <th>Code</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock Limit</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th class="none">Action</th>
                        </tr>
                        <?php 
                            if($items) foreach($items as $key=>$value){ 
                                if($value->low_level > $value->quantity){ 
                                    $orderInfo = get_result('order_list', ['product_code' => $value->code], ['product_code']);
                                    if(empty($orderInfo)){ 
                        ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value->code; ?></td>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo filter($value->product_cat); ?></td>
                            <td><?php echo $value->low_level; ?></td>
                            <td><?php echo $value->quantity; ?></td>
                            <td><?php echo ($value->quantity <= 0 ? "<span style='color:red'>Unavailable</span>" : "Available "); ?></td>
                            <td class="none">
                                <a class="btn btn-success" title="Order" onclick="return confirm('Are you sure want to order this Product?');" href="<?php echo site_url('stock/order_list/store/'.$value->code);?>">Order</a>
                            </td>
                        </tr>
                        <?php }}} ?>
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

<script>
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;
        csvFile = new Blob([csv], {type: "text/csv"});
        downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }
    
    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");
        
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            
            for (var j = 0; j < cols.length; j++) 
                row.push(cols[j].innerText);
            
            csv.push(row.join(","));        
        }
    
        downloadCSV(csv.join("\n"), filename);
    }
</script>