<?php
    $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result[0]->voucher_no));
?>
<style>
    .table>tbody>tr>td {padding: 2px;}
    .print_show {display: none;}
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
        border: 1px solid transparent;
        left: 0px;
        position: absolute;
        top: 0px;
        width: 100%;
        }
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        /*.table-bordered, .print-font { font-size: 8px !important; }
        .table tr td, .table tr th {
            font-size: 8px !important;
        }*/
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 1px solid #333 !important;
        }
        .print_show {display: table-row;}
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>
            </div> 
            <div class="panel-body">
                <!--print header start-->
    		    <?php $this->load->view('print'); ?>
    		    <!--print header end-->
    		    
                <div class="row">
                    <div class="col-xs-6 print-font">
                        <?php
                            $address = "N/A";
                            $cdata = json_decode($result[0]->address, true);
                            $address = (!empty($cdata['address']) ? $cdata['address'] : '');
                            if($result[0]->sap_type != "cash" ) {
                                
                                $where = array('code' => $result[0]->party_code);
                                $party_info = $this->action->read('parties', $where);
                                $address = ($party_info)? $party_info[0]->address: " ";
                        ?>
                        <label>Name : <?php if ($party_info != null) { echo filter($party_info[0]->name);}else{echo "N/A";} ?></label> <br>
                        <!--<label>Name : <?php echo filter($result[0]->party_code); ?></label> <br>-->
                        <label style="margin-bottom: 10px;">
                        Contact Person : <?php if ($party_info != null) { echo filter($party_info[0]->contact_person);}else{echo "N/A";} ?>
                        </label>
                    </div>
                    <div class="col-xs-6 print-font">
                        <label style="margin-bottom: 10px;">
                         <label style="width: 100%;">
                             Mobile : <?php if ($party_info != null) { echo $party_info[0]->mobile;}else{echo "N/A";} ?>
                         </label>
                         <label>Address : <?php echo $address; ?> </label>
                        <?php } else { ?>
                        <label>Name : <?php echo filter($result[0]->party_code); ?></label><br>
                        <label>Mobile : <?php echo $cdata['mobile']; ?></label><br>
                        <?php } ?>
                        </label>
                    </div>
                    <div class="col-xs-6 print-font">
                        <label style="margin-bottom: 10px;">Voucher No : <?php echo $result[0]->voucher_no; ?> </label> <br>
                        <?php if($result[0]->sap_type == "cash" ) { ?>
                        <!--<label>Address : <?php echo $address; ?> </label>-->
                        <label>Date : <?php echo $result[0]->sap_at; ?></label>
                        <?php }else{ ?>
                            <label>Date : <?php echo $result[0]->sap_at; ?></label>
                        <?php } ?>
                    </div>
                    
                    <div class="col-xs-6 print-font">
                        <label>Sold By : <?php echo $info[0]->meta_value; ?></label>
                    </div>
                    
                    <?php if($result[0]->sap_type == "cash" ) { ?>
                    <div class="col-xs-4 print-font">
                        &nbsp;
                        <!--<label>Date : <?php //echo $result[0]->sap_at; ?></label> <br>-->
                    </div>
                    <?php } ?>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th width="30%">Product</th>
                        <!--<th width="30%">Manufacturer</th>-->
                        <th width="30%" class="none">Self Name</th>
                        <th width="150">Qty</th>
                        <th width="150">Price</th>
                        <!--<th>Discount</th>-->
                        <th width="150">Total (TK)</th>
                    </tr>
                    <?php
                        $total = 0.00;
                        $total_sub = 0.0;
                        $total_profit = 0.0;
                        $where = array('voucher_no' => $result[0]->voucher_no);
                        $saleInfo = $this->action->read('sapitems', $where);
                        foreach($saleInfo as $key => $row){
                            $profit = 0.00;
                            $profit = ( $row->sale_price - $row->purchase_price ) * $row->quantity;
                            $product= $this->action->read('products', ['product_code'=>$row->product_code])[0];
                    ?>
                    <tr>
                        <td style="width: 50px;"><?php echo ($key + 1); ?></td>
                        <td>
                        <?php
                            $where = array('code' => $row->product_code);
                            $productInfo = $this->action->read('stock', $where);
                            if(!empty($row->name)){
                                echo $row->name;
                            }else{
                                if($productInfo){ echo filter($productInfo[0]->name); }
                            }
                            
                            
                        ?>
                        </td>
                        <!--<td><?php //echo filter($product->subcategory); ?>&nbsp;</td>-->
                        <td class="none"><?php echo filter($product->self_name); ?>&nbsp;</td>
                        <td><?php echo $row->quantity; ?>&nbsp;</td>
                        <td><?php echo $row->sale_price; ?>&nbsp;</td>
                        <!--<td><?php //echo $row->discount; ?>&nbsp;</td>-->
                        <td>
                            <?php
                                $subtotal = $row->sale_price * $row->quantity - $row->discount;
                                $total_sub += $subtotal;
                                echo f_number($subtotal);
                            ?>&nbsp;
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="2" class="text-right">Total Qty</th>
                        <td class="none">&nbsp;</td>
                        <th><?php echo $result[0]->total_quantity; ?>&nbsp;</th>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    
                    <tr class="print_show">
                        <th class="text-right" colspan="4">Paid Type &nbsp;&nbsp;</th>
                        <th> <?php echo ucfirst($result[0]->paid_type); ?></th>
                    </tr>
                    
                    <tr class="none">
                        <th class="text-right" colspan="5">Paid Type &nbsp;&nbsp;</th>
                        <th> <?php echo ucfirst($result[0]->paid_type); ?></th>
                    </tr>
                    
                    <tr class="print_show">
                        <th class="text-right" colspan="4">Sub Total &nbsp;&nbsp;TK</th>
                        <th><?php echo f_number($total_sub); ?></th>
                    </tr>
                    
                    <tr class="none">
                        <th class="text-right" colspan="5">Sub Total &nbsp;&nbsp;TK</th>
                        <th><?php echo f_number($total_sub); ?></th>
                    </tr>
                    
                    <tr class="print_show">
                        <th class="text-right" colspan="4">
                            Discount &nbsp;&nbsp;TK
                        </th>
                        <th>
                            <?php
                                $total_discount = $result[0]->total_discount;
                                echo f_number($result[0]->total_discount);
                            ?>
                        </th>
                    </tr>
                    <tr class="none">
                        <th class="text-right" colspan="5">
                            Discount &nbsp;&nbsp;TK
                        </th>
                        <th>
                            <?php
                                $total_discount = $result[0]->total_discount;
                                echo f_number($result[0]->total_discount);
                            ?>
                        </th>
                    </tr>
                    
                    <?php
                        if($result[0]->sap_type == 'cash'){
                            $due_paid = $due = 0.00;
                            $where = array('voucher_no' => $result[0]->voucher_no);
                            $due_paid_sum = $this->action->read_sum('due_collect','paid',$where);
                            $due_remission_sum = $this->action->read_sum('due_collect','remission',$where);
                                    
                            $paid = $result[0]->paid + $due_paid_sum[0]->paid;
                            $remission = ($due_remission_sum[0]->remission !=null)? $due_remission_sum[0]->remission:0.00;
                            $due = $total - $paid - $remission;
                        }else{
                            $paid = $result[0]->paid;
                            $remission = 0.00;
                        }
                    ?>
                    <tr class="print_show">
                        <th class="text-right" colspan="4">Paid &nbsp;&nbsp;TK</th>
                        <th><?php echo f_number($paid); ?></th>
                    </tr>
                    <tr class="none">
                        <th class="text-right" colspan="5">Paid &nbsp;&nbsp;TK</th>
                        <th><?php echo f_number($paid); ?></th>
                    </tr>
                    
                    <tr class="print_show">
                        <th class="text-right" colspan="4">Grand Total &nbsp;&nbsp;TK</th>
                        <th>
                            <?php
                                $gtotal = $total = $total_sub  - $total_discount;
                                echo f_number($total);
                            ?>
                        </th>
                    </tr>
                    <tr class="none">
                        <th class="text-right" colspan="5">Grand Total &nbsp;&nbsp;TK</th>
                        <th>
                            <?php
                                $gtotal = $total = $total_sub  - $total_discount;
                                echo f_number($total);
                            ?>
                        </th>
                    </tr>
    
                    <?php if ($remission > 0) { ?>
    
                    <tr class="print_show">
                        <th class="text-right" colspan="5">Remission &nbsp;&nbsp;TK</th>
                        <th>
                            <?php echo f_number($remission); ?>
                        </th>
                    </tr>
                    <tr class="none">
                        <th class="text-right" colspan="5">Remission &nbsp;&nbsp;TK</th>
                        <th>
                            <?php echo f_number($remission); ?>
                        </th>
                    </tr>
    
                    <?php } ?>
                    
                    <?php if ($result[0]->sap_type == 'credit') { ?>
                    
                    <!--<tr>
                        <th>Current Balance</th>
                        <td class="text-right">
                            <?php
                                //current balance = $balance + grand total -paid
                                $current_balance = $balance + $total - $result[0]->paid;
                                $current_status = ($current_balance < 0 ) ? "Payable":"Receivable";
                                echo f_number(abs($current_balance))." TK&nbsp;[ ".$current_status." ]"; 
                            ?>
                    </tr>-->
                    
                    
                    <!--previous current Balance-->
                    <tr class="none">
                        <!--<th>Current Balance</th>-->
                        <th class="text-right" colspan="5">Due &nbsp;&nbsp;TK</th>
                        <td>
                            <?php
                                //$current_status = ($result[0]->party_balance < 0 ) ? "Payable":"Receivable";
                                //echo f_number(abs($result[0]->party_balance))."[ ".$current_status." ]"; 
                                echo $result[0]->due;
                            ?>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <tr class="none">
                        <th class="text-right" colspan="5">Due &nbsp;&nbsp;TK</th>
                        <td><?php
                                //$current_status = ($result[0]->due < 0 ) ? "Payable":"Receivable";
                                //echo f_number(abs($due));
                                echo $result[0]->due;
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                    
                    <tr class="print_show">
                        <th colspan="5">In Word : <span id="inword3"></span> Taka Only.</th>
                    </tr>
                    <tr class="none">
                        <th colspan="6">In Word : <span id="inword2"></span> Taka Only.</th>
                    </tr>
                </table>
                
                <style>.bi_border{ display: inline-block; border: 1px solid #000; border-radius: 10px; padding: 3px 5px; margin-bottom: -7px;}</style>
                <div class="col-sm-9 col-xs-9">
                    <h6 style="margin-top: 20px;"><span class="bi_border">বিঃ দ্রঃ ঔষধ পরিবর্তন করতে হলে অবশ্যই ইনভয়েস সাথে আনতে হবে। </span> </h6> 
                    <!--<h6 class="text-center"><span class="bi_border">বিঃ দ্রঃ বন্ধ কোম্পানির মালের কোনো গ্যারান্টি নাই । </span> </h6>-->
                </div>
                <div class="col-sm-3 col-xs-3">
                    <h4 style="margin-top: 20px;" class="text-center print-font">
                        ---------- <br>
                        Authority
                    </h4>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){$("#inword").html(inWorden(<?php echo $gtotal; ?>));});
    $(document).ready(function(){$("#inword2").html(inWorden(<?php echo $gtotal; ?>));});
    $(document).ready(function(){$("#inword3").html(inWorden(<?php echo $gtotal; ?>));});
    $(document).ready(function(){$("#inword4").html(inWorden(<?php echo $gtotal; ?>));});
    $('.page-break').css({
        pageBreakAfter : "always"
    });
</script>