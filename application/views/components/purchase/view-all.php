<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style type="text/css">
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
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
    }

    .table-title {
        font-size: 20px;
        color: #333;
        background: #f5f5f5;
        text-align: center;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Purchase</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                echo $this->session->flashdata('deleted');
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">Voucher No </label> -->
                    <div class="col-md-3">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                    </div>

                    <!-- <label class="col-md-2 control-label">Supplier Name </label> -->
                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>-- Select Supplier Name --</option>
                            <?php if (!empty($allParty)) {
                                foreach ($allParty as $key => $row) { ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>

                    <!-- <label class="col-md-2 control-label">From </label> -->
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <!-- <label class="col-md-2 control-label">To </label> -->
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="btn-group">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php if ($result != null) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show Result</h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="panel-body">
                    <!--print header start-->
    			    <?php $this->load->view('print');?>
    			    <!--print header end-->

                    <h4 class="text-center hide" style="margin-top: 0px;">All Purchase</h4>
                    <table class="table table-bordered table2">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Voucher No</th>
                            <th>Supplier Name</th>
                            <th>Mobile</th>
                            <th>Total (TK)</th>
                            <th>Paid (TK)</th>
                            <th>Due (TK)</th>
                            <th class="none">Action</th>
                        </tr>

                        <?php
                        $totalBill = $totalPaid = $totalDue = 0;
                        foreach ($result as $key => $val) {
                            
                            $due = $val->total_bill - $val->paid;
                            
                            $totalBill += $val->total_bill;
                            $totalPaid += $val->paid;
                            $totalDue  += $due;
                            ?>
                            <tr>
                                <td style="width: 40px;"><?php echo $key + 1; ?></td>
                                <td><?php echo $val->sap_at; ?></td>
                                <td><?php echo $val->voucher_no; ?></td>
                                <td><?php echo filter($val->name); ?></td>
                                <td><?php echo $val->mobile; ?></td>
                                <td><?php echo f_number($val->total_bill); ?></td>
                                <td><?php echo f_number($val->paid); ?></td>
                                <td><?php echo f_number($due); ?></td>

                                <td class="none" style="width: 210px;">
                                    <a title="View" class="btn btn-primary"
                                       href="<?php echo site_url('purchase/purchase/invoice?vno=' . $val->voucher_no); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a title="Edit" class="btn btn-warning"
                                       href="<?php echo site_url('purchase/edit_purchase?vno=' . $val->voucher_no); ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a title="Return" class="btn btn-info"
                                       href="<?php echo site_url('purchase/return_purchase?vno=' . $val->voucher_no); ?>">
                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                    </a>
                                    <?php if ($privilege != 'user') { ?>
                                        <a title="Delete" class="btn btn-danger"
                                           onclick="return confirm('Are you sure want to delete this Data?');"
                                           href="<?php echo site_url('purchase/purchase/delete?vno=' . $val->voucher_no); ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        
                            <tr>
                                <th colspan="5" class="text-right"> Total </th>
                                <th> <?php echo f_number($totalBill); ?> </th>
                                <th> <?php echo f_number($totalPaid); ?> </th>
                                <th> <?php echo f_number($totalDue); ?> </th>
                            </tr>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    // linking between two date
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>