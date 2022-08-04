
<div class="container-fluid" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
		<a href="<?php echo site_url('sms/sendSms'); ?>" class="btn btn-default" id="send-sms">			
		Send SMS
		</a>
			
		<a href="<?php echo site_url('sms/sendSms/send_custom_sms'); ?>" class="btn btn-default" id="custom-sms">
			Custom SMS
		</a>

		<a href="<?php echo site_url('sms/sendSms/sms_report'); ?>" class="btn btn-default" id="sms-report">
			SMS Report
		</a>
    </div>
</div>