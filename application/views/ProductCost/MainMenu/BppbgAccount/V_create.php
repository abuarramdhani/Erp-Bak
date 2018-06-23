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
                                    <form id="frm-BppbgAccount" action="<?php echo base_url('ProductCost/BppbgAccount/create') ?>" method="post" enctype="multipart/form-data">
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
                                                    <a href="<?php echo base_url('ProductCost/BppbgAccount/DownloadTemplate/4A02') ?>" class="btn btn-block btn-danger" target="_blank"><i class="fa fa-cloud-download"></i> PRODUCTION</a>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="<?php echo base_url('ProductCost/BppbgAccount/DownloadTemplate/1A01') ?>" class="btn btn-block btn-success" target="_blank"><i class="fa fa-cloud-download"></i> NON PRODUCTION</a>
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
        <div class="modal fade" id="loader-BppbgAccount" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="text-center" style="font-size: 2em; color: white;">
                    <i class="fa fa-spinner fa-pulse fa-5x"></i><br><br>
                    <p>Processing Data, Please Wait ....</p>
                </div>
            </div>
        </div>
    </div>
</div>