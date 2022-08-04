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
    .balance {background: rgb(245, 245, 245);}
    .balance h4{line-height: 48px; font-weight: bold;}
    .red{
        color: red;
        font-weight: bold;
        background-color: #FFE4E3;
    }
    .green{
        color: green;
        font-weight: bold;
        background-color: #CCE3DF;
    }
    .s_red{
        background-color: #FE3939;
        font-weight: bold;
        color: #fff;
        cursor: default;
        font-size: 1.2em;
        padding: 13px 0px !important;
    }
    .s_red:hover{
        color: #fff;
    }
    .s_green{
        background-color: #449D44;
        font-weight: bold;
        color: #fff;
        cursor: default;
        font-size: 1.2em;
        padding: 13px 0px !important;
    }
    .s_green:hover{
        color: #fff;
    }
</style>

<?php echo $this->session->flashdata('confirmation'); ?>

<div class="panel panel-default none">
    <div class="panel-heading">
        <div class="panal-header-title pull-left">
            <h1>Search Balance</h1>
        </div>
    </div>

    <div class="panel-body">

        <!-- horizontal form -->
        <?php $attribute = array( 'name' => '', 'class' => 'form-horizontal', 'id' => '' );
        echo form_open('', $attribute); ?>

        <div class="form-group">
            <label class="col-md-1 control-label">Form</label>
            <div class="col-md-4">
                <div class="input-group date" id="datetimepickerFrom">
                    <input type="text" name="date[from]" placeholder="From ( YYYY-MM-DD )" class="form-control" required >
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <label class="col-md-1 control-label">To</label>
            <div class="col-md-4">
                <div class="input-group date" id="datetimepickerTo">
                    <input type="text" name="date[to]" placeholder="To ( YYYY-MM-DD )" class="form-control" required >
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="btn-group">
                <input class="btn btn-primary" type="submit" name="show" value="Show">
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <div class="panel-footer">&nbsp;</div>
</div>


<div class="panel panel-default">
    <div class="panel-heading ">
        <div class="panal-header-title">
            <h1 class="pull-left">Balance Sheet</h1>
            <a href="#" class="pull-right " style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>    
    <div class="panel-body">
        <!--print header start-->                    		    
        <?php $this->load->view('print');?>                    		    
        <!--print header end-->

        <?php $total_cost = $other_income = $total_sale = $total_purchase = $bank_income = $bank_cost = $due_Collection = $totalCash = 0.00; ?>
        <div class="row">
        <div class="col-xs-6">
            <?php if ($saleIncome != NULL) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                   
                    <caption>
                        <h4 class="text-center">Total Paid</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Voucher</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                    foreach ($saleIncome as $key => $value){ ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->voucher_no; ?></td>
                        <td><?php echo $value->paid; $total_sale += $value->paid;?></td>
                    </tr>
                   
                    <?php } ?>

                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th> <?php echo f_number($total_sale); ?> TK</th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            
            <?php if ($otherIncome != null) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <caption>
                        <h4 class="text-center">Other Income</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th width="300">Field</th>
                        <th width="100">Amount</th>
                    </tr>
                    <?php 
            
                    foreach ($otherIncome as $key => $value){
                        $field_amount = 0.00;
                        $where = array('field' => $value->field,'date' => $value->date);
                        $field_amount = $this->action->read_sum('income','amount',$where);
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo filter($value->field); ?></td>
                        <td><?php echo $field_amount[0]->amount; $other_income += $field_amount[0]->amount;?></td>
                    </tr>
                    
                    <?php } ?>
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th><?php echo f_number($other_income); ?></th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            
            <?php if ($dueCollection != null) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <caption>
                        <h4 class="text-center">Due Collection</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th width="50">Voucher</th>
                        <th width="300">Client Name</th>
                        <th width="100">Amount</th>
                    </tr>
                    <?php 
            
                    foreach ($dueCollection as $key => $value){
                        $field_amount = 0.00;
                        $where = array('voucher_no' => $value->voucher_no);
                        $due_amount = $this->action->read_sum('due_collect','paid',$where);
                        if($due_amount[0]->paid > 0 ){ 
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo ($value->voucher_no); ?></td>
                        <td><?php echo filter($value->party_code); ?></td>
                        <td><?php echo $due_amount[0]->paid; $due_Collection += $due_amount[0]->paid;?></td>
                    </tr>
                    
                    <?php } } ?>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><?php echo f_number($due_Collection); ?></th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            

            <?php /*if ($bankIncome != null) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <caption>
                        <h4 class="text-center">Bank Withdraw</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Bank</th>
                        <th>Account No.</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                    
                    foreach ($bankIncome as $key => $value){
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo filter($value->bank); ?></td>
                        <td><?php echo filter($value->account_number); ?></td>
                        <td><?php echo $value->amount; $bank_income += $value->amount ?></td>
                    </tr>
                    
                    <?php } ?>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><?php echo f_number($bank_income); ?></th>
                    </tr>
                </table>
            </div>
            <?php } */?>
        </div>
        
        <!--credit section end here-->


    <!--============================================================================-->    

        
        <!--Debit Section start here-->
        
        <div class="col-xs-6">
            
            <?php if ($purchase != NULL) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                   
                    <caption>
                        <h4 class="text-center">Cash to Supplier</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Voucher</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                    foreach ($purchase as $key => $value){ ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->voucher_no; ?></td>
                        <td><?php echo $value->paid; $total_purchase += $value->paid;?></td>
                    </tr>
                   
                    <?php } ?>

                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th> <?php echo f_number($total_purchase); ?> TK</th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            
            <?php if ($cashtoTT != null) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <caption>
                        <h4 class="text-center">Cash to T.T.</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Name</th>
                        <th>Amount</th>
                    </tr>
                    
                    <?php 
                    
                    foreach ($cashtoTT as $key => $value){
                        $totalCash = 0.00;
                        $where = array('code' => $value->party_code);
                        $partyInfo = $this->action->read('parties',$where);
                    ?>
                    
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo ($partyInfo) ? filter($partyInfo[0]->name) : '' ; ?></td>
                        <td><?php echo $value->debit; $totalCash += $value->debit;?></td>
                    </tr>
                    
                    <?php } ?>
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th><?php echo f_number($totalCash); ?></th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            
            
            <?php if ($allCost != null) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <caption>
                        <h4 class="text-center">General Cost</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Field</th>
                        <th>Amount</th>
                    </tr>
                    
                    <?php 
                    
                    foreach ($allCost as $key => $value){
                        
                        $field_amount = 0.00;
                        $where = array('cost_field' => $value->cost_field,'trash' => 0,'date'=>$value->date);
                        $field_amount = $this->action->read_sum('cost','amount',$where);
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo filter($value->cost_field); ?></td>
                        <td><?php echo $field_amount[0]->amount; $total_cost += $field_amount[0]->amount;?></td>
                    </tr>
                    
                    <?php } ?>
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th><?php echo f_number($total_cost); ?></th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            

            <?php if ($bankCost != null) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <caption>
                        <h4 class="text-center">Bank Deposit</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Bank</th>
                        <th>Account No.</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                    $bank_cost = 0.00;
                    foreach ($bankCost as $key => $value){
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo filter($value->bank); ?></td>
                        <td><?php echo filter($value->account_number); ?></td>
                        <td><?php echo $value->amount; $bank_cost += $value->amount ; ?></td>
                    </tr>
                    
                    <?php } ?>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><?php echo f_number($bank_cost); ?></th>
                    </tr>
                </table>
            </div>
            <?php } ?>

        </div>
        
        <!--Debit section end here-->


            
            <!-- Calculate Balance -->
            <?php
                $balance = $total_income = $totalCost = 0.00;

                $total_income = $total_sale + $bank_income + $other_income + $due_Collection;
                $totalCost = $total_purchase + $bank_cost + $total_cost + $totalCash;
                $balance = ($total_income - $totalCost);
                $balance_status = ($balance < 0 )? "red":"green";
            ?>

            <div class="col-md-12">
                <strong class="col-md-6 pull-left btn s_green" style="padding: 10px">Total Income : <?php echo $total_income; ?> TK </strong> 
                <strong class="col-md-6 pull-left btn s_red" style="padding: 10px">Total Cost : <?php echo $totalCost; ?> TK</strong>
            </div>
            <div class="col-sm-12" style="margin-top: -15px;">
                <div class="balance text-center">
                    <h4>Balance = <?php echo $total_income .' - '. $totalCost ; ?></h4>
                    <!-- <h4>Balance = ( Total Sale Income + Total Bank Income ) - ( Total Purchase Cost + Total Bank Cost + Total General Cost )</h4> -->
                    <h4 class="<?php echo $balance_status; ?>"><span>Balance : <?php echo $balance ?> TK</span></h4>
                </div>
            </div>

        </div>
    </div>

    <div class="panel-footer">&nbsp;</div>
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
</script>
