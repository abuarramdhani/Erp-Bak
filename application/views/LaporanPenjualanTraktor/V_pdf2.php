<style>
.table-utama {
    border-collapse: collapse;
}

.table-utama,
td,
th {
    border: 1px solid grey;
    font-size: 12px;
}

.table-kedua,
.table-kedua tbody td,
.table-kedua tbody th {
    border: unset;
}
</style>

<label>Analisa Penjualan<b> Cabang/Showroom</b></label><br>
<table width="100%" style="margin-top:10px;margin-bottom:50px;" class="table-utama">
    <thead>
        <tr>
            <th style="vertical-align:middle;width:8%;">
                <center>Cabang</center>
            </th>
            <th style="vertical-align:middle;">
                <center>Pencapaian Target Penjualan / Aktivitas</center>
            </th>
            <th style="vertical-align:middle;width:12%">
                <center>Tgl Input</center>
            </th>
            <th style="vertical-align:middle;width:15%;">
                <center>Problem</center>
            </th>
            <th style="vertical-align:middle;width:15%;">
                <center>Root Cause</center>
            </th>
            <th style="vertical-align:middle;width:15%;">
                <center>Action</center>
            </th>
            <th style="vertical-align:middle;width:12%">
                <center>Due Date</center>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if ($status == 0) {
            for ($i = 0; $i < count($analisa); $i++) { ?>
        <tr>
            <td style="vertical-align: middle;" rowspan="<?= count($analisa[$i]) ?>">
                <center><?= $namaCabang[$i] ?></center>
            </td>
            <td style="padding:10px;vertical-align: middle;" rowspan="<?= count($analisa[$i]) ?>">
                <?php if ($lajupenjualan[$i] != '-') { ?>
                <table style="width:100%" class="table-kedua">
                    <tbody>
                        <tr>
                            <th colspan="3" style="text-align:left;padding-bottom:10px">Laju Penjualan<br>
                                <label><?= date('F Y') ?></label>
                            </th>
                        </tr>
                        <tr>
                            <td>Rata2</td>
                            <td>
                                <center><?= $lajupenjualan[$i]['TOTAL_PER_HARI'] ?></center>
                            </td>
                            <td>/ hari</td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>
                                <center><?= $lajupenjualan[$i]['TARGET_PER_HARI'] ?></center>
                            </td>
                            <td>/ hari</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td colspan="2" rowspan="2" style="padding-left:5px">
                                <?php if ($lajupenjualan[$i]['TOTAL_PER_HARI'] < $lajupenjualan[$i]['TARGET_PER_HARI']) {
                                                echo 'Dibawah Target Laju Penjualan';
                                            } else {
                                                echo 'Diatas Target Laju Penjualan';
                                            } ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding:2px;"></td>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align:left;padding-bottom:10px">Penjualan per Bulan<br>
                                <label><?= date('F Y') ?></label>
                            </th>
                        </tr>
                        <tr>
                            <td>Akumulasi</td>
                            <td>
                                <center><?= $lajupenjualan[$i]['TOTAL'] ?></center>
                            </td>
                            <td>Unit</td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>
                                <center><?= $lajupenjualan[$i]['TARGET'] ?></center>
                            </td>
                            <td>Unit</td>
                        </tr>
                        <tr>
                            <td>Pencapaian</td>
                            <td colspan="2">
                                <center><?= $lajupenjualan[$i]['PERBANDINGAN'] ?> %</center>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php } else {
                            echo '-';
                        } ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <center><?php if ($analisa[$i] != NULL) {
                                    echo $analisa[$i][0]['DAYS'];
                                } ?></center>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?php if ($analisa[$i] != NULL) {
                            echo $analisa[$i][0]['PROBLEM'];
                        } ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?php if ($analisa[$i] != NULL) {
                            echo $analisa[$i][0]['ROOT_CAUSE'];
                        } ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?php if ($analisa[$i] != NULL) {
                            echo $analisa[$i][0]['ACTION'];
                        } ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <center><?php if ($analisa[$i] != NULL) {
                                    echo $analisa[$i][0]['DUE_DATE'];
                                } ?></center>
            </td>
        </tr>
        <?php if (count($analisa[$i]) > 1) {
                    for ($a = 1; $a < count($analisa[$i]); $a++) { ?>
        <tr>
            <td style="padding:10px;vertical-align: middle;">
                <center><?= $analisa[$i][$a]['DAYS'] ?></center>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?= $analisa[$i][$a]['PROBLEM'] ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?= $analisa[$i][$a]['ROOT_CAUSE'] ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?= $analisa[$i][$a]['ACTION'] ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <center><?= $analisa[$i][$a]['DUE_DATE'] ?></center>
            </td>
        </tr>
        <?php }
                }
            }
        }
        if ($status == 1) { ?>
        <tr>
            <td style="vertical-align: middle;" rowspan="<?= count($analisa) ?>">
                <center><?= $cabang ?></center>
            </td>
            <td style="padding:10px;vertical-align: middle;" rowspan="<?= count($analisa) ?>">
                <?php if ($infoDetail != '-') { ?>
                <table style="width:100%" class="table-kedua">
                    <tbody>
                        <tr>
                            <th colspan="3" style="text-align:left;">Laju Penjualan</th>
                        </tr>
                        <tr>
                            <td>Rata2</td>
                            <td>
                                <center><?= $infoDetail['TOTAL_PER_HARI'] ?></center>
                            </td>
                            <td>/ hari</td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>
                                <center><?= $infoDetail['TARGET_PER_HARI'] ?></center>
                            </td>
                            <td>/ hari</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td colspan="2" rowspan="2" style="padding-left:5px">
                                <?php if ($infoDetail['TOTAL_PER_HARI'] < $infoDetail['TARGET_PER_HARI']) {
                                            echo 'Dibawah Target Laju Penjualan';
                                        } else {
                                            echo 'Diatas Target Laju Penjualan';
                                        } ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding:2px;"></td>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align:left;">Penjualan per Bulan</th>
                        </tr>
                        <tr>
                            <td>Akumulasi</td>
                            <td>
                                <center><?= $infoDetail['TOTAL'] ?></center>
                            </td>
                            <td>Unit</td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>
                                <center><?= $infoDetail['TARGET'] ?></center>
                            </td>
                            <td>Unit</td>
                        </tr>
                        <tr>
                            <td colspan="2">Pencapaian</td>
                            <td>
                                <center><?= $infoDetail['PERBANDINGAN'] ?> %</center>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php } else {
                        echo '-';
                    } ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <center><?php if ($analisa != NULL) {
                                echo $analisa[0]['DAYS'];
                            } ?></center>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?php if ($analisa != NULL) {
                        echo $analisa[0]['PROBLEM'];
                    } ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?php if ($analisa != NULL) {
                        echo $analisa[0]['ROOT_CAUSE'];
                    } ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?php if ($analisa != NULL) {
                        echo $analisa[0]['ACTION'];
                    } ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <center>
                    <?php if ($analisa != NULL) {
                            echo $analisa[0]['DUE_DATE'];
                        } ?>
                </center>
            </td>
        </tr>
        <?php if (count($analisa) > 1) {
                for ($i = 1; $i < count($analisa); $i++) { ?>
        <tr>
            <td style="padding:10px;vertical-align: middle;">
                <center><?= $analisa[$i]['DAYS'] ?></center>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?= $analisa[$i]['PROBLEM'] ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?= $analisa[$i]['ROOT_CAUSE'] ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <?= $analisa[$i]['ACTION'] ?>
            </td>
            <td style="padding:10px;vertical-align: middle;">
                <center><?= $analisa[$i]['DUE_DATE'] ?></center>
            </td>
        </tr>
        <?php }
            }
        } ?>
    </tbody>
</table>