<style>
    @media print{
    aside{display: none !important;}
    nav{display: none;}
    .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
    .none{display: none;}
    .panel-heading{display: none;}
    .panel-footer{display: none;}
    .panel .hide{display: block !important;}
    .title{font-size: 25px;}
    table tr th,table tr td{font-size: 12px;}
    }
    .table tr th {width: 22%;}
</style>
<div class="container-fluid" >
  <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panal-header-title">
          <h1 class="pull-left">Profile</h1>
          <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
      <div class="panel-body" ng-cloak>
        <!--print header start-->
	    <?php $this->load->view('print');?>
	    <!--print header end-->
			    
        <h4 class="text-center hide" style="margin-top: 0px;">Profile</h4>
        <div class="text-right">
            <img style="width: 110px; margin-bottom: 10px;" src="<?php echo site_url($partyInfo[0]->path); ?>" />
        </div>
        <table class="table table-bordered table-hover">
          <tr>
            <th>Client Name</th>
            <td><?php echo filter($partyInfo[0]->name); ?></td>
            <th>Opening Date</th>
            <td><?php echo $partyInfo[0]->opening; ?></td>
          </tr>
          <tr>
            <th>Contact Person</th>
            <td><?php echo filter($partyInfo[0]->contact_person); ?></td>
            <th>Mobile Number</th>
            <td><?php echo $partyInfo[0]->mobile; ?></td>
          </tr>
          <tr>
            <th>Initial Balance </th>
            <td>
              <?php
              $init_balance = $partyInfo[0]->initial_balance;
              $status = ($init_balance < 0) ? " Payable" : " Receivable";
              echo abs($init_balance) . ' TK &nbsp; [' . $status . '&nbsp;]';
              ?>
            </td>
            <th>Address</th>
            <td><?php echo filter($partyInfo[0]->address); ?></td>
          </tr>
          <tr>
            <th>Credit Limit </th>
            <td><?php echo $partyInfo[0]->credit_limit;?> TK</td>
            <th>Current Balance </th>
            <td>
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
              ?>
            </td>
          </tr>
          <tr>
            <th>Status</th>
            <td colspan="3"><?php echo filter($partyInfo[0]->status);?></td>
          </tr>
        </table>
      </div>
      <div class="panel-footer">&nbsp;</div>
    </div>
  </div>
</div>