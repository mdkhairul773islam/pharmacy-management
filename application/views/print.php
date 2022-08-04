<?php
    $footer_info=json_decode($meta->footer,true);
    $header_info=json_decode($meta->header,true);
?>
<style>
    .hide h2 {padding-left: 40px;}
    .hide h3 {color: #000;}
    .hide h4 {padding-left: 40px;padding: 3px 0;color: #000;}
</style>
<div class="row hide">
    <div class="view-profile col-md-12 row">
        <div class="col-sm-2 col-xs-2">
            <img class="img-thumbnail" style="margin-top: 20px" src="<?php echo site_url($footer_info['footer_img']); ?>">
        </div>
        <div class="col-sm-10 col-xs-10">
            <h3 class="text-center title" style="margin: 10px 0 0; font-weight: bold; font-size: 25px !important;">
                <?php echo $header_info['site_name']; ?>
            </h3>
            
            <h4 class="text-left" style="margin: 0;">
                <?php echo $footer_info['addr_address']; ?>
            </h4>
            
            <h4 class="text-left" style="margin: 0;">
                Mobile: <?php echo $footer_info['addr_moblile']; ?>
            </h4>
            
            <h4 class="text-left" style="margin: 0;">
                Email: <?php echo $footer_info['addr_email']; ?>
            </h4>
        </div>                          
    </div><hr>
</div>
<!-- Banner End Here -->