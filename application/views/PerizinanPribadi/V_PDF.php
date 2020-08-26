<?php
setlocale(LC_TIME, 'id_ID.utf8');
set_time_limit(0);
ini_set("memory_limit", "2048M");
if ($jenis == '1') {
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
                <th>ID Izin</th>
                <th>Tgl Pengajuan</th>
                <th>Pekerja</th>
                <th>Jenis Izin</th>
                <th>Atasan Approved</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($IzinApprove as $row) { ?>
                <tr>
                    <td style="white-space: nowrap;"><?php echo $no; ?></td>
                    <td style="white-space: nowrap;"><?php echo $row['id'] ?></td>
                    <td style="white-space: nowrap;"><?= strftime('%d %B %Y', strtotime($row['created_date'])); ?></td>
                    <td style="white-space: nowrap;">
                        <?php foreach (explode(',', $row['nama_pkj']) as $key) : ?>
                            <p style="display: block;"><?= $key ?></p>
                        <?php endforeach; ?>
                    </td>
                    <td style="text-align: left; white-space: nowrap;"><?php echo $row['jenis_ijin'] ?></td>
                    <td style="white-space: nowrap;"><?= $row['atasan'] . ' - ' . $row['nama_atasan'] ?></td>
                    <td style="white-space: nowrap;"><?php echo $row['ket_pekerja'] ?></td>
                    <td style="white-space: nowrap;"><?php echo $row['status']; ?></td>
                </tr>
            <?php
                $no++;
            }
            ?>
        </tbody>
    </table>
</body>

</html>