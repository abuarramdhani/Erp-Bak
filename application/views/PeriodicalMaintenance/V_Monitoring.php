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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PeriodicalMaintenance/Monitoring/'); ?>">
                                    <i class="icon-wrench icon-2x">
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
                <form name="Orderform" action="<?php echo base_url('PeriodicalMaintenance/Monitoring/printForm'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border"><b>Monitoring</b></div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-12 text-left">
                                            <!-- <label class="control-label"><?php echo date("l, d F Y") ?></label> -->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4" style="text-align: right;">
                                            <label>No Dokumen :</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <select id="nodocMPA" name="nodocMPA" class="form-control select2" style="width:400px" data-placeholder="Pilih No Dokumen">
                                                    <option></option>
                                                    <?php foreach ($nodoc as $key => $value) { ?>
                                                        <option value="<?= $value['DOCUMENT_NUMBER'] ?>"><?= $value['DOCUMENT_NUMBER'] ?> - <?= $value['NAMA_MESIN'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="panel-body">
                                    <div class="col-md-3">
                                        <label class="control-label">Tanggal Pengecekan : </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input id="tglCek" name="tglCek" type="text" class="form-control pull-right" style="width:100%;" placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-1" id="loadingTanggalPME"></div>
                                    
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label class="control-label">Pilih Mesin : </label>
                                        <select disabled class="select4 form-control" style="width: 100%" name="mesinMon" id="mesinMon" data-placeholder="Pilih Mesin">
                                            <option></option>
                                            <?php foreach ($mesin as $key => $value) { ?>
                                                <option value="<?= $value['NAMA_MESIN'] ?>"><?= $value['NAMA_MESIN'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                 -->

                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <button type="button" onclick="getPMEMon(this)" class="btn btn-success" id="btnfind" title="search" style="float: right;"><i class="fa fa-search"></i> Find</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-danger" id="btncetak" title="cetak" target="_blank" style="float: left;"><i class="fa fa-print"></i> Cetak</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="ResultPMEMon"></div>
                            </div>
                        </div>
                    </div>
            </div>
            </form>

        </div>
</section>
<!-- Modal Edit -->
<div class="modal fade" id="modalEditMonitoring" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Edit Data Pengecekan</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="subMonitoringEdit"></div>
            </div>
        </div>

    </div>
</div>