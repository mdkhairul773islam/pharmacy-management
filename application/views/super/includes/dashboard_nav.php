<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">

		<a href="<?php echo site_url('purchase/purchase'); ?>" class="btn btn-default" id="add-new">
			Purchase
		</a>
		
		<!-- <a href="<?php // echo site_url('production/production'); ?>" class="btn btn-default" id="add-new">
			Production
		</a> -->
		
		<a href="<?php echo site_url('stock/stock/'); ?>" class="btn btn-default" id="stoke">
           Stock</a>
		
		<?php 
		    /*
		        <a href="<?php echo site_url('sale/sale'); ?>" class="btn btn-default" id="add-new">
        			Sale
        		</a>
        		
        		<a href="<?php echo site_url('sale/credit'); ?>" class="btn btn-default" id="add-new">
        			Credit Sale
        		</a>
		    */
		?>
    </div>
</div>
