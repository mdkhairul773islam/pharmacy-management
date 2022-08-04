<script src="<?php echo site_url('private/js/ngscript/allClientCtrl.js'); ?>"></script>
<style>
    @media print{
        aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        table tr th,table tr td{font-size: 12px;}
    }
    .action-btn a{
        margin-right: 0;
        margin: 3px 0;
    }
</style>

<div class="container-fluid" ng-controller="allClientCtrl" ng-cloak>
    <div class="row">
    	<?php  echo $this->session->flashdata('confirmation'); ?>

        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>

    	<div class="panel panel-default loader-hide" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Client</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
            </div>

            <div class="panel-body" ng-cloak>
                <!--print header start-->
			    <?php $this->load->view('print');?>
			    <!--print header end-->

                <h4 class="text-center hide" style="margin-top: 0px;">All Client</h4>
                <div class="row none">
                    <div class="col-md-3" style="margin-bottom:15px;">
                        <input type="text" ng-model="search" placeholder="Search...." class="form-control">
                    </div>
                    <div class="col-md-offset-6 col-md-3">
                        <select ng-model="perPage" class="form-control pull-right" style="width:100px;">
                            <option value="">All</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                </div>
                <p> <span style="color: green;font-weight: bold;">Green = Receivable</span>&nbsp;<span style="color: red;font-weight: bold;">Red = Payable</span></p>
                <table class="table table-bordered">
                    <tr>
                        <th width="50">SL</th>
                        <th width="75">C.ID</th>
                        <th>Date</th>
                        <th>Image</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th width="120">Mobile</th>
                        <th width="115">Balance</th>
                        <th width="115">Credit Limit</th>
                        <th class="none" style="width: 160px;">Action</th>
                    </tr>
                    <tr dir-paginate="row in allParty|filter:search|filter:searchItem|orderBy:sortField:reverse|itemsPerPage:perPage">
                        <input type="hidden" ng-value="row.showroom_id">
                        <td>{{ row.sl }}</td>
                        <td>{{ row.code }}</td>
                        <td>{{ row.opening | textBeautify}} </td>
                        <td><img width="60" ng-src="<?php echo site_url('{{ row.path }}'); ?>"> </td>
                        <td>{{ row.name | textBeautify}} </td>
                        <td>{{ row.address | textBeautify}} </td>
                        <td>{{ row.mobile }}</td>
                        <td style="{{ row.color}}">{{ row.balance }}</td>
                        <td>{{ row.credit_limit}}</td>
                        <td class="none action-btn">
                            <a class="btn btn-info" title="Preview" href="<?php echo site_url('client/client/preview?partyCode={{row.code}}'); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('client/client/edit?partyCode={{row.code}}');?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <?php if($privilege !='user'){ ?>
                            <a onclick="return confirm('Do you want to delete this Client?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('client/client/delete/{{row.code}}'); ?>">
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
