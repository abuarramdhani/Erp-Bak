<style>
    h4,
    h5 {
        text-align: center;
    }

    table {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        margin: auto;
    }

    th {
        border: 0.5px solid black;
        text-align: center;
    }

    td {
        border: 0.5px solid black;
    }
</style>
<h4>Monitoring Limbah</h4>
<h5>Periode : <?= $start . " s/d " . $end ?> </h5>
<!-- 
<?php ($seksi == null) ? "" : print "<h5>Seksi :" . implode(", ", $seksi) . "</h5>" ?> -->

<table id="tableLimbah" class="table table-bordered table-striped">
    <thead class="bg-primary ">
        <tr>
            <th>No</th>
            <th>Jenis Limbah</th>
            <th>Pekerja Pengirim</th>
            <th>Tanggal Masuk</th>
            <th>Waktu</th>
            <th>Seksi Pengirim</th>
            <th>Jumlah Limbah</th>
            <th>Berat(Kg)</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($data as $data) : ?>
            <tr>
                <td style="text-align: center;"><?= $i++ ?></td>
                <td><?= $data['jenis_limbah'] ?></td>
                <td><?= $data['pekerja'] ?></td>
                <td style="text-align: center;"><?= $data['tanggal_kirim'] ?></td>
                <td style="text-align: center;"><?= $data['waktu'] ?></td>
                <td><?= $data['section_name'] ?></td>
                <td><?= $data['jumlahall'] ?></td>
                <td style="text-align: right;"><?= floatval($data['berat_kirim']) ?></td>
            </tr>
        <?php $totalBerat = $totalBerat + floatval($data['berat_kirim']);
        endforeach ?>
        <tr>
            <td colspan="7"> <strong>Total Berat Limbah</strong></td>
            <td style="text-align: right;"> <strong><?= $totalBerat; ?></strong></td>
        </tr>
    </tbody>
</table>