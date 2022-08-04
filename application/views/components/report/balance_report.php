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
            <h1 class="pull-left">Balance Sheet&nbsp;<small style="color:red"><?=($_POST ? ('('.$_POST['date']['from']).' to '.($_POST['date']['to']).')' : '')?></small></h1>
            <a href="#" class="pull-right " style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>    
    <div class="panel-body">
        <!--print header start-->                    		    
        <?php $this->load->view('print');?>                    		    
        <!--print header end-->

        <?php $total_cost = $total_bank_cost = $supplier_payment = $client_payment = $other_income = $total_sale = $total_purchase = $bank_income = $bank_cost = $due_Collection = $total_fixed_asset = $totalCash = 0.00; ?>
        <div class="row">
        <div class="col-xs-6">
            
            <?php if ($saleIncome != NULL) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                   
                    <caption>
                        <h4 class="text-center">Sales Paid</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Voucher</th>
                        <th>Client Name</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                    foreach ($saleIncome as $key => $value){
                        if($value->paid > 0){
                        // read client name from `parties` table
                        $where = array('code' => $value-> party_code);
                        $partyInfo = $this->action->read('parties',$where);
                    
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->voucher_no; ?></td>
                        <td><?php echo ($partyInfo)? filter($partyInfo[0]->name) : ''; ?></td>
                        <td><?php echo $value->paid; $total_sale += $value->paid;?></td>
                    </tr>
                   
                    <?php } } ?>

                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th> <?php echo f_number($total_sale); ?> TK</th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            <?php /* if ($fixed_assate != NULL) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                   
                    <caption>
                        <h4 class="text-center">Fixed Assat</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Date</th>
                        <th>Fixed assat</th>
                        <th>Amount</th>
                    </tr>
                    <?php foreach ($fixed_assate as $key => $value){ ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo $value->field_fixed_assate; ?></td>
                        <td><?php echo $value->amount; $total_fixed_asset += $value->amount ?></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th> <?php echo f_number($total_fixed_asset); ?> TK</th>
                    </tr>
                </table>
            </div>
            <?php } */ ?>
            
            
            
            <?php if ($clientPayment != NULL) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                   
                    <caption>
                        <h4 class="text-center">Party Collection</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Client Name</th>
                        <th>Amount</th>
                    </tr>
                    <?php
                    $credit = 0;
                    foreach ($clientPayment as $key => $value){
                        $credit = $value->credit - $value->remission;
                        if($credit > 0){
                        // read client name from `parties` table
                        $where = array('code' => $value-> party_code);
                        $partyInfo = $this->action->read('parties',$where);
                    
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo ($partyInfo)? filter($partyInfo[0]->name) : ''; ?></td>
                        <td><?php echo $credit; $client_payment += $credit;?></td>
                    </tr>
                   
                    <?php } } ?>

                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th> <?php echo f_number($client_payment); ?> TK</th>
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
                    <?php foreach ($otherIncome as $key => $value){ $other_income += $value->amount; ?>
                    <tr>
                        <td><?=(++$key)?></td>
                        <td><?php echo $value->field?></td>
                        <td><?php echo $value->amount?></td>
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
                        <h4 class="text-center">Purchase Paid</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Voucher</th>
                        <th>Name</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                    foreach ($purchase as $key => $value){
                        if($value->paid > 0){
                        // read supplier name from `parties` table
                        $where = array('code' => $value-> party_code);
                        $partyInfo = $this->action->read('parties',$where);
                    
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->voucher_no; ?></td>
                        <td><?php echo ($partyInfo)? $partyInfo[0]->name: ''; ?></td>
                        <td><?php echo $value->paid; $total_purchase += $value->paid;?></td>
                    </tr>
                   
                    <?php } } ?>

                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th> <?php echo f_number($total_purchase); ?> TK</th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            
            
            <?php if ($supplierPayment != NULL) { ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                   
                    <caption>
                        <h4 class="text-center">Supplier Payment</h4>
                    </caption>
                    <tr>
                        <th width="50">SL</th>
                        <th>Name</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                    foreach ($supplierPayment as $key => $value){
                        if($value->debit > 0){
                        // read supplier name from `parties` table
                        $where = array('code' => $value-> party_code);
                        $partyInfo = $this->action->read('parties',$where);
                    
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo ($partyInfo)? $partyInfo[0]->name: ''; ?></td>
                        <td><?php echo $value->debit; $supplier_payment += $value->debit;?></td>
                    </tr>
                   
                    <?php } } ?>

                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th> <?php echo f_number($supplier_payment); ?> TK</th>
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
                        if($value->debit > 0){
                        $totalCash = 0.00;
                        $where = array('code' => $value->party_code);
                        $partyInfo = $this->action->read('parties',$where);
                    ?>
                    
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo ($partyInfo) ? filter($partyInfo[0]->name) : '' ; ?></td>
                        <td><?php echo $value->debit; $totalCash += $value->debit;?></td>
                    </tr>
                    
                    <?php } } ?>
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
                        if($field_amount[0]->amount > 0){
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo filter($value->cost_field); ?></td>
                        <td><?php echo $field_amount[0]->amount; $total_cost += $field_amount[0]->amount;?></td>
                    </tr>
                    
                    <?php } } ?>
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th><?php echo f_number($total_cost); ?></th>
                    </tr>
                </table>
            </div>
            <?php } ?>
            
            

            
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
                    
                    <?php 
                    $bank_cost_tt = 0.00;
                    foreach ($bankCostCashTT as $key => $value){
                    ?>
                        
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo filter($value->bank); ?></td>
                        <td><?php echo filter($value->account_number); ?></td>
                        <td><?php echo $value->amount; $bank_cost_tt += $value->amount ; ?></td>
                    </tr>
                    
                    <?php } ?>
                    
                    
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><?php echo $total_bank_cost = $bank_cost+$bank_cost_tt; ?></th>
                    </tr>
                </table>
            </div>
            

        </div>
        
        <!--Debit section end here-->
            <?php
                
                $is_closing = false;
                if(!$_POST || (isset($_POST['date']['from']) && ($_POST['date']['from']==$_POST['date']['to']))){
                    $is_closing = true;
                    // read previous closing balance
                    $presentDate = isset($_POST['date']['from'])? $_POST['date']['from'] : date('Y-m-d');
                    $previousDate = date('Y-m-d', strtotime("-1 day", strtotime($presentDate)));
                    
                    $closingInfo = $this->action->read('closing_balance', array('date' => $previousDate));
                    $closing_amount = ($closingInfo) ? $closingInfo[0]->closing_balance : 0.0;
                }
                
                
                
            ?>

            
            <!-- Calculate Balance -->
            <?php
                $balance = $total_income = $totalCost = 0.00;

                $total_income = $total_sale + $bank_income + $other_income + $due_Collection + $client_payment + $total_fixed_asset;
                $totalCost = $total_purchase + $total_bank_cost + $total_cost + $totalCash + $supplier_payment;
                if($is_closing)
                $balance = ($total_income - $totalCost) + $closing_amount;
                else
                $balance = ($total_income - $totalCost);
                $balance_status = ($balance < 0 )? "red":"green";
            ?>

            <div class="col-md-12">
                <strong class="col-md-6 pull-left btn s_green" style="padding: 10px">Total Income : <?php echo $total_income; ?> TK </strong> 
                <strong class="col-md-6 pull-left btn s_red" style="padding: 10px">Total Cost : <?php echo $totalCost; ?> TK</strong>
            </div>
            <div class="col-sm-12" style="margin-top: -15px;">
                <div class="balance text-center">
                    <?php if($is_closing){ ?>
                        <h4>Initial Balance = <?php echo $closing_amount; ?></h4>
                        <h4>With Initial Balance = <?php echo $total_income .' - '. $totalCost ; ?></h4>
                    <?php } else{ ?>
                        <h4>Balance = <?php echo $total_income .' - '. $totalCost ; ?></h4>
                    <?php } ?>
                    <!-- <h4>Balance = ( Total Sale Income + Total Bank Income ) - ( Total Purchase Cost + Total Bank Cost + Total General Cost )</h4> -->
                    <h4 class="<?php echo $balance_status; ?>"><span>Balance : <?php echo $balance ?> TK</span></h4>
                </div>
            </div>
            
            <div class="col-sm-11">
                <?php 
                    if($is_closing){
                    echo form_open();
                    $date = isset($_POST['date'])? $_POST['date']['to'] :date('Y-m-d');
                ?>
                    <input type="hidden" name="closing_balance" value="<?php echo $balance; ?>" class="form-control">
                    <input type="hidden" name="opening_balance" value="<?php echo $closing_amount; ?>" class="form-control">
                    <input type="hidden" name="date" value="<?php echo $date; ?>" class="form-control">
                    
                    <div class="col-md-1 pull-right">
                        <input type="submit" class="btn btn-info" name="close_balance" value="Close Balance" >
                    </div>
                <?php echo form_close();}?>
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
