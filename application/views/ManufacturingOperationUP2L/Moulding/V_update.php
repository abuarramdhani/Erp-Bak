<?php echo validation_errors(); ?>
<?php // echo "<pre>";print_r($Moulding);exit();
?>
<section class="content">
    <div class="inner">
        <div class="row">
            <form method="post" action="<?php echo site_url('ManufacturingOperationUP2L/Moulding/update/' . $id); ?>" class="form-horizontal">
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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Moulding/'); ?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span><br /></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Update Moulding</div>

                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <input type="hidden" name="txtMouldingId" id="txtMouldingId" value="<?= $Moulding[0]['moulding_id'] ?>">

                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="cmbComponentCodeHeader">
                                                    Component
                                                </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control jsSlcComp toupper" data-placeholder="Choose an option" id="cmbComponentCodeHeader" name="cmbComponentCodeHeader" onchange="getCompDescMO(this)">
                                                        <option value="<?php echo $Moulding[0]['component_code'].' | '.$Moulding[0]['component_description'].' | '.$Moulding[0]['kode_proses']?>">
                                                        <?php echo $Moulding[0]['component_code'].' | '.$Moulding[0]['component_description'].' | '.$Moulding[0]['kode_proses']?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtProductionDateHeader" class="control-label col-lg-4">Production Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="<?php echo date('Y-m-d') ?>" name="txtProductionDateHeader" value="<?php echo $Moulding[0]['production_date'] ?>" class="date form-control time-form1 ajaxOnChange" data-date-format="yyyy-mm-dd" id="txtProductionDateHeader" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-4">Print Code</label>
                                                <div id="print_code_area">
                                                    <div class="col-md-4">
                                                        <?php if ($Moulding[0]['print_code']) { ?>
                                                            <input type="text" name="print_code" id="print_code" class="form-control" value="<?php echo $Moulding[0]['print_code']; ?>">
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
                                                    <option value="<?php echo $Moulding[0]['shift']; ?>"><?php echo $Moulding[0]['shift']; ?></option>
                                                </select>    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtMouldingQuantityHeader" class="control-label col-lg-4">Moulding Quantity</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Moulding Quantity" name="txtMouldingQuantityHeader" id="txtMouldingQuantityHeader" class="form-control" value="<?php echo $Moulding[0]['moulding_quantity']; ?>" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-12">
                                            <br />
                                        </div>
                                    </div>
                                    <div class="box-footer text-right">
                                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                        <a href="<?php echo site_url('ManufacturingOperationUP2L/Moulding'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>