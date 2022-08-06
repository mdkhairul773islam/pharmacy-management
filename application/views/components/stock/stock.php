<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
    }
    .wid-100{width: 100px;}
    #loading{text-align: center;}
    #loading img{display: inline-block;}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default none">

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width:401px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Overall Report</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <?php
                            $total_sale = $total_purchase = $total_balance_profit = 0;
                            $stockInfo = get_result('stock', ['trash'=> 0], 'SUM(sell_price * quantity) as total_sale, SUM(purchase_price * quantity) as total_purchase, SUM(quantity) as total_stock_qty');
                            
                            if($stockInfo){
                                $total_sale      = $stockInfo[0]->total_sale;
                                $total_purchase  = $stockInfo[0]->total_purchase;
                                $total_stock_qty = $stockInfo[0]->total_stock_qty;
                                $total_balance_profit = $total_sale - $total_purchase;
                            }
                        ?>
                            <pre>
                                <table class="table">
                                    <tr>
                                        <th>Purchase Amount</th>
                                        <th>: <?=number_format($total_purchase, 2)?> TK</th>
                                    </tr>
                                    <tr>
                                        <th>Sale Amount</th>
                                        <th>: <?=number_format($total_sale, 2)?> TK</th>
                                    </tr>
                                    <tr>
                                        <th>Stock Quantity&nbsp;</th>
                                        <th>: <?=number_format($total_stock_qty, 2)?> </th>
                                    </tr>
                                </table>
                            </pre>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Stock</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                echo $this->session->flashdata('deleted');
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <div class="col-md-3">
                         <input  name="code"  id="productList" style="width:100%;" placeholder="Select Product"  />
                    </div>

                    <div class="col-md-3">
                        <select name="category" class="form-control js-example-basic-single">
                            <option value="" selected >-- Category --</option>
                            <?php if(!empty($allCategory)){ foreach($allCategory as $key => $row){ ?>
                            <option value="<?php echo $row->slug; ?>">
                                <?php echo filter($row->category); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="subcategory" class="form-control js-example-basic-single">
                            <option value="" selected >-- Manufacturer --</option>
                            <?php if(!empty($allSubcategory)){ foreach($allSubcategory as $key => $row){ ?>
                            <option value="<?php echo $row->slug; ?>">
                                <?php echo filter($row->subcategory); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="btn-group">
                        <input type="submit" name="find" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Stock</a></h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" href="<?=site_url('/stock/stock/pdf')?>"><i class="fa fa-cloud-download" aria-hidden="true"></i> Download</a>
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">Short Report</button>
                </div>
            </div>

            <div class="panel-body">
                <!--print header start-->
			    <?php $this->load->view('print');?>
			    <!--print header end-->

                <h4 class="hide text-center" style="margin-top: 0px;">Stock</h4>
                 <div class="table-responsive">
                    <h3>
                        <?php 
                            
                            //print_r($_POST);
                            if(!empty($_POST)){
                                
                                if(!empty($_POST['code'])){
                                    $product = get_name('products','product_name',['product_code' => $_POST['code']]);
                                    $products = 'Products:'.filter($product);
                                    
                                }else{
                                    $products = '';
                                }
                                
                                if(!empty($_POST['category'])){
                                    $category = 'Category:'.filter($_POST['category']);
                                    
                                }else{
                                    $category = '';
                                }
                                
                                if(!empty($_POST['subcategory'])){
                                    $subcategory = 'Manufacturer:'.filter($_POST['subcategory']);
                                }else{
                                    $subcategory = '';
                                }
                            }
                            
                        ?>
                        <?php
                            if(!empty($_POST)){
                        ?>
                             <h3>
                                 <b>
                                    <?php echo $products.'&nbsp;'.$category.'&nbsp;'.$subcategory.'&nbsp;'; ?>&nbsp;
                                 </b>    
                            </h3>
                        <?php
                            }
                        ?>
                        
                    </h3>
                    <table class="table table-bordered">
                        <thead>
                            <th style="width: 40px;">SL</th>
                            <th>Name</th>
                            <th>Batch</th>
                            <th>Expire Date</th>
                            <th>Category</th>
                            <th>Manufacturer</th>
                            <th>Quantity</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <!--<th>MRP</th>-->
                            <th>Amount</th>
                            <th>Sale Amount</th>
                        </thead>
                       
                        <tbody id="data_table"></tbody>
                    </table>
                    <div style="text-align: center;" id="onscroll_loader"><img src="<?php echo site_url('public/img/loader.gif'); ?>" alt="" style="width: 30px;"></div>    
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<!-- Select Option 2 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>

<script>
     $('.js-example-basic-single').select2();
    (function () {
        // initialize select2 dropdown
        $('#productList').select2({
            data: product_list(),
            placeholder: 'search',
            multiple: false,
            // creating query with pagination functionality.
            query: function (data) {
                var pageSize, dataset, that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function (e) {
                        return e.text.toUpperCase().indexOf(data.term.toUpperCase()) >= 0;
                    });
                } else if (data.term === '') {
                    results = that.data;
                }
                data.callback({
                    results: results.slice((data.page - 1) * pageSize, data.page * pageSize),
                    more: results.length >= data.page * pageSize,
                });
            },
        });
    })();

	function product_list() {

		var id_arr = new Array();
		var text_arr = new Array();
        <?php 
            $sl = 1;
            if(!empty($allProduct)){ foreach($allProduct as $row){
        ?>
			 id_arr["<?php echo $sl; ?>"]   = "<?php echo $row->code; ?>";
			 text_arr["<?php echo $sl; ?>"] = "<?php echo $row->name."-".filter($row->subcategory)."(".filter($row->batch_no) . ")"; ?>";
			
		<?php $sl++;  } } ?>
        return _.map(_.range(1,<?php echo count($allProduct)+1; ?>), function (i) {
            return {
                id:   id_arr[i],
                text: text_arr[i],
            };
        });
    } 
</script>


<script>
$(document).ready(function(){
    var currentPageNumber = 0;
    loadData(currentPageNumber);

    $(window).scroll(function(){
      if($(window).scrollTop() == ($(document).height() - $(window).height())){
          currentPageNumber += 1;
          loadData(currentPageNumber);
      }
    });
      
    function loadData(currentPage){
      var data_row = '', total_installment_price = 0, total_amount_price = 0;

      $.post("<?php echo site_url('stock/stock/onscroll_load_all_data'); ?>", 
        { 
            pageNumber: currentPage,
            pageSize :250,
            find:"<?php  if(!empty($_POST['find'])){ echo $_POST['find']; }else{ echo ''; } ?>",
            code:"<?php  if(!empty($_POST['code'])){ echo $_POST['code']; }else{ echo ''; } ?>",
            category:"<?php  if(!empty($_POST['category'])){ echo $_POST['category']; }else{ echo ''; } ?>",
            subcategory:"<?php  if(!empty($_POST['subcategory'])){ echo $_POST['subcategory']; }else{ echo ''; } ?>"
            
        }, 
        function(data, success){
            /*<td class="total_amount">${single_record['mrp']}</td>*/
          if(data!=0){
            var respons = JSON.parse(data);
            for(key in respons){
              var single_record = respons[key];
              data_row += '<tr>';
              data_row += `
                          <td>${single_record['sl']}</td>
                          <td>${single_record['name']}</td>
                          <td>${single_record['batch_no']}</td>
                          <td>${single_record['expire_date']}</td>
                          <td>${single_record['category']}</td>
                          <td>${single_record['manufacturer']}</td>
                          <td class="total_quantity">${(single_record['quantity'] > 0 ? single_record['quantity'] : '<small style="color:red;">Not Available</small>')}</td>
                          <td class="total_purchase">${single_record['purchase_price']}</td>
                          <td class="total_sale">${single_record['sell_price']}</td>
                          <td class="total_amount">${single_record['amount']}</td>
                          <td class="sale_amount">${single_record['sale_amount']}</td>
                        `;
              data_row += '</tr>';
            }
            data_table.innerHTML+=data_row;
          }else{
            
            var totalQuantity       = document.querySelectorAll('.total_quantity');
            var totalAmount         = document.querySelectorAll('.total_amount');
            var saleAmount         = document.querySelectorAll('.sale_amount');

            var total_quantity = total_amount = sale_amount_ = total_sale = total_purchase = 0;

            // calculate total sale price start
            Object.values(totalQuantity).forEach((value, index)=>{
                if(!isNaN(+value.innerHTML)){
                    total_quantity += (+1*value.innerHTML);
                }
            });
            total_quantity = total_quantity.toFixed(2);
            
            
            Object.values(totalAmount).forEach((value, index)=>{
                total_amount += (+1*value.innerHTML);
            });
            total_amount = total_amount.toFixed(2);
            
            Object.values(saleAmount).forEach((value, index)=>{
                sale_amount_ += (+1 * value.innerText.replaceAll(',', ''));
            });
            sale_amount_ = parseFloat(sale_amount_).toFixed(2);
            
            
            var totalPurchase_      = document.querySelectorAll('.total_purchase');
            var totalSale_          = document.querySelectorAll('.total_sale');
            
            Object.values(totalSale_).forEach((value, index)=>{
                total_sale += (+1*value.innerHTML);
            });
            total_sale = total_sale.toFixed(2);
            
            Object.values(totalPurchase_).forEach((value, index)=>{
                total_purchase += (+1*value.innerHTML);
            });
            total_purchase = total_purchase.toFixed(2);
            
            
            // calculate total low level price end
            if(document.querySelector('#totalValusRow')){
              data_table.removeChild(totalValusRow);
            }
            data_table.innerHTML += `
                                    <tr id="totalValusRow">
                                      <th colspan="6" style="text-align: right;">Total</th>
                                      <th>${total_quantity} Qty.</th>
                                      <th>${total_purchase} TK</th>
                                      <th>${total_sale} TK</th>
                                      <th>${total_amount} TK.</th>
                                      <th>${sale_amount_} TK.</th>
                                    </tr>
                                  `; 
            //----------------------------------------------------------------
          
          }
          
          if(data==''){
            onscroll_loader.style.cssText = "display:none;text-align:center;";
          }else{
            onscroll_loader.style.cssText = "display:block;text-align:center;";
          }

        });
    }

   });


</script>



