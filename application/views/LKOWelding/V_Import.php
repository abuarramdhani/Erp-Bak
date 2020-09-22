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
                                        <div class="col-md-12">
                                            <div class="col-md-1" style="text-align: right;"> <label>Tanggal</label></div>
                                            <div class="col-md-4"><input type="text" id="tgl_import" name="tgl_import" required autocomplete="off" placeholder="Tanggal Bekerja" class="form-control" /></div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <table class="table table-bordered" id="tbl_hasil_import" style="font-size: 9pt">
                                                <thead class="bg-teal">
                                                    <tr>
                                                        <th class="text-center bg-teal" rowspan="2" style="vertical-align: middle;font-size: 8pt">NO</th>
                                                        <th class="text-center bg-teal" rowspan="2" style="vertical-align: middle;font-size: 8pt">NO INDUK</th>
                                                        <th class="text-center bg-teal" rowspan="2" style="vertical-align: middle;font-size: 8pt;width:200px">NAMA PEKERJA</th>
                                                        <th class="text-center" rowspan="2" style="vertical-align: middle;font-size: 8pt;width:200px">URAIAN PEKERJAAN</th>
                                                        <th class="text-center" colspan="3">PENCAPAIAN</th>
                                                        <th class="text-center" rowspan="2" style="vertical-align: middle;font-size: 8pt">SHIFT</th>
                                                        <th class="text-center" rowspan="2" style="vertical-align: middle;font-size: 8pt">KET</th>
                                                        <th class="text-center" style="vertical-align: middle;font-size: 8pt" colspan="8">KONDITE</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center" style="font-size: 8pt;">TGT</th>
                                                        <th class="text-center" style="font-size: 8pt;">ACT</th>
                                                        <th class="text-center" style="font-size: 8pt;">%</th>
                                                        <th class="text-center" style="font-size: 8pt;">MK</th>
                                                        <th class="text-center" style="font-size: 8pt;">I</th>
                                                        <th class="text-center" style="font-size: 8pt;">BK</th>
                                                        <th class="text-center" style="font-size: 8pt;">TKP</th>
                                                        <th class="text-center" style="font-size: 8pt;">KP</th>
                                                        <th class="text-center" style="font-size: 8pt;">KS</th>
                                                        <th class="text-center" style="font-size: 8pt;">KK</th>
                                                        <th class="text-center" style="font-size: 8pt;">PK</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($array_import as $key => $lk) { ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_noind[]" value="<?= $lk['noind'] ?>" /><?= $lk['noind'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_nama[]" value="<?= $lk['nama'] ?>" /><?= $lk['nama'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_work[]" value="<?= $lk['work'] ?>" /><?= $lk['work'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_tgt[]" value="<?= $lk['tgt'] ?>" /><?= $lk['tgt'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_act[]" value="<?= $lk['act'] ?>" /><?= $lk['act'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_persen[]" value="<?= $lk['persen'] ?>" /><?= $lk['persen'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_shift[]" value="<?= $lk['shift'] ?>" /><?= $lk['shift'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_ket[]" value="<?= $lk['ket'] ?>" /><?= $lk['ket'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_mk[]" value="<?= $lk['mk'] ?>" /><?= $lk['mk'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_lk[]" value="<?= $lk['i'] ?>" /><?= $lk['i'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_bk[]" value="<?= $lk['bk'] ?>" /><?= $lk['bk'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_tkp[]" value="<?= $lk['tkp'] ?>" /><?= $lk['tkp'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_kp[]" value="<?= $lk['kp'] ?>" /><?= $lk['kp'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_ks[]" value="<?= $lk['ks'] ?>" /><?= $lk['ks'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_kk[]" value="<?= $lk['kk'] ?>" /><?= $lk['kk'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="import_pk[]" value="<?= $lk['pk'] ?>" /><?= $lk['pk'] ?></td>
                                                        </tr>
                                                    <?php $no++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: right;margin-top:20px">
                                            <button formaction="<?php echo base_url('LaporanKerjaOperator/Input/InsertImport'); ?>" class="btn btn-danger" style="text-align: right;">Insert</button>
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
<div class="modal fade" id="modal_edit" role="dialog">
    <div class="modal-dialog" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Edit Data</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="edittttttt"></div>
            </div>
        </div>
    </div>
</div>