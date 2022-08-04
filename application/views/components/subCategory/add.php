<div class="container-fluid" ><!--ng-controller="addSubcategoryCtrl"  -->
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Manufacturer</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
				$attr = array('class' =>'form-horizontal');
	            echo form_open('subCategory/subCategory/addsubCategory', $attr);
				?>

                <!--<div class="form-group">
                    <label class="col-md-3 control-label">Category Name  <span class="req">*</span></label>
                    <div class="col-md-4">
                        <select name="category" class="form-control">
                            <option value="" selected disabled>-- Select --</option>
                            <?php
                            if($categories != null){
                            foreach ($categories as $key => $value) { ?>
                            <option value="<?php echo $value->category; ?>">
                                <?php echo str_replace('_', ' ', $value->category); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>-->

                <div class="form-group">
                    <label class="col-md-3 control-label">Manufacturer <span class="req">*</span></label>

                    <div class="col-md-4">
                        <input type="text" name="subcategory" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="catetory_submit" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
