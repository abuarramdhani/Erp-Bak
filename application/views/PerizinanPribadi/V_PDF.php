<?php
setlocale(LC_TIME, 'id_ID.utf8');
set_time_limit(0);
ini_set("memory_limit", "2048M");
if ($perseksi == 'Tidak') {
    $warna = '#20ab2e';
} else {
    $warna = '#f29e1f';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <table class="table" style="width: 100px; border-collapse: collapse" border="1">
        <thead>
            <tr style="background-color: <?= $warna ?>;">
                <th>No</th>
                <?= $perseksi == 'Tidak' ? '<th>Form Manual</th>
                                            <th>Sistem</th>
                                            <th>Set by</th>' : ''; ?>
                <th>ID Izin</th>
                <th>Tgl Pengajuan</th>
                <th>Pekerja</th>
                <th>Seksi</th>
                <th>Jenis Izin</th>
                <th>Waktu Keluar</th>
                <th>Atasan Approved</th>
                <th>Keterangan</th>
                <th>Status</th>
                <?php if ($jenis == '2') { ?>
                    <th>Poin</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            if (!empty($IzinApprove)) {
                foreach ($IzinApprove as $row) { ?>
                    <tr>
                        <td style="white-space: nowrap;"><?= $no; ?></td>
                        <?php if ($perseksi == 'Tidak') { ?>
                            <td style="white-space: nowrap;"><?php if ($row['manual'] == null) {
                                                                    echo '';
                                                                } else {
                                                                    echo $row['manual'] == 'f' ? 'Tidak' : 'Ya';
                                                                } ?></td>
                            <td style="white-space: nowrap;"><?php if ($row['manual'] == null) {
                                                                    echo '';
                                                                } else {
                                                                    echo 'Ya';
                                                                } ?></td>
                            <td style="white-space: nowrap;"><?= $row['set_manual'] ?></td>
                        <?php } ?>
                        <td style="white-space: nowrap;"><?= $row['id'] ?></td>
                        <td style="white-space: nowrap;"><?= strftime('%d %B %Y', strtotime($row['created_date'])); ?></td>
                        <td style="white-space: nowrap;">
                            <?php foreach (explode(',', $row['nama_pkj']) as $key) : ?>
                                <p style="display: block;"><?= $key ?></p>
                            <?php endforeach; ?>
                        </td>
                        <?php if ($jenis == '2') { ?>
                            <td style="text-align: left; white-space: nowrap;"><?= $row['seksi'] ?></td>
                        <?php } else { ?>
                            <td style="white-space: nowrap;">
                                <?php foreach (explode(',', $row['kodesie']) as $key) :
                                    foreach ($seksi as $value) {
                                        if ($key == $value['kodesie']) { ?>
                                            <p><?= $value['seksi'] ?></p>
                                <?php }
                                    }
                                endforeach ?>
                            </td>
                        <?php } ?>
                        <td style="text-align: left; white-space: nowrap;"><?= $row['jenis_ijin'] ?></td>
                        <td style="text-align: left; white-space: nowrap;"><?= $row['keluar'] ?></td>
                        <td style="white-space: nowrap;"><?= $row['atasan'] ?></td>
                        <td><?= $row['keperluan'] ?></td>
                        <td style="white-space: nowrap;"><?= $row['status']; ?></td>
                        <?php if ($jenis == '2') { ?>
                            <td style="white-space: nowrap;"><?php if (date("Y-m-d", strtotime($row['created_date'])) == date("Y-m-d") && empty($row['point'])) {
                                                                    echo '-';
                                                                } elseif (date("Y-m-d", strtotime($row['created_date'])) <= date("Y-m-d") && empty($row['point'])) {
                                                                    echo '0';
                                                                } else {
                                                                    echo $row['point'];
                                                                } ?></td>
                        <?php } ?>
                    </tr>
            <?php
                    $no++;
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>