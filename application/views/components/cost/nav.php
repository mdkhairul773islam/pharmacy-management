<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("cost_menu","field")){ ?>	
		<a href="<?php echo site_url('cost/cost'); ?>" class="btn btn-default" id="field">
			Field of Expenditure 
		</a>
		<?php } ?>
		
		<?php if(ck_action("cost_menu","new")){ ?>
		<a href="<?php echo site_url('cost/cost/newcost'); ?>" class="btn btn-default" id="new">
			New Expenditure
		</a>
		<?php } ?>
		
        <?php if(ck_action("cost_menu","all")){ ?>
		<a href="<?php echo site_url('cost/cost/allcost'); ?>" class="btn btn-default" id="all">
			All Expenditure
		</a>
		<?php } ?>
    </div>
</div>