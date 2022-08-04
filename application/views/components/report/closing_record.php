<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
    	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{
            display: block !important;
        }
        .block-hide{
            display: none;
        }
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
</style>

<div class="container-fluid" >
    <div class="row">
        <div><?php echo $this->session->flashdata('confirmation');  ?></div>
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Balance Closing Record</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!--print header start-->                    		    
                <?php $this->load->view('print');?>                    		    
                <!--print header end-->
                
                <div class="col-md-12 text-center hide">
                    <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">Balance Closing Record</h3>
                </div>
                
                <span class="hide print-time"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>
            
                <table class="table table-bordered">
                    <tr>
                        <th width="55" >SL</th>
                        <th>Date</th>
                        <!--<th>Opening Balance </th>-->
                        <th>Closing Balance </th>
                    </tr>
                    <?php foreach($closingInfo as $key => $value){ ?>
                    <tr>
                        <td><?php echo $key+1;?></td>
                        <td><?php echo $value->date; ?></td>
                        <!--<td><?php echo $value->opening_balance; ?></td>-->
                        <td><?php echo $value->closing_balance; ?></td>
                    </tr>
                    <?php } ?>
                </table>
                
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
