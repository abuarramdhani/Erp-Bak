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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DbHandlingSeksi/MonitoringHandling'); ?>">
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
                            <div class="box-header with-border" style="font-weight: bold;">REQUEST HANDLING</div>
                            <div class="box-body">
                                <form name="Orderform" class="form-horizontal" action="<?php echo base_url('DbHandlingSeksi/MonitoringHandling/AddreqHand'); ?>" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                    <div class="col-md-12" style="text-align: right;"><button class="btn btn-warning">Tambah</button></div>
                                </form>
                                <div class="col-md-12" style="font-weight: bold;text-align:center">
                                    <h4>BARU</h4>
                                </div>
                                <div class="col-md-12" id="tabel_reqhandseksi"></div>
                                <div class="col-md-12" style="font-weight: bold;text-align:center">
                                    <h4>REVISI</h4>
                                </div>
                                <div class="col-md-12" id="tabel_reqhandseksi2"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border" style="font-weight: bold;">Persentase Penggunaan Item by Dept class</div>
                            <div class="box-body">
                                <div class="col-md-12" id="view_presentasi"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border" style="font-weight: bold;">DATA SARANA HANDLING</div>
                            <div class="box-body">
                                <div class="col-md-12" id="tabel_datahandseksi"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
<!-- Modal Img Carousel -->
<div class="modal fade" id="mdl-carousel" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Foto</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="fotodisini"></div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Proses Handling -->
<div class="modal fade" id="ModalPros" role="dialog">
    <div class="modal-dialog" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Proses</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="IniProsesnya"></div>
            </div>
        </div>

    </div>
</div>
