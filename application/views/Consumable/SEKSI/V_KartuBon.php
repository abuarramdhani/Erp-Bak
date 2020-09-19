<style>
    .haha {
        height: 27px;
    }

    table {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<table style="width: 100%; margin-top: 40px; border: 1px solid black; border-collapse: collapse;">
    <tr>
        <td rowspan="4" style="width: 12%; padding-top: 5px; padding-bottom: 5px; border: 1px solid black; border-collapse: collapse; border-right:none" align="center">
            <img style="height:79px" src="<?php echo base_url('assets/img/quick.jpg') ?>">
        </td>
        <td rowspan="2" style="width: 30%;">
            <p style="font-size: 11px;"><strong>CV. KARYA HIDUP SENTOSA</strong></p>
            <p style="font-size: 9px;">Jl. Magelang No. 144 YOGYAKARTA</p>
            <br />
        </td>
        <td rowspan="2" style="width: 8%; padding-left: 30px;">
            <b style="font-size: 45px; color: red;">CSM</b>
        </td>
        <td rowspan="4" style="width: 8%; border: 1px solid black; border-collapse: collapse; text-align: center;border-left:none">
            <img style="width:80px;height:80px;" src="<?= base_url('/assets/upload/Consumable/' . $array_pdf[0]['no_bon'] . '.png') ?>" />
        </td>
        <td style="width: 20%;font-size: 10px;border: 1px solid black; border-collapse: collapse;">&nbsp;Tanggal :&nbsp;<strong><?= date('d M Y') ?></strong>
        </td>
        <td style="width: 20%;font-size: 10px;border: 1px solid black; border-collapse: collapse;">&nbsp;No : &nbsp;<strong><?= $array_pdf[0]['no_bon'] ?></strong>
        </td>
    </tr>
    <tr>
        <td style="width: 20%;font-size: 8px;border: 1px solid black; border-collapse: collapse;border-bottom:none">&nbsp;Seksi Pengebon :</td>
        <td style="width: 20%;font-size: 8px;">&nbsp;Pengebonan ke Gudang :</td>
    </tr>
    <tr>
        <td rowspan="2" colspan="2" align="left" style="width: 20%;font-size: 10px; border: 1px solid black; border-collapse: collapse;border-top:none;border-left:none;border-right:none">&nbsp; <strong>
                <p style="font-size: 14px;"><strong>BUKTI PERMINTAAN & PEMAKAIAN BARANG GUDANG (BPPBG)</strong></p>
            </strong>
        </td>
        <td align="center" style="white-space: nowrap; width: 20%;font-size: 10px;border: 1px solid black; border-collapse: collapse;border-top:none">&nbsp; <strong><?= $array_pdf[0]['seksi_pengebon'] ?></strong>
        </td>
        <td align="center" style="width: 20%;font-size: 10px;border: 1px solid black; border-collapse: collapse;border-top:none">&nbsp;<strong><?= $array_pdf[0]['bonkegudang'] ?></strong>
        </td>
    </tr>
    <tr>
        <td style="width: 20%;font-size: 8px;border: 1px solid black; border-collapse: collapse; border-bottom:none">&nbsp; Seksi Pemakai :</td>
        <td style="width: 20%;font-size: 8px;border: 1px solid black; border-collapse: collapse;border-bottom:none">&nbsp;Cost Center/ Branch :</td>
    </tr>
    <tr>
        <td colspan="4" style="border: 1px solid black; border-collapse: collapse; font-size: 11px; height: 30px;">
            &nbsp;Untuk : &nbsp;<strong> <?= $array_pdf[0]['untuk'] ?></strong>
        </td>
        <td align="center" style="width: 10%;font-size: 10px;border: 1px solid black; border-collapse: collapse;border-top:none">&nbsp; <strong><?= $array_pdf[0]['seksi_pemakai'] ?></strong>
        </td>
        <td align="center">
            <strong style="font-size: 11px;"><?= $array_pdf[0]['seksi_pemakai'] ?> / <?= $array_pdf[0]['branch'] ?> </strong></td>
    </tr>
</table>
<table style="border: 1px solid black; border-collapse: collapse;width: 100%;border-top:none">
    <tr>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt;border-top:none;width:4%" rowspan="2">No</th>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt;border-top:none;width:15%" rowspan="2">Item</th>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt;border-top:none;width:30%" rowspan="2">Deskripsi</th>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt;border-top:none" rowspan="2">Satuan</th>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt;border-top:none" colspan="2">Qty</th>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt;border-top:none" rowspan="2">Keterangan Pemakaian</th>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt;border-top:none" rowspan="2">Account</th>
    </tr>
    <tr>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt">Diminta</th>
        <th style="border: 1px solid black; border-collapse: collapse;font-size: 9pt">Diserahkan</th>

    </tr>
    <?php $no = 1;
    foreach ($array_pdf as $value) { ?>
        <tr>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt;">
                <center><?= $no ?></center>
            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">
                <center><?= $value['item'] ?></center>
            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt;padding-left:7px">
                <?= $value['nama_barang'] ?>
            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">
                <center><?= $value['satuan'] ?></center>
            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">
                <center><?= $value['qty_bon'] ?></center>
            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">
            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">
                <center>Untuk kebutuhan periode <?= $array_pdf[0]['periodebon'] ?></center>
            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt"><?= $value['account'] ?></td>
        </tr>
    <?php
        $no++;
    }

    $nom = $no - 1;

    if ($nom <= 10) {
        $tr = 10 - $nom;
        for ($a = 0; $a < $tr; $a++) {
            echo '<tr>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">

            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">

            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt;padding-left:7px">

            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">

            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">

            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt">
            </td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt"></td>
            <td class="haha" style="border: 1px solid black; border-collapse: collapse;font-size: 8pt"></td>

        </tr>';
        }
    }
    ?>
</table>