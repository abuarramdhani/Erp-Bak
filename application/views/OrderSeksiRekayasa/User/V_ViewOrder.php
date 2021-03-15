<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-dashboard"></i> 
                Lihat Order
            </h3>
            <div class="pull-right">
          		<a title="Export Pdf.."
           			class="btn btn-sm btn-info"
           			href="<?php echo base_url('OrderSeksiRekayasa/Pdf/'.$order[0]['id_order']); ?>">
              		<i class="fa fa-download"></i>
                    <b>CETAK</b>
          		</a>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table" style="border: 1px solid #000">
                    <tbody>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Nama Pengorder</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td style="border-top: 1px solid #000; border-right: 1px solid #000" width="35%"><?= $order[0]['nama'] ?><span class="pull-right">No. Induk: <?= $order[0]['no_induk'] ?></span></td>
                            <td style="border-top: 1px solid #000" width="13%"><b>No Order</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td style="border-top: 1px solid #000; border-right: 1px solid #000" width="35%"><?= $order[0]['id_order'] ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Seksi Pengorder</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td style="border-top: 1px solid #000; border-right: 1px solid #000" width="35%"><?= $order[0]['seksi'] ?></td>
                            <td style="border-top: 1px solid #000" width="13%"><b>Tanggal Order</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td style="border-top: 1px solid #000; border-right: 1px solid #000" width="35%"><?= date("d M Y", strtotime($order[0]['tanggal_order'])) ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Jenis Order</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td style="border-top: 1px solid #000; border-right: 1px solid #000" width="35%"><?= $order[0]['jenis_order'] ?></td>
                            <td style="border-top: 1px solid #000" width="13%"><b>Tanggal Estimasi Selesai</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td style="border-top: 1px solid #000; border-right: 1px solid #000" width="35%"><?= date("d M Y", strtotime($order[0]['tanggal_estimasi_selesai'])) ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Nama Alat/Mesin</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['nama_alat_mesin'] ?></td>
                        </tr>
                        <?php if($order[0]['jenis_order'] == 'MEMBUAT ALAT/MESIN' || $order[0]['jenis_order'] == 'OTOMASI'){ ?>
                            <tr>
                                <td style="border-top: 1px solid #000" width="13%"><b>Jumlah Alat/Mesin</b></td>
                                <td style="border-top: 1px solid #000" width="2%">:</td>
                                <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['jumlah_alat_mesin'] ?></td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000" width="13%"><b>Spesifikasi Alat/Mesin</b></td>
                                <td style="border-top: 1px solid #000" width="2%">:</td>
                                <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['spesifikasi_alat_mesin'] ?></td>
                            </tr>
                        <?php }else if ($order[0]['jenis_order'] == 'MODIFIKASI ALAT/MESIN' || $order[0]['jenis_order'] == 'REBUILDING MESIN') { ?>
                            <tr>
                                <td style="border-top: 1px solid #000" width="13%"><b>Nomor Alat/Mesin</b></td>
                                <td style="border-top: 1px solid #000" width="2%">:</td>
                                <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['nomor_alat_mesin'] ?></td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000" width="13%"><b>Jumlah Alat/Mesin</b></td>
                                <td style="border-top: 1px solid #000" width="2%">:</td>
                                <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['jumlah_alat_mesin'] ?></td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000" width="13%"><b>Tipe Alat/Mesin</b></td>
                                <td style="border-top: 1px solid #000" width="2%">:</td>
                                <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['tipe_alat_mesin'] ?></td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000" width="13%"><b>Fungsi Alat/Mesin</b></td>
                                <td style="border-top: 1px solid #000" width="2%">:</td>
                                <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['fungsi_alat_mesin'] ?></td>
                            </tr>
                        <?php }else if ($order[0]['jenis_order'] == 'HANDLING MESIN') { ?>
                            <tr>
                                <td style="border-top: 1px solid #000" width="13%"><b>Jumlah Alat/Mesin</b></td>
                                <td style="border-top: 1px solid #000" width="2%">:</td>
                                <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['jumlah_alat_mesin'] ?></td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000" width="13%"><b>Layout Alat/Mesin</b></td>
                                <td style="border-top: 1px solid #000" width="2%">:</td>
                                <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                                    <iframe frameborder="0" class="mt-1" style="width:100%;height:250px" src="<?= base_url($order[0]['layout_alat_mesin']) ?>"></iframe>
                                    <!-- <img style="width: 70%" src="<?= base_url($order[0]['layout_alat_mesin']) ?>"> -->
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Benefit</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['benefit'] ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Target</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                                <?= $order[0]['target'] ?>
                                <?php if ($order[0]['dokumen_target'] != null) { ?>
                                <div><br/></div>
                                <div class="text-left">
                                <!-- <img style="width: 70%" src="<?= base_url($order[0]['dokumen_target']) ?>"> -->
                                    <iframe frameborder="0" class="mt-1" style="width:100%;height:250px" src="<?= base_url($order[0]['dokumen_target']) ?>"></iframe>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Kondisi Sebelum</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                                <?= $order[0]['kondisi_sebelum'] ?>
                                <?php if ($order[0]['dokumen_kondisi_sebelum'] != null) { ?>
                                <div><br/></div>
                                <div class="text-left">
                                <!-- <img style="width: 70%" src="<?= base_url($order[0]['dokumen_kondisi_sebelum']) ?>"> -->
                                    <iframe frameborder="0" class="mt-1" style="width:100%;height:250px" src="<?= base_url($order[0]['dokumen_kondisi_sebelum']) ?>"></iframe>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Kondisi Sesudah</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                                <?= $order[0]['kondisi_sesudah'] ?>
                                <?php if ($order[0]['dokumen_kondisi_sesudah'] != null) { ?>
                                <div><br/></div>
                                <div class="text-left">
                                <!-- <img style="width: 70%" src="<?= base_url($order[0]['dokumen_kondisi_sesudah']) ?>"> -->
                                    <iframe frameborder="0" class="mt-1" style="width:100%;height:250px" src="<?= base_url($order[0]['dokumen_kondisi_sesudah']) ?>"></iframe>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php if ($order[0]['dokumen_ket_pelengkap'] != null) { ?>
                        <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Proposal Pengadaan Asset</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                                <div class="text-left">
                                    <iframe frameborder="0" class="mt-1" style="width:100%;height:250px" src="<?= base_url($order[0]['dokumen_ket_pelengkap']) ?>"></iframe>
                                </div>
                                
                            </td>
                        </tr>
                        <?php } ?>
                        <?php if ($order[0]['dokumen_otorisasi'] != null){ ?>
                            <tr>
                            <td style="border-top: 1px solid #000" width="13%"><b>Dokumen Otorisasi</b></td>
                            <td style="border-top: 1px solid #000" width="2%">:</td>
                            <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                                <div class="text-left">
                                    <iframe frameborder="0" class="mt-1" style="width:100%;height:250px" src="<?= base_url($order[0]['dokumen_otorisasi']) ?>"></iframe>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>