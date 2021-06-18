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
    font-size: 12px;
}
</style>

<label><b>Informasi Pasar</b> di Cabang/Showroom</label><br>
<table width="100%" style="margin-top:10px;margin-bottom:50px;" class="table-utama">
    <thead>
        <tr>
            <th style="vertical-align:middle;width:12%;">
                <center>Cabang</center>
            </th>
            <th style="vertical-align:middle;width:15%;">
                <center>Tanggal Input Data</center>
            </th>
            <th style="vertical-align:middle;">
                <center>Informasi Pasar (Tren Penjualan, Data Kompetitor, Kondisi Ekonomi, Musim)</center>
            </th>
            <th style="vertical-align:middle;width:25%;">
                <center>Lampiran Data</center>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($analisa as $value) { ?>
        <tr>
            <td style="vertical-align: middle;">
                <center><?= $value['BRANCH'] ?></center>
            </td>
            <td style="vertical-align: middle;">
                <center><?= $value['MARKET_CREATION_DATE'] ?></center>
            </td>
            <td style="vertical-align: middle;padding:10px;">
                <?= $value['MARKET_DESC'] ?>
            </td>
            <td style="padding:10px;">
                <?php $pathimg = explode(',', $value['ATTACHMENT']);
                    foreach ($pathimg as $row) {
                        $explodepath = explode('/', $row);
                        $end = explode('.', end($explodepath));

                        if (end($end) == 'png' || end($end) == 'jpg' || end($end) == 'jpeg') { ?>
                <img style="display:block;width:160px;margin:10px 0;" src="<?= $row ?>">
                <?php }
                        if (end($end) == 'xls' || end($end) == 'xlsx') {
                            echo '<a style="margin:10px 0" href="' . $row . '">link</a>';
                        }
                    }
                    ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>