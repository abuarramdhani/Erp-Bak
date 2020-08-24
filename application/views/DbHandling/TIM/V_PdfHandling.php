<style>
    table {
        font-family: Arial, Helvetica, sans-serif;
    }

    td {
        height: 30px;
    }

    .div1 {
        position: relative;
        float: right;
        left: -50%;

    }

    .div2 {
        position: relative;
        left: 50%;
    }

    div {
        font-family: Arial, Helvetica, sans-serif;
    }

    .heighttr {
        height: 100px;
    }
</style>
<table style="width: 100%;border:1px solid black;border-collapse:collapse;border-top:none;page-break-inside:avoid">
    <tr>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center;width:50%"><strong>Gambar</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center;"><strong>Keterangan</strong></td>
    </tr>
    <?php if ($dataHandling[0]['proses'] == 'Linear') { ?>
        <?php if ($image != null) {
            $row = sizeof($image); ?>
            <?php foreach ($image as $key => $img) { ?>
                <tr>
                    <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">
                        <img style="max-width:300px;padding:10px;max-height:300px" src="<?php echo base_url('assets/upload/DatabaseHandling/fotolinier' . $img['id_handling'] . $img['urutan'] . '.png'); ?>">
                    </td>
                    <?php if ($key == 0) { ?>
                        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;vertical-align:top" rowspan="<?= $row ?>"><?= $dataHandling[0]['keterangan'] ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">Tidak Ada Foto</td>
                <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;vertical-align:top"><?= $dataHandling[0]['keterangan'] ?></td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <?php if ($image != null) {
            $row = sizeof($image); ?>
            <?php foreach ($image as $key => $img) { ?>
                <tr>
                    <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">
                        <img style="max-width:300px;padding:10px;max-height:300px" src="<?php echo base_url('assets/upload/DatabaseHandling/fotononlinier' . $img['id_handling'] . $img['urutan'] . '.png'); ?>">
                    </td>
                    <?php if ($key == 0) { ?>
                        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;vertical-align:top" rowspan="<?= $row ?>"><?= $dataHandling[0]['keterangan'] ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">Tidak Ada Foto</td>
                <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;vertical-align:top"><?= $dataHandling[0]['keterangan'] ?></td>
            </tr>
        <?php } ?>
    <?php } ?>

</table>
<div style="width: 100%; border:1px solid black; border-collapse: collapse;border-top:none;padding-left:10px;">
    <p style="font-size: 10pt;">Alur Proses &nbsp; :</p>
    <?php if ($dataHandling[0]['proses'] == 'Linear') { ?>
        <div class="div1">
            <div class="div2">
                <?php $r = 0;
                $count = sizeof($array_proses);
                if ($count == 3) {
                    $style_kotak = "float:left;margin-bottom:4mm;width:40mm";
                    $style_arrow = "float:left;margin-bottom:4mm;width:10mm";
                    $font = "10pt";
                } else if (3 < $count && $count <= 6) {
                    $style_kotak = "float:left;margin-bottom:4mm;width:25mm";
                    $style_arrow = "float:left;margin-bottom:4mm;width:7mm";
                    $font = "9pt";
                } else if (6 < $count && $count <= 8) {
                    $style_kotak = "float:left;margin-bottom:4mm;width:17mm";
                    $style_arrow = "float:left;margin-bottom:4mm;width:7mm";
                    $font = "8pt";
                } else {
                    $style_kotak = "float:left;margin-bottom:4mm;width:12mm";
                    $style_arrow = "float:left;margin-bottom:4mm;width:7mm";
                    $font = "6pt";
                }
                foreach ($array_proses as $fu) { ?>
                    <?php if ($r == 0) { ?>
                        <div class="divproses2" style="display: none;">
                            <h5 style="font-size: 10pt; text-align:center">→</h5>
                        </div>
                        <div class="divproses" style=" border: 1px solid black;border-collapse: collapse;background-color:<?= $fu['warna'] ?>;<?= $style_kotak ?>">
                            <h5 style="font-size: <?= $font ?>; text-align:center;"><?= $fu['seksi'] ?></h5>
                        </div>
                    <?php } else { ?>
                        <div class="divproses2" style="<?= $style_arrow ?>">
                            <h5 style="font-size: 10pt; text-align:center;">→</h5>
                        </div>
                        <div class="divproses" style=" border: 1px solid black;border-collapse: collapse;background-color:<?= $fu['warna'] ?>;<?= $style_kotak ?>">
                            <h5 style="font-size: <?= $font ?>; text-align:center"><?= $fu['seksi'] ?></h5>
                        </div>
                    <?php } ?>
                <?php $r++;
                } ?>
            </div>
        </div>
    <?php } else { ?>
        <div style="text-align: center;padding:20px"><img style="width:300px;height:300px" src="<?php echo base_url('assets/upload/DatabaseHandling/prosesnonlinier' . $dataHandling[0]['id_handling'] . '.png'); ?>"></div>
    <?php } ?>

</div>