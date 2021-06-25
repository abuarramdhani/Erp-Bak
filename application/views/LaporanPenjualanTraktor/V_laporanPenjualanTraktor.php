<section class="content" style="margin-top:50px;">
    <div class="col-lg-12">
        <div class="carousel slide" data-interval="5000" data-ride="carousel">
            <div class="carousel-inner">
                <!-- Laporan Penjualan Harian -->
                <div class="item active">
                    <div class="text-center">
                        <h3 style="margin-bottom:30px;">Laporan Penjualan
                            <b>Harian</b>
                        </h3>
                    </div>
                    <table class="table table-bordered table-responsive table-stripped" style="margin-bottom:30px;">
                        <thead>
                            <tr class="bg-primary">
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center>Penjualan Cabang</center>
                                </th>
                                <th>
                                    <center><?= $header[0]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[1]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[2]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[3]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[4]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[5]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[6]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[7]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[8]['TANGGAL'] ?></center>
                                </th>
                                <th>
                                    <center><?= $header[9]['TANGGAL'] ?></center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center>Rata2</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center>AK</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center>Target</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center>%</center>
                                </th>
                            </tr>
                            <tr class="bg-primary">
                                <th>
                                    <center><?= rtrim($header[0]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[1]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[2]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[3]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[4]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[5]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[6]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[7]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[8]['BULAN']) ?></center>
                                </th>
                                <th>
                                    <center><?= rtrim($header[9]['BULAN']) ?></center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($daily as $row) { ?>
                            <tr>
                                <td><?= $row['CABANG'] ?></td>
                                <td>
                                    <center><?= $row['SATU'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['DUA'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['TIGA'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['EMPAT'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['LIMA'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ENAM'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['TUJUH'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['DELAPAN'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['SEMBILAN'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['SEPULUH'] ?></center>
                                </td>
                                <td>
                                    <center>
                                        <?= $rata[$i] = round($row['TOTAL'] / $sumDate['JUMLAH_HARI']); ?>
                                    </center>
                                </td>
                                <td>
                                    <center><?= $row['TOTAL'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['TARGET'] ?></center>
                                </td>
                                <td>
                                    <center><?php if ($row['TARGET'] != 0) {
                                                    echo $row['PERBANDINGAN_TOTAL'];
                                                } ?></center>
                                </td>
                            </tr>
                            <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td><b>TOTAL KOMERSIAL</b></td>
                                <td>
                                    <center><b><?= $totalDaily['SATU'] ?></b></center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['DUA'] ?></b></center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['TIGA'] ?></b></center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['EMPAT'] ?></b></center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['LIMA'] ?></b></center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['ENAM'] ?></b></center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['TUJUH'] ?></b></center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['DELAPAN'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['SEMBILAN'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['SEPULUH'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= round($totalDaily['TOTAL'] / $sumDate['JUMLAH_HARI']) ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['TOTAL'] ?></b></center>
                                </td>
                                <td>
                                    <center><b><?= $totalDaily['TARGET'] ?></b></center>
                                </td>
                                <td>
                                    <center>
                                        <b><?php if ($totalDaily['TARGET'] != 0) {
                                                echo round(($totalDaily['TOTAL'] * 100) / $totalDaily['TARGET'], 2) . " %";
                                            } ?></b>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah Hari Penjualan</td>
                                <td colspan="10">
                                    &emsp;&emsp;<?= $sumDate['JUMLAH_HARI'] ?>
                                </td>
                                <td colspan="4" style="text-align:center;">Laju
                                    Hari&emsp;<?= $sumDate['JUMLAH_HARI'] ?> / <?= $sumDayMonth['JUMLAH_HARI'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Laporan Omset Penjualan Harian Pertipe Perproduk -->
                <div class="item">
                    <div class="text-center">
                        <h3 style="margin-bottom:30px;">Laporan Omset Penjualan
                            <b>Harian Pertipe Perproduk</b>
                        </h3>
                    </div>
                    <table class="table table-bordered table-responsive table-stripped" style="margin-bottom:30px;">
                        <thead>
                            <tr class="bg-primary">
                                <th style="vertical-align:middle;height:85px;">
                                    <center>Penjualan Cabang</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">ZEVA
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">G1000
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">BOXER
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">M1000
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">G600
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">ZENA
                                        Rotary</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">ZENA Super
                                        Power
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">IMPALA
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;"> CAPUNG
                                        METAl</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CAPUNG
                                        RAWA</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CAKAR BAJA
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CAKAR BAJA
                                        MINI
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CACAH BUMI
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">
                                        KASUARI
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;margin:auto;">TOTAL</center>
                                </th>
                            </tr>
                            <tr class="bg-primary">
                                <th>
                                    <center>
                                        <?= $dateToday ?>
                                    </center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($typeSingle as $row) { ?>
                            <tr>
                                <td><?= $row['CABANG'] ?></td>
                                <td>
                                    <center><?= $row['AAH0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAB0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAG0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAE0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAC0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ACA0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ACC0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAK0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAL0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAN0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ADA0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ADB0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ADC0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ADD0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['TOTAL'] ?></center>
                                </td>
                            </tr>
                            <?php
                            }
                            ?><tr>
                                <td><b>TOTAL KOMERSIAL</b></td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['AAH0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['AAB0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['AAG0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['AAE0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['AAC0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['ACA0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['ACC0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['AAK0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['AAL0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['AAN0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['ADA0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['ADB0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['ADC0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeSingle['ADD0'] ?></b>
                                    </center>
                                </td>
                                <td rowspan=2 style="vertical-align:middle;">
                                    <center>
                                        <b><?= $totalTypeSingle['TOTAL'] ?></b>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=7 style="text-align:center;">Laju Penjualan
                                    Hari (
                                    <?= $sumDate['JUMLAH_HARI'] ?>
                                    / <?= $sumDayMonth['JUMLAH_HARI'] ?> )
                                </td>
                                <td colspan=8 style="text-align:right;">
                                    Total Penjualan =&emsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Total Laporan Omset Penjualan Pertipe Perproduk s/d hari ini -->
                <div class="item">
                    <div class="text-center">
                        <h3 style="margin-bottom:30px;"><b>Total</b> Laporan Omset Penjualan Pertipe Perproduk
                            <b> s/d hari ini</b>
                        </h3>
                    </div>
                    <table class="table table-bordered table-responsive table-stripped" style="margin-bottom:30px;">
                        <thead>
                            <tr class="bg-primary">
                                <th style="vertical-align:middle;height:85px;">
                                    <center>Penjualan Cabang</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">ZEVA
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">G1000
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">BOXER
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">M1000
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">G600
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">ENA Rotary
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">ZENA Super
                                        Power
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">IMPALA
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CAPUNG
                                        METAl</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CAPUNG
                                        RAWA</center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CAKAR BAJA
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CAKAR BAJA
                                        MINI
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">CACAH BUMI
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;font-weight:normal;margin:auto;">KASUARI
                                    </center>
                                </th>
                                <th rowspan=2 style="vertical-align:middle;">
                                    <center style="writing-mode: vertical-lr;margin:auto;">TOTAL</center>
                                </th>
                            </tr>
                            <tr class="bg-primary">
                                <th>
                                    <center>
                                        <?= $dateToday ?>
                                    </center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($typeTotal as $row) { ?>
                            <tr>
                                <td><?= $row['CABANG'] ?></td>
                                <td>
                                    <center><?= $row['AAH0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAB0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAG0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAE0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAC0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ACA0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ACC0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAK0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAL0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['AAN0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ADA0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ADB0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ADC0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['ADD0'] ?></center>
                                </td>
                                <td>
                                    <center><?= $row['TOTAL'] ?></center>
                                </td>
                            </tr>
                            <?php
                            }
                            ?><tr>
                                <td><b>TOTAL KOMERSIAL</b></td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['AAH0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['AAB0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['AAG0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['AAE0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['AAC0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['ACA0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['ACC0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['AAK0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['AAL0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['AAN0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['ADA0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['ADB0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['ADC0'] ?></b>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <b><?= $totalTypeTotal['ADD0'] ?></b>
                                    </center>
                                </td>
                                <td style="vertical-align:middle;">
                                    <center>
                                        <b><?= $totalTypeTotal['TOTAL'] ?></b>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Rata2 Penjualan</b>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['AAH0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['AAB0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['AAG0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['AAE0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['AAC0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['ACA0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['ACC0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['AAK0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['AAL0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['AAN0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['ADA0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['ADB0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['ADC0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['ADD0'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= round($totalTypeTotal['TOTAL'] / $sumDate['JUMLAH_HARI']) ?>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Jumlah Hari Penjualan</td>
                                <td>
                                    <center>=</center>
                                </td>
                                <td colspan="2">
                                    <center><?= $sumDate['JUMLAH_HARI'] ?></center>
                                </td>
                                <td colspan="6" style="text-align:right;">Laju Hari</td>
                                <td>
                                    <center>:</center>
                                </td>
                                <td style="text-align:center;">
                                    <?= $sumDate['JUMLAH_HARI'] ?></td>
                                <td colspan="3">/ <?= $sumDayMonth['JUMLAH_HARI'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Button export -->
                <div style="margin-bottom:50px;display:flex;justify-content:center;">
                    <a class="btn btn-danger" href="<?= base_url('laporanPenjualanTR2/exportPdf/' . $cabang) ?>"><i
                            class="fa fa-file-pdf-o" aria-hidden="true"></i><b>&ensp;PDF</b></a>
                    <a class="btn btn-success" href="<?= base_url('laporanPenjualanTR2/exportExcel/' . $cabang) ?>"
                        style="margin-left: 15px;"><i class="fa fa-file-excel-o"
                            aria-hidden="true"></i><b>&ensp;Excel</b></a>
                    <?php if ($statusView == 1) { ?>
                    <a class="btn" href="<?php if ($cabang == 'Pusat') {
                                                    echo base_url('laporanPenjualanTR2/Pusat');
                                                } else {
                                                    echo base_url('laporanPenjualanTR2/Cabang/' . $cabang);
                                                } ?>" style="margin-left: 15px;color:white;background-color:#4C575E"><i
                            class="fa fa-arrow-left" aria-hidden="true"></i><b>&ensp;Kembali</b></a>
                    <?php }
                    if ($statusButton == 0) { ?>
                    <a class="btn" href="<?= base_url('laporanPenjualanTraktor/logoutFromView') ?>"
                        style="margin-left: 15px;color:white;background-color:#4C575E">Logout From
                        View</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>