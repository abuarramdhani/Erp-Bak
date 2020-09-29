<?php
setlocale(LC_TIME, 'id_ID.utf8');
set_time_limit(0);
ini_set("memory_limit", "2048M");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <table class="table" style="width: 100%; border-collapse: collapse" border="1">
        <thead>
            <tr style="background-color: #3cbd56;">
                <th>No</th>
                <th>Tanggal</th>
                <th>Pekerja</th>
                <th>Saran</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            if (!empty($data)) {
                foreach ($data as $row) { ?>
                    <tr>
                        <td style="white-space: nowrap;"><?= $no; ?></td>
                        <td style="white-space: nowrap;"><?= strftime('%d %B %Y', strtotime($row['created_date'])); ?></td>
                        <td style="text-align: left; white-space: nowrap;"><?= $row['noind'] ?></td>
                        <td style="text-align: left;"><?= $row['saran'] ?></td>
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