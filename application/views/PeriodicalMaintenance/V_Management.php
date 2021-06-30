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
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('PeriodicalMaintenance/Management/'); ?>">
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
                <form name="Orderform" action="<?php echo base_url('PeriodicalMaintenance/Management/cetakForm'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post">

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>Management</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-left">
                                        <!-- <label class="control-label"><?php echo date("l, d F Y") ?></label> -->
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label class="control-label">Mesin : </label>
                                        <select class="select4 form-control" style="width: 100%" name="list_mesin"
                                            id="selectMesin" data-placeholder="Pilih Mesin">
                                            <option></option>
                                            <?php foreach ($mesin as $key => $value) { ?>
                                            <option value="<?= $value['NAMA_MESIN'] ?>"><?= $value['NAMA_MESIN'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-1">
                                        <button type="button" onclick="getPME(this)" class="btn btn-success"
                                            id="btnfind" title="search"><i class="fa fa-search"></i> Find</button>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-danger" id="btncetak" title="cetak" target="_blank"><i class="fa fa-print"></i> Cetak</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>

        </div>
                                            </form>
        <div class="row">
                            <div class="col-md-12" id="ResultPME"></div>
                        </div>
</section>
<!-- Modal Edit -->
<div class="modal fade" id="modalEditManagement" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Edit Uraian Kerja</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="subManagementEdit"></div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalEditTopManagement" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Revisi Dokumen</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="topManagementEdit"></div>
            </div>
        </div>

    </div>
</div>