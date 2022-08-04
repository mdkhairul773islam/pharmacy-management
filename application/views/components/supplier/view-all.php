<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
	@media print{
		aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
		.panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
		.hide{display: block !important;}
		table tr th,table tr td{font-size: 12px;}
	}
	.md15 {
		padding: 0 15px !important;
	}
	.Receivable{
		color: green;
		font-weight: bold;
	}
	.Payable{
		color: red;
		font-weight: bold;
	}
</style>
<div class="container-fluid">
	<div class="row">
		<?php  echo $this->session->flashdata('confirmation'); ?>
		<div class="panel panel-default" id="data">
			<div class="panel-heading">
				<div class="panal-header-title">
					<h1 class="pull-left">View All Supplier</h1>
					<a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
			</div>
			<div class="panel-body">
			    <!--print header start-->
			    <?php $this->load->view('print');?>
			    <!--print header end-->
			    
				<h4 class="text-center hide" style="margin-top: 0px;">All Supplier</h4>
				<div class="row md15">
					<?php
					echo $this->session->flashdata('deleted');
					$attr = array("class" => "form-horizontal");
					echo form_open("", $attr);
					?>
					<div class="form-group none">
						<label class="col-md-2 control-label">Supplier Name </label>
						<div class="col-md-4">
							<select name="party_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
								<option value="" selected disabled>--Select---</option>
								<?php if($allParty != null){ foreach($allParty as $key => $row){ ?>
								<option value="<?php echo $row->code; ?>">
									<?php echo filter($row->name); ?>
								</option>
								<?php }} ?>
							</select>
						</div>
						
						<div class="col-md-4">
							<div class="btn-group">
								<input type="submit" name="show" value="Show" class="btn btn-primary">
							</div>
						</div>
					</div>
					
					<?php echo form_close(); ?>
				</div>
				
				<div class="row md15">
					<div class="table-responsive">
                		<p> <span style="color: green;font-weight: bold;">Green = Receivable</span>&nbsp;<span style="color: red;font-weight: bold;">Red = Payable</span></p>

						<table class="table table-bordered">
							<tr>
								<th style="width: 50px;">SL</th>
								<th>Date</th>
								<th>Name</th>
								<th>Contact Person</th>
								<th>Mobile</th>
								<th>Current Balance</th>
								<th>Type</th>
								<th class="none">Status</th>
								<th class="none" style="width: 170px;">Action</th>
							</tr>
							<?php foreach ($results as $key => $value) { ?>
							<tr>
								<td><?php echo $key+1; ?></td>
								<td><?php echo filter($value->opening); ?></td>
								<td><?php echo filter($value->name); ?></td>
								<td><?php echo filter($value->contact_person); ?></td>
								<td><?php echo $value->mobile; ?></td>
								<?php
									// Calculate Balance from partytrasaction table.
									// Final balance = total_debit - total_credit + initial_balance.
									// Final Balance (+ve) = Receivable and (-ve) = Payable
								$where = array(
									'party_code' => $value->code,
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
									$balance = $total_debit -  $total_credit + $total_remission + $value->initial_balance;
								}else{
									$balance = $value->initial_balance;
								}
								$balance_status = ($balance >= 0) ?  "Receivable" : "Payable";
								?>
								<th class="text-center <?php echo $balance_status; ?>"><?php echo number_format(abs($balance), 2); ?></th>
								<th class="<?php echo $balance_status; ?>" ><?php echo $balance_status; ?> </th>
								<td class="none"><?php echo filter($value->status); ?></td>
								
								
								<td  class="none">
									<a class="btn btn-info" title="Preview" href="<?php echo site_url('supplier/supplier/preview/'.$value->id);?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
									
									<a class="btn btn-warning" title="Edit" href="<?php echo site_url('supplier/supplier/edit/'.$value->id);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php if($privilege !='user'){ ?>
									<a onclick="return confirm('Do you want to delete this information?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('supplier/supplier/delete/'.$value->code); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								    <?php } ?>
								</td>
							</tr>
							<?php } ?>
							
						</table>
					</div>
				</div>
			</div>
			<div class="panel-footer">&nbsp;</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>