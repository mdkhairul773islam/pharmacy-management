<script src="<?php echo site_url('private/js/ngscript/productAddCtrl.js') ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<div class="container-fluid">
    <div class="row" ng-controller="productAddCtrl">
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
                
                <input type="hidden" name="product_code" value="<?php echo generateUniqueId('products'); ?>" class="form-control" readonly>
                <div class="form-group">
                    <label class="col-md-2 control-label">Product Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="product_name" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Generic Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="generic_name" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Category<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="category" ng-model="category" ng-change="getAllSubcategory()" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>---Select---</option>
                            <?php if($allCategory != null){ foreach ($allCategory as $key => $value) { ?>
                            <option value="<?php echo $value->slug ?>"> <?php echo filter($value->category); ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Manufacturer<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="sub_category" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>---Select---</option>
                            <?php if($allSubcategory != null){ foreach ($allSubcategory as $key => $value) { ?>
                            <option value="<?php echo $value->slug ?>"> <?php echo filter($value->subcategory); ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                
                <!--<div class="form-group">
                    <label class="col-md-2 control-label">Manufacturer<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="sub_category" class="form-control" required>
                            <option value="" selected disabled>---Select---</option>
                            <option ng-repeat="row in allSubCategory" value="{{ row.subcategory}}">{{ row.subcategory | removeUnderScore}}</option>
                        </select>
                    </div>
                </div>-->
                
                 <div class="form-group">
                    <label class="col-md-2 control-label">Self Name </label>
                    <div class="col-md-5">
                         <input type="text" name="self_name" class="form-control"  />
                        <!--<select name="self_name" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>---Select---</option>
                            <?php  /*foreach(config_item('self_name') as $value){ ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php } */ ?>
                        </select>-->
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Pack Size</label>
                    <div class="col-md-5">
                        <input type="text" name="pack_size" class="form-control"  />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Purchase Price</label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="purchase_price" id="purchase_price" min="0" value="0" class="form-control" step="any">
                        <!-- <div class="input-group-addon">TK / kg</div> -->
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Sale Price </label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="sale_price" id="sale_price" min="0" value="0" class="form-control" step="any">
                        <!-- <div class="input-group-addon">TK / kg</div> -->
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Discount </label>
                    <div class="col-md-5 input-group">
                        <input type="text" name="discount" id="discount" min="0" value="0" class="form-control" step="any">
                        <!-- <div class="input-group-addon">TK / kg</div> -->
                    </div>
                </div>
                
                <!--<div class="form-group">
                    <label class="col-md-2 control-label">MRP </label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="mrp" min="0" value="0" class="form-control" step="any">
                    </div>
                </div>-->
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Unit</label>
                    <div class="col-md-5 input-group">
                        <?php $unit = $this->action->read('unit'); ?>
                        <select name="unit" class="form-control" required>
                            <option value="" selected disabled>--Select--</option>
                            <?php foreach($unit as $key=> $value) { ?>
                            <option value="<?php echo $value->unit; ?>"><?php echo $value->unit; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Stock Limit</label>
                    <div class="col-md-5">
                        <input type="number" min="0" name="low_level" class="form-control"  />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Status </label>
                    <div class="col-md-5">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="available" checked> Available
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="notavailable"> Not Available
                        </label>
                    </div>
                </div>
                
                <!--<div class="form-group">
                    <label class="col-md-2 control-label">Photo <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="file" name="photo" class="form-control file" required>
                    </div>
                </div>-->
                
                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save " name="product_add" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    var purchase_price = document.querySelector('#purchase_price');
    var sale_price     = document.querySelector('#sale_price'); 
    var discount       = document.querySelector('#discount');
    
    if(purchase_price && sale_price && discount){
        discount.addEventListener('input', ()=>{
            var dis_amount = ((sale_price.value) / 100) * (discount.value);
            purchase_price.value = (sale_price.value - dis_amount);
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>