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
                        <div class="box box-info">
                            <div class="box-header with-border"></div>
                            <form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-2">
                                            <a class="btn btn-info" onclick="addlist()">Input Manual</a>
                                        </div>
                                        <div class="col-md-1"><label>OR</label></div>
                                        <div class="col-md-3">
                                            <input type="file" placeholder="Import File" class="form-control" />
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-success" formaction="<?php echo base_url('LaporanKerjaOperator/Input/ImportFile'); ?>">Import</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary" formaction="<?php echo base_url('LaporanKerjaOperator/Input/DownLoadLayout'); ?>">Download Layout</button>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" id="view_input_data"></div>
                                        <div class="col-md-12" style="text-align: right;margin-top:20px">
                                            <a class="btn btn-danger" onclick="modalprint()" style="text-align: right;">Print Laporan</a>
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
<div class="modal fade" id="modal_add_list" role="dialog">
    <div class="modal-dialog" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Insert Data</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="Listt"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_print" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Filter Laporan </h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="tglll"></div>
            </div>
        </div>
    </div>
</div>