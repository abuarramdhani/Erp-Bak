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

    .heightdong {
        height: 80px;
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
            <?php if ($row  < 2 || $row == 2) { ?>
                <?php foreach ($image as $key => $img) { ?>
                    <tr>
                        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">
                            <img style="max-width:300px;padding:10px;max-height:300px" src="<?= base_url('/assets/upload/DatabaseHandling/fotolinier' .  $img['id_handling'] . $img['urutan'] . '.png'); ?>">
                        </td>
                        <?php if ($key == 0) { ?>
                            <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;vertical-align:top" rowspan="<?= $row ?>">
                                <?php
                                $ketdb = str_replace("\n", "<br>", $dataHandling[0]['keterangan']);
                                echo $ketdb;
                                ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">
                        <img style="max-width:300px;padding:10px;max-height:300px" src="<?= base_url('/assets/upload/DatabaseHandling/fotolinier' .  $image[0]['id_handling'] . $image[0]['urutan'] . '.png'); ?>">
                    </td>
                    <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">
                        <img style="max-width:300px;padding:10px;max-height:300px" src="<?= base_url('/assets/upload/DatabaseHandling/fotolinier' .  $image[2]['id_handling'] . $image[2]['urutan'] . '.png'); ?>">
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">
                        <img style="max-width:300px;padding:10px;max-height:300px" src="<?= base_url('/assets/upload/DatabaseHandling/fotolinier' .  $image[1]['id_handling'] . $image[1]['urutan'] . '.png'); ?>">
                    </td>
                    <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;vertical-align:top">
                        <?php
                        $ketdb = str_replace("\n", "<br>", $dataHandling[0]['keterangan']);
                        echo $ketdb;
                        ?>
                    </td>
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
                        <img style="max-width:300px;padding:10px;max-height:300px" src="<?= base_url('/assets/upload/DatabaseHandling/fotononlinier' .  $img['id_handling'] . $img['urutan'] . '.png') ?>">
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
<div style="width: 100%; border:1px solid black; border-collapse: collapse;border-top:none;">
    <p style="font-size: 10pt;margin-left:10px;">Alur Proses &nbsp; :</p>
    <?php if ($dataHandling[0]['proses'] == 'Linear') { ?>
        <table style="width:100%;text-align:center">
            <tr>
                <?php $r = 0;
                $count = sizeof($array_proses);
                if ($count < 3 || $count == 3) {
                    $style_kotak = "width:40mm";
                    $style_arrow = "width:10mm";
                    $font = "10pt";
                } else if (3 < $count && $count <= 6) {
                    $style_kotak = "width:25mm";
                    $style_arrow = "width:7mm";
                    $font = "9pt";
                } else if (6 < $count && $count <= 8) {
                    $style_kotak = "width:17mm";
                    $style_arrow = "width:7mm";
                    $font = "8pt";
                } else {
                    $style_kotak = "width:12mm";
                    $style_arrow = "width:7mm";
                    $font = "6pt";
                }

                foreach ($array_proses as $fu) { ?>
                    <?php if ($r == 0) { ?>
                        <th class="heightdong" style="border: 1px solid black;border-collapse: collapse;background-color:<?= $fu['warna'] ?>;<?= $style_kotak ?>">
                            <h5 style="font-size: <?= $font ?>; text-align:center"><?= $fu['seksi'] ?></h5>
                        </th>
                    <?php } else { ?>
                        <th class="heightdong">
                            <h5 style="font-size: 10pt; text-align:center;<?= $style_arrow ?>">→</h5>
                        </th>
                        <th class="heightdong" style="border: 1px solid black;border-collapse: collapse;background-color:<?= $fu['warna'] ?>;<?= $style_kotak ?>">
                            <h5 style="font-size: <?= $font ?>; text-align:center"><?= $fu['seksi'] ?></h5>
                        </th>
                    <?php } ?>
                <?php $r++;
                } ?>
            </tr>
        </table>
    <?php } else { ?>
        <div style="text-align: center;padding:20px"><img style="width:300px;height:300px" src="<?= base_url('/assets/upload/DatabaseHandling/prosesnonlinier' . $dataHandling[0]['id_handling'] . '.png') ?>"></div>
    <?php } ?>

</div>