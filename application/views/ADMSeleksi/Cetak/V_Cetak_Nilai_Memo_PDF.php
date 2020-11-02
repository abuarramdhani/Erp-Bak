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
            font-size: 9pt;
        }

        #title {
            font-size: 18pt;
            margin-bottom: 5px;
            padding: 0;
        }

        .subtitle {
            font-size: 9pt;
        }

        hr {
            padding: 0;
            margin-bottom: 0px;
            height: 2.5px;
            color: solid black;
        }

        .headerSurat {
            text-align: left;
            font-size: 9pt;
        }

        .keterangan {
            font-size: 9pt;
        }

        .tb1,
        .tb3 {
            border: 0;
            width: 100%;
            border-spacing: 0;
            line-height: 1.01 !important;
            text-align: left;
            font-size: 9pt;
            margin-top: 0.5em;
        }

        .tb3 {
            font-size: 9pt;
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .tb3 {
            border: 1px solid black;
            border-collapse: collapse;
            line-height: 1.01 !important;
            font-size: 9pt !important;
        }

        .tb3 td {
            border: 1px solid black !important;
        }

        .tb3 th {
            border: 1px solid black !important;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .other-pages {
            page-break-inside: avoid;
        }

        @page {
            margin-header: 20px;
            header: html_otherpages;
        }

        @page :first {
            margin-header: 20px;
            header: html_firstpage;
        }
    </style>
</head>

<?php {  ?>

    <body>
        <div style="width: 100%;">
            <htmlpageheader name="firstpageheader">
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
            </htmlpageheader>
            <sethtmlpageheader name="firstpageheader" value="on" show-this-page="1" />

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
                        <?php $no = 1;
                        foreach ($dataNilai as $index => $dataNilai) : ?>
                            <div class="other-pages">
                                <table class="tb1 mt-10">
                                    <tbody>
                                        <tr>
                                            <td style="width: 2%;"><?= $no++ . "." ?></td>
                                            <td style="width: 1%;"><?= $dataNilai['noind'] ?></td>
                                            <td style="width: 1%;">-</td>
                                            <td style="width: 96%; text-align: left;"><?= $dataNilai['nama'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="tb1">
                                    <tbody>
                                        <tr>
                                            <td style="width: 2%;"> </td>
                                            <td style="width: 98%;"><?= "SEKSI " . $dataNilai['seksi'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="tb3" style="margin-left: auto; margin-right: auto; width: 100%;">
                                    <thead>
                                        <tr>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['ncv'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['ncp'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nap'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nnb'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nsf'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['ns5'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nhdl'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nbgab'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nbcc1'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['ncc1'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['ncc2'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nbcm1'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nbcm2'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['ncm1'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['ncm2'] . "</th>"; ?>
                                            <?php echo "<th style='width: 6,25%'>" . $dataNilai['nabu'] . "</th>"; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['cv'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['cp'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['ap'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['nb'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['sf'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['s5'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['hdl'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= trim($dataNilai['bgab']) ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['bcc1'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['cc1'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['cc2'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['bcm1'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['bcm2'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['cm1'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['cm2'] ?> </td>
                                            <td style=" border: 1px solid black; width: 6,25%;"><?= $dataNilai['abu'] ?> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <br>
                    <div class="keterangan other-pages">
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
                                <?php if ($dataNilai['ncv'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[0]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[0]['materi'] . "</td>
                                            <td>" . $dataMateri[0]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['ncp'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[1]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[1]['materi'] . "</td>
                                            <td>" . $dataMateri[1]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nap'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[2]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[2]['materi'] . "</td>
                                            <td>" . $dataMateri[2]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nnb'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[3]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[3]['materi'] . "</td>
                                            <td>" . $dataMateri[3]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nsf'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[4]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[4]['materi'] . "</td>
                                            <td>" . $dataMateri[4]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['ns5'] != '-')
                                    echo "<tr>
                                        <td>" . $dataMateri[5]['materi'] . "</td>
                                        <td>" . $dataMateri[5]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[5]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nhdl'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[6]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[6]['materi'] . "</td>
                                            <td>" . $dataMateri[6]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nbgab'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[7]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[7]['materi'] . "</td>
                                            <td>" . $dataMateri[7]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nbcc1'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[9]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[9]['materi'] . "</td>
                                            <td>" . $dataMateri[9]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['ncc1'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[11]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[11]['materi'] . "</td>
                                            <td>" . $dataMateri[11]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['ncc2'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[12]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[12]['materi'] . "</td>
                                            <td>" . $dataMateri[12]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nbcm1'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[13]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[13]['materi'] . "</td>
                                            <td>" . $dataMateri[13]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nbcm2'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[14]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[14]['materi'] . "</td>
                                            <td>" . $dataMateri[14]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['ncm1'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[16]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[16]['materi'] . "</td>
                                            <td>" . $dataMateri[16]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['ncm2'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[17]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[17]['materi'] . "</td>
                                            <td>" . $dataMateri[17]['bataslulus'] . "</td>
                                            </tr>"  ?>
                                <?php if ($dataNilai['nabu'] != '-')
                                    echo "<tr>
                                            <td>" . $dataMateri[18]['kdmateri'] . "</td>
                                            <td>" . $dataMateri[18]['materi'] . "</td>
                                            <td>" . $dataMateri[18]['bataslulus'] . "</td>
                                            </tr>"  ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach ?>
                <br>
                <div class="other-pages">
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
                    <div class="other-pages">
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
            </div>
    </body>

</html>
<?php
} ?>