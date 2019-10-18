<section class="content">
    <div class="inner">
        <div class="row">
            <form class="form-horizontal">
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
                                        <br />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Read Quality Control</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                        <?php foreach ($QualityControl as $headerRow) : ?>
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
                                                                <td class="col-lg-2" style="border: 0"><strong>Selep Quantity</strong></td>
                                                                <td style="border: 0">: <?php echo $headerRow['selep_quantity']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-lg-2" style="border: 0"><strong>Checking Quantity</strong></td>
                                                                <td style="border: 0">: <?php echo $headerRow['checking_quantity']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-lg-2" style="border: 0"><strong>Scrap Quantity</strong></td>
                                                                <td style="border: 0">: <?php echo $headerRow['scrap_quantity']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-lg-2" style="border: 0"><strong>Employee</strong></td>
                                                                <td style="border: 0">: <?php echo $headerRow['employee']; ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div align="right">
                                        <a href="<?php echo site_url('ManufacturingOperationUP2L/QualityControl'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
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