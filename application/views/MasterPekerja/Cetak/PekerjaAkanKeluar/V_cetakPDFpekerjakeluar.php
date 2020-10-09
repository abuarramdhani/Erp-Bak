<h4 style="text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 11pt;">Data Pekerja Akan Keluar Periode <?php if ($date2) {
                                                                                                                                                                        echo $date2;
                                                                                                                                                                    } else {
                                                                                                                                                                        echo $date1;
                                                                                                                                                                    } ?></h4>
<table id="tb1" class="table table-bordered table-striped" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">No</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">No Induk</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Nama</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Seksi</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Unit</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Masuk Kerja</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Diangkat</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Tanggal Keluar</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Akhir Kontrak</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Lama Kontrak</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Keterangan</th>
            <th style="border: 0.5px solid black; text-align: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;">Asal OS</th>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($listOfdata as $data) : ?>
            <tr style="color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                    echo "#fc0303";
                                } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                    echo "#000";
                                } else {
                                    echo "#3059fc";
                                } ?>;">
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; text-align: center; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                                    echo "#fc0303";
                                                                                                                                                                                } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                                    echo "#000";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "#3059fc";
                                                                                                                                                                                } ?>;"><?= $no++ ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } ?>;"><?= $data['noind']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } ?>;"><?= $data['nama']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } ?>;"><?= $data['seksi']; ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } ?>;"><?= $data['unit'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; text-align: center; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                                    echo "#fc0303";
                                                                                                                                                                                } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                                    echo "#000";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "#3059fc";
                                                                                                                                                                                } ?>;"><?= $data['masukkerja'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; text-align: center; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                                    echo "#fc0303";
                                                                                                                                                                                } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                                    echo "#000";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "#3059fc";
                                                                                                                                                                                } ?>;"><?= $data['diangkat'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; text-align: center; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                                    echo "#fc0303";
                                                                                                                                                                                } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                                    echo "#000";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "#3059fc";
                                                                                                                                                                                } ?>;"><?= $data['tglkeluar'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black;text-align: center; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                                    echo "#fc0303";
                                                                                                                                                                                } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                                    echo "#000";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "#3059fc";
                                                                                                                                                                                } ?>;"><?= $data['akhkontrak'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; text-align: center; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                                    echo "#fc0303";
                                                                                                                                                                                } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                                    echo "#000";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "#3059fc";
                                                                                                                                                                                } ?>;"><?= $data['lmkontrak'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } ?>;"><?= $data['ket'] ?></td>
                <td style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 9pt;border: 0.5px solid black; color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                                                                                echo "#fc0303";
                                                                                                                                                            } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                                                                                echo "#000";
                                                                                                                                                            } else {
                                                                                                                                                                echo "#3059fc";
                                                                                                                                                            } ?>;"><?= $data['asal_outsourcing'] ?></td>
            </tr>
        <?php endforeach; ?>
</table>