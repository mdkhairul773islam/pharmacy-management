<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("ledger","company-ledger")){ ?>
		<a href="<?php echo site_url('ledger/companyLedger'); ?>" class="btn btn-default" id="company-ledger">
			    Supplier Ledger
		 </a>
		 <?php } ?>
			
		<?php if(ck_action("ledger","client-ledger")){ ?>
		<a href="<?php echo site_url('ledger/clientLedger'); ?>" class="btn btn-default" id="client-ledger">
			Client Ledger
		</a>
        <?php } ?>
    </div>
</div>
