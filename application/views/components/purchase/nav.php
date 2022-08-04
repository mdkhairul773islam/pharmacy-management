<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("purchase_menu","add-new")){ ?>
		<a href="<?php echo site_url('purchase/purchase'); ?>" class="btn btn-default" id="add-new">
			Add Purchase
		</a>
		<?php } ?>
		
        <?php if(ck_action("purchase_menu","all")){ ?>
		<a href="<?php echo site_url('purchase/purchase/show_purchase'); ?>" class="btn btn-default" id="all">
			All Purchase
		</a>
		<?php } ?>
		
        <?php if(ck_action("purchase_menu","wise")){ ?>
		<a href="<?php echo site_url('purchase/purchase/itemWise'); ?>" class="btn btn-default" id="wise">
			Item Wise
		</a>
		<?php } ?>
		
		<?php if(ck_action("purchase_menu","return")){ ?>
		<a href="<?php echo site_url('purchase/purchase_return'); ?>" class="btn btn-default" id="return">
			Add Purchase Return
		</a>
		<?php } ?>
		
		<?php if(ck_action("purchase_menu","all_return")){ ?>
		<a href="<?php echo site_url('purchase/purchase_return/allReturn'); ?>" class="btn btn-default" id="all_return">
			All Purchase Return
		</a>
		<?php } ?>
    </div>
</div>
