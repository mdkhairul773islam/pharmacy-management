        <style>
           .header {
           padding: 0 15px;
           }
           .hr {
           margin: 10px -15px;
           border: 0.5px solid rgba(0, 168, 255, 1);
           }
           .md15 {margin: 0;}
        </style>
        <div class="container-fluid">
           <div class="row">
              <?php echo $this->session->flashdata('error'); ?>
              <div class="panel panel-default">
                 <div class="panel-heading">
                    <h2 class="dashboard-title text-center" >Welcome To Dashboard...</h2>
                 </div>
                 <div class="panel-body">
                    <!-- Today's Purchase Details -->
                    <div class="row">
                        <?php if(ck_action("dashboard","today_purchase")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-2">
        	                  <span>Today's Purchase</span>
        	                  <h1><?php if($total_purchase[0]->total_bill !==null ){echo $total_purchase[0]->total_bill;}else{ echo "0"; } ?></h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","tody_due")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-3">
        	                  <span>Today's Due</span>
        	                  <h1><?php echo $todays_due; ?> </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","tody_paid")){ ?>
            	        <div class="col-md-3">
        	               <div class="dash-box dash-box-4">
        	                  <span>Today's Total Paid</span>
        	                  <h1><?php echo $total_paid; ?></h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","tt")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-3">
        	                  <span>Bank To TT</span>
        	                  <h1><?php if($bankToTT[0]->amount !== null){ echo $bankToTT[0]->amount;}else{echo "0";} ?>  </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
                        <?php if(ck_action("dashboard","supplier_paid")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-4">
        	                  <span>Supplier Paid</span>
        	                  <h1><?php if($supplier_paid[0]->debit !== null){ echo $supplier_paid[0]->debit;}else{echo "0";} ?> </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","bank_withdraw")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-6">
        	                  <span>Bank Withdraw</span>
        	                  <h1><?php if($bank_withdraw[0]->amount !== null){ echo $bank_withdraw[0]->amount;}else{echo "0";} ?> </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","ClientCollection")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-7">
        	                  <span>Client Collection</span>
        	                  <h1><?php if($client_collection[0]->credit !== null){ echo $client_collection[0]->credit;}else{echo "0";} ?> </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","bank_deposit")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-5">
        	                  <span>Bank Deposit</span>
        	                  <h1><?php if($bank_diposit[0]->amount !== null){echo $bank_diposit[0]->amount;}else{ echo "0";}?> </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","cash_tt")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-8">
        	                  <span>Cash To T.T</span>
        	                  <h1><?php if($cashToTT[0]->debit !== null){echo $cashToTT[0]->debit;}else{ echo "0";}?> </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","today_cost")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-12">
        	                  <span>Adaar Cost</span>
        	                  <h1><?php if($total_cost[0]->amount !== null){ echo $total_cost[0]->amount;}else{echo "0";} ?> </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
                        <?php if(ck_action("dashboard","today_income")){ ?>
            	        <div class="col-md-3">
        	               <div class="dash-box dash-box-9">
        	                  <span>Today's Income</span>
        	                  <h1><?php if($total_income[0]->amount == null && $total_rent[0]->amount == null){ echo "0";}else{ echo $total_income[0]->amount + $total_rent[0]->amount;} ?> </h1>
        	               </div>
        	            </div>
            	       <?php } ?>
            	       
            	       
            	       <?php if(ck_action("dashboard","customar")){ ?>
            	       <div class="col-md-3">
        	               <div class="dash-box dash-box-2">
        	                  <span>Customar</span>
        	                  <h1><?php if($totalClient !==null ){echo $totalClient;}else{ echo "0"; } ?></h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","manufacturer")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-1">
        	                  <span>Manufacturer</span>
        	                  <h1><?php if($totalManufacturer !==null ){echo $totalManufacturer;}else{ echo "0"; } ?></h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","product")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-3">
        	                  <span>Product</span>
        	                  <h1><?php if($totalProduct !== null){ echo $totalProduct;}else{echo "0";} ?> </h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <?php if(ck_action("dashboard","invoice")){ ?>
        	            <div class="col-md-3">
        	               <div class="dash-box dash-box-4">
        	                  <span>Invoice</span>
        	                  <h1><?php if($totalInvoice !==null ){echo $totalInvoice;}else{ echo "0"; } ?></h1>
        	               </div>
        	            </div>
        	            <?php } ?>
        	            
        	            <div class="col-md-3">
        	                <a href="#">
            	               <div class="dash-box dash-box-4">
            	                  <span>Update Cash</span>
            	                  <h1><?php echo ($opening_balance ? ($cash + $opening_balance[0]->closing_balance) : 0); ?></h1>
            	               </div>
        	               </a>
        	            </div>
                    </div>
                 </div>
                 <div class="row">
                    <div id="chart-container">
                    	&nbsp;
                    </div>
                 </div>
                    <div class="panel-footer">&nbsp;</div>
              </div>
           </div>
        </div>
    </div>
</div>