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
        <?php if ($status == 0) {
            for ($i = 0; $i < count($infoPasar); $i++) { ?>
        <tr>
            <td style="vertical-align: middle;" rowspan="<?= count($infoPasar[$i]) ?>">
                <center><?= $namaCabang[$i] ?></center>
            </td>
            <td style="vertical-align: middle;">
                <center><?= $infoPasar[$i][0]['DAYS'] ?></center>
            </td>
            <td style="vertical-align: middle;padding:10px;">
                <?= $infoPasar[$i][0]['DESCRIPTION'] ?>
            </td>
            <td style="padding:10px;">
                <?php $path = $infoPasar[$i][0]['ATTACHMENT'];
                        if ($path != '-') {
                            $explodepath = explode('/', $path);
                            $end = explode('.', end($explodepath));
                            if (end($end) == 'png' || end($end) == 'jpg' || end($end) == 'jpeg' || end($end) == 'JPG' || end($end) == 'PNG' || end($end) == 'JPEG') { ?>
                <img style="display:block;width:160px;margin:10px 0;" src="<?= $path ?>">
                <?php }
                            if (end($end) == 'xls' || end($end) == 'xlsx' || end($end) == 'XLS' || end($end) == 'XLSX') {
                                echo '<a style="margin:10px 0" href="' . $path . '">link</a>';
                            }
                        } else {
                            echo '-';
                        } ?>
            </td>
        </tr>
        <?php if (count($infoPasar[$i]) > 1) {
                    for ($a = 1; $a < count($infoPasar[$i]); $a++) { ?>
        <tr>
            <td style="vertical-align: middle;">
                <center><?= $infoPasar[$i][$a]['DAYS'] ?></center>
            </td>
            <td style="vertical-align: middle;padding:10px;">
                <?= $infoPasar[$i][$a]['DESCRIPTION'] ?>
            </td>
            <td style="padding:10px;">
                <?php $path = $infoPasar[$i][$a]['ATTACHMENT'];
                                if ($path != '-') {
                                    $explodepath = explode('/', $path);
                                    $end = explode('.', end($explodepath));
                                    if (end($end) == 'png' || end($end) == 'jpg' || end($end) == 'jpeg' || end($end) == 'JPG' || end($end) == 'PNG' || end($end) == 'JPEG') { ?>
                <img style="display:block;width:160px;margin:10px 0;" src="<?= $path ?>">
                <?php }
                                    if (end($end) == 'xls' || end($end) == 'xlsx' || end($end) == 'XLS' || end($end) == 'XLSX') {
                                        echo '<a style="margin:10px 0" href="' . $path . '">link</a>';
                                    }
                                } else {
                                    echo '-';
                                } ?>
            </td>
        </tr>
        <?php }
                }
            }
        }
        if ($status == 1) { ?>
        <tr>
            <td style="vertical-align: middle;" rowspan="<?= count($infoPasar) ?>">
                <center><?= $cabang ?></center>
            </td>
            <td style="vertical-align: middle;">
                <center><?= $infoPasar[0]['DAYS'] ?></center>
            </td>
            <td style="vertical-align: middle;padding:10px;">
                <?= $infoPasar[0]['DESCRIPTION'] ?>
            </td>
            <td style="padding:10px;">
                <?php $path = $infoPasar[0]['ATTACHMENT'];
                    if ($path != '-') {
                        $explodepath = explode('/', $path);
                        $end = explode('.', end($explodepath));
                        if (end($end) == 'png' || end($end) == 'jpg' || end($end) == 'jpeg' || end($end) == 'JPG' || end($end) == 'PNG' || end($end) == 'JPEG') { ?>
                <img style="display:block;width:160px;margin:10px 0;" src="<?= $path ?>">
                <?php }
                        if (end($end) == 'xls' || end($end) == 'xlsx' || end($end) == 'XLS' || end($end) == 'XLSX') {
                            echo '<a style="margin:10px 0" href="' . $path . '">link</a>';
                        }
                    } else {
                        echo '-';
                    } ?>
            </td>
        </tr>
        <?php if (count($infoPasar) > 1) {
                for ($a = 1; $a < count($infoPasar); $a++) { ?>
        <tr>
            <td style="vertical-align: middle;">
                <center><?= $infoPasar[$a]['DAYS'] ?></center>
            </td>
            <td style="vertical-align: middle;padding:10px;">
                <?= $infoPasar[$a]['DESCRIPTION'] ?>
            </td>
            <td style="padding:10px;">
                <?php $path = $infoPasar[$a]['ATTACHMENT'];
                            if ($path != '-') {
                                $explodepath = explode('/', $path);
                                $end = explode('.', end($explodepath));
                                if (end($end) == 'png' || end($end) == 'jpg' || end($end) == 'jpeg' || end($end) == 'JPG' || end($end) == 'PNG' || end($end) == 'JPEG') { ?>
                <img style="display:block;width:160px;margin:10px 0;" src="<?= $path ?>">
                <?php }
                                if (end($end) == 'xls' || end($end) == 'xlsx' || end($end) == 'XLS' || end($end) == 'XLSX') {
                                    echo '<a style="margin:10px 0" href="' . $path . '">link</a>';
                                }
                            } else {
                                echo '-';
                            } ?>
            </td>
        </tr>
        <?php }
            }
        } ?>
    </tbody>
</table>