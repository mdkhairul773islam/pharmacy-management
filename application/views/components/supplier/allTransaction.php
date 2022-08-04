<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
@media print{
aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
.panel{border: 1px solid transparent; left: 0px; position: absolute; top: 0px; width: 100%;}
.hide{display: block !important;}
}
</style>
<div class="container-fluid">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Payment</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label"> Supplier Name </label> -->
                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>-- Select Supplier --</option>
                            <?php
                            if ($info != null) {
                            foreach ($info as $row) {
                            ?>
                            <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    <?php if ($transactionInfo != NULL) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!--print header start-->
			    <?php $this->load->view('print');?>
			    <!--print header end-->
                
                <h4 class="text-center hide" style="margin-top: 0px;">All Transaction</h4>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Transaction By</th>
                        <th class="text-center">Paid</th>
                        <th class="text-center">Remission</th>
                        <th class="text-center">Paid By</th>
                        <th class="none" width="160px">Action</th>
                    </tr>
                    <?php
                    $total = $total_remission= 0.00;
                    foreach ($transactionInfo as $key => $row) {
                        if(strlen($row->party_code) == 3){
                        $where = array("code" => $row->party_code);
                        $info  = $this->action->read("parties", $where);
                        $total += $row->debit;
                        $total_remission += $row->remission;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $key + 1; ?></td>
                        <td class="text-center"><?php echo $row->transaction_at; ?></td>
                        <td class="text-center"><?php echo filter($info[0]->name); ?></td>
                        <td class="text-center"><?php echo filter($row->transaction_via); ?></td>
                        <td class="text-center"><?php echo f_number($row->debit); ?></td>
                        <td class="text-center"><?php echo f_number($row->remission); ?></td>
                        <td><?php echo $row->comment; ?></td>
                        <td class="none">
                            <a class="btn btn-info" href="<?php echo site_url('supplier/all_transaction/view/'.$row->id);?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('supplier/transaction/edit_transaction/'.$row->id);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <?php if($privilege !='user'){ ?>
                            <a href="<?php echo site_url('supplier/all_transaction/delete_transaction/'.$row->id);?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete this ?')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } } ?>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                        <td class="text-center"><strong><?php echo f_number($total); ?> Tk</strong></td>
                        <td class="text-center"><strong><?php echo f_number($total_remission); ?> Tk</strong></td>
                        <td></td>
                        <td class="none"></td>
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
    $("#datetimepickerFrom").on("dp.change", function (e) {
    $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerTo").on("dp.change", function (e) {
    $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>