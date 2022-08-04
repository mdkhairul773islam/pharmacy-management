<script src="<?php echo site_url('private/js/ngscript/productEditCtrl.js') ?>"></script>
<div class="container-fluid" ng-init="id='<?php echo $id;?>';" ng-model="id">
    <div class="row" ng-controller="productEditCtrl" ng-cloak>
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Product</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php $attr = array('class' => 'form-horizontal');
                echo form_open_multipart('', $attr); ?>
                
                <input type="hidden" name="product_code" ng-value="product.product_code" class="form-control" readonly>
                    
                <div class="form-group">
                    <label class="col-md-2 control-label">Product Name </label>
                    <div class="col-md-5">
                        <input type="text" name="product_name" ng-value="product.product_name" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Generic Name</label>
                    <div class="col-md-5">
                        <input type="text" name="generic_name" class="form-control" ng-value="product.generic_name">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Category<span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="category" ng-model="category" class="form-control">
                            <option value="" disabled selected> &nbsp;</option>
                            <?php if($allCategory != null){ foreach ($allCategory as $key => $value) { ?>
                            <option value="<?php echo $value->slug ?>" > <?php echo filter($value->category); ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Manufacturer<span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="sub_category" ng-model="subcategory" class="form-control">
                            <option value="" disabled selected> &nbsp;</option>
                            <?php if($allSubcategory != null){ foreach ($allSubcategory as $key => $value) { ?>
                            <option value="<?php echo $value->slug ?>" > <?php echo filter($value->subcategory); ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-md-2 control-label">Self Nmae<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <!--<select name="self_name" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>---Select---</option>
                            <?php  /*foreach(config_item('self_name') as $value){ ?>
                            <option  value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php }*/ ?>
                        </select>-->
                        
                        <input type="text" name="self_name" class="form-control" ng-value="product.self_name" />
                    </div>
                </div>

                <!--<div class="form-group">
                    <label class="col-md-2 control-label">Manufacturer<span class="req"> *</span></label>
                    <div class="col-md-5">
                        <select name="sub_category" ng-model="subcategory" class="form-control" required>
                            <option ng-repeat="row in allSubCategory" value="{{ row.subcategory }}">{{ row.subcategory | removeUnderScore}}</option>
                        </select>
                    </div>
                </div>-->
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Pack Size</label>
                    <div class="col-md-5">
                        <input type="text" ng-model="pack_size" name="pack_size" ng-value="product.pack_size" class="form-control"  />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Purchase Price</label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="purchase_price" id="purchase_price" min="0" ng-value="product.purchase_price" class="form-control" step="any">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Sale Price </label>
                    <div class="col-md-5 input-group">
                        <input type="number" oninput="calc()" name="sale_price" id="sale_price" min="0" ng-value="product.sale_price"  class="form-control" step="any">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Discount </label>
                    <div class="col-md-5 input-group">
                        <input type="text" oninput="calc()" name="discount" id="discount" min="0" ng-value="product.discount"  class="form-control" step="any">
                    </div>
                </div>
                
                <!--<div class="form-group">
                    <label class="col-md-2 control-label">MRP </label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="mrp" min="0" ng-value="product.mrp" class="form-control" step="any">
                    </div>
                </div>-->
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Unit</label>
                    <div class="col-md-5 input-group">
                        <?php $unit = $this->action->read('unit');
                            
                        ?>
                        <select name="unit" class="form-control" ng-model="unit" required>
                           <?php foreach($unit as $key=> $value) { ?>
                            <option value="<?php echo $value->unit; ?>"><?php echo $value->unit; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Stock Limit</label>
                    <div class="col-md-5">
                        <input type="number" min="0" ng-model="low_level" ng-value="product.low_level" name="low_level" class="form-control"  />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Status </label>
                    <div class="col-md-5">
                        <label class="radio-inline">
                            <input type="radio" name="status" ng-model="status" value="available" ng-checked="status=='available'"> Available
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" ng-model="status" value="notavailable" ng-checked="status=='notavailable'"> Not Available
                        </label>
                    </div>
                </div>
                
                <!--<div class="form-group">
                    <label class="col-md-2 control-label">Photo</label>
                    <div class="col-md-5">
                        <input type="file" name="photo" class="form-control file">
                    </div>
                </div>-->
                
                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Update " name="update" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    function calc(){
        var purchase_price = document.querySelector('#purchase_price');
        var sale_price     = document.querySelector('#sale_price'); 
        var discount       = document.querySelector('#discount');
        
        if(purchase_price && sale_price && discount){
            var dis_amount = ((sale_price.value) / 100) * (discount.value);
            purchase_price.value = (sale_price.value - dis_amount);
            
        }
    }
</script>
