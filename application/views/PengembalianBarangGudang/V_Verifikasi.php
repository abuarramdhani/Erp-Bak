<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-tv"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <table width="100%" class="table table-bordered table-fit tblMonPengembalian" id="tblMonPengembalian">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-center">No</th>
                                                <th class="text-center" style="display:none;">ID Pengembalian</th>
                                                <th class="text-center">Kode Komponen</th>
                                                <th class="text-center">Nama Komponen</th>
                                                <th class="text-center">Qty Komponen</th>
                                                <th class="text-center">Alasan Pengembalian</th>
                                                <th class="text-center">Status Verifikasi QC</th>
                                                <th class="text-center">Keterangan Verifikasi</th>
                                                <th class="text-center">Seksi Penerima Barang</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 0; foreach ($getPengembalian as $v): $no++
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no; ?></td>
                                                <td class="text-center" style="display:none;"><?= $v['ID_PENGEMBALIAN']; ?></td>
                                                <td><?= $v['KODE_KOMPONEN']; ?></td>
                                                <td><?= $v['NAMA_KOMPONEN']; ?></td>
                                                <td class="text-center"><?= $v['QTY_KOMPONEN']; ?></td>
                                                <td><?= $v['ALASAN_PENGEMBALIAN']; ?></td>
                                                <td>
                                                <?php if ($v['STATUS_VERIFIKASI'] == 'Menunggu Hasil Verifikasi QC') { ?>
                                                    <button class="label label-danger btn-real-ena faa-flash faa-slow animated" onclick="InputVerifQc('<?= $v['ID_PENGEMBALIAN']; ?>')">Input Hasil Verifikasi QC <b class="fa fa-arrow-right"></b>&nbsp;</button>
                                                <?php } elseif ($v['STATUS_VERIFIKASI'] == 'Belum Verifikasi') { ?>
                                                    <span class="label label-warning">Menunggu Gudang Create Order Verifikasi</span>
                                                <?php } else {?>
                                                    <?= $v['STATUS_VERIFIKASI']; ?>
                                                <?php } ?>
                                                </td>
                                                <td><?= $v['KETERANGAN']; ?></td>
                                                <td><?= $v['LOCATOR']; ?></td>
                                                <td>
                                                    <!-- <a class="btn btn-info btn-sm" onclick="btnUpdatePBG('<?= $v['ID_PENGEMBALIAN']?>')" data-toggle="modal" data-target="#editseksi"> -->
                                                    <a class="btn btn-info btn-sm" onclick="btnUpdatePBG('<?= $v['ID_PENGEMBALIAN']?>')">
                                                        <i class="fa fa-pencil"></i>&nbsp; Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <form method="POST" action="<?php echo base_url("VerifikasiPengembalianBarang/Verifikasi/exportDataBlmVerif")?>">
                                        <div class="text-center">
                                            <button type="submit" title="Export" class="btn btn-success"><i class="fa fa-download"></i> Export Excel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade bd-example-modal-md" id="editseksi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <div style="float:left">
                                    <h4 style="font-weight:bold;">Update Seksi Penerima Barang</h4>
                                </div>
                                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align:right">
                                                <label>Seksi Penerima Barang :</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select id="update_seksi" name="seksi" class="form-control select2" data-placeholder="Pilih Seksi Penerima Barang" style="width: 100%;">
                                                    <option value=""></option>
                                                    <option value="82">MACHINING A REJ</option>
                                                    <option value="83">MACHINING B REJ</option>
                                                    <option value="84">MACHINING C REJ</option>
                                                    <option value="85">MACHINING D REJ</option>
                                                    <option value="88">PAINTING REJ</option>
                                                    <option value="1017">AREA HTM</option>
                                                    <option value="1007">AREA WELDING</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="area-save-edit">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>