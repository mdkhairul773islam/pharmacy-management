<style>
    .action-btn a {
        margin-right: 0;
        margin: 3px 0;
    }

    .checkbox {
        margin: 0 !important;
    }

    .hide {
        display: none !important;
    }

    @media print {

        aside,
        .panel-heading,
        .panel-footer,
        nav,
        .none {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }

        table tr th,
        table tr td {
            font-size: 12px;
        }

        .print_banner_logo {
            width: 19%;
            float: left;
        }

        .print_banner_logo img {
            margin-top: 10px;
        }

        .print_banner_text {
            width: 80%;
            float: right;
            text-align: center;
        }

        .print_banner_text h2 {
            margin: 0;
            line-height: 38px;
            text-transform: uppercase !important;
        }

        .print_banner_text p {
            margin-bottom: 5px !important;
        }

        .print_banner_text p:last-child {
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Due Collection List</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php echo form_open(); ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="voucher_no" placeholder="Enter voucher no...."
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!--<h4 class="text-center hide" style="margin-top: 0px;"></h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>All Cash Client Due</h3>
                </div>


                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Paid <small>(Tk)</small></th>
                        <th>Remission <small>(Tk)</small></th>
                        <th class="none" width="120px">Action</th>
                    </tr>

                    <?php
                    $totalPaid = $totalRemission = 0;
                    if (!empty($results)) {
                        foreach ($results as $key => $row) {

                            $info    = json_decode($row->address);
                            $mobile  = $info->mobile;

                            $totalPaid      += $row->paid;
                            $totalRemission += $row->remission;
                            ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $row->date; ?></td>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td><?php echo check_null(filter($row->party_code)); ?></td>
                                <td><?php echo check_null($mobile); ?></td>
                                <td><?php echo f_number($row->paid); ?></td>
                                <td><?php echo f_number($row->remission); ?></td>
                                <td class="none text-center">
                                    <a title="View" class="btn btn-primary"
                                       href='<?php echo site_url("due_list/due_list/invoice/$row->id"); ?>'><i
                                                class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a title="Delete" class="btn btn-danger"
                                       onclick="return confirm('Do you want to delete this data?');"
                                       href='<?php echo site_url("due_list/due_list/delete/$row->id"); ?>'><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>

                            </tr>
                        <?php }
                    } ?>
                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th><?php echo f_number($totalPaid); ?> TK</th>
                        <th><?php echo f_number($totalRemission); ?> TK</th>
                        <th></th>
                    </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>