<style type="text/css">
    .info-view{
        width: 100%;
        max-width: 230px;
        max-height: 230px;
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }
    .custom-table tr td{
        padding: 0 !important;
    }
    .custom-table tr td .form-control{
        border: transparent;
    }
</style>

<div class="container-fluid" ng-controller="DeductionCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Deduction </h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class"=>"form-horizontal");
                echo form_open('', $attr); 
                ?>

                <div class="row">
                    <div class="col-md-7">

                        <div class="form-group">
                            <label class="col-md-4 control-label">ID <span class="req">*</span></label>
                            <div class="col-md-8">
                                <input 
                                    type="text" 
                                    name="id" 
                                    class="form-control" 
                                    ng-model="eid"
                                    ng-keyup="getProfileFn()"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Name </label>
                            <div class="col-md-8">
                                <input type="text" ng-model="profile.name" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Post </label>
                            <div class="col-md-8">
                                <input type="text" ng-model="profile.post" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Mobile </label>
                            <div class="col-md-8">
                                <input type="text" ng-model="profile.mobile" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Jobining Date </label>
                            <div class="col-md-8">
                                <input type="text" ng-model="profile.joining" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5" ng-if="profile.active" ng-cloak>
                        <figure class="info-view">
                            <img class="img-responsive img-thumbnail" ng-src="{{ profile.image }}" alt="profile pic not found!">
                        </figure>
                    </div>
                </div>

                <hr style="border: 1px dashed  #ddd;">

                

                <table class="table table-bordered custom-table" ng-if="profile.active" ng-cloak>
                    <tr>
                        <th>Name</th>
                       <!--  <th>Percentage</th> -->
                        <th>Amount</th>
                        <th>Remarks</th>
                    </tr>

                    <tr ng-repeat="row in deductions">
                        <th>{{ row.fields }}</th>
                        <!-- <td> 
                            <input 
                                type="number" 
                                name="percent[]" 
                                ng-model="row.percentage"
                                min="0" max="100"
                                class="form-control" 
                                required step="any">
                        </td> -->

                        <td> 
                            <input 
                                type="number"
                                name="amount[]" 
                                ng-model="row.amount"
                                class="form-control" 
                                min="0" step="any" 
                                required> 
                            <input type="hidden" name="name[]" ng-value="row.fields">
                        </td>

                        <td>
                            <input 
                                type="text" 
                                name="remark[]" 
                                ng-model="row.remarks"
                                class="form-control"> 
                        </td>
                    </tr>
                </table>

                <div class="pull-right">
                    <input type="submit" name="create" value="Save" class="btn btn-primary">
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
