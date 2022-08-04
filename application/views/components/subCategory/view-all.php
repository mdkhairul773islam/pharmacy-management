<!-- load Angular Controller -->
<script type="text/javaScript" src="<?php echo site_url('private/js/ngscript/showsubcategoryCtrl.js'); ?>"></script>

<style>
    @media print{
        aside{display: none !important;}
        nav{display: none;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .none{display: none;}
        .panel-heading{display: none;}
        .panel-footer{display: none;}
        .panel .hide{display: block !important;}
        .title{font-size: 25px;}
        table tr th,table tr td{font-size: 12px;}
    }
</style>

<div class="container-fluid" ng-controller="showsubcategoryCtrl">
    <div class="row">
	    <?php  echo $this->session->flashdata('confirmation'); ?>

	    <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>

	    <div class="panel panel-default loader-hide" id="data">
	        <div class="panel-heading">
	            <div class="panal-header-title">
	                <h1 class="pull-left">All Manufacturer</h1>
	                <a
						class="btn btn-primery pull-right"
						style="font-size: 14px; margin-top: 0;"
						onclick="window.print()">
						<i class="fa fa-print"></i> Print
					</a>
				</div>
	        </div>

	        <div class="panel-body"  ng-cloak>
	            <!-- Print banner -->
                <!--<img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">-->
                
                <!-- Banner Start Here -->
                <?php
                    $footer_info=json_decode($meta->footer,true);
                    $header_info=json_decode($meta->header,true);
                ?>
                <style>
                    .hide h2{
                            padding-left: 40px;
                    }
                    .hide h4{
                        padding: 3px 0;
                        padding-left: 40px;
                    }
                </style>
                <div class="row hide">
                    <div class="view-profile col-md-12 row">
                        <div class="col-sm-4 col-xs-4 col-sm-offset-1 col-xs-offset-1">
                            <img width="200" style="margin-top: 20px" src="<?php echo site_url($footer_info['footer_img']); ?>">
                        </div>
                        <div class="col-sm-7 col-xs-7">
                            <h2 class="text-left title" style="margin-top: 10px; font-weight: bold;">
                                <?php echo $header_info['site_name']; ?>
                            </h2>
                            
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
                
	            <h4 class="text-center hide" style="margin-top: 0px;">All Brand </h4>

	            <div class="row none" style="margin-bottom:15px;">
                    <div class="col-sm-4" style="margin-bottom:15px;">
                        <input type="text" ng-model="search" placeholder="Search.........." class="form-control">
                    </div>

                    <div class="col-sm-offset-4 col-sm-4">
                        <div style="display: flex;" class="pull-right">
                            <label style="line-height: 34px; padding-right: 5px;">Per Page</label>
                            <select ng-model="perPage" class="form-control" style="width:75px;">
                                <option value="">All</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                         </div>
                    </div>
                </div>

	            <table class="table table-bordered">
	                <tr>
	                    <th style="width: 50px;">SL</th>
	                    <th style="cursor:pointer;" ng-click="sortField='subcategorys'; reverse = !reverse;">Manufacturer &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>
	                    <!--<th style="cursor:pointer;" ng-click="sortField='category'; reverse = !reverse;">Category &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>-->
	                    <th class="none" style="width: 115px;">Action</th>
	                </tr>

	                <tr dir-paginate="(index,subcategory) in subcategorys|filter:search|itemsPerPage:perPage|orderBy:sortField:reverse">
	                    <td>{{subcategory.sl}}</td>
	                    <td>{{subcategory.subcategory | removeUnderScore | textBeautify}}</td>
	                    <!--<td>{{subcategory.category | removeUnderScore | textBeautify}}</td>-->
	                    <td  class="none">
	                        <a
								class="btn btn-warning"
								title="Edit" href="<?php echo site_url('subCategory/subCategory/editsubCategory?id={{subcategory.id}}');?>">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							</a>
                        <?php if($privilege !='user'){ ?>
							<a onclick="return confirm('Do you want to delete this Sub Category?');"
								class="btn btn-danger" title="Delete"
								href="<?php echo site_url('subCategory/subCategory/deletesubCategory/{{subcategory.id}}'); ?>">
								<i class="fa fa-trash-o" aria-hidden="true"></i>
							</a>
						<?php } ?>
	                    </td>
	                </tr>
	            </table>

	            <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
	        </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
