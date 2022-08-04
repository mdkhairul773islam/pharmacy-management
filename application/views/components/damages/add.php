<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<!-- custom Core JavaScript -->
<script src="<?php echo site_url('private/js/ngscript/damageCtrl.js'); ?>"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />

<div class="container-fluid">
    <div class="row">
	   <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Damage Product</h1>
                </div>
            </div>
            <div class="panel-body" ng-controller="damageCtrl" ng-cloak>
                <?php $attr = array('class' => 'form-horizontal');
	            echo form_open('', $attr); ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Product Name <span class="req">*</span></label>
                    <div class="col-md-5" >
                        <select name="product_code" ng-model="damage" ng-init="damage=''" ng-change="damageQty()" id="" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option selected disabled>---Select here---</option>
                            <?php foreach ($product as $key => $value) { ?>
                            <option value="<?php echo $value->code; ?>"><?php echo filter($value->name); ?></option>
                           <?php } ?>
                        </select>
                        <!--<input name="product_code" onchange="angular.element($(this)).scope().damageQty()" id="productName" style="width:100%;" placeholder="type product name"  />-->
                        <small>Curent Qty : <span style="color:green">{{quantity}}</span></small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Quantity ( {{ unit }} )<span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="quantity" class="form-control" step="any" required>
                        <input type="hidden" name="unit" ng-value="unit">
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-md-2 control-label">Remark</label>
                    <div class="col-md-5">
                        <textarea name="remark" class="form-control" rows="6" cols="12"></textarea>
                    </div>
                </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
<script>
    (function () {
        // initialize select2 dropdown
        $('#productName').select2({
            data: dropdownData(),
            placeholder: 'search',
            multiple: false,
            // creating query with pagination functionality.
            query: function (data) {
                var pageSize,
                        dataset,
                        that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function (e) {
                        return e.text.toUpperCase().indexOf(data.term.toUpperCase()) >= 0;
                    });
                } else if (data.term === '') {
                    results = that.data;
                }
                data.callback({
                    results: results.slice((data.page - 1) * pageSize, data.page * pageSize),
                    more: results.length >= data.page * pageSize,
                });
            },
        });
    })();

    // For the testing purpose we are making a huge array of demo data

	function dropdownData() {

		var id_arr = new Array();
		var text_arr = new Array();
		<?php 
			 $sl=1;
			  foreach($product as $product_list){
		?>
			 id_arr['<?php echo $sl; ?>']   = '<?php echo $product_list->code; ?>';
			 text_arr['<?php echo $sl; ?>'] = '<?php echo $product_list->name.'-'.filter($product_list->category); ?>';
			
		<?php $sl++;  } ?>
        return _.map(_.range(1,<?php echo count($product)+1; ?>), function (i) {
            return {
                id:   id_arr[i],
                text: text_arr[i],
            };
        });
    } 
    
</script>


