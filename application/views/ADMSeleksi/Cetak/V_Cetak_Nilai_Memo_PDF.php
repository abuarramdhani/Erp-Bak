<html>

<head>
    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1;
        }

        p {
            margin: 0;
            padding: 0;
            text-align: justify;
            font-size: 9.5pt;
        }

        #title {
            font-size: 18pt;
            margin-bottom: 5px;
            padding: 0;
        }

        .subtitle {
            font-size: 9.5pt;
        }

        hr {
            padding: 0;
            margin-bottom: 0px;
            height: 2.5px;
            color: solid black;
        }

        .headerSurat {
            text-align: left;
            font-size: 9.5pt;
        }

        .keterangan {
            font-size: 9.5pt;
        }

        .tb1,
        .tb3 {
            border: 0;
            width: 100%;
            border-spacing: 0;
            line-height: 1.01 !important;
            text-align: left;
            font-size: 9.5pt;
            margin-top: 0.5em;
        }

        .tb3 {
            font-size: 9.5pt;
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .tb3 {
            border: 1px solid black;
            border-collapse: collapse;
            line-height: 1.01 !important;
            font-size: 9.5pt !important;
        }

        .tb3 td {
            border: 1px solid black !important;
        }

        .tb3 th {
            border: 1px solid black !important;
        }
    </style>
</head>

<?php {  ?>

    <body>
        <div style="width: 100%;">
            <header>
                <p style="text-align: center;" id="title">
                    <span>
                        <strong>MEMO</strong>
                    </span>
                    <br>
                    <span class="subtitle">
                        SEKSI RECRUITMENT & SELECTION
                    </span>
                    <br>
                    <span class="subtitle">
                        CV. Karya Hidup Sentosa
                    </span>
                </p>
            </header>
            <hr>
            <div class="headerSurat">
                <?php foreach ($dataMemo as $dataMemo) : ?>
                    <table class="tb1">
                        <tbody>
                            <tr>
                                <td style="width: 10%;">No</td>
                                <td style="width: 1%;">:</td>
                                <td style="width: 89%;"><?= $dataMemo['nosurat'] ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Hal</td>
                                <td style="width: 1%;">:</td>
                                <td style="width: 89%;"><?= $dataMemo['hal'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="kepada">
                        <p>Kepada :</p>
                        <p><strong>Yth. <?= $dataMemo['jenis'] ?> <?= $dataMemo['nmtujuan'] ?></strong></p>
                        <p><strong><?= $dataMemo['seksitujuan'] ?></strong></p>
                        <p><u><strong>di tempat</strong></u></p>
                    </div>
                    <br>
                    <p>Dengan Hormat,</p>
                    <br>
                    <div class="isi">
                        <p>Sehubungan dengan pelaksanaan Training Orientasi bagi pekerja di CV. Karya Hidup Sentosa pada <?= $dataMemo['periode'] ?> , berikut ini kami sampaikan hasil nilai training orientasi bagi pekerja baru di Seksi <strong><?= $dataMemo['seksitujuan'] ?></strong>, yaitu :</p>
                    </div>
                    <div>
                        <table class="tb3" style="margin-left: auto; margin-right: auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No induk</th>
                                    <th>Seksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($dataNilai as $index => $data) : ?>
                                    <tr>
                                        <td style="text-align: center;"><?= $i++ ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['noind'] ?></td>
                                        <td><?= $data['seksi'] ?></td>
                                    <?php endforeach ?>
                                    </tr>
                            </tbody>
                        </table>

                        <div>
                            <table class="tb3" style="margin-left: auto; margin-right: auto; width: 100%;">
                                <thead>
                                    <tr>
                                        <?php $a = 1;
                                        foreach ($dataNilai as $index => $data) : ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>No</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['ncv'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['ncp'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nap'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nnb'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nsf'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['ns5'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nhdl'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nbgab'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nbcc1'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['ncc1'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['ncc2'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nbcm1'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nbcm2'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['ncm1'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['ncm2'] . "</th>"; ?>
                                            <?php if ($index == 0) echo "<th style='width: 6,25%'>" . $data['nabu'] . "</th>"; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;  border: 1px solid black; width: 6,25%;"><?= $a++ ?></td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['cv'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['cp'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['ap'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['nb'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['sf'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['s5'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['hdl'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= trim($data['bgab']) ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['bcc1'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['cc1'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['cc2'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['bcm1'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['bcm2'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['cm1'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['cm2'] ?> </td>
                                        <td style=" border: 1px solid black; width: 6,25%;"><?= $data['abu'] ?> </td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="keterangan">
                        <p><strong>Keterangan :</strong></p>
                        <table class="tb3" style="margin-left: auto; margin-right: auto;">
                            <thead>
                                <tr>
                                    <th>KD</th>
                                    <th>Materi</th>
                                    <th>Batas Kelulusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataNilai as $index => $data) : ?>

                                    <?php if ($index == 0 && $data['ncv'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[0]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[0]['materi'] . "</td>
                                            <td>" . $dataMateri[0]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['ncp'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[1]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[1]['materi'] . "</td>
                                            <td>" . $dataMateri[1]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nap'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[2]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[2]['materi'] . "</td>
                                            <td>" . $dataMateri[2]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nnb'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[3]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[3]['materi'] . "</td>
                                            <td>" . $dataMateri[3]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nsf'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[4]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[4]['materi'] . "</td>
                                            <td>" . $dataMateri[4]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['ns5'] != '-')
                                        echo "<tr>
                                        <td>" . $dataMateri[5]['materi'] . "</td>
                                        <td>" . $dataMateri[5]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[5]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nhdl'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[6]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[6]['materi'] . "</td>
                                            <td>" . $dataMateri[6]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nbgab'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[7]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[7]['materi'] . "</td>
                                            <td>" . $dataMateri[7]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nbcc1'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[9]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[9]['materi'] . "</td>
                                            <td>" . $dataMateri[9]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['ncc1'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[11]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[11]['materi'] . "</td>
                                            <td>" . $dataMateri[11]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['ncc2'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[12]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[12]['materi'] . "</td>
                                            <td>" . $dataMateri[12]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nbcm1'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[13]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[13]['materi'] . "</td>
                                            <td>" . $dataMateri[13]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nbcm2'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[14]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[14]['materi'] . "</td>
                                            <td>" . $dataMateri[14]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['ncm1'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[16]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[16]['materi'] . "</td>
                                            <td>" . $dataMateri[16]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['ncm2'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[17]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[17]['materi'] . "</td>
                                            <td>" . $dataMateri[17]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                    <?php if ($index == 0 && $data['nabu'] != '-')
                                        echo "<tr>
                                            <td>" . $dataMateri[18]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[18]['materi'] . "</td>
                                            <td>" . $dataMateri[18]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach ?>
                <br>
                <div>
                    <p>Bagi pekerja yang tidak lulus pada salah satu materi training orientasi, kami akan mengundang yang
                        bersangkutan untuk mengikuti kembali materi tersebut. Mengenai jadwal pelaksanaannya kami menunggu
                        arahan dari Bapak/Ibu dan mohon untuk konfirmasi terlebih dahulu ke Unit Pelatihan.</p>
                    <br>
                    <p>
                        Demikian pemberitahuan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
                    </p>
                </div>
                <br>

                <div>
                    <p><strong>Yogyakarta, <?= $dateSurat ?></strong></p>
                    <p><?= ucwords(strtolower($dataMemo['seksipengirim'])) ?></p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p><u><?= strtoupper($dataMemo['nmpengirim']) ?></u></p>
                    <p><?= strtoupper($dataMemo['jbtpengirim']) ?></p>
                </div>
                <br>
                <div>
                    <p>Tembusan :</p>
                    <?php if ($dataMemo['tembusan1'] != '') echo "<p>" . $dataMemo['tembusan1'] ?>
                    <?php if ($dataMemo['tembusan2'] != '') echo "<p>" . $dataMemo['tembusan2'] ?>
                    <?php if ($dataMemo['tembusan3'] != '') echo "<p>" . $dataMemo['tembusan3'] ?>
                    <?php if ($dataMemo['tembusan4'] != '') echo "<p>" . $dataMemo['tembusan4'] ?>
                    <?php if ($dataMemo['tembusan5'] != '') echo "<p>" . $dataMemo['tembusan5'] ?>
                </div>
            </div>
        </div>

    </body>

</html>
<?php
} ?>