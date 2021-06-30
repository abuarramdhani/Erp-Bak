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
                                        <?= $Title ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg">
                                    <i class="fa fa-list fa-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header with-border"></div>
                            <form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label> File </label></div>
                                        <div class="col-md-3">
                                            <input type="file" placeholder="Import File" type="file" name="excel_file" class="form-control" accept=".csv, .xls,.xlsx" />
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label> Date of Data Source </label></div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="date_of_data_source" id="date_of_data_source">
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-5" style="text-align: right;">
                                            <button class="btn btn-success" formaction="<?php echo base_url('CARVP/Input/ImportFile'); ?>">Import</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary" formaction="<?php echo base_url('CARVP/Input/LayoutExcel'); ?>">Download Layout</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>