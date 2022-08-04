<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php /* if(ck_action("sale_menu","add-new")){ ?>
		<a href="<?php echo site_url('sale/sale'); ?>" class="btn btn-default" id="add-new">
			Cash Sale
		</a>
		<?php } ?>
		
		<?php if(ck_action("sale_menu","add-new")){ ?>
		<a href="<?php echo site_url('sale/credit'); ?>" class="btn btn-default" id="add-new">
			Credit Sale
		</a>
		<?php }*/ ?>
		
		<a href="<?php echo site_url('sale/new_sale'); ?>" class="btn btn-default" id="new-sale">
			New Sale
		</a>
		
        <?php if(ck_action("sale_menu","all")){ ?>
		<a href="<?php echo site_url('sale/searchSale'); ?>" class="btn btn-default" id="all">
			All Sale
		</a>
		<?php } ?>
		
        <?php if(ck_action("sale_menu","wise")){ ?>
		<a href="<?php echo site_url('sale/sale/itemWise'); ?>" class="btn btn-default" id="wise">
			Item Wise
		</a>
        <?php } ?>
    </div>
</div>
