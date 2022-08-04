<style>
    @media print{
        aside, nav, .panel-heading, .panel-footer, .none{
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
    }

</style>

<div class="container-fluid" >
        <?php echo $this->session->flashdata("confirmation"); ?>   
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit Unit</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array(
                    "class" => "form-horizontal",
                    "id" => "search_data"
                );
                echo form_open("unit/unit/edit/".$unit[0]->id, $attr);
                ?>

                  <div class="form-group">
                        <div class="col-md-3">
                            <label>Unit</label>
                        </div>                            
                        <div class="col-md-5">
                            <input type="text" name="unit" value="<?= $unit[0]->unit ?>" class="form-control" >
                            <input type="hidden" name="id" value="<?= $unit[0]->id ?>" class="form-control" >
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="update" value="Update" class="btn btn-primary" >
                        </div>
                  </div>
                <?php echo form_close(); ?>                       
                 </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

