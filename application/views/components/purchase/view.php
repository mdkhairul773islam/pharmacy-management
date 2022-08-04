<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,900" rel="stylesheet">
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
    }
    .wid-100{
        width: 100px;
    }
    .custom-table>tbody>tr>th,
    .custom-table>tbody>tr>td{
        border: none;
        line-height: 18px;
        padding: 4px !important;
    }
    .custom-table>tbody>tr>th {
        width: 140px;
    }
    .view {
        font-family: 'Raleway', sans-serif;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!--print header start-->
			    <?php $this->load->view('print');?>
			    <!--print header end-->
			    
                <div class="row">
                    <div class="col-xs-6">
                        <table class="table custom-table view">
                            <tr>
                                <th>Supplier Name :</th>
                                <td><?php echo filter($voucherInfo->name); ?></td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td><?php echo filter($voucherInfo->address); ?></td>
                            </tr>
                            <tr>
                                <th>Mobile :</th>
                                <td><?php echo $voucherInfo->mobile; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6">
                        <table class="table custom-table">
                            <tr>
                                <th width="200">Date :</th>
                                <td><?php echo $voucherInfo->sap_at; ?></td>
                            </tr>
                            <tr>
                                <th>Voucher No :</th>
                                <td><?php echo $voucherInfo->voucher_no; ?></td>
                            </tr>
                            <tr>
                            </tr>
                        </table>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr class="view">
                        <th>Sl</th>
                        <th>Product Name</th>
                        <th>Batch No</th>
                        <th>Expire Date</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Price (TK)</th>
                        <th>Total (TK)</th>
                    </tr>
                    <?php
                    $total_discount = array();
                    foreach($itemsInfo as $key => $row){ ?>
                    <tr>
                        <td style="width: 50px;"><?php echo ($key + 1); ?></td>
                        <td class="view"><?php echo filter($row->name); ?></td>
                        <td class="view"><?php echo filter($row->batch_no); ?></td>
                        <td class="view"><?php echo filter($row->expire_date); ?></td>
                        <td style="width: 80px;"><?php echo filter($row->unit); ?></td>
                        <td class="wid-100 text-right"><?php echo $row->quantity; ?></td>
                        <td class="wid-100 text-right"><?php echo $row->purchase_price; ?></td>
                        <td class="wid-100 text-right"><?php echo $row->purchase_price*$row->quantity; ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <div class="col-xs-offset-8 col-xs-4">
                    <div class="row">
                        <table class="table custom-table text-right">
                            <tr>
                                <th class="view" width="200">Total Amount :</th>
                                <td><b><?php echo f_number($voucherInfo->total_bill + $voucherInfo->total_discount - $voucherInfo->transport_cost); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Total Discount :</th>
                                <td><b><?php echo f_number($voucherInfo->total_discount); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Transport Cost :</th>
                                <td><b><?php echo f_number($voucherInfo->transport_cost); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Grand Total:</th>
                                <?php $grandTotal = $voucherInfo->total_bill - array_sum($total_discount); ?>
                                <td><b><?php echo f_number($grandTotal); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Paid :</th>
                                <td><b><?php echo $voucherInfo->paid; ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Due :</th>
                                <td><b><?php echo f_number($grandTotal - $voucherInfo->paid); ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>