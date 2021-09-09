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
                                <!-- <div class="panel-body" id="tb_monitoring"></div> -->
                                <!-- <div class="alert  alert-dismissible filter_area"  style="border-radius:12px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4 class="theboldfont"><i class="icon fa fa-warning"></i> &nbsp; NB:</h4>
                                        <h6 style="font-size:13px;letter-spacing: 1px;line-height:1.4">
                                            <ul style="margin-top: 5px;margin-left: -23px;">
                                                <li>Mohon untuk Create MO berdasarkan <b>Seksi Penerima Barang</b></li>
                                            </ul>
                                        </h6>
                                    </div> -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-bordered table-fit tblMonPengembalian">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-center">No</th>
                                                <th><input type="checkbox" class="checkedAllPBGSeksi"></th>
                                                <th class="text-center">Tgl Pengembalian</th>
                                                <th class="text-center">Kode Komponen</th>
                                                <th class="text-center">Nama Komponen</th>
                                                <th class="text-center">Qty Komponen</th>
                                                <th class="text-center">Alasan Pengembalian</th>
                                                <!-- <th class="text-center">PIC Assembly</th>
                                                <th class="text-center">PIC Gudang</th> -->
                                                <th class="text-center">Status Verifikasi QC</th>
                                                <th class="text-center">Keterangan Verifikasi</th>
                                                <th class="text-center">Seksi Penerima Barang</th>
                                                <th class="text-center">MO Seksi</th>
                                                <!-- <th class="text-center">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 0; foreach ($getPengembalian as $v): 

                                            if ($v['MO_SEKSI'] == '0'){
                                                if($v['LT_GUDANG'] > 1){
                                                // if($v['LT_QC'] > 2 || $v['LT_GUDANG'] > 1){
                                                    $penanda = 'bg-danger';
                                                }else{
                                                    $penanda = '';
                                                }
                                            }else{
                                                $penanda = 'bg-success';
                                            }

                                        $no++
                                        ?>
                                            <tr>
                                                <td class="text-center <?= $penanda ?>"><?= $no; ?></td>
                                                <td class="text-center <?= $penanda ?>">
                                                    <input type="checkbox"  class="ch_komp_pbg_seksi" name="ch_komp_seksi[]" value="<?= $v['ID_PENGEMBALIAN'].'+'; ?>">
                                                    <!-- <input type="hidden" name="id_pengembalian[]" value="<?= $v['ID_PENGEMBALIAN'] ?>"> -->
                                                </td>
                                                <td class="text-center <?= $penanda ?>"><?= $v['TGL_INPUT']; ?></td>
                                                <td class="<?= $penanda ?>"><?= $v['KODE_KOMPONEN']; ?></td>
                                                <td class="<?= $penanda ?>"><?= $v['NAMA_KOMPONEN']; ?></td>
                                                <td class="text-center <?= $penanda ?>"><?= $v['QTY_KOMPONEN']; ?></td>
                                                <td class="<?= $penanda ?>"><?= $v['ALASAN_PENGEMBALIAN']; ?></td>
                                                <!-- <td class="<?= $penanda ?>"><?= $v['PIC_ASSEMBLY']; ?></td>
                                                <td class="<?= $penanda ?>"><?= $v['PIC_GUDANG']; ?></td> -->
                                                <td class="<?= $penanda ?>"><?= $v['STATUS_VERIFIKASI']; ?></td>
                                                <td class="<?= $penanda ?>"><?= $v['KETERANGAN']; ?></td>
                                                <td class="<?= $penanda ?>"><?= $v['LOCATOR']; ?></td>
                                                <td class="<?= $penanda ?>"><?= $v['MO_SEKSI_TAMPIL']; ?></td>
                                                <!-- <td class="text-center <?= $penanda ?>">
                                                    <a href="<?php echo base_url('PengembalianBarangGudang/Monitoring/CreateMOSeksi/'.$v['ID_PENGEMBALIAN']) ?>">
                                                        <button class="btn btn-sm <?= ($v['MO_SEKSI'] == '0') ? 'btn-danger' : 'btn-success' ?>" target="_blank">
                                                            <b><?= $text_button ?></b>
                                                        </button>
                                                    </a>
                                                </td> -->
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <form method="post" target="_blank" id="createallMOSeksi" action="<?php echo base_url('PengembalianBarangGudang/Monitoring/createallMOSeksi'); ?>">
                                        <input type="hidden" name="slcKompPBGSeksi" value="">
                                        <?php foreach ($getPengembalian as $key => $v) { ?>
                                        <input type="hidden" name="id_pengembalian[]" value="<?= $v['ID_PENGEMBALIAN'] ?>">
                                        <input type="hidden" name="id_komponen[]" value="<?= $v['INVENTORY_ITEM_ID'] ?>">
                                        <input type="hidden" name="kode_komponen[]" value="<?= $v['KODE_KOMPONEN'] ?>">
                                        <input type="hidden" name="nama_komponen[]" value="<?= $v['NAMA_KOMPONEN'] ?>">
                                        <input type="hidden" name="qty_komponen[]" value="<?= $v['QTY_KOMPONEN'] ?>">
                                        <input type="hidden" name="uom[]" value="<?= $v['UOM'] ?>">
                                        <input type="hidden" name="alasan_pengembalian[]" value="<?= $v['ALASAN_PENGEMBALIAN'] ?>">
                                        <input type="hidden" name="pic_assembly[]" value="<?= $v['PIC_ASSEMBLY'] ?>">
                                        <input type="hidden" name="pic_gudang[]" value="<?= $v['PIC_GUDANG'] ?>">
                                        <input type="hidden" name="status_verifikasi[]" value="<?= $v['STATUS_VERIFIKASI'] ?>">
                                        <input type="hidden" name="keterangan[]" value="<?= $v['KETERANGAN'] ?>">
                                        <input type="hidden" name="subinv[]" value="<?= $v['SUBINV_PENERIMA_BARANG'] ?>">
                                        <input type="hidden" name="locator[]" value="<?= $v['LOCATOR_PENERIMA_BARANG'] ?>">
                                        <?php } ?>
                                        <button type="button" class="btn btn-success pull-right" disabled="disabled" id="btnCreateMoSeksi" onclick="document.getElementById('createallMOSeksi').submit();">
                                            <b>Create MO Seksi </b><b id="jmlSlcPBGSeksi"></b>
                                        </button>
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