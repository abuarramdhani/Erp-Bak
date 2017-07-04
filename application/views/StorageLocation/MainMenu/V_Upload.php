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
                                        <?php echo $title;?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SaveLocation/FileUpload');?>">
                                    <i aria-hidden="true" class="fa fa-2x fa-cloud-upload">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <?php  echo $message; ?>
                        <div class="col-lg-12 text-center">
                            <a href="<?php echo base_url('StorageLocation/FileUpload/Download') ?>">
                                <button class="btn btn-warning">
                                    <i aria-hidden="true" class="fa fa-download"></i> Download Template
                                </button>
                            </a>
                        </div>
                        <div class="col-lg-6 col-lg-offset-3" style="padding-top: 20px;">
                            <center>
                                <h2>
                                    <i class="fa fa-cloud-upload " style="vertical-align: middle;">
                                    </i>
                                    <strong>
                                        File
                                    </strong>
                                    Uploader
                                </h2>
                            </center>
                        </div>
                        <div class="row">
                            <form accept-charset="utf-8" action="<?php echo base_url('StorageLocation/FileUpload/DoUpload') ?>" enctype="multipart/form-data" method="post">
                                <div class="col-lg-4 col-lg-offset-3">
                                    <input class="form-control " name="datafile" style="width:400px" type="file">
                                    </input>
                                </div>
                                <div class="col-md-2" style="text-align: right ;">
                                    <button class="btn btn-primary" type="submit">
                                        <span class="fa fa-upload">
                                        </span>
                                        Upload
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>