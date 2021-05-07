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
                                            <label>Periode Cek :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                            <input style="width:100%"  type="text" class="date form-control" name="txtPeriodeMPA" id="txtPeriodeMPA" autocomplete="off" required>
                                            </div>
                                           
                                        </div>
                                        <div class="col-md-1" id="loadDateBetween"></div>
                                        <label class="label label-danger"
                                                style="margin-left: 0px;font-size:16px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                                                <span onclick="deleteCekMPA()"><i class="fa fa-trash"></i>&nbsp; Hapus Data Pengecekan</span>
                                            </label>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4" style="text-align: right;">
                                            <label>No Dokumen :</label>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select disabled="disabled" id="nodocMPA" name="nodocMPA" class="form-control select2" style="width:100%" data-placeholder="Pilih No Dokumen">
                                                    <!-- <option></option> -->

                                                </select>
                                            </div>
                                        </div>
                                    </div>

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