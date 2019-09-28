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
                                            <div class="form-group">
                                                <input type="hidden" name="txtMouldingId" id="txtMouldingId" value="<?= $Moulding[0]['moulding_id'] ?>">
                                                <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component Code</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Component Code" name="txtComponentCodeHeader" id="txtComponentCodeHeader" class="form-control" value="<?php echo $Moulding[0]['component_code'];?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Component Description</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Component Description" name="txtComponentDescriptionHeader" id="txtComponentDescriptionHeader" class="form-control" value="<?= $Moulding[0]['component_description'];?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtProductionDateHeader" class="control-label col-lg-4">Production Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="<?php echo date('Y-m-d') ?>" name="txtProductionDateHeader" value="<?php echo $Moulding[0]['production_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtProductionDateHeader" />
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
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
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