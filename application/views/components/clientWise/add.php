<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Product</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php $attr = array('class' => 'form-horizontal');
                echo form_open_multipart('', $attr); ?>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Client Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="client"  class="selectpicker form-control" required data-show-subtext="true" data-live-search="true" >
                            <option value="" disabled>-- Select Name --</option>
                            <?php foreach($allClient as $key => $value) { ?>
                            <option value="<?php echo $value->code; ?>"><?php echo filter($value->name)." ( ".$value->address." ) "; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Product Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        
                        <select name="product" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>-- Select Product --</option>
                            <?php if($allProducts != null){ foreach($allProducts as $key => $row){ ?>
                            <option value="<?php echo $row->product_code; ?>">
                                <?php echo filter($row->product_name); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Price <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="price" step="any" min="0.00" placeholder="0.00" class="form-control" required>
                    </div>
                </div>
                
               
                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save " name="save" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>