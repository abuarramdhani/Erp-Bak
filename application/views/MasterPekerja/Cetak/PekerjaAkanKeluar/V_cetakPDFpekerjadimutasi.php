<h4 style="text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 11pt;">Data Pekerja Dimutasi Periode <?php if ($date2) {
                                                                                                                                                                    echo $date2;
                                                                                                                                                                } else {
                                                                                                                                                                    echo $date1;
                                                                                                                                                                } ?></h4>
<table id="tb3" class="table table-bordered table-striped" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">No</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">No Induk</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Nama</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Seksi/Unit Asal</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Dimutasi Ke</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Gol Kerja</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Pekerjaan</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Mulai Berlaku</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($dataDimutasi as $data) : ?>
            <tr>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt; border: 0.5px solid black; text-align: center;"><?= $no++ ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt; border: 0.5px solid black;"><?= $data['noind']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt; border: 0.5px solid black;"><?= $data['nama']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt; border: 0.5px solid black;"><?= $data['seksi_lama']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt; border: 0.5px solid black;"><?= $data['seksi_baru']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt; border: 0.5px solid black; text-align: center;"><?= $data['golkerjabr']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt; border: 0.5px solid black; text-align: center;"><?= $data['pekerjaan']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt; border: 0.5px solid black; text-align: center;"><?= $data['tglberlaku']; ?></td>
            </tr>
        <?php endforeach; ?>
</table>