<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?php if ($datahandling[0]['status'] == 'active') {
                                            $judul = 'Detail Data Handling';
                                        } else {
                                            $judul = 'Detail Request Handling';
                                        } ?>
                                        <?= $judul ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border" style="font-weight: bold;"></div>
                            <div class="box-body">
                                <form name="Orderform" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: right; font-size:14pt">LAST REV DATE : <?= date('d-M-Y H:i:s', strtotime($datahandling[0]['last_update_date'])) ?></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Doc No</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input value="<?= $datahandling[0]['doc_number'] ?>" type="text" readonly class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($datahandling[0]['rev_no'] == -1) {
                                            $rev = 'Request baru';
                                        } else if ($datahandling[0]['rev_no'] == -2) {
                                            $rev = 'Request revisi';
                                        } else {
                                            $rev = $datahandling[0]['rev_no'];
                                        } ?>
                                        <div class="col-md-4" style="text-align: right;"><label>Rev No</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input value="<?= $rev ?>" type="text" readonly class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Kode Komponen</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input id="kodkomp" value="<?= $datahandling[0]['kode_komponen'] ?>" type="text" readonly class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Nama Dokumen</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input type="text" readonly id="namkomp" value="<?= $datahandling[0]['nama_komponen'] ?>" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Status Komponen</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input type="text" readonly id="stakomp" value="<?= $datahandling[0]['stat_komp'] ?>" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Produk</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input type="text" readonly id="prod_uct" value="<?= $datahandling[0]['kode_produk'] ?> - <?= $datahandling[0]['nama_produk'] ?>" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Sarana</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input type="text" readonly id="sar_ana" value="<?= $datahandling[0]['sarana'] ?>" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Qty / Handling</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input type="text" readonly id="qtyy" value="<?= $datahandling[0]['qty_handling'] ?>" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Berat</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input type="text" readonly id="berad" value="<?= $datahandling[0]['berat'] ?>" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Seksi</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input type="text" readonly id="sek_si" value="<?= $datahandling[0]['seksi'] ?>" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Proses</label></div>
                                        <div class="col-md-6" style="text-align: left;"><input type="text" readonly id="pros_es" value="<?= $datahandling[0]['proses'] ?>" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Preview Proses :</label></div>
                                    </div>
                                    <?php if ($datahandling[0]['proses'] == 'Linear') { ?>
                                        <div class="panel-body">
                                            <div class="col-md-12" style="border: 1px solid black;text-align:center">
                                                <?php $j = 0;
                                                $count = sizeof($dataProses);
                                                if ($count == 3) {
                                                    $style_kotak = "width:60mm";
                                                    $style_arrow = "width:20mm";
                                                    $font = "12pt";
                                                } else if (3 < $count && $count <= 6) {
                                                    $style_kotak = "width:40mm";
                                                    $style_arrow = "width:15mm";
                                                    $font = "10pt";
                                                } else if (6 < $count && $count <= 8) {
                                                    $style_kotak = "width:20mm";
                                                    $style_arrow = "width:10mm";
                                                    $font = "9pt";
                                                } else {
                                                    $style_kotak = "width:17mm";
                                                    $style_arrow = "width:10mm";
                                                    $font = "8pt";
                                                }
                                                foreach ($dataProses as $va) { ?>
                                                    <?php if ($j == 0) { ?>
                                                        <div style="display: inline-block;">
                                                            <div style="height:75px;text-align:center;display:none"><i class="fa fa-arrow-right fa-2x"></i></div>
                                                        </div>
                                                        <div style="display: inline-block;">
                                                            <div style="background-color: <?= $va['warna'] ?>;border: 1px solid black;margin-top:20px;text-align:center;padding: 20px 0;<?= $style_kotak ?>">
                                                                <p style="margin:10px;font-size:<?= $font ?>"><?= $va['seksi'] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div style="display: inline-block;">
                                                            <div style="height:75px;text-align:center;<?= $style_arrow ?>"><i class="fa fa-arrow-right"></i></div>
                                                        </div>
                                                        <div style="display: inline-block;">
                                                            <div style="background-color: <?= $va['warna'] ?>;border: 1px solid black;margin-top:20px;text-align:center;padding: 20px 0;<?= $style_kotak ?>">
                                                                <p style="margin:10px;font-size:<?= $font ?>"><?= $va['seksi'] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php $j++;
                                                } ?>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="panel-body">
                                            <div class="col-md-4" style="text-align: right;color:white"><label>prosesnya</label></div>
                                            <div class="col-md-6"><img style="width:100%" src="<?php echo base_url('assets/upload/DatabaseHandling/prosesnonlinier' . $datahandling[0]['id_handling'] . '.png'); ?>"></div>
                                        </div>
                                    <?php } ?>

                                    <?php $i = 0;
                                    foreach ($image as $value) { ?>
                                        <?php if ($datahandling[0]['proses'] == 'Linear') { ?>
                                            <?php if ($i == 0) { ?>
                                                <div class="panel-body">
                                                    <div class="col-md-4" style="text-align: right;"><label>Foto</label></div>
                                                    <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="urutanfotolinier[]" value="<?= $value['urutan'] ?>" /></div>
                                                    <div class="col-md-5"><img style="width:100%" src="<?php echo base_url('assets/upload/DatabaseHandling/fotolinier' . $value['id_handling'] . $value['urutan'] . '.png'); ?>"></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="panel-body">
                                                    <div class="col-md-4" style="text-align: right;color:white"><label>Foto</label></div>
                                                    <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="urutanfotolinier[]" value="<?= $value['urutan'] ?>" /></div>
                                                    <div class="col-md-5"><img style="width:100%" src="<?php echo base_url('assets/upload/DatabaseHandling/fotolinier' . $value['id_handling'] . $value['urutan'] . '.png'); ?>"></div>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if ($i == 0) { ?>
                                                <div class="panel-body">
                                                    <div class="col-md-4" style="text-align: right;"><label>Foto</label></div>
                                                    <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="urutanfotononlinier[]" value="<?= $value['urutan'] ?>" /></div>
                                                    <div class="col-md-5"><img style="width:100%" src="<?php echo base_url('assets/upload/DatabaseHandling/fotononlinier' . $value['id_handling'] . $value['urutan'] . '.png'); ?>"></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="panel-body">
                                                    <div class="col-md-4" style="text-align: right;color:white"><label>Foto</label></div>
                                                    <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="urutanfotononlinier[]" value="<?= $value['urutan'] ?>" /></div>
                                                    <div class="col-md-5"><img style="width:100%" src="<?php echo base_url('assets/upload/DatabaseHandling/fotononlinier' . $value['id_handling'] . $value['urutan'] . '.png'); ?>"></div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php $i++;
                                    } ?>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Keterangan</label></div>
                                        <div class="col-md-6" style="text-align: left;"><textarea readonly id="ketr" class="form-control"><?= $datahandling[0]['keterangan'] ?></textarea></div>
                                    </div>
                                    <?php if ($datahandling[0]['status'] == 'active') {
                                        if ($datahandling[0]['rev_no'] == 0) {
                                            $displaydiv = 'none';
                                        } else {
                                            $displaydiv = '';
                                        }
                                        $display = '';
                                        $display2 = 'none';
                                    } else {
                                        $displaydiv = 'none';
                                        $display = 'none';
                                        $display2 = '';
                                    } ?>
                                    <div class="panel-body">
                                        <div class="col-md-6" style="text-align: left;">
                                            <button formaction="<?php echo base_url('DbHandling/MonitoringHandling'); ?>" class="btn btn-danger">Back</button>
                                        </div>
                                        <div class="col-md-6" style="text-align: right; display:<?= $display ?>">
                                            <button formaction="<?php echo base_url('DbHandling/MonitoringHandling/PrintDataHandling/' . $datahandling[0]['id_handling']); ?>" formtarget="_blank" class="btn btn-success">Print</button>
                                            <a onclick="revisidatahandling(<?= $datahandling[0]['id_handling'] ?>)" class="btn btn-warning">Revisi</a>
                                        </div>
                                        <div class="col-md-6" style="text-align:right;display:<?= $display2 ?>">
                                            <a onclick="acc(<?= $datahandling[0]['id_handling'] ?>)" class="btn btn-success">Accept</a>
                                            <a onclick="reject(<?= $datahandling[0]['id_handling'] ?>)" class="btn btn-danger">Reject</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display:<?= $displaydiv ?>">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border" style="font-weight: bold;">History Dokumen</div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <form name="Orderform" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                            <table class="table table-bordered">
                                                <thead class="bg-yellow">
                                                    <tr>
                                                        <th class="text-center">No Dokumen</th>
                                                        <th class="text-center">Rev No</th>
                                                        <th class="text-center">Foto</th>
                                                        <th class="text-center">Proses</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($DataHandTbl as $key => $value) { ?>
                                                        <?php if ($key == 0) { ?>
                                                        <?php } else { ?>
                                                            <tr>
                                                                <input type="hidden" value="<?= $value['proses'] ?>" id="proseshandlingg<?= $value['id_handling'] ?>" />
                                                                <td class="text-center"><?= $value['doc_number'] ?></td>
                                                                <td class="text-center"><?= $value['rev_no'] ?></td>
                                                                <td class="text-center"><a onclick="imgcarousell(<?= $value['id_handling'] ?>)" class="btn btn-info">Foto</a></td>
                                                                <td class="text-center"><a onclick="proseshandlingg(<?= $value['id_handling'] ?>)" class="btn btn-default">Proses</a></td>
                                                                <td class="text-center"><button formaction="<?php echo base_url('DbHandling/MonitoringHandling/PrintDataHandling/' . $value['id_handling']); ?>" formtarget="_blank" class="btn btn-success">Print</button></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalrevhand" role="dialog">
    <div class="modal-dialog" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Revisi Data Handling</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="revhand"></div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Img Carousel -->
<div class="modal fade" id="modalcarousell" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Foto Handling</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="imgcarr"></div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Proses Handling -->
<div class="modal fade" id="modalproseshandlingg" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Proses</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="prosesss"></div>
            </div>
        </div>

    </div>
</div>