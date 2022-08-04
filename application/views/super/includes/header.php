<?php
    $logo_data  = json_decode($meta->logo,true);
    $header_data  = json_decode($meta->header,true);
?>
<!DOCTYPE html>
<html lang="en" ng-app="MainApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $header_data['site_name']; ?> | <?php echo ucwords(str_replace('_','',$meta_title)); ?></title>
    <link rel="icon" href="<?php echo site_url($logo_data['faveicon']); ?>" type="image/png">

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo site_url('private/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Bootstrap Date Picker -->
    <link href="<?php echo site_url('private/plugins/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet">

    <!-- Bootstrap file upload CSS -->
    <link href="<?php echo site_url('private/plugins/bootstrap-fileinput-master/css/fileinput.min.css') ;?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo site_url('private/css/simple-sidebar.css'); ?>" rel="stylesheet">

    <!-- Awesome Font CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    
    <!-- Custom CSS -->

    <link href="<?php echo site_url('private/css/profile.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('private/css/form.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('private/css/top-nav.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('private/css/style.css'); ?>" rel="stylesheet">
    
    
    <link href="<?php echo site_url('private/plugins/cart/css/material-charts.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('private/plugins/cart/css/example.css'); ?>" rel="stylesheet">
    

    <!-- Responsive CSS -->
    <link href="<?php echo site_url('private/css/responsive.css'); ?>" rel="stylesheet">

    <!-- Angular -->
    <script type="text/javaScript" src="<?php echo site_url('private/js/angular.js'); ?>"></script>
    <script type="text/javaScript" src="<?php echo site_url('private/js/angular-sanitize.min.js'); ?>"></script>
    <script type="text/javaScript" src="<?php echo site_url('private/js/dirPagination.js'); ?>"></script>
    <script type="text/javaScript" src="<?php echo site_url('private/js/ngscript/app.js'); ?>"></script>

    <!-- jQuery -->
    <script type="text/javaScript" src="<?php echo site_url('private/js/jquery.js'); ?>"></script>

    <!-- includ moment for bootstrap calander -->
    <script type="text/javascript" src="<?php echo site_url('private/js/Moment.js'); ?>"></script>
    <script type="text/javaScript" src="<?php echo site_url('private/plugins/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js') ;?>"></script>

    <script type="text/javascript" src="<?php echo site_url('private/js/inwordbn.js'); ?>"></script>

    <!-- custom Core JavaScript -->
        <script src="<?php echo site_url('private/js/script.js'); ?>"></script>

    <!-- CHART -->
    <script src="<?php echo site_url('private/js/loader.js'); ?>"></script>



</head>

<body <?php echo $active; ?>>

 <div id="wrapper" class="<?php if($this->data['width'] == 'full-width') {echo 'toggled';} ?>">
