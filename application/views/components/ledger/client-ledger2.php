<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
@media print{
    aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
    .panel{border: 1px solid transparent; left: 0px; position: absolute; top: 0px; width: 100%;}
    .hide{display: block !important;}

}
.table tr th, .table tr td{font-size: 13px; padding: 4px !important;}
.table tr td p {margin: 0;padding: 0;}
</style>

<div class="container-fluid" ng-controller="clientLedgerCtrl">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Party Ledger</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>
                
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label"> Party Name </label> -->
                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>-- Select Party Name --</option>
                            <?php
                            if ($info != null) {
                                foreach ($info as $row) {
                            ?>
                            <option value="<?php echo $row->code; ?>">	<?php echo filter($row->name)." [ ".$row->address." ]"; ?></option>
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
        <!-- Get data before submit result start here -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                 <!-- <img class="img-responsive print-banner hide" src="<?php //echo site_url($banner_info[0]->path); ?>">  -->
                 <!-- Banner Start Here -->
                <?php
                    $footer_info=json_decode($meta->footer,true);
                    $header_info=json_decode($meta->header,true);
                ?>
                <style>
                    .hide h2{
                            padding-left: 40px;
                    }
                    .hide h4{
                        padding: 3px 0;
                        padding-left: 40px;
                    }
                </style>
                <div class="row hide">
                    <div class="view-profile col-md-12 row">
                        <div class="col-sm-4 col-xs-4 col-sm-offset-1 col-xs-offset-1">
                            <img width="200" style="margin-top: 20px" src="<?php echo site_url($footer_info['footer_img']); ?>">
                        </div>
                        <div class="col-sm-7 col-xs-7">
                            <h2 class="text-left title" style="margin-top: 10px; font-weight: bold;">
                                <?php echo $header_info['site_name']; ?>
                            </h2>
                            
                            <h4 class="text-left" style="margin: 0;">
                                <?php echo $footer_info['addr_address']; ?>
                            </h4>
                            
                            <h4 class="text-left" style="margin: 0;">
                                Mobile: <?php echo $footer_info['addr_moblile']; ?>
                            </h4>
                            
                            <h4 class="text-left" style="margin: 0;">
                                Email: <?php echo $footer_info['addr_email']; ?>
                            </h4>
                        </div>                          
                    </div><hr>
                </div>
                <!-- Banner End Here -->

                <h4 class="text-center hide" style="margin-top: 0px;">Party Ledger</h4>

                <hr>
                <address class="text-center hide" style="font-size: 16px; font-weight: bold; margin-bottom: 15px;">
                    Milon Electronics <br>
                    Rupkotha Road, Sherpur - 2100<br>
                    Phone: 0931 61928<br>
                    Mobile: 01712 009954 | 01919 009954
                    <hr style="margin: 5px 0; border-top: 2px solid #ddd;">
                </address>

                <table class="table table-bordered">
                    <tr>
                        <th>Party ID</th>
                        <th width="200">Party Name</th>
                        <th>Address</th>
                        <th>Initial Balance</th>
                        <th>Credit Limit</th>
                        <th>Credit</th>
                        <th>Debit </th>
                        <th>Balance</th>
                        <th>Status</th>
                    </tr>

                      <?php
                      $totalDebit = $totalCredit = $total = $totalQuantity = $grandTotal = 0.00;
                      
                      foreach ($defaultData as $key => $row) {
                      ?>
                      <tr>
                          <td><?php echo $row['code']; ?></td>
                          <td><?php echo filter($row['name']); ?></td>
                          <td><?php echo filter($row['address']); ?></td>
                          <td><?php echo abs($row['init'])." [ ".$row['init_status']." ]"; ?></td>
                          <td><?php echo $row['credit_limit']; ?></td>
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
                          <th colspan="5" class="text-right">Total</th>
                          <th><strong><?php echo f_number($totalCredit); ?></strong></th>
                          <th><strong><?php echo f_number($totalDebit); ?></strong></th>
                          <th><strong><?php echo abs($grandTotal); ?></strong></th>
                          <th class="text-center"><strong><?php  echo ($grandTotal >= 0) ? "Receivable" : "Payable"; ?></strong></th>
                      </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
      <?php } } else { ?>


        <!--Get data before submit result End here-->
        <?php if ($resultset != NULL) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- print banner -->
                <!-- <img class="img-responsive print-banner hide" src="<?php// echo site_url($banner_info[0]->path); ?>"> --> 
                <!-- Banner Start Here -->
                <?php
                    $footer_info=json_decode($meta->footer,true);
                    $header_info=json_decode($meta->header,true);
                ?>
                <style>
                    .hide h2{
                            padding-left: 40px;
                    }
                    .hide h4{
                        padding: 3px 0;
                        padding-left: 40px;
                    }
                </style>
                <div class="row hide">
                    <div class="view-profile col-md-12 row">
                        <div class="col-sm-4 col-xs-4 col-sm-offset-1 col-xs-offset-1">
                            <img width="200" style="margin-top: 20px" src="<?php echo site_url($footer_info['footer_img']); ?>">
                        </div>
                        <div class="col-sm-7 col-xs-7">
                            <h2 class="text-left title" style="margin-top: 10px; font-weight: bold;">
                                <?php echo $header_info['site_name']; ?>
                            </h2>
                            
                            <h4 class="text-left" style="margin: 0;">
                                <?php echo $footer_info['addr_address']; ?>
                            </h4>
                            
                            <h4 class="text-left" style="margin: 0;">
                                Mobile: <?php echo $footer_info['addr_moblile']; ?>
                            </h4>
                            
                            <h4 class="text-left" style="margin: 0;">
                                Email: <?php echo $footer_info['addr_email']; ?>
                            </h4>
                        </div>                          
                    </div><hr>
                </div>
                <!-- Banner End Here -->
                <h4 class="text-center hide" style="margin-top: 0px;">Party Ledger</h4>

                <hr>
                <address class="text-center hide" style="font-size: 16px; font-weight: bold; margin-bottom: 15px;">
                    Milon Electronics <br>
                    Rupkotha Road, Sherpur - 2100<br>
                    Phone: 0931 61928<br>
                    Mobile: 01712 009954 | 01919 009954
                    <hr style="margin: 5px 0; border-top: 2px solid #ddd;">
                </address>

                <div class="row">
                    <div class="col-xs-5">
                        <!--pre><?php //print_r($partyInfo); ?></pre-->

                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Party ID:</th>
                                <td><?php echo $partyInfo[0]->code; ?></td>
                            </tr>

                            <tr>
                                <th>Party Name :</th>
                                <td><?php echo filter($partyInfo[0]->name); ?></td>
                            </tr>

                            <tr>
                                <th>Address:</th>
                                <td><?php echo $partyInfo[0]->address; ?></td>
                            </tr>
                            <tr>
                            	<th>Mobile: </th>
                            	<td><?php echo $partyInfo[0]->mobile; ?></td>
                            </tr>

                            <tr>
                                <th>Opening Balance :</th>
                                <td>
                                    <strong>
                                    <?php
                                // After Submit Date Start here
                                    if($fromDate != NULL || $toDate != NULL){
                                        $prevInfo = getPreviousInfo($fromDate,$partyCode,$partyBrand);
                                        $opening_balance = getPartyMeta($partyInfo[0]->code, 'opening_balance');
                                        //echo "<pre>";echo $fromDate;print_r($prevInfo);echo "</pre>";

                                        if(count($prevInfo)){
                                            $opening_balance+=$prevInfo[0]->previous_balance;
                                        }

                                        $status = ($opening_balance < 0) ? "Payable" : "Receivable";
                                        echo abs($opening_balance). "/- ".$status;
                                    }else{
                                       $openingBalance = getPartyMeta($partyInfo[0]->code, 'opening_balance');
                                       $status = ($openingBalance >= 0)? "Receivable" : "Payable";
                                       echo abs($openingBalance)."/-".$status;
                                    }
                                    ?>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                    

                    <div class="col-xs-offset-2 col-xs-5">
                        <table class="table table-bordered">
                            <tr>
                                <th width="50%">From Date :</th>
                                <td><?php echo $fromDate; ?> </td>
                            </tr>

                            <tr>
                                <th>From To :</th>
                                <td><?php echo $toDate; ?> </td>
                            </tr>

                            <tr>
                                <th>Current Balance :</th>
                                <td>
					    <strong>
		                            <?php
		                            // echo "<pre>"; print_r($partyBalance); echo "</pre>";

		                            $totalBalance = 0.00;
		                            foreach($partyBalance as $key => $row) {
		                            	$totalBalance += $row->balance;
		                            }

		                            $status = ($totalBalance < 0) ? "Payable" : "Receivable";
		                            echo abs($totalBalance) . "/- " . $status;

		                            // $status = ($partyBalance[0]->balance > 0) ? "Payable" : "Receivable";
		                            // echo abs($partyBalance[0]->balance) . "/- " . $status;
		                            ?>
                                        
                        </strong>
				</td>
                            </tr>

                            <tr>
                                <th>Commission :</th>
                                <td><strong><?php echo $totalCommissionAmoint; ?>/-</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30px;">SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <!--th>Details</th-->
                        <!--th>Trans. Det.</th-->
                        <th>Quantity (Kg)</th>
                        <th>Com. Det. (Tk)</th>                        
                        <th>Debit (Tk)</th>
                        <th>Credit (Tk)</th>
                        <th>Balance (Tk)</th>
                        <!--th>Status</th-->
                        <th class="none" style="width: 55px;">Action</th>
                    </tr>



                    <!-- initial balance row start here -->
                    <tr>
                    	<td>1</td>
                    	<td colspan="6">Previous Balance</td>
                    	<td>
                    	<?php
                    	if($brandExists == "yes") {
                    		echo f_number(abs($resultset[0]->previous_balance));
                    	} else {
                    		$totalInitialBalance = 0.00;

		        	foreach($partyBalance as $key => $row) {
		        		$totalInitialBalance += $row->initial_balance;
		        	}

                    		echo f_number(abs($totalInitialBalance));
                    	}
                    	?>
                    	</td>

                    	<!--td>
                    	<?php
                    	if($brandExists == "yes") {
                    		echo ($resultset[0]->previous_balance < 0) ? "Payable" : "Receivable";
                    	} else {
                    		echo ($totalInitialBalance < 0) ? "Payable" : "Receivable";
                    	}
                    	?>
                    	</td-->
                    	<td class="none"> </td>
                    	
                    	
                    </tr>
                    <!-- initial balance row start here -->








		  <?php
		  $totalDebit = $total = $totalCommission = $TotalQuantity  = 0.00;
		  foreach ($resultset as $key => $row) {
		  	if($row->status == "zb") {
		  		if($brandExists == "no") {

		$total += $row->paid;

			// work with sale section
			$relationList = array();
			$debit = "-";

			if($row->remark == 'sale') {
				$relationList = explode(':', $row->relation);
				$where = array('voucher_no' => $relationList[1]);

				$saleInfo = $this->action->read('saprecords', $where);
				$debit = ($saleInfo) ? $saleInfo[0]->total_bill : 0.00;
			    	$totalDebit += $debit;
			}
		    ?>
                    <tr>
                        <td><?php echo ($key + 2); ?></td>
                        <td><?php echo $row->transaction_at; ?></td>
                        <td><?php echo $vno = ($row->remark == 'sale') ? $relationList[1] : ''; ?></td>


			<td>
			<?php
			if($row->remark == 'sale') {
				$where = array('voucher_no' => $relationList[1]);
				$items = $this->action->read('sapitems', $where);
				$records = $this->action->read('saprecords', $where);

				if($records != NULL){
					if($records[0]->sap_type == 'do') {
						echo 'DO No ' . $records[0]->voucher_no;
					} elseif($records[0]->sap_type == 'retail') {
						echo 'Retail ' . $records[0]->voucher_no;
					} else {
						echo '';
					}
				}

 				$totalCommission = 0.00;
				/* foreach ($items as $item) {
					$totalCom = $item->sale_price * $item->quantity;
					// echo "<p>" . $item->quantity . " " . $item->unit . "@" . $item->sale_price . "=" . $totalCom . "/-</p>";
					
					 $totalCommission += $totalCom ;
				}*/
				
				foreach ($records as $re) {
					
					 $totalCommission += $re->total_discount ;
				}
				
				echo $totalCommission;

				// echo ($records) ?  'Paid = ' . $records[0]->paid . '/-' : 'Paid = ' ."0.00" . '/-';
			} else {
				echo 'Cash Payment';
			}
			?>
			</td>

			<td>
			<?php
			if($row->remark == 'sale') {
				//echo "<strong>Truck  No " . metadata('sapmeta', array('voucher_no' => $vno, 'meta_key' => 'truck_no')) . "</strong>";
				$trackAmount = metadata('sapmeta', array('voucher_no' => $relationList[1], 'meta_key' => 'truck_fare'));

				/* $where = array('voucher_no' => $relationList[1]);
				$items = $this->action->read('sapitems', $where);
 				
 				$grandTotalTrackRant = 0.00;
				foreach ($items as $item) {
					$totalTrackRant = $trackAmount * $item->quantity;
					$totalCom = $item->sale_price * $item->quantity;
					
					$grandTotalTrackRant += $totalTrackRant;

					// "<p>Trk. Fr = " . $item->quantity . " " . $item->unit . "@" . $trackAmount . "/- =" . $totalTrackRant . "/-</p>";
					//echo "<strong>(" . $totalCom . " - " . $totalTrackRant . " = " . ($totalCom - $totalTrackRant) . "/-)</strong>";
					
					
				}*/
				
				echo $trackAmount;
			}
			?>
			</td>

            		<!--td>
    			<?php
    			// commisssion data
    			if($row->remark == 'sale') {
    				$amount = metadata('sapmeta', array('voucher_no' => $vno, 'meta_key' => 'commission_amount'));
    				$comm = ($amount != null) ? $amount : 0.00;

    				$where = array('voucher_no' => $relationList[1]);
    				$items = $this->action->read('sapitems', $where);
    				
    				$records = $this->action->read('saprecords', $where);

    				/*foreach ($items as $item) {
    					$totalCom = $comm * $item->quantity;
    					$totalCommission += $totalCom;
    					// echo "<p>" . $item->quantity . " " . $item->unit . "@" . $comm . "/- = " . $totalCom . "/-</p>";
    				}*/
    				
    				
    				
    				
    				$totalCommission = 0.00;
				/* foreach ($items as $item) {
					$totalCom = $item->sale_price * $item->quantity;
					// echo "<p>" . $item->quantity . " " . $item->unit . "@" . $item->sale_price . "=" . $totalCom . "/-</p>";
					
					 $totalCommission += $totalCom ;
				}*/
				
				foreach ($records as $re) {
					
					 $totalCommission += $re->total_discount ;
				}
				
				echo $totalCommission;
				
    			}
    			?>
			</td-->
			
			
			
			<td>
				<?php
			      	//Quantity
			      	if($row->remark == 'sale') {
				$where = array('voucher_no' => $relationList[1]);
				$records = $this->action->read('saprecords', $where);
				
				echo $records[0]->total_quantity;
				
				$TotalQuantity += $records[0]->total_quantity;
				
				}
			      
			      ?>
			</td>

			<td><?php echo $debit; ?></td>
			<td><?php echo $row->paid; ?></td>
            		<td><?php echo f_number(abs($row->current_balance)); ?></td>
            		<td class="none">
	                    	<?php if($row->remark == 'sale') { ?>
	                    	<a class="btn btn-info" title="Preview" target="_blank" href="<?php echo site_url('sale/viewSale?vno=' . $relationList[1]); ?>"> <i class="fa fa-eye" aria-hidden="true"> </i> </a> 
	                    	<?php }else{ ?>
		                 	&nbsp;
		                 <?php } ?>
	                 </td>
            <!--td><?php echo ($row->current_balance >=0)? "Receivable" : "Payable"; ?></td-->
         </tr>
		 <?php } } else {
		    $total += $row->paid;

			// work with sale section
			$relationList = array();
			$debit = "-";

			if($row->remark == 'sale') {
				$relationList = explode(':', $row->relation);
				$where = array('voucher_no' => $relationList[1]);

				$saleInfo = $this->action->read('saprecords', $where);
				$debit = ($saleInfo) ? $saleInfo[0]->total_bill : 0.00;
			    $totalDebit += $debit;
			} ?>

            <tr>
                <td><?php echo ($key + 2); ?></td>
                <td><?php echo $row->transaction_at; ?></td>
                <td><?php echo $vno = ($row->remark == 'sale') ? $relationList[1] : ''; ?></td>


		    	<!--td>
            			<?php
            			if($row->remark == 'sale') {
            				$where = array('voucher_no' => $relationList[1]);
            				$items = $this->action->read('sapitems', $where);
            				$records = $this->action->read('saprecords', $where);

            				if($records != NULL){
            					if($records[0]->sap_type == 'do') {
            						echo 'DO No ' . $records[0]->voucher_no;
            					} elseif($records[0]->sap_type == 'retail') {
            						echo 'Retail ' . $records[0]->voucher_no;
            					} else {
            						echo '';
            					}
            				}

            				foreach ($items as $item) {
            					$totalCom = $item->sale_price * $item->quantity;
            					echo "<p>" . $item->quantity . " " . $item->unit . "@" . $item->sale_price . "=" . $totalCom . "/-</p>";
            				}

            				echo ($records) ?  'Paid = ' . $records[0]->paid . '/-' : 'Paid = ' ."0.00" . '/-';
            			} else {
            				echo 'Cash Payment';
            			}
            			?>
			     </td-->

			     <!--td>
        			<?php
        			if($row->remark == 'sale') {        			
        			
        				//echo "<strong>Truck  No " . metadata('sapmeta', array('voucher_no' => $vno, 'meta_key' => 'truck_no')) . "</strong>";
        				$trackAmount = metadata('sapmeta', array('voucher_no' => $relationList[1], 'meta_key' => 'truck_fare'));

        				/*$where = array('voucher_no' => $relationList[1]);
        				$items = $this->action->read('sapitems', $where);
	                                
	                                $grandTotalTrackRant = 0.00;
        				foreach ($items as $item) {
        					$totalTrackRant = $trackAmount * $item->quantity;
        				        $totalCom = $item->sale_price * $item->quantity;
        					
        					$grandTotalTrackRant += $totalTrackRant;

        					// echo "<p>Trk. Fr = " . $item->quantity . " " . $item->unit . "@" . $trackAmount . "/- =" . $totalTrackRant . "/-</p>";
        					//echo "<strong>(" . $totalCom . " - " . $totalTrackRant . " = " . ($totalCom - $totalTrackRant) . "/-)</strong>";
        					
        					
        				}*/
        				
        				
        				echo $trackAmount;
        			}
        			?>
			      </td-->
			      
			      
			      
			      
			      <td>
			      
			      <?php
			      	//Quantity
			      	if($row->remark == 'sale') {
				$where = array('voucher_no' => $relationList[1]);
				$records = $this->action->read('saprecords', $where);
				
				echo $records[0]->total_quantity;
				
				$TotalQuantity += $records[0]->total_quantity;
				
				}
			      
			      ?>
			      </td>
			      
			      

                  <td>
            			<?php
            			// commisssion data
            			if($row->remark == 'sale') {
            				$amount = metadata('sapmeta', array('voucher_no' => $vno, 'meta_key' => 'commission_amount'));
            				$comm = ($amount != null) ? $amount : 0.00;

            				$where = array('voucher_no' => $relationList[1]);
            				$items = $this->action->read('sapitems', $where);
            				
            				$records = $this->action->read('saprecords', $where);

            				/* foreach ($items as $item) {
            					$totalCom = $comm * $item->quantity;
            					$totalCommission += $totalCom;
            					//echo "<p>" . $item->quantity . " " . $item->unit . "@" . $comm . "/- = " . $totalCom . "/-</p>";
            					
            					
            				}
            				
            				echo $totalCommission;*/
            				
            				$totalCommission = 0.00;
					/* foreach ($items as $item) {
						$totalCom = $item->sale_price * $item->quantity;
						// echo "<p>" . $item->quantity . " " . $item->unit . "@" . $item->sale_price . "=" . $totalCom . "/-</p>";
						
						 $totalCommission += $totalCom ;
					}*/
					
					foreach ($records as $re) {
						
						 $totalCommission += $re->total_discount ;
					}
				
				   echo $totalCommission;
            			  }
            			?>
			        </td>

    		    <td><?php echo $debit; ?></td>
    		    <td><?php echo $row->paid; ?></td>
                    <td><?php echo f_number(abs($row->current_balance)); ?></td>
                    <td class="none">
	                    <?php if($row->remark == 'sale') { ?>
	                    	<a class="btn btn-info" title="Preview" target="_blank" href="<?php echo site_url('sale/viewSale?vno=' . $relationList[1]); ?>"> <i class="fa fa-eye" aria-hidden="true"> </i> </a> 
	                    <?php }else{ ?>
		                       &nbsp;
		             <?php } ?>
		     </td>
                    
                    <!--td><?php echo ($row->current_balance >=0) ? "Receivable" : "Payable"; ?></td-->
                  </tr>
		        <?php }} ?>


                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><strong><?php echo f_number($TotalQuantity ); ?></strong></th>
                        <th><strong><?php echo f_number($totalCommission); ?></strong></th>
                        <th><strong><?php echo f_number($totalDebit); ?></strong></th>
                        <th><strong><?php echo f_number($total); ?></strong></th>

                        <th>
                        	<strong>
                            	<?php
                                	$totalPartyBalance = 0.00;
                                	foreach($partyBalance as $key => $val) {
                                		$totalPartyBalance += $val->balance;
                                		
                                	}
                                	$status = ($totalPartyBalance >= 0) ? "Receivable" : "Payable";
                                	echo f_number(abs($totalPartyBalance))." [ ".$status." ] ";
                            	?>
                        	</strong>
                        </th>
                        <th class="none"></th>

                        <!--th><?php echo ($totalPartyBalance >= 0) ? "Receivable" : "Payable"; ?>
                        </th-->
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php }} ?>
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
