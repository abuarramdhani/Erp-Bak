<style>
.table-utama. {
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
            <th style="vertical-align:middle;width:12%;">
                <center>Cabang</center>
            </th>
            <th style="vertical-align:middle;">
                <center>Pencapaian Target Penjualan / Aktivitas</center>
            </th>
            <th style="vertical-align:middle;width:16%;">
                <center>Problem</center>
            </th>
            <th style="vertical-align:middle;width:16%;">
                <center>Root Cause</center>
            </th>
            <th style="vertical-align:middle;width:16%;">
                <center>Action</center>
            </th>
            <th style="vertical-align:middle;width:12%">
                <center>Due Date</center>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($analisa as $value) { ?>
        <tr>
            <td style="vertical-align: middle;">
                <center><?= $value['BRANCH'] ?></center>
            </td>
            <td style="padding:10px;">
                <table style="width:100%" class="table-kedua">
                    <tbody>
                        <tr>
                            <th colspan="3" style="text-align:left;">Laju Penjualan</th>
                        </tr>
                        <tr>
                            <td>Rata2</td>
                            <td>
                                <center><?= $value['TOTAL_PER_HARI'] ?></center>
                            </td>
                            <td>/ hari</td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>
                                <center><?= $value['TARGET_PER_HARI'] ?></center>
                            </td>
                            <td>/ hari</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td colspan="2" rowspan="2" style="padding-left:5px">
                                <?php if ($value['TOTAL_PER_HARI'] < $value['TARGET_PER_HARI']) {
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
                                <center><?= $value['TOTAL'] ?></center>
                            </td>
                            <td>Unit</td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>
                                <center><?= $value['TARGET'] ?></center>
                            </td>
                            <td>Unit</td>
                        </tr>
                        <tr>
                            <td>Pencapaian</td>
                            <td>
                                <center><?= $value['PERBANDINGAN'] ?> %</center>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="padding:10px">
                <?= $value['PROBLEM'] ?>
            </td>
            <td style="padding:10px">
                <?= $value['ROOT_CAUSE'] ?>
            </td>
            <td style="padding:10px">
                <?= $value['ACTION'] ?>
            </td>
            <td style="padding:10px">
                <center><?= $value['DUE_DATE'] ?></center>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>