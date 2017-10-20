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
                                        Upload Plan Item List
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/ItemPlan');?>">
                                    <i aria-hidden="true" class="fa fa-list-alt fa-2x">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Upload file Excel
                            </div>
                            <div class="panel-body">
                                <?php echo $message; ?>
                                <form action="<?php echo base_url('ProductionPlanning/ItemPlan/CreateUpload'); ?>" class="form-horizontal" enctype="multipart/form-data" method="post">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <h2>
                                                <b>
                                                    This Action will replace all data
                                                </b>
                                            </h2>
                                            <p>
                                                -- Klick button 'DOWNLOAD SAMPLE' to download sample format item data list --
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-offset-2 col-md-2" for="dp2">
                                                Item Data File (.xls)
                                            </label>
                                            <div class="col-lg-6">
                                                <input class="form-control" name="itemData" required="" type="file">
                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                        <a class="btn btn-default" href="<?php echo site_url('ProductionPlanning/ItemPlan');?>">CANCEL</a>
                                        <a class="btn btn-warning" href="<?php echo base_url('ProductionPlanning/ItemPlan/DownloadSample');?>">
                                            <i aria-hidden="true" class="fa fa-download"></i> DOWNLOAD SAMPLE
                                        </a>
                                        <button class="btn btn-primary" type="submit">
                                            <i aria-hidden="true" class="fa fa-upload">
                                            </i>
                                            UPLOAD
                                        </button>
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
</section>