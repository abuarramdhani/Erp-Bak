<div class="box-body box-report">
    <div class="table-responsive">
        Lampiran Order
        <br/>
        <?php if ($order[0]['layout_alat_mesin'] != null){ ?>
            <table class="table" style="padding-bottom: 0; margin-bottom: 0;">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Layout Alat/Mesin :</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                        <?php if($order[0]['ext_layout'] == 'pdf'){ ?>
                            <a href="<?= base_url($order[0]['layout_alat_mesin']) ?>">Klik untuk preview <?= $order[0]['filename_layout'] ?></a>
                        <?php }else { ?>
                            <img style="width: 70%" src="<?= base_url($order[0]['layout_alat_mesin']) ?>">
                        <?php }
                        ?>
                        <!-- <iframe frameborder="0" class="mt-1" style="width:100%;height:350px" src="<?= base_url($order[0]['layout_alat_mesin']) ?>"></iframe> -->
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
        <!-- <br/> -->
        <?php if ($order[0]['dokumen_target'] != null){ ?>
            <table class="table" style="padding-bottom: 0; margin-bottom: 0;">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Target :</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                        <?php if($order[0]['ext_target'] == 'pdf'){ ?>
                            <a href="<?= base_url($order[0]['dokumen_target']) ?>">Klik untuk preview <?= $order[0]['filename_target'] ?></a>
                        <?php }else { ?>
                            <img style="width: 70%" src="<?= base_url($order[0]['dokumen_target']) ?>">
                        <?php }
                        ?>
                        <!-- <iframe frameborder="0" class="mt-1" style="width:100%;height:350px" src="<?= base_url($order[0]['dokumen_target']) ?>"></iframe> -->
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
        <!-- <br/> -->
        <?php if ($order[0]['dokumen_kondisi_sebelum'] != null){ ?>
            <table class="table" style="padding-bottom: 0; margin-bottom: 0;">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Kondisi Sebelum :</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                        <?php if($order[0]['ext_kondisi_sebelum'] == 'pdf'){ ?>
                            <a href="<?= base_url($order[0]['dokumen_kondisi_sebelum']) ?>">Klik untuk preview <?= $order[0]['filename_kondisi_sebelum'] ?></a>
                        <?php }else { ?>
                            <img style="width: 70%" src="<?= base_url($order[0]['dokumen_kondisi_sebelum']) ?>">
                        <?php }
                        ?>
                        <!-- <iframe frameborder="0" class="mt-1" style="width:100%;height:350px" src="<?= base_url($order[0]['dokumen_kondisi_sebelum']) ?>"></iframe> -->
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
        <!-- <br/> -->
        <?php if ($order[0]['dokumen_kondisi_sesudah'] != null){ ?>
            <table class="table" style="padding-bottom: 0; margin-bottom: 0;">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Kondisi Sesudah :</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                        <?php if($order[0]['ext_kondisi_sesudah'] == 'pdf'){ ?>
                            <a href="<?= base_url($order[0]['dokumen_kondisi_sesudah']) ?>">Klik untuk preview <?= $order[0]['filename_kondisi_sesudah'] ?></a>
                        <?php }else { ?>
                            <img style="width: 70%" src="<?= base_url($order[0]['dokumen_kondisi_sesudah']) ?>">
                        <?php }
                        ?>
                        <!-- <iframe frameborder="0" class="mt-1" style="width:100%;height:350px" src="<?= base_url($order[0]['dokumen_kondisi_sesudah']) ?>"></iframe> -->
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
        <!-- <br/> -->
        <?php if ($order[0]['dokumen_ket_pelengkap'] != null){ ?>
            <table class="table" style="padding-bottom: 0; margin-bottom: 0;">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Keterangan Pelengkap :</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                        <?php if($order[0]['ext_ket_pelengkap'] == 'pdf'){ ?>
                            <a href="<?= base_url($order[0]['dokumen_ket_pelengkap']) ?>">Klik untuk preview <?= $order[0]['filename_ket_pelengkap'] ?></a>
                        <?php }else { ?>
                            <img style="width: 70%" src="<?= base_url($order[0]['dokumen_ket_pelengkap']) ?>">
                        <?php }
                        ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
        <!-- <br/> -->
        <?php if ($order[0]['dokumen_otorisasi'] != null){ ?>
            <table class="table" style="padding-bottom: 0; margin-bottom: 0;">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Dokumen Otorisasi :</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                        <?php if($order[0]['ext_otorisasi'] == 'pdf'){ ?>
                            <a href="<?= base_url($order[0]['dokumen_otorisasi']) ?>">Klik untuk preview <?= $order[0]['filename_otorisasi'] ?></a>
                        <?php }else { ?>
                            <img style="width: 70%" src="<?= base_url($order[0]['dokumen_otorisasi']) ?>">
                        <?php }
                        ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>