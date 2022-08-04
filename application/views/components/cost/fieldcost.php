<script src="<?php echo site_url('private/js/ngscript/costCtrl.js')?>"></script>
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
    }
</style>
<div class="container-fluid block-hide">
    <div class="row">

    <?php echo $this->session->flashdata('confirmation'); ?>

    <!-- horizontal form -->
    <?php
    $attribute = array(
        'name' => '',
        'class' => 'form-horizontal',
        'id' => ''
    );
    echo form_open('cost/cost/add', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Field of Expenditure</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Expenditure </label>
                        <div class="col-md-7">
                            <input type="text" name="field_cost" class="form-control" autocomplete="off">
                        </div>

                        <div>
                            <div class="btn-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Save">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<div class="container-fluid" >
    <div class="row" ng-controller="costCtrl" ng-cloak>
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Field of Expenditure</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
               <!--print header start-->
    		    <?php $this->load->view('print');?>
    		    <!--print header end-->
    		    
                <span class="hide print-time"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>
            
                <div ng-cloak class="row none" style="margin-bottom:15px;">
                 <div class="col-md-4">
                     <input type="text" ng-model="search" placeholder="Search by Name..." class="form-control">
                </div>
                <div class="col-md-5">&nbsp;</div>
                <div class="col-md-3">
                    <div>
                         <span style="margin-left: 55px;line-height: 2.4;font-weight: bold;">Per Page&nbsp;:&nbsp;</span>
                         <select ng-model="perPage" ng-init="perPage='50'"; class="form-control" style="width:90px;float:right;">
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                         </select>
                     </div>
                </div>
            </div>

            <table class="table table-bordered" ng-cloak>
                <tr>
                    <th width="55" >SL</th>
                    <th>Field of Expenditure </th>
                    <th style="text-align:center; width: 115px;" class="block-hide">Action</th>
                </tr>
                <tr dir-paginate="row in fields|filter:search|itemsPerPage:perPage|orderBy:sortField:reverse">
                    <td>{{row.sl}}</td>
                    <td>{{row.cost_field | textBeautify}}</td>
                    <td class="none text-center" >                        
                        <a title="Edit" class="btn btn-warning" ng-click="getFieldName(row.cost_field)" data-toggle="modal" data-target="#myModal" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <?php if($privilege !='user'){ ?>
                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Field of Cost?');" href="<?php echo site_url('cost/cost/delete_field/{{row.id}}'); ?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <?php } ?>
                    </td>
                </tr>
            </table>
             <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>
            
            <!--Modal section start here-->
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Field Name</h4>
                  </div>
                    <div class="modal-body">
                        <div class="row">
                        <?php
                            $attr = array('class' => 'form-horizontal');
                            echo form_open('', $attr);
                        ?>
                            <input type="hidden" name="old_name" value="{{oldname}}">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Field Name <span class="req"> *</span></label>
                                <div class="col-md-7">
                                    <input type="text" name="new_name" class="form-control" value="{{ oldname | textBeautify}}" >
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="btn-group pull-right">
                                    <input type="submit" value="Update" name="update" class="btn btn-info">
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <!--Modal section end here-->
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

