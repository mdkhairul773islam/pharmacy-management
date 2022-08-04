<script src="<?php echo site_url('private/js/ngscript/showAllProductCtrl.js')?>"></script>
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
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
        .title{
            font-size: 25px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row" ng-controller="showAllProductCtrl" ng-cloak>

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>


        <div class="panel panel-default loader-hide" id="data">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Products</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>

                </div>
            </div>

            <div class="panel-body">
                <div class="row none" style="margin-bottom:15px;">
                  <div class="col-md-4">
                      <input type="text" ng-model="searchText" placeholder="Search Here...." class="form-control">
                  </div>
                  <div class="col-md-5">&nbsp;</div>
                      <div class="col-md-3">
                         <div>
                              <span style="margin-left: 55px;line-height: 2.4;font-weight: bold;">Per Page&nbsp;:&nbsp;</span>
                              <select ng-model="perPage" class="form-control" style="width:92px;float:right;">
                                 <option value="">All</option>
                                 <option value="10">10</option>
                                 <option value="20">20</option>
                                 <option value="50">50</option>
                                 <option value="100">100</option>
                                 <option value="150">150</option>
                                 <option value="200">200</option>
                                 <option value="500">500</option>
                              </select>
                          </div>
                      </div>
                  </div>

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

                <h4 class="hide text-center" style="margin-top: 0px;">All Products</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center" >SL</th>
                            <th class="text-center" >Name </th>
                            <th class="text-center" >Generic Name </th>
                            <!--<th width="70">image</th>-->
                            <th class="text-center" >Category </th>
                            <th class="text-center" >Self Name </th>
                            <th class="text-center" >Manufacturer </th>
                            <th class="text-center" >Pack Size </th>
                            <th class="text-center" >Stock Limit </th>
                            <th class="text-center" >Unit </th>
                            <th class="text-center" >Purchase Price</th>
                            <th class="text-center" >Sale Price </th>
                            <!--<th class="text-center" >MRP </th>-->
                            <!--th class="text-center" >Status</th-->
                            <th width="120" class="none"> Action </th>
                        </tr>

                        <tr dir-paginate="row in products|filter:searchText|itemsPerPage:perPage|orderBy:sortField:reverse">
                            <td class="text-center"> {{ row.sl }} </td>
                            <td> {{ row.product_name | textBeautify }}</td>
                            <td> {{ row.generic_name | textBeautify }}</td>
                            <!--<td><img style="height: 40px; width: 100%;" src="{{ 'http://al-ara.com/'+row.path}}" /> </td>-->
                            <td class="text-center"> {{ row.product_cat | textBeautify }} </td>
                            <td class="text-center"> {{ row.self_name }} </td>
                            <td class="text-center"> {{ row.subcategory | textBeautify }} </td>
                            <td class="text-center"> {{ row.pack_size | textBeautify }} </td>
                            <td class="text-center"> {{ row.low_level | textBeautify }} </td>
                            <td class="text-center"> {{ row.unit | textBeautify }} </td>
                            <td class="text-center"> {{ row.purchase_price }} </td>
                            <td class="text-center"> {{ row.sale_price }} </td>
                            <!--<td class="text-center"> {{ row.mrp }} </td>-->
                            <!--td class="text-center"> {{ row.status | textBeautify }} </td-->
                            <td class="none" >
                                <a class="btn btn-warning" title="Edit" href="<?php echo site_url('product/product/edit/{{ row.id }}');?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <?php if($privilege !='user'){ ?>
                                <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure want to delete this Product?');" href="<?php echo site_url('product/product/delete/{{ row.id }}') ;?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                    <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
                 </div>
               </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
