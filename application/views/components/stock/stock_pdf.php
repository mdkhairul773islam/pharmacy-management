<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    
<div class="panel">
    <div class="panel-heading">
        <div class="panal-header-title pull-left">
            <h1>Search Stock</h1>
        </div>
    </div>

    <div class="panel-body">
        <?php
            $attr = array("class" => "form-horizontal");
            echo form_open("", $attr);
        ?>

        <div class="form-group">
            <div class="col-md-3">
                <select name="search[category]" class="form-control select2" id="select2">
                    <option value="" selected >-- Category --</option>
                    <?php if(!empty($allCategory)){ foreach($allCategory as $key => $row){ ?>
                    <option value="<?php echo $row->slug; ?>">
                        <?php echo filter($row->category); ?>
                    </option>
                    <?php }} ?>
                </select>
            </div>

            <div class="col-md-3">
                <select name="search[subcategory]" class="form-control select2">
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
        <?php echo form_close(); ?>
    </div>

</div>
    


<table id="example" class="table table-bordered">
    <thead>
        <th>SL</th>
        <th>Name</th>
        <th>Category</th>
        <th>Manufacturer</th>
        <th>Quantity</th>
        <th>Purchase Price</th>
        <th>Sale Price</th>
        <th>Amount</th>
    </thead>
    
    <tbody>
        <?php foreach($stocks as $key=>$stock){ ?>
    <tr>
        <td><?=(++$key)?></td>
        <td><?=($stock->name)?></td>
        <td><?=($stock->category)?></td>
        <td><?= filter($stock->subcategory)?></td>
        <td><?=($stock->quantity)?></td>
        <td><?=($stock->purchase_price)?></td>
        <td><?=($stock->sell_price)?></td>
        <td><?=($stock->purchase_price * $stock->quantity)?></td>
    </tr>
    <?php } ?>
    </tbody>
    
</table>
    
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
<script>
    $('.select2').select2();
    
	$(document).ready(function() {
		$('#example').DataTable( {
		    pageLength: 50,
			paging: true,
			searching: true,
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		} );
	} );
</script>