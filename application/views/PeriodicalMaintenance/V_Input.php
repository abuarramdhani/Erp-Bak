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
                                        Periodical Maintenance
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="">
                                    <i aria-hidden="true" class="fa fa-refresh fa-2x">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <center><b style="font-size: 20px">Input Uraian Kerja</b></center>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 5px">

                                        <div class="alert-warning" id="alert-message" style="margin-bottom: 5px"></div>
                                        <form action="#" method="post" id="formInputPME">
                                            <div class="row">

                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <label>Doc No</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <input type="text" name="no_dokumen" id="no_dokumen"
                                                                class="form-control"
                                                                style="width: 100%;text-align: center;"
                                                                placeholder="No Dokumen" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <label>Rev No</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <input type="text" name="no_revisi" id="no_revisi"
                                                                class="form-control"
                                                                style="width: 100%;text-align: center;"
                                                                placeholder="No Revisi" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <label>Rev Date</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <div class="input-group date">
                                                                <input type="text" class="form-control pull-right"
                                                                    id="tgl_revisi" name="tgl_revisi"
                                                                    placeholder="DD/MM/YYYY" autocomplete="off">
                                                                <div class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <label>Catatan Revisi</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <textarea style="width: 100%;text-align: left;"
                                                                id="catatan_revisi_mpa" maxlength="500"
                                                                name="catatan_revisi_mpa" class="form-control"
                                                                placeholder="Catatan Revisi Dokumen"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <label>Mesin</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <select class="select4 form-control" style="width: 100%"
                                                                name="machineMPA" id="machineMPA"
                                                                data-placeholder="Nama Mesin">
                                                                <option></option>
                                                                <?php foreach ($mesin as $key => $value) { ?>
                                                                <option value="<?= $value['NAMA_MESIN'] ?>">
                                                                    <?= $value['NAMA_MESIN'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-1" id="loadingMachineMPA"></div> -->

                                                </div>
                                                <!-- </div>


                                            <div class="row"> -->


                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <label>Kondisi</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <select id="kondisi_mesin" name="kondisi_mesin"
                                                                class="form-control select2" style="width: 100%"
                                                                data-placeholder="Kondisi Mesin">
                                                                <!-- <option value="" disabled="" selected="">Pilih Sub Inventory</option> -->
                                                                <option></option>
                                                                <option>Mati</option>
                                                                <option>Beroperasi</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <label>Header</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <input type="text" name="header" id="header"
                                                                class="form-control"
                                                                style="width: 100%;text-align: center;"
                                                                placeholder="Header" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <label>Uraian</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <input type="text" name="uraian_kerja" id="uraian_kerja"
                                                                class="form-control"
                                                                style="width: 100%;text-align: center;"
                                                                placeholder="Uraian Kerja" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1"> <label>Standar</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <input type="text" name="standar" id="standar"
                                                                class="form-control"
                                                                style="width: 100%;text-align: center;"
                                                                placeholder="Standar" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1"> <label>Periode</label>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group">
                                                            <select id="periodeMPA" name="periodeMPA"
                                                                class="form-control select2" style="width: 100%"
                                                                data-placeholder="Periode">
                                                                <option></option>
                                                                <option>Harian</option>
                                                                <option>Mingguan</option>
                                                                <option>2 Mingguan</option>
                                                                <option>Bulanan</option>
                                                                <option>2 Bulanan</option>
                                                                <option>3 Bulanan</option>
                                                                <option>4 Bulanan</option>
                                                                <option>5 Bulanan</option>
                                                                <option>6 Bulanan</option>
                                                                <option>8 Bulanan</option>
                                                                <option>9 Bulanan</option>
                                                                <option>Tahunan</option>
                                                                <option>2 Tahunan</option>
                                                                <option>3 Tahunan</option>
                                                                <option>4 Tahunan</option>
                                                                <option>5 Tahunan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                </form>

                                <div class="panel-body">
                                    <div class="col-md-7 text-right">
                                        <button id="btnResetPME" class="btn btn-danger"><i class="fa fa-refresh"></i><b>
                                                Reset</b></button>
                                    </div>
                                    <div class="col-md-5">
                                        <a style="width:72px" href="javascript:void(0);"
                                            id="addRowPeriodicalMaintenance" onclick="addRowPeriodicalMaintenance()"
                                            class="btn btn-success" title="Insert Table"><i class="fa fa-plus"></i><b>
                                                Add </b></a>
                                    </div>

                                </div>
                                <form name="Orderform" class="form-horizontal"
                                    onsubmit="return validasi();window.location.reload();"
                                    action="<?php echo base_url('PeriodicalMaintenance/Input/Insert'); ?>"
                                    method="post">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover text-center"
                                                style="table-layout: auto;" name="tblPeriodicalMaintenance"
                                                id="tblPeriodicalMaintenance">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th>Nama Mesin</th>
                                                        <th>Kondisi Mesin</th>
                                                        <th>Header</th>
                                                        <th>Uraian Kerja</th>
                                                        <th>Standar</th>
                                                        <th>Periode</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyPreviousMPE" style="display:none;">

                                                </tbody>
                                                <tbody id="tbodyPeriodicalMaintenance">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                        <div class="row text-right" style="padding-right: 10px">
                                            <button type="submit" title="Insert to Oracle"
                                                class="btn btn-success"><b>Insert</b></button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>