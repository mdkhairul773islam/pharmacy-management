<style>
    .view-site:hover {color: #333;}
    a:focus {border: none;}
    .screen_list {
        justify-content: center;
        border: 1px solid #eee;
        position: relative;
        height: 65px;
        display: none;
        border-left: none;
        align-items: center;
    }
    .company_title,
    .screen_list:hover {background: none !important;}
    .company_title {
        width: auto !important;
        padding-left: 15px;
        display: none;
    }
    .company_title h3 {
        text-transform: uppercase;
        font-weight: 700;
        color: #28A9E0;
        font-size: 19px;
    }
    @media screen and (max-width: 480px) {
        .top-title {display:none;}
	}
</style>


<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="row">
        <nav class="col-xs-12 content-fixed-nav">
            <ul>
                <li>
                    <a href="#menu-toggle" id="menu-toggle">
                        <i class="fa fa-angle-left"></i>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
                <li class="company_title"><h3>Life Care Pharmacy</h3></li>
            </ul>
            
            <ul class="nav-inner-right">
                <li style="width: auto;">
                    <a target="_blank" style="font-weight: bold; color: #00A8FF; border-right: none;" href="<?= site_url("sale/new_sale"); ?>"><i class="fa fa-shopping-cart"></i> New Sale</a>
                </li>
                <li style="width: auto;" class="top-title">
                    <a style="font-weight: bold;"><span style="color: #000;">Hello: </span> <span style="color: #00A8FF;"><?php echo $this->data['name']; ?></span></a>
                </li>
                <li class="user-menu dropdown" style="width: 72px;">
                    <a class="dropdown-toggle" type="button" data-toggle="dropdown" style="border-left: none;">
                        <img class="nav-pic" src="<?php echo site_url($image); ?>" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-menu-description"><a>Settings</a></li>
                        <li><a href="<?php echo site_url("settings/profile");?>">Profile</a></li>
                        <li><a href="<?php echo site_url('settings/createProfile'); ?>">Create Profile</a></li>
                        <li><a href="<?php echo site_url("settings/allProfile");?>">All Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url('access/users/logout'); ?>">Logout</a></li>
                    </ul>
                </li>
                <li class="screen_list">
                    <button class="full_screen_btn" id="screen_ctrl">
                        <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
    <!-- top navigation end -->

    <div class="main-area">&nbsp;</div>
