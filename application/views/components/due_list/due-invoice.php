<style>
    .action-btn a {
        margin-right: 0;
        margin: 3px 0;
    }

    .checkbox {
        margin: 0 !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Invoice</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <!--pre><?php //echo $result['voucher_no'];?></pre-->
            <div class="panel-body" ng-cloak>
                <?php $this->load->view('print', $this->data); ?>
                <h4 class="text-center hide">
                    Due Collect
                </h4>

                <?php
                $sale_by = get_name('sapmeta', 'meta_value', ['voucher_no' => $info->voucher_no, 'meta_key' => 'sale_by', 'trash' => 0]);
                $partyInfo = json_decode($info->address);
                ?>

                <div class="row">
                    <div class="col-md-4 print-font">
                        <label>Name : <?php echo check_null(filter($info->party_code)); ?></label> <br>
                        <label> Mobile : <?php echo check_null($partyInfo->mobile); ?></label>
                    </div>

                    <div class="col-md-4 print-font">
                        <label> Voucher No : <?php echo $info->voucher_no; ?></label> <br>
                        <label> Sales Man : <?php echo $sale_by; ?> </label>
                    </div>

                    <div class="col-md-4 print-font">
                        <label>Date : <?php echo $info->date; ?></label> <br>
                    </div>
                </div>

                <div class="col-md-12">&nbsp;</div>

                <table class="table table-bordered">
                    <tr>
                        <th>Total Bill <small>(Tk)</small></th>
                        <th>Previous Paid <small>(Tk)</small></th>
                        <th>Paid <small>(Tk)</small></th>
                        <th>Remission <small>(Tk)</small></th>
                        <th>Due <small>(Tk)</small></th>
                    </tr>

                    <tr>
                        <td><?php echo $info->total_bill; ?></td>
                        <td><?php echo $info->previous_paid; ?></td>
                        <td><?php echo $info->paid; ?></td>
                        <td><?php echo $info->remission; ?></td>
                        <td><?php echo $info->due; ?></td>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>