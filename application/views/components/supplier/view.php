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
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered,
        .print-font {font-size: 16px;}
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <?php 
                $where     = array ('code'=> $records[0]->party_code);
                $partyInfo = $this->action->read('parties', $where);
            ?>
            <div class="panel-body">
                <!--print header start-->
			    <?php $this->load->view('print');?>
			    <!--print header end-->

                <div class="row">
                	<div class="col-xs-8 print-font">
                		<label style="margin-bottom: 10px;">
                            Voucher No : <?php echo $party_code . $partyInfo[0]->id; ?>
                            
                        </label> <br>

                        <label style="margin-bottom: 10px;">
                           Supplier Name: <?php  echo $partyInfo[0]->name; ?>
                        </label>
                     </div>

                	<div class="col-xs-4 print-font">
                		<label>Date : <?php echo $records[0]->transaction_at; ?></label> <br>
                		<label>Print Time : <?php echo date("h:i:s A"); ?></label>
                    </div>
                </div>


                <?php
                    // Calculate Balance from partytrasaction table.
                    // Final balance = total_debit - total_credit + initial_balance.
                    // Final Balance (+ve) = Receivable and (-ve) = Payable
                    $where = array(
                        'party_code' => $records[0]->party_code,
                        'trash' => 0
                    );
                    $transactionRec = $this->retrieve->read('partytransaction',$where);
                    $total_credit = $total_debit = $total_remission = 0.0;
                    if ($transactionRec != null) {
                        foreach ($transactionRec as $key => $row) {
                            $total_credit += $row->credit;
                            $total_debit += $row->debit;
                            $total_remission += $row->remission;
                        }
                        $balance = $total_debit -  $total_credit + $total_remission + $partyInfo[0]->initial_balance;
                    }else{
                        $balance = $partyInfo[0]->initial_balance;
                    }
                    $balance_status = ($balance >= 0) ?  "Receivable" : "Payable";
                ?>



                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">Paid</th>
                        <th class="text-center">Remission</th>
                        <th class="text-center">Transaction Type</th>
                        <th class="text-center"> <?php if($balance > 0){echo'Total Balance(Tk)';}else{echo'Total Due';} ?>  </th>
                        <th width="100">Paid By</th>
                    </tr>
                    <tr>
                        <td class="text-center"><?php echo $records[0]->debit; ?></td>
                        <td class="text-center"><?php echo $records[0]->remission; ?></td>
                        <td class="text-center"><?php echo ucfirst($records[0]->transaction_via); ?></td>
                        <td class="text-center"><?php echo abs($balance)." [ ".$balance_status." ]"; ?></td>
                        <td><?php echo ucfirst($records[0]->comment); ?></td>
                    </tr>

                    <tr>
                        <td rowspan="7" colspan="4">In Word : <strong id="inword"></strong> Taka Only.</td>
                    </tr>              
                </table>

                <div class="pull-right hide">
                    <h4 style="margin-top: 50px;" class="text-center print-font">
                    -------------------------------- <br>
                    Signature of authority
                    </h4>
                </div>
              </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#inword").html(inWorden(<?php echo $records[0]->debit; ?>));
    });
</script>
