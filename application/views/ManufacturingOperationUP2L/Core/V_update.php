<?php //echo validation_errors();
//echo "<pre>";print_r($Core[0]['shift']);exit; 
?>
<section class="content">
    <div class="inner">
        <div class="row">
            <form method="post" action="<?php echo site_url('ManufacturingOperationUP2L/Core/update/' . $id); ?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                    <h1><b><?= $Title ?></b></h1>
                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Core/'); ?>">
                                        <i class="icon-wrench icon-2x"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Update Core</div>
                                <?php
                                foreach ($Core as $headerRow) :
                                    ?>
                                    <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="cmbComponentCodeHeader">
                                                    Component
                                                </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control jsSlcComp toupper" data-placeholder="Choose an option" id="cmbComponentCodeHeader" name="cmbComponentCodeHeader" onchange="getCompDescMO(this)">
                                                        <option value="<?php echo $headerRow['component_code'].' | '.$headerRow['component_description'].' | '.$headerRow['kode_proses']?>">
                                                        <?php echo $headerRow['component_code'].' | '.$headerRow['component_description'].' | '.$headerRow['kode_proses']?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtProductionDateHeader">
                                                    Production Date
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="form-control time-form1 ajaxOnChange" id="txtProductionDateHeader" name="txtProductionDateHeader" placeholder="" type="text" value="<?php echo $headerRow['production_date'] ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Print Code</label>
                                                <div id="print_code_area">
                                                    <div class="col-md-4">
                                                        <?php if ($headerRow['print_code']) { ?>
                                                            <input type="text" name="print_code" id="print_code" class="form-control" value="<?php echo $headerRow['print_code']; ?>">
                                                        <?php } else {?>
                                                        <small>-- Pilih ulang Production Date agar Kode muncul --</small>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtShift" class="control-label col-lg-4">Shift</label>
                                                <div class="col-lg-4">
                                                <select class="form-control slcShift" id="txtShift" name="txtShift">
                                                    <option value="<?php echo $headerRow['shift']; ?>"><?php echo $headerRow['shift']; ?></option>
                                                </select>    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtCoreQuantityHeader">
                                                    Core Quantity
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="form-control" id="txtCoreQuantityHeader" name="txtCoreQuantityHeader" placeholder="Core Quantity" type="text" value="<?php echo $headerRow['core_quantity']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtJobIdHeader">
                                                    Job Id
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="form-control" id="txtJobIdHeader" name="txtJobIdHeader" placeholder="Job Id" type="text" value="<?php echo $headerRow['employee_id']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer text-right">
                                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                        <a href="<?php echo site_url('ManufacturingOperationUP2L/Core'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>