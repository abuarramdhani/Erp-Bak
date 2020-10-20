<h4 style="text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 11pt;">Daftar Pekerja Diperbantukan Periode <?php if ($date2) {
                                                                                                                                                                            echo $date2;
                                                                                                                                                                        } else {
                                                                                                                                                                            echo $date1;
                                                                                                                                                                        } ?></h4>
<table id="tb2" class="table table-bordered table-striped" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">No</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">No Induk</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Nama</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Seksi/Unit Asal</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Diperbantukan Ke</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Gol Kerja</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Pekerjaan</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Periode (Lama)</th>
            <th style="border: 0.5px solid black; text-align: center;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($dataDiperbantukan as $data) : ?>
            <tr>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; text-align: center; color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                                    echo "#fc0303";
                                                                                                                                                                                } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                                    echo "#3059fc";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "#000";
                                                                                                                                                                                } ?> ;"><?= $no++ ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black;color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } ?> ;"><?= $data['noind'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black;color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } ?> ;"><?= $data['nama'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black;color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } ?> ;"><?= $data['seksi_awal'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black;color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } ?> ;"><?= $data['seksi_perbantuan'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; text-align: center;color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                                    echo "#fc0303";
                                                                                                                                                                                } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                                    echo "#3059fc";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "#000";
                                                                                                                                                                                } ?> ;"><?= $data['golkerja'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black;color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } ?> ;"><?= $data['pekerjaan'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black;color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } ?> ;"><?= $data['lama'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black;color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } ?> ;"><?= $data['ket'] ?></td>
            </tr>
        <?php endforeach; ?>
</table>