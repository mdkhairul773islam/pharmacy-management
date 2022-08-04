<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("due_list_menu","cash")){ ?>	
		<a href="<?php echo site_url('due_list/due_list'); ?>" class="btn btn-default" id="cash">
			Cash Client Due
		</a>
		<?php } ?>
		
        <?php if(ck_action("due_list_menu","collection_list")){ ?>	
		 <a href="<?php echo site_url('due_list/due_list/due_collection_list'); ?>" class="btn btn-default" id="collection_list">
			Due Collection List
		</a>
		<?php } ?>
		
		<?php if(ck_action("due_list_menu","credit")){ ?>
		<a href="<?php echo site_url('due_list/due_list/credit'); ?>" class="btn btn-default" id="credit">
			Credit Client Due
		</a>
		<?php } ?>
		
		<?php if(ck_action("due_list_menu","supplier")){ ?>
		<a href="<?php echo site_url('due_list/due_list/supplier'); ?>" class="btn btn-default" id="supplier">
			Supplier Due
		</a>
		<?php } ?>
    </div>
</div>