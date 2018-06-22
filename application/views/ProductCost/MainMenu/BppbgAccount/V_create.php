<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?php echo $Title; ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductCost/BppbgAccount/create');?>">
                                    <i aria-hidden="true" class="fa fa-user fa-2x">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $errmessage; ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Create New Bppbg Account
                            </div>
                            <div class="box-body">
                                    <form action="<?php echo base_url('ProductCost/BppbgAccount/create') ?>" method="post" enctype="multipart/form-data">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-2 col-md-offset-1">
                                                    <label>UPLOAD FILE EXCEL</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="hidden" name="check" value="1">
                                                    <input type="file" name="fileAccount" class="form-control" placeholder="Choose File Excel" required="">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-2 col-md-offset-1">
                                                    <label>DOWNLOAD TEMPLATE</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="<?php echo base_url('ProductCost/BppbgAccount/DownloadTemplate/4A01') ?>" class="btn btn-block btn-danger" target="_blank"><i class="fa fa-cloud-download"></i> PRODUCTION</a>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="<?php echo base_url('ProductCost/BppbgAccount/DownloadTemplate/1E01') ?>" class="btn btn-block btn-success" target="_blank"><i class="fa fa-cloud-download"></i> NON PRODUCTION</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button id="bAccountSubmitBtn" type="submit" class="btn btn-primary pull-right">SUBMIT</button>
                                                    <a class="btn btn-default pull-right" href="<?php echo base_url('ProductCost/BppbgAccount') ?>">BACK</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-md-12">
        <div class="modal fade" id="slcBppbgCategoryModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                        <h4 class="modal-title">
                            Select Bppbg Category!
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover datatable-default" width="100%">
                                    <thead class="bg-primary">
                                        <td>No</td>
                                        <td>Category Code</td>
                                        <td>Category Description</td>
                                        <td>General Description</td>
                                    </thead>
                                    <tbody>
                                    <?php $x=1; foreach ($category as $c) { ?>
                                        <tr style="cursor: pointer;" onclick="slcBppbgCategoryProceed('<?php echo $c['USING_CATEGORY_CODE']; ?>','<?php echo $c['USING_CATEGORY_DESCRIPTION']; ?>')">
                                            <td><?php echo $x++; ?></td>
                                            <td><?php echo $c['USING_CATEGORY_CODE']; ?></td>
                                            <td><?php echo $c['USING_CATEGORY_DESCRIPTION']; ?></td>
                                            <td><?php echo $c['GENERAL_DESCRIPTION']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="modal fade" id="slcCostCenterModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                        <h4 class="modal-title">
                            Select Cost Center!
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover datatable-default" width="100%">
                                    <thead class="bg-primary">
                                        <td>No</td>
                                        <td>Cost Center</td>
                                        <td>Cost Center Description</td>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach ($costcenter as $cc) { ?>
                                        <tr style="cursor: pointer;" onclick="slcCostCenterProceed('<?php echo $cc['COST_CENTER']; ?>','<?php echo $cc['COST_CENTER_DESCRIPTION']; ?>')">
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $cc['COST_CENTER']; ?></td>
                                            <td><?php echo $cc['COST_CENTER_DESCRIPTION']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>