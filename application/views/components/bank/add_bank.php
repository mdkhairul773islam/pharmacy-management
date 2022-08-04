<div class="container-fluid">
    <div class="row">
	<?php echo $confirmation; ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Bank</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->

                <?php
	                $attr=array('class'=>'form-horizontal');
	                echo form_open('',$attr);
                ?>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="bank_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="btn-group pull-right">
                            <input type="submit" value="Save" name="add_bank" class="btn btn-primary">
                        </div>
                    </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
