<div class="container-fluid">
    <div class="row">
        <?php //echo $confirmation; ?>
        <?php echo $this->session->flashdata('confirmation'); ?>
       
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Supplier</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('', $attr);
                ?>

                
                <input type="hidden" name="code" class="form-control" value="<?php echo $party_code; ?>" readonly>
                    
                <div class="form-group">
                  <label class="col-md-3 control-label">Date<span class="req">&nbsp;*</span></label>
                  <div class="col-md-5">
                    <div class="input-group date" id="datetimepicker">
                      <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" placeholder="YYYY-MM-DD" required>
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Supplier Name<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control"  required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Contact Person</label>
                    <div class="col-md-5">
                        <input type="text" name="contact_person" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" class="form-control"  required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Address </label>
                    <div class="col-md-5">
                        <textarea name="address" cols="15" rows="5" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Opening Balance (TK) <span class="req">&nbsp;*</span></label>
                    <div class="col-md-3">
                        <input type="number" name="balance" class="form-control" min="0" step="any" value="0.00" required>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="receivable" selected>Receivable</option>
                            <option value="payable" >Payable</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="add" value="Save" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>