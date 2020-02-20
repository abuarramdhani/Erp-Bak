<?php $num=1; $i=0; foreach($hasil as $val){ 
// echo "<pre>"; print_r($val[$i]); exit();
 if ($val['jml_spb'] == '0' && $val['jml_pelayanan'] == '0' && $val['jml_pengeluaran'] == '0' && $val['jml_packing'] == '0') {
    
} else{
?>
<div class="box-body">
    <div class="panel-body">
        <div class="col-md-12">
            <label class="text-right">Tanggal : <?php echo $val['tanggal'] ?></label>
            <input type="hidden" name="tanggalnya[]" value="<?= $val['tanggal']?>">
            <input type="hidden" name="tglAwal[]" value="<?= $tglAwal?>">
            <input type="hidden" name="tglAkhir[]" value="<?= $tglAkhir?>">
        </div>
        <!-- <div class="col-md-12"> -->
        <div class="col-md-6">
            <label class="text-right">DOSP / SPB masuk : <?= $val['jml_spb'] ?> lembar</label>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-xs btn-info" onclick="addDoSpb2(this, <?= $num?>)">Rincian</button></td>
        </div>
        <!-- </div> -->
        <div class="col-md-12">
            <div id="DoSpb<?=$num?>" class="table-responsive" style="display:none">
                <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Dokumen</th>
                            <th>No Dokumen</th>
                            <th>Jumlah Item</th>
                            <th>Jumlah Pcs</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $a= 0; $no=1; foreach($val['dosp'] as $do){ ?>
                        <tr>
                            <td style="width: 5px"><?= $no; ?></td>
                                <td><input type="hidden" name="tgl_dospb[]" value="<?= $do['TGL_DIBUAT']?>"><?= $do['TGL_DIBUAT']?></td>
                                <td><input type="hidden" name="jenis_dospb[]" value="<?= $do['JENIS_DOKUMEN']?>"><?= $do['JENIS_DOKUMEN']?></td>
                                <td><input type="hidden" name="no_dospb[]" value="<?= $do['NO_DOKUMEN']?>"><?= $do['NO_DOKUMEN']?></td>
                                <td><input type="hidden" name="jml_item_dospb[]" value="<?= $do['JUMLAH_ITEM']?>"><?= $do['JUMLAH_ITEM']?></td>
                                <td><input type="hidden" name="jml_pcs_dospb[]" value="<?= $do['JUMLAH_PCS']?>"><?= $do['JUMLAH_PCS']?></td>
                                <td><input type="hidden" name="urgent_dospb[]" value="<?= $do['URGENT']?> <?= $do['BON'] ?>"><?= $do['URGENT']?> <?= $do['BON'] ?></td>
                            </tr>
                        <?php $no++; $a++;}?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            <label class="text-right">Pelayanan</label>
        </div>
        <div class="col-md-3">
            Terselesaikan : <?= $val['jml_pelayanan'] ?> lembar
        </div>
        <div class="col-md-3">
            Tanggungan : <?= $val['krg_pelayanan'] ?> lembar
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-xs btn-info" onclick="addRinPelayanan2(this, <?= $num?>)">Rincian</button>
        </div>
        <div class="col-md-12">
            <div id="RinPelayanan1<?= $num?>" style="display:none">
                <center><label>Terselesaikan</label></center>
                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Dokumen</th>
                            <th>No Dokumen</th>
                            <th>Jumlah Item</th>
                            <th>Jumlah Pcs</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Waktu</th>
                            <th>PIC</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($val['pelayanan'] as $plyn) {?>
                            <tr>
                                <td style="width: 5px"><?= $no; ?></td>
                                <td><input type="hidden" name="tgl_plyn[]" value="<?= $plyn['TGL_DIBUAT']?>"><?= $plyn['TGL_DIBUAT']?></td>
                                <td><input type="hidden" name="jenis_plyn[]" value="<?= $plyn['JENIS_DOKUMEN']?>"><?= $plyn['JENIS_DOKUMEN']?></td>
                                <td><input type="hidden" name="no_plyn[]" value="<?= $plyn['NO_DOKUMEN']?>"><?= $plyn['NO_DOKUMEN']?></td>
                                <td><input type="hidden" name="jml_item_plyn[]" value="<?= $plyn['JUMLAH_ITEM']?>"><?= $plyn['JUMLAH_ITEM']?></td>
                                <td><input type="hidden" name="jml_pcs_plyn[]" value="<?= $plyn['JUMLAH_PCS']?>"><?= $plyn['JUMLAH_PCS']?></td>
                                <td><?= $plyn['MULAI_PELAYANAN']?>
                                    <input type="hidden" name="tgl_mulai_plyn[]" value="<?= $plyn['TGL_MULAI_PELAYANAN']?>">
                                    <input type="hidden" name="jam_mulai_plyn[]" value="<?= $plyn['JAM_MULAI_PELAYANAN']?>">
                                </td>
                                <td><?= $plyn['SELESAI_PELAYANAN']?>
                                    <input type="hidden" name="tgl_selesai_plyn[]" value="<?= $plyn['TGL_SELESAI_PELAYANAN']?>">
                                    <input type="hidden" name="jam_selesai_plyn[]" value="<?= $plyn['JAM_SELESAI_PELAYANAN']?>">
                                </td>
                                <td><input type="hidden" name="waktu_pelayanan[]" value="<?= $plyn['WAKTU_PELAYANAN']?>"><?= $plyn['WAKTU_PELAYANAN']?></td>
                                <td><input type="hidden" name="pic_plyn[]" value="<?= $plyn['PIC_PELAYAN']?>"><?= $plyn['PIC_PELAYAN']?></td>
                                <td><input type="hidden" name="urgent_plyn[]" value="<?= $plyn['URGENT']?> <?= $plyn['BON'] ?>"><?= $plyn['URGENT']?> <?= $plyn['BON'] ?></td>
                            </tr>
                        <?php $no++;}?>
                    </tbody>
                </table>
            </div>
            <div id="RinPelayanan2<?= $num?>" style="display:none">
                <center><label>Tanggungan</label></center>
                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:100%">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Dokumen</th>
                            <th>No Dokumen</th>
                            <th>Jumlah Item</th>
                            <th>Jumlah Pcs</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($val['krgpelayanan'] as $kplyn){ ?>
                            <tr>
                                <td style="width: 5px"><?= $no; ?></td>
                                <td><input type="hidden" name="tgl_krgplyn[]" value="<?= $kplyn['TGL_DIBUAT']?>"><?= $kplyn['TGL_DIBUAT']?></td>
                                <td><input type="hidden" name="jenis_krgplyn[]" value="<?= $kplyn['JENIS_DOKUMEN']?>"><?= $kplyn['JENIS_DOKUMEN']?></td>
                                <td><input type="hidden" name="no_krgplyn[]" value="<?= $kplyn['NO_DOKUMEN']?>"><?= $kplyn['NO_DOKUMEN']?></td>
                                <td><input type="hidden" name="jml_item_krgplyn[]" value="<?= $kplyn['JUMLAH_ITEM']?>"><?= $kplyn['JUMLAH_ITEM']?></td>
                                <td><input type="hidden" name="jml_pcs_krgplyn[]" value="<?= $kplyn['JUMLAH_PCS']?>"><?= $kplyn['JUMLAH_PCS']?></td>
                                <td><input type="hidden" name="urgent_krgplyn[]" value="<?= $kplyn['URGENT']?> <?= $kplyn['BON'] ?>"><?= $kplyn['URGENT']?> <?= $kplyn['BON'] ?></td>
                            </tr>
                        <?php $no++; }?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            <label class="text-right">Pengeluaran</label>
        </div>
        <div class="col-md-3">
            Terselesaikan : <?= $val['jml_pengeluaran'] ?> lembar
        </div>
        <div class="col-md-3">
            Tanggungan : <?= $val['krg_pengeluaran'] ?> lembar
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-xs btn-info" onclick="addRinPengeluaran2(this, <?= $num?>)">Rincian</button></td>
        </div>
        <div class="col-md-12">
            <div id="RinPengeluaran1<?= $num?>" style="display:none">
                <center><label>Terselesaikan</label></center>
                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:100%">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Dokumen</th>
                            <th>No Dokumen</th>
                            <th>Jumlah Item</th>
                            <th>Jumlah Pcs</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Waktu</th>
                            <th>PIC</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($val['pengeluaran'] as $pglr){ ?>
                            <tr>
                                <td style="width: 5px"><?= $no; ?></td>
                                <td><input type="hidden" name="tgl_pglr[]" value="<?= $pglr['TGL_DIBUAT']?>"><?= $pglr['TGL_DIBUAT']?></td>
                                <td><input type="hidden" name="jenis_pglr[]" value="<?= $pglr['JENIS_DOKUMEN']?>"><?= $pglr['JENIS_DOKUMEN']?></td>
                                <td><input type="hidden" name="no_pglr[]" value="<?= $pglr['NO_DOKUMEN']?>"><?= $pglr['NO_DOKUMEN']?></td>
                                <td><input type="hidden" name="jml_item_pglr[]" value="<?= $pglr['JUMLAH_ITEM']?>"><?= $pglr['JUMLAH_ITEM']?></td>
                                <td><input type="hidden" name="jml_pcs_pglr[]" value="<?= $pglr['JUMLAH_PCS']?>"><?= $pglr['JUMLAH_PCS']?></td>
                                <td><?= $pglr['MULAI_PENGELUARAN']?>
                                    <input type="hidden" name="tgl_mulai_pglr[]" value="<?= $pglr['TGL_MULAI_PENGELUARAN']?>">
                                    <input type="hidden" name="jam_mulai_pglr[]" value="<?= $pglr['JAM_MULAI_PENGELUARAN']?>">
                                </td>
                                <td><?= $pglr['SELESAI_PENGELUARAN']?>
                                    <input type="hidden" name="tgl_selesai_pglr[]" value="<?= $pglr['TGL_SELESAI_PENGELUARAN']?>">
                                    <input type="hidden" name="jam_selesai_pglr[]" value="<?= $pglr['JAM_SELESAI_PENGELUARAN']?>">
                                </td>
                                <td><input type="hidden" name="waktu_pengeluaran[]" value="<?= $pglr['WAKTU_PENGELUARAN']?>"><?= $pglr['WAKTU_PENGELUARAN']?></td>
                                <td><input type="hidden" name="pic_pglr[]" value="<?= $pglr['PIC_PENGELUARAN']?>"><?= $pglr['PIC_PENGELUARAN']?></td>
                                <td><input type="hidden" name="urgent_pglr[]" value="<?= $pglr['URGENT']?> <?= $pglr['BON'] ?>"><?= $pglr['URGENT']?> <?= $pglr['BON'] ?></td>
                            </tr>
                        <?php $no++;} ?>
                        
                    </tbody>
                </table>
            </div>
            <div id="RinPengeluaran2<?= $num?>" style="display:none">
                <center><label>Tanggungan</label></center>
                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:100%">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Dokumen</th>
                            <th>No Dokumen</th>
                            <th>Jumlah Item</th>
                            <th>Jumlah Pcs</th>
                            <th>PIC</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($val['krgpengeluaran'] as $kpglr){ ?>
                            <tr>
                                <td style="width: 5px"><?= $no; ?></td>
                                <td><input type="hidden" name="tgl_krgpglr[]" value="<?= $kpglr['TGL_DIBUAT']?>"><?= $kpglr['TGL_DIBUAT']?></td>
                                <td><input type="hidden" name="jenis_krgpglr[]" value="<?= $kpglr['JENIS_DOKUMEN']?>"><?= $kpglr['JENIS_DOKUMEN']?></td>
                                <td><input type="hidden" name="no_krgpglr[]" value="<?= $kpglr['NO_DOKUMEN']?>"><?= $kpglr['NO_DOKUMEN']?></td>
                                <td><input type="hidden" name="jml_item_krgpglr[]" value="<?= $kpglr['JUMLAH_ITEM']?>"><?= $kpglr['JUMLAH_ITEM']?></td>
                                <td><input type="hidden" name="jml_pcs_krgpglr[]" value="<?= $kpglr['JUMLAH_PCS']?>"><?= $kpglr['JUMLAH_PCS']?></td>
                                <td><input type="hidden" name="pic_krgpglr[]" value="<?= $kpglr['PIC_PELAYAN']?>"><?= $kpglr['PIC_PELAYAN']?></td>
                                <td><input type="hidden" name="urgent_krgpglr[]" value="<?= $kpglr['URGENT']?> <?= $kpglr['BON'] ?>"><?= $kpglr['URGENT']?> <?= $kpglr['BON'] ?></td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            <label class="text-right">Packing</label>
        </div>
        <div class="col-md-3">
            Terselesaikan : <?= $val['jml_packing'] ?> lembar
        </div>
        <div class="col-md-3">
            Tanggungan : <?= $val['krg_packing'] ?> lembar
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-xs btn-info" onclick="addRinPacking2(this, <?= $num?>)">Rincian</button></td>
        </div>
        <div class="col-md-12">
            <div id="RinPacking1<?= $num?>" style="display:none">
                <center><label>Terselesaikan</label></center>
                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:100%">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Dokumen</th>
                            <th>No Dokumen</th>
                            <th>Jumlah Item</th>
                            <th>Jumlah Pcs</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Waktu</th>
                            <th>PIC</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($val['packing'] as $pck){ ?>
                            <tr>
                                <td style="width: 5px"><?= $no; ?></td>
                                <td><input type="hidden" name="tgl_pck[]" value="<?= $pck['TGL_DIBUAT']?>"><?= $pck['TGL_DIBUAT']?></td>
                                <td><input type="hidden" name="jenis_pck[]" value="<?= $pck['JENIS_DOKUMEN']?>"><?= $pck['JENIS_DOKUMEN']?></td>
                                <td><input type="hidden" name="no_pck[]" value="<?= $pck['NO_DOKUMEN']?>"><?= $pck['NO_DOKUMEN']?></td>
                                <td><input type="hidden" name="jml_item_pck[]" value="<?= $pck['JUMLAH_ITEM']?>"><?= $pck['JUMLAH_ITEM']?></td>
                                <td><input type="hidden" name="jml_pcs_pck[]" value="<?= $pck['JUMLAH_PCS']?>"><?= $pck['JUMLAH_PCS']?></td>
                                <td><?= $pck['MULAI_PACKING']?>
                                    <input type="hidden" name="tgl_mulai_pck[]" value="<?= $pck['TGL_MULAI_PACKING']?>">
                                    <input type="hidden" name="jam_mulai_pck[]" value="<?= $pck['JAM_MULAI_PACKING']?>">
                                </td>
                                <td><?= $pck['SELESAI_PACKING']?>
                                    <input type="hidden" name="tgl_selesai_pck[]" value="<?= $pck['TGL_SELESAI_PACKING']?>">
                                    <input type="hidden" name="jam_selesai_pck[]" value="<?= $pck['JAM_SELESAI_PACKING']?>">
                                </td>
                                <td><input type="hidden" name="waktu_packing[]" value="<?= $pck['WAKTU_PACKING']?>"><?= $pck['WAKTU_PACKING']?></td>
                                <td><input type="hidden" name="pic_pck[]" value="<?= $pck['PIC_PACKING']?>"><?= $pck['PIC_PACKING']?></td>
                                <td><input type="hidden" name="urgent_pck[]" value="<?= $pck['URGENT']?> <?= $pck['BON'] ?>"><?= $pck['URGENT']?> <?= $pck['BON'] ?></td>
                            </tr>
                        <?php $no++;} ?>
                    </tbody>
                </table>
            </div>
            <div id="RinPacking2<?= $num?>" style="display:none">
                <center><label>Tanggungan</label></center>
                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:100%">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Dokumen</th>
                            <th>No Dokumen</th>
                            <th>Jumlah Item</th>
                            <th>Jumlah Pcs</th>
                            <th>PIC</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($val['krgpacking'] as $kpck){ ?>
                            <tr>
                                <td style="width: 5px"><?= $no; ?></td>
                                <td><input type="hidden" name="tgl_krgpck[]" value="<?= $kpck['TGL_DIBUAT']?>"><?= $kpck['TGL_DIBUAT']?></td>
                                <td><input type="hidden" name="jenis_krgpck[]" value="<?= $kpck['JENIS_DOKUMEN']?>"><?= $kpck['JENIS_DOKUMEN']?></td>
                                <td><input type="hidden" name="no_krgpck[]" value="<?= $kpck['NO_DOKUMEN']?>"><?= $kpck['NO_DOKUMEN']?></td>
                                <td><input type="hidden" name="jml_item_krgpck[]" value="<?= $kpck['JUMLAH_ITEM']?>"><?= $kpck['JUMLAH_ITEM']?></td>
                                <td><input type="hidden" name="jml_pcs_krgpck[]" value="<?= $kpck['JUMLAH_PCS']?>"><?= $kpck['JUMLAH_PCS']?></td>
                                <td><input type="hidden" name="pic_krgpck[]" value="<?= $kpck['PIC_PENGELUARAN']?>"><?= $kpck['PIC_PENGELUARAN']?></td>
                                <td><input type="hidden" name="urgent_krgpck[]" value="<?= $kpck['URGENT']?> <?= $kpck['BON'] ?>"><?= $kpck['URGENT']?> <?= $kpck['BON'] ?></td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <table style="width: 50%;table-layout:fixed">
                <tbody>
                    <tr>
                        <th width="53.5%" style="padding-left:15px">Jumlah DOSP/SPB selesai</th>
                        <th><input type="hidden" name="jml_selesai[]" value="<?= $val['jml_selesai']?>">: <?= $val['jml_selesai'] ?> pcs</th>
                    </tr>
                    <tr>
                        <th style="padding-left:15px">Kekurangan DOSP/SPB selesai</th>
                        <th><input type="hidden" name="krg_selesai[]" value="<?= $val['krg_selesai']?>">: <?= $val['krg_selesai'] ?> pcs</th>
                    </tr>
                    <tr>
                        <th style="padding-left:15px">DOSP / SPB cancel hari ini</th>
                        <th>: <?= $val['cancel'] ?> lembar</th>
                    </tr>
                    <tr>
                        <th style="padding-left:15px">Penerimaan menyelesaikan</th>
                        <th>: <?= $val['jml_gd'] ?> lembar</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> 
</div> 
<?php $num++; $i++; } } ?>

<div class="col-md-12 text-right">
    <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-download"> Download</i></button>
</div>