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
                                    <i class="fa fa-pencil fa-2x">
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
                        <div class="box box-primary">
                            <div class="box-header with-border" style="font-weight: bold;">REQUEST MASTER HANDLING</div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12" style="text-align: right;"><button onclick="AddReqMasterHandling()" class="btn btn-warning">Tambah</button></div>
                                </div>

                                <div class="panel-body">
                                    <div class="col-md-12" id="tabel_reqjnshand"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
<!-- Modal Proses Handling -->
<div class="modal fade" id="MdlReqJns" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Request Master Handling</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="ReqJns"></div>
            </div>
        </div>

    </div>
</div>