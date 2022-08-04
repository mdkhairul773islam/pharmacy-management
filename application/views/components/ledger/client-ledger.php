<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
    }
    .table tr th, .table tr td{font-size: 13px; padding: 4px !important;}
    .table tr td p {margin: 0;padding: 0;}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Client Ledger</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label"> Client Name </label> -->
                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>-- Select Client Name --</option>
                            <?php
                            if ($info != null) {
                            foreach ($info as $row) {
                            ?>
                            <option value="<?php echo $row->code; ?>"><?php echo filter($row->name)." ( ".$row->address." )"; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                    
                        <!-- <label class="col-md-2 control-label">From</label> -->
                        <div class="col-md-3">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <!-- <label class="col-md-2 control-label">To</label> -->
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
                <?php
                if (!$this->input->post("show")) {
                    if($defaultData != NULL){
                        ?>
                        <!--Get data before submit result start here-->
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
                    		    
                <h4 class="text-center hide" style="margin-top: 0px;">Client Ledger</h4>
              
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th>Opening Balance</th>
                        <th>Debit (Tk)</th>
                        <th>Credit (Tk)</th>
                        <th>Balance (Tk)</th>
                        <th class="text-center">Status</th>
                    </tr>
                    <?php
                        $totalDebit = $totalCredit = $total = $totalQuantity = $grandTotal = 0.00;
                        foreach($defaultData as $key => $row){
                        ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo filter($row['name']); ?></td>
                                <td><?php echo filter($row['address']); ?></td>
                                <td><?php echo abs($row['init'])." [ ".$row['init_status']." ]"; ?></td>
                                <td><?php echo $row['credit'];$totalCredit += $row['credit']; ?></td>
                                <td><?php echo $row['debit'];$totalDebit += $row['debit']; ?></td>
                                <td>
                                    <?php
                                    $balance = 0.0;
                                    $balance = $row['debit'] - $row['credit'] + $row['init'];
                                    $status = ($balance > 0 )? "Receivable": "Payable";
                                    echo abs($balance);
                                    $grandTotal += $balance;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $status; ?>
                                </td>
                            </tr>
                        <?php }  ?>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th><strong><?php echo f_number($totalCredit); ?></strong></th>
                            <th><strong><?php echo f_number($totalDebit); ?></strong></th>
                            <th><strong><?php echo abs($grandTotal); ?></strong></th>
                            <th class="text-center"><strong><?php  echo ($grandTotal >= 0) ? "Receivable" : "Payable"; ?></strong></th>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
            <!--Get data before submit result end here-->
            <?php } } else { ?>
            <!--Get data after submit result Start here-->
            <?php if ($resultset != NULL) { ?>
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

                <h4 class="text-center hide" style="margin-top: 0px;">Client Ledger</h4>

                <div class="row">
                    <div class="col-xs-5">
                        <table class="table table-bordered">
                            <tr>
                                <th width="35%">Client ID :</th>
                                <td><?php echo $partyInfo[0]->code; ?></td>
                            </tr>
                            <tr>
                                <th>Party :</th>
                                <td><?php echo filter($partyInfo[0]->name); ?></td>
                            </tr>
                            <tr>
                                <th> Address :</th>
                                <td> <?php echo $partyInfo[0]->address; ?> </td>
                            </tr>
                            <tr>
                                <th> Mobile :</th>
                                <td> <?php echo $partyInfo[0]->mobile; ?> </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-offset-2 col-xs-5">
                        <table class="table table-bordered">
                            <tr>
                                <th>Date :</th>
                                <td>
                                    <?php
                                    if($fromDate != NULL || $toDate != NULL){
                                        echo $fromDate . ' To ' . $toDate;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th width="40%">Opening Balance :</th>
                                <td>
                                    <strong>
                                        <?php
                                        $opening_status = ($partyInfo[0]->initial_balance < 0)? "Payable":"Receivable";
                                        echo abs($partyInfo[0]->initial_balance)." TK &nbsp; [".$opening_status." ]";
                                        $opening_balance = $partyInfo[0]->initial_balance;
                                        ?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Current Balance :</th>
                                <td>
                                    <strong>
                                        <?php
                                        // Calculate Balance from partytrasaction table.
                                        // Final balance = total_debit - total_credit + initial_balance.
                                        // Final Balance (+ve) = Receivable and (-ve) = Payable
                                        $where = array(
                                            'party_code' => $partyInfo[0]->code,
                                            'trash' => 0
                                        );
                                        $transactionRec = $this->retrieve->read('partytransaction',$where);
                                        $total_credit = $total_debit = 0.0;
                                        if ($transactionRec != null) {
                                            foreach ($transactionRec as $key => $row) {
                                                $total_credit += $row->credit;
                                                $total_debit += $row->debit;
                                            }
                                            $balance = $total_debit -  $total_credit + $partyInfo[0]->initial_balance;
                                        }else{
                                            $balance = $partyInfo[0]->initial_balance;
                                        }
                                        $status = ($balance < 0) ? " Payable" : " Receivable";
                                        echo abs($balance) . ' TK &nbsp; [' . $status . '&nbsp;]';
                                        
                                        
                                        
                                        // calculate previous balance before from date
                                        $total_credit = $total_debit = 0.0;
                                        if ($transactionRec != null && $fromDate != NULL) {
                                            foreach ($transactionRec as $key => $row) {
                                                if($row->transaction_at < $fromDate ){
                                                    $total_credit += $row->credit;
                                                    $total_debit += $row->debit;
                                                }
                                            }
                                            $opening_balance = $total_debit -  $total_credit + $partyInfo[0]->initial_balance;
                                        }
                                        
                                        ?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Discount :</th>
                                <td><strong>
                                    <?php
                                    $total_discount = 0.00;
                                    foreach ($transactionRec as $key => $value) {
                                        if($value->remark == 'sale'){
                                            $relationList = explode(':', $value->relation);
                                            $where = array('voucher_no' => $relationList[1],'trash' => 0);
                                            $purchase = $this->action->read('saprecords', $where);
                                            if($purchase){
                                                $total_discount += $purchase[0]->total_discount;
                                            }
                                        }
                                    }
                                    echo $total_discount." TK";
                                    ?>
                                </strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30px;">SL</th>
                        <th>Date</th>
                        <th>Details</th>
                        <th>Paid By</th>
                        <th>Voucher No</th>
                        <th>Credit (Tk)</th>
                        <th>Debit (Tk)</th>
                        <th>Remission (Tk)</th>
                        <th>Balance</th>
                        <th class="none" style="width:40px;">Action</th>
                    </tr>
                    
                    <!-- previous balance row start here -->
                    <?php $staus = ($resultset[0]->previous_balance > 0) ? "Receivable" : "Payable"; ?>
                    <tr>
                        <td>1</td>
                        <td colspan="5" class="text-center">Previous Balance</td>
                        <td><?php echo abs($opening_balance)." TK &nbsp;[ ".$opening_status." ]"; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="none">&nbsp;</td>
                    </tr>
                    <!-- previous balance row end here -->
                    
                    
                    <?php
                    $totalDebit = $total = $totalCredit = $stepBalance = $grandtotalQuant = $total_remission = 0.00;
                    $stepBalance += $opening_balance;
                    foreach($resultset as $key => $row){
                        $voucher = ($row->remark == 'sale') ? explode(':',$row->relation):"";
                    ?>
                        <tr>
                            <td><?php echo ($key + 2); ?></td>
                            <td style="width:100px;"><?php echo $row->transaction_at; ?></td>
                            <td>
                                <strong><?php echo ($row->remark == 'sale')? "":"Transaction"; ?></strong>
                                <?php
                                     
                                     if(!empty($voucher[1])){
                                        $vno = $voucher[1];
                                        $where_product = [];
                                        $where_product = array('voucher_no' => $vno);
                                        $saleInfo = $this->action->read('sapitems', $where_product);
                                        
                                        foreach($saleInfo as  $rows){
                                            $product = get_name('products','product_name',['product_code'=>$rows->product_code]);
                                            
                                            
                                            if(!empty($row->name) && $row->name != null){
                                                $product_name = $row->name;
                                            }else{
                                                $product_name = $product;
                                            }
                                            echo $product_name.'-'.number_format($rows->quantity,0).'*'.$rows->sale_price.'&nbsp;=&nbsp;'.($rows->sale_price*$rows->quantity).'<br>';
                                            
                                        }
                                     }    
                                       
                                ?>
                            </td>
                            <td><?php echo (isset($row->comment)) ? (filter($row->comment)) : ''; ?></td>
                            <td><?php echo $vno = ($row->remark == 'sale') ? $voucher[1] : ''; ?></td>
                            <td><?php echo $debit = $row->debit; $totalDebit += $row->debit; ?></td>
                            <td><?php echo $credit = $row->credit; $totalCredit += $row->credit; ?></td>
                            <td><?php echo $row->remission; $total_remission +=$row->remission ?></td>
                            <td>
                                <?php
                                    $stepBalance += ($debit - $credit);
                                    $step_status = ($stepBalance < 0 )? "Payable":"Receivable";
                                    echo abs($stepBalance)." TK &nbsp;[ ".$step_status." ]";
                                ?>
                            </td>
                            <td class="none">
                            <?php if($row->remark == 'sale'){ ?>
                            <a class="btn btn-info" title="Preview" target="_blank" href="<?php echo site_url('sale/viewSale?vno=' . $voucher[1]); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <?php }else{ ?>
                            &nbsp;
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th><strong><?php echo f_number($totalDebit); ?></strong></th>
                        <th><strong><?php echo f_number($totalCredit); ?></strong></th>
                        <th><strong><?=($total_remission)?> TK</strong></th>
                        <th><strong><?php 
                                        $balance = $totalDebit - $totalCredit + $opening_balance;
                                        $balance_status = ($balance < 0 )? "Payable":"Receivable";
                                        echo abs($balance)." TK &nbsp;[ ".$balance_status." ]";
                                    ?>
                        </strong></th>
                        <th class="none">&nbsp;</th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php }} ?>
        <!--Get data after submit result End here-->
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