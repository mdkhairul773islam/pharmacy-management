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
                
	            <div class="col-md-3">
	               <a href="<?php echo site_url('purchase/purchase/show_purchase'); ?>">
    	               <div class="dash-box dash-box-2">
    	                  <span>Today's Purchase</span>
    	                  <h1><?php if($total_purchase[0]->total_bill !==null ){echo $total_purchase[0]->total_bill;}else{ echo "0"; } ?></h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	                <a href="<?php echo site_url('sale/searchSale'); ?>">
                       <div class="dash-box dash-box-1">
                          <span>Today's Sale</span>
                          <h1> <?php echo $total_sale; ?></h1>
                       </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
    	            <a href="<?php echo site_url('due_list/due_list'); ?>">
    	               <div class="dash-box dash-box-3">
    	                  <span>Today's Due</span>
    	                  <!--<h1><?php //if($todays_due[0]->paid !== null){ echo $todays_due[0]->paid;}else{echo "0";} ?> </h1>-->
    	                  <h1>&nbsp;<?php echo $todays_due; ?> </h1>
    	               </div>
    	            </a>
	            </div>
	            
	            <div class="col-md-3">
	               <a href="<?php echo site_url('sale/searchSale'); ?>">
    	               <div class="dash-box dash-box-4">
    	                  <span>Today's Total Paid</span>
    	                  <h1><?=(isset($total_paid) ? $total_paid : 0) ?></h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	                <a href="<?php echo site_url(''); ?>">
    	               <div class="dash-box dash-box-3">
    	                  <span>Bank To TT</span>
    	                  <h1><?php if($bankToTT[0]->amount !== null){ echo $bankToTT[0]->amount;}else{echo "0";} ?>  </h1>
    	               </div>
	               </a>
	            </div>

	            <div class="col-md-3">
	                <a href="<?php echo site_url('supplier/all_transaction'); ?>">
    	               <div class="dash-box dash-box-4">
    	                  <span>Supplier Paid</span>
    	                  <h1><?php if($supplier_paid[0]->debit !== null){ echo $supplier_paid[0]->debit;}else{echo "0";} ?> </h1>
    	               </div>
	               </a>
	            </div>
	            
	            <!--div class="col-md-3">
	                <a href="<?php echo site_url('bank/bankInfo/ledger'); ?>">
    	               <div class="dash-box dash-box-6">
    	                  <span>Bank Withdraw</span>
    	                  <h1><?php if($bank_withdraw[0]->amount !== null){ echo $bank_withdraw[0]->amount;}else{echo "0";} ?> </h1>
    	               </div>
	               </a>
	            </div-->
	            
	            <!--<div class="col-md-3">-->
	            <!--    <a href="#">-->
    	        <!--       <div class="dash-box dash-box-6">-->
    	        <!--          <span>Today's Cash</span>-->
    	        <!--          <h1><?php echo $cash; ?> </h1>-->
    	        <!--       </div>-->
	            <!--   </a>-->
	            <!--</div>-->
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-8">
	                  <span>Cash To Bank</span>
	                  <h1><?php if($cash_to_bank[0]->amount !== null){ echo $cash_to_bank[0]->amount;}else{echo "0";} ?> </h1>
	               </div>
	            </div-->
	            
	            <div class="col-md-3">
	                <a href="<?php echo site_url('client/all_transaction'); ?>">
    	               <div class="dash-box dash-box-7">
    	                  <span>Client Collection</span>
    	                  <h1><?php if($client_collection[0]->credit !== null){ echo $client_collection[0]->credit;}else{echo "0";} ?> </h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	                <a href="<?php echo site_url('bank/bankInfo/all_account'); ?>">
    	               <div class="dash-box dash-box-5">
    	                  <span>Bank Deposit</span>
    	                  <h1><?php if($bank_diposit[0]->amount !== null){echo $bank_diposit[0]->amount;}else{ echo "0";}?> </h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	                <a href="<?php echo site_url(''); ?>">
    	               <div class="dash-box dash-box-8">
    	                  <span>Cash To T.T</span>
    	                  <h1><?php if($cashToTT[0]->debit !== null){echo $cashToTT[0]->debit;}else{ echo "0";}?> </h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	               <div class="dash-box dash-box-12">
	                  <span>Others Cost</span>
	                  <h1><?php if($total_cost[0]->amount !== null){ echo $total_cost[0]->amount;}else{echo "0";} ?> </h1>
	               </div>
	            </div>
	            
	            <!--<div class="col-md-3">-->
	            <!--    <a href="<?php echo site_url('cost/cost/allcost'); ?>">-->
    	        <!--       <div class="dash-box dash-box-12">-->
    	        <!--          <span>Today's Cost</span>-->
    	        <!--          <h1><?php if($total_cost[0]->amount !== null){ echo $total_cost[0]->amount;}else{echo "0";} ?> </h1>-->
    	        <!--       </div>-->
	            <!--   </a>-->
	            <!--</div>-->
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-12">
	                  <span>Cash To Suplier</span>
	                  <h1>0.000 </h1>
	               </div>
	            </div-->

	            <div class="col-md-3">
	                <a href="<?php echo site_url('income/income/all'); ?>">
    	               <div class="dash-box dash-box-9">
    	                  <span>Today's Income</span>
    	                  <h1><?php if($total_income[0]->amount == null && $total_rent[0]->amount == null){ echo "0";}else{ echo $total_income[0]->amount + $total_rent[0]->amount;} ?> </h1>
    	               </div>
	               </a>
	            </div>
	            
	            
	            <!--**************************************************-->
	            <div class="col-md-3">
	                <a href="<?php echo site_url('client/client/view_all'); ?>">
    	               <div class="dash-box dash-box-2">
    	                  <span>Customar</span>
    	                  <!--<h1><?php if($totalClient !==null ){echo $totalClient;}else{ echo "0"; } ?></h1>-->
    	                  <h1><?php if($client !==null ){echo $client;}else{ echo "0"; } ?></h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	                <a href="<?php echo site_url('subCategory/subCategory/allsubCategory'); ?>">
    	               <div class="dash-box dash-box-1">
    	                  <span>Manufacturer</span>
    	                  <h1><?php if($totalManufacturer !==null ){echo $totalManufacturer;}else{ echo "0"; } ?></h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	                <a href="<?php echo site_url('product/product/allProduct'); ?>">
    	               <div class="dash-box dash-box-3">
    	                  <span>Product</span>
    	                  <h1><?php if($totalProduct !== null){ echo $totalProduct;}else{echo "0";} ?> </h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	                <a href="#">
    	               <div class="dash-box dash-box-4">
    	                  <span>Today's Cash</span>
    	                  <h1><?php echo $cash; ?></h1>
    	               </div>
	               </a>
	            </div>
	            
	            <div class="col-md-3">
	                <a href="#">
    	               <div class="dash-box dash-box-4">
    	                  <span>Update Cash</span>
    	                  <h1><?php echo ($opening_balance ? ($cash + $opening_balance[0]->closing_balance) : 0); ?></h1>
    	               </div>
	               </a>
	            </div>
	            
	            <!--div class="col-md-3">
	                <a href="<?php echo site_url('sale/searchSale'); ?>">
    	               <div class="dash-box dash-box-4">
    	                  <span>Invoice</span>
    	                  <h1><?php if($totalInvoice !==null ){echo $totalInvoice;}else{ echo "0"; } ?></h1>
    	               </div>
	               </a>
	            </div-->
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-3">
	                  <span>Today's Sale Return</span>
	                  <h1><?php echo $totalSaleReturn; ?></h1>
	               </div>
	            </div-->
	            
	            
	            
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-1">
	                  <span>Bank To Cash</span>
	                  <h1><?php if($bank_to_cash[0]->amount !== null){ echo $bank_to_cash[0]->amount;}else{echo "0";} ?> </h1>
	               </div>
	            </div-->
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-5">
	                  <span>Today's Purchase Return</span>
	                  <h1>0.000</h1>
	               </div>
	            </div-->

	            
	            <?php
	            /*$return_amount = 0.00;

	            foreach($sale_return  as $row){
	            $return_amount += $row->return_amount;

	            }*/

	            ?>
            </div>
         </div>
         <div class="row">
           
            <!--div class="col-md-12">
                <section>           
                    <div class="subsection">                
                        <div class="example-container clearfix">                    
                            <div class="example-chart">
                                <div id="bar-chart-sale"></div>
                            </div>
                        </div>
                    </div>           
                </section>
            </div>
            <div class="col-md-12">
                <section>           
                    <div class="subsection">                
                        <div class="example-container clearfix">                    
                            <div class="example-chart">
                                <div id="bar-chart-purchase"></div>
                            </div>
                        </div>
                    </div>           
                </section>
            </div>
            <div class="col-md-12">
                <section>           
                    <div class="subsection">                
                        <div class="example-container clearfix">                    
                            <div class="example-chart">
                                <div id="bar-chart-cost"></div>
                            </div>
                        </div>
                    </div>           
                </section>
            </div>
            <div class="col-md-12">
                <section>           
                    <div class="subsection">                
                        <div class="example-container clearfix">                    
                            <div class="example-chart">
                                <div id="pie-chart-example"></div>
                            </div>
                        </div>
                    </div>           
                </section>
            </div-->
         </div>
            <div class="panel-footer">&nbsp;</div>
      </div>
   </div>
</div>
</div>
</div>

<pre><?php //print_r($sale_month);?></pre>

<script type="text/javaScript" src="<?php echo site_url('private/plugins/cart/js/material-charts.js'); ?>"></script>
<!--<script type="text/javaScript" src="<?php echo site_url('private/plugins/cart/js/example.js'); ?>"></script>-->

<script>
    $(document).ready(function() {
    
    // sale section start here
    
    var saleData = <?php echo $sale;?>;
    var months = Object.keys(saleData);
    var values = Object.values(saleData);
    
	var exampleBarChartData = {
		"datasets": {
			"values": [50, 80, 70, 65, 50, 60,50, 80, 70, 65, 50, 60],
			"labels": [
				"Jan", 
				"Feb", 
				"Mar", 
				"Apr", 
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec"
			],
			//"values" : values,
			//"labels": months,
			"color": "green"
		},
		"title": "Monthly Sale Chart",
		"noY": true,
		"height": "300px",
		//"width": "450px",
		"width": "960px",
		"background": "#FFFFFF",
		"shadowDepth": ".5"
	};
	MaterialCharts.bar("#bar-chart-sale", exampleBarChartData)
	
	// sale section end here
	
	
	
	
	// purchase section start here
	
	var purchaseData = <?php echo $purchase;?>;
    var months = Object.keys(purchaseData);
    var values = Object.values(purchaseData);
    
	var exampleBarChartData = {
		"datasets": {
			"values": [50, 80, 70, 65, 50, 60,50, 80, 70, 65, 50, 60],
			"labels": [
				"Jan", 
				"Feb", 
				"Mar", 
				"Apr", 
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec"
			],
			//"values" : values,
			//"labels": months,
			"color": "blue"
		},
		"title": "Monthly Purchase Chart",
		"noY": true,
		"height": "300px",
		//"width": "450px",
		"width": "960px",
		"background": "#FFFFFF",
		"shadowDepth": ".5"
	};
	MaterialCharts.bar("#bar-chart-purchase", exampleBarChartData)
	
	// purchase section end here



    
    // cost section start from here
    
    var costData = <?php echo $cost;?>;
    var months = Object.keys(costData);
    var values = Object.values(costData);
    
	var exampleBarChartData = {
		"datasets": {
			"values": [50, 80, 70, 65, 50, 60,50, 80, 70, 65, 50, 60],
			"labels": [
				"Jan", 
				"Feb", 
				"Mar", 
				"Apr", 
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec"
			],
			//"values" : values,
			//"labels": months,
			"color": "red"
		},
		"title": "Monthly Cost Chart",
		"noY": true,
		"height": "300px",
		//"width": "450px",
		"width": "960px",
		"background": "#FFFFFF",
		"shadowDepth": ".5"
	};
	MaterialCharts.bar("#bar-chart-cost", exampleBarChartData)
	
	// cost section end here
	

	var examplePieChartData = {
		"dataset": {
			"values": [5, 30, 5, 20, 40],
			"labels": [
				"Apples", 
				"Oranges", 
				"Berries", 
				"Peaches", 
				"Bananas"
			],
		},
		"title": "Most Sale",
		"height": "300px",
		"width": "450px",
		"background": "#FFFFFF",
		"shadowDepth": "1"
	};

	MaterialCharts.pie("#pie-chart-example", examplePieChartData)
});

</script>


 