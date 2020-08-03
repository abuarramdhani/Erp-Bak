<style>
    table {
        font-family: Arial, Helvetica, sans-serif;
    }

    td {
        height: 30px;
    }

    .divproses {
        width: 40mm;
        float: left;
        margin-left: 7mm;
        margin-bottom: 4mm;

    }

    .divproses2 {
        width: 20mm;
        float: left;
        margin-left: 7mm;
        margin-bottom: 4mm;

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
        <?php $row = sizeof($image);
        foreach ($image as $key => $img) { ?>
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
        <?php $row = sizeof($image);
        foreach ($image as $key => $img) { ?>
            <tr>
                <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;text-align:center">
                    <img style="max-width:300px;padding:10px;max-height:300px" src="<?php echo base_url('assets/upload/DatabaseHandling/fotononlinier' . $img['id_handling'] . $img['urutan'] . '.png'); ?>">
                </td>
                <?php if ($key == 0) { ?>
                    <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;vertical-align:top" rowspan="<?= $row ?>"><?= $dataHandling[0]['keterangan'] ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    <?php } ?>

</table>
<div style="width: 100%; border:1px solid black; border-collapse: collapse;border-top:none;padding-left:10px;">
    <p style="font-size: 10pt;">Alur Proses &nbsp; :</p>
    <?php if ($dataHandling[0]['proses'] == 'Linear') { ?>
        <?php $r = 0;
        foreach ($array_proses as $fu) { ?>
            <?php if ($r == 0) { ?>
                <div class="divproses2" style="display: none;">
                    <h5 style="font-size: 10pt; text-align:center">→</h5>
                </div>
                <div class="divproses" style=" border: 1px solid black;border-collapse: collapse;background-color:<?= $fu['warna'] ?>">
                    <h5 style="font-size: 10pt; text-align:center;"><?= $fu['seksi'] ?></h5>
                </div>
            <?php } else { ?>
                <div class="divproses2">
                    <h5 style="font-size: 10pt; text-align:center">→</h5>
                </div>
                <div class="divproses" style=" border: 1px solid black;border-collapse: collapse;background-color:<?= $fu['warna'] ?>">
                    <h5 style="font-size: 10pt; text-align:center"><?= $fu['seksi'] ?></h5>
                </div>
            <?php } ?>
        <?php $r++;
        } ?>
    <?php } else { ?>
        <div style="text-align: center;padding:20px"><img style="width:300px;height:300px" src="<?php echo base_url('assets/upload/DatabaseHandling/prosesnonlinier' . $dataHandling[0]['id_handling'] . '.png'); ?>"></div>
    <?php } ?>
</div>