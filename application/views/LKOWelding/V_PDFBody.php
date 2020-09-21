<table style="width:100%;font-family:Calibri">
    <tr>
        <td style="font-size:7pt;text-align : left"><strong>HARI / TGL : <?= $hari ?> / <?= $laporan[0]['TANGGAL'] ?></strong></td>
        <td style="font-size:7pt;text-align : left"><strong>SHIFT : <?= $laporan[0]['SHIFT'] ?></strong></td>
        <td style="font-size:7pt;text-align : left"><strong>HAL : </strong></td>
    </tr>
</table>
<table style="border: 1px solid black; border-collapse:collapse;width:100%;font-family:Calibri">
    <tr>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;" rowspan="2">NO</th>
        <th style="font-size:7pt;" rowspan="2">NO.INDUK</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;" rowspan="2">NAMA PEKERJA</th>
        <th style="font-size:7pt;" rowspan="2">URAIAN PEKERJAAN</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;" colspan="3">PENCAPAIAN</th>
        <th style="font-size:7pt;" rowspan="2">SHIFT</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;" rowspan="2">KETERANGAN</th>
        <th style="font-size:7pt;" colspan="8">KONDITE</th>
    </tr>
    <tr>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">TGT</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">ACT</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">%</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">MK</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">I</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">BK</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">TKP</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">KP</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">KS</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">KK</th>
        <th style="border: 1px solid black; border-collapse:collapse;font-size:7pt;">PK</th>
    </tr>
    <?php $n = 1;
    foreach ($laporan as $lko) { ?>
        <tr>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $n ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['NO_INDUK'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['NAMA_PEKERJA'] ?></td>
            <td style="text-align:left;padding-left:5px;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['URAIAN_PEKERJAAN'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['PENCAPAIAN_TGT'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['PENCAPAIAN_ACT'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['PENCAPAIAN_PERSEN'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['SHIFT'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KETERANGAN'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KONDITE_MK'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KONDITE_I'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KONDITE_BK'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KONDITE_TKP'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KONDITE_KP'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KONDITE_KS'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KONDITE_KK'] ?></td>
            <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><?= $lko['KONDITE_PK'] ?></td>
        </tr>
    <?php $n++;
    } ?>
</table>
<table style="border: 1px solid white; border-collapse:collapse;font-family:Calibri;margin-top:20px; width:100%">
    <tr>
        <td style="width: 70%;"></td>
        <td style="font-size:7pt;" colspan="2">Menyetujui,</td>
    </tr>
    <tr>
        <td style="width: 70%;"></td>
        <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;">Kepala Seksi</td>
        <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;">Ass.Ka.Unit</td>
    </tr>
    <tr>
        <td style="width: 70%;"></td>
        <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><br><br><br><br><br><br></td>
        <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><br><br><br><br><br><br></td>
    </tr>
    <tr>
        <td style="width: 70%;"></td>
        <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><br></td>
        <td style="text-align:center;border: 1px solid black; border-collapse:collapse;font-size:7pt;"><br></td>
    </tr>
</table>