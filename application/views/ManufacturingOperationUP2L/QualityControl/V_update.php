<section class="content">
    <div class="inner">
        <div class="row">
            <form method="post" action="<?php echo site_url('ManufacturingOperationUP2L/QualityControl/update/' . $id); ?>" class="form-horizontal">
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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/QualityControl/'); ?>">
                                        <i class="icon-wrench icon-2x"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Update Quality Control</div>
                                <?php
                                foreach ($QualityControl as $headerRow) :
                                    ?>
                                    <input type="hidden" name="id_fix" value="<?= $headerRow['selep_id_c']?>">
                                    <div class="box-body">
                                        <div class="panel-body">
                                                <table class="table" style="border: 0px !Important;">
                                                    <tr>
                                                        <td class="col-lg-2" style="border: 0"><strong>Component Code</strong></td>
                                                        <td style="border: 0">: <?php echo $headerRow['component_code']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-lg-2" style="border: 0"><strong>Component Description</strong></td>
                                                        <td style="border: 0">: <?php echo $headerRow['component_description']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-lg-2" style="border: 0"><strong>Checking Date</strong></td>
                                                        <td style="border: 0">: <?php echo $headerRow['checking_date']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-lg-2" style="border: 0"><strong>Shift</strong></td>
                                                        <td style="border: 0">: <?php echo $headerRow['shift']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-lg-2" style="border: 0"><strong>Employee</strong></td>
                                                        <td style="border: 0">: <?php echo $headerRow['employee']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-lg-2" style="border: 0"><strong>Selep Quantity</strong></td>
                                                        <td style="border: 0">: <?php echo $headerRow['selep_quantity']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <br><td class="col-lg-2" style="border: 0"><strong>Checking Quantity</strong></td>
                                                        <td style="border: 0"><div class="col-lg-5"><input type="text" placeholder="Checking Quantity" name="txtCheckingQuantityHeader" id="mo_txtCheckingQuantityHeader" class="form-control" value="<?php echo $headerRow['checking_quantity']; ?>" /></div></td>
                                                    </tr>
                                                </table>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                                <a href="<?php echo site_url('ManufacturingOperationUP2L/QualityControl'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                            </div>
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