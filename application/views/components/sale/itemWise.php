<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>


<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css"/>
<style type="text/css">
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }
    }

    .table-title {
        font-size: 20px;
        color: #333;
        background: #f5f5f5;
        text-align: center;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }

    .select2-product_code-ji-container {
        height: 35px !important;
    }

    .select2-selection__arrow, .select2-selection--single {
        height: 36px !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View Item Wise Sale </h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                echo $this->session->flashdata('deleted');
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Products </label>
                    <div class="col-md-4">
                        <input name="stock_id" id="productList" style="width:100%;"
                               placeholder="type product name"/>
                    </div>
                    <div class="col-md-3">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php if (!empty($results)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show
                            Result </h1>&nbsp;&nbsp;<small>(<?php echo filter($results[0]->name); ?>
                            )</small>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                <div class="panel-body">
                    <!--print header start-->
    			    <?php $this->load->view('print');?>
    			    <!--print header end-->
    			    
                    <h4 class="text-center hide" style="margin-top: 0px;">View Item Wise Sale</h4>
                    <!--<h5 class="text-center hide" style="margin-top: 5px;">Products : <?php echo filter($_POST['product_code']); ?></h5>-->
                    <table class="table table-bordered table2">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Batch No</th>
                            <th>Voucher No</th>
                            <th>Quantity</th>
                            <th width="60" class="none">Action</th>
                        </tr>

                        <?php $total = 0;
                        foreach ($results as $key => $row) {
                            $total += $row->quantity;
                            ?>

                            <tr>
                                <td style="width: 40px;"><?php echo $key + 1; ?></td>
                                <td><?php echo $row->sap_at; ?></td>
                                <td><?php echo $row->batch_no; ?></td>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td><?php echo $row->quantity; ?></td>
                                <td class="none">
                                    <a title="View" class="btn btn-primary"
                                       href="<?php echo site_url('sale/viewSale?vno=' . $row->voucher_no); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>


                        <tr>
                            <th colspan="3" style="text-align: right; "> Total</th>
                            <td colspan="2"> <?php echo $total . "&nbsp"; ?>Qty. </td>
                        </tr>


                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>


<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
    (function () {
        // initialize select2 dropdown
        $('#productList').select2({
            data: dropdownData(),
            placeholder: 'search',
            multiple: false,
            // creating query with pagination functionality.
            query: function (data) {
                var pageSize,
                    dataset,
                    that = this;
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


    function dropdownData() {

        var id_arr = new Array();
        var text_arr = new Array();
        <?php
        $sl = 1;
        if (!empty($productList)){ foreach($productList as $row){
        ?>
        id_arr["<?php echo $sl; ?>"] = "<?php echo $row->id; ?>";
        text_arr["<?php echo $sl; ?>"] = "<?php echo $row->name . "-" . filter($row->category) . " (" . filter($row->batch_no) . ")"; ?>";

        <?php $sl++;  } } ?>
        return _.map(_.range(1,<?php echo count($productList) + 1; ?>), function (i) {
            return {
                id: id_arr[i],
                text: text_arr[i],
            };
        });
    }
</script>
    