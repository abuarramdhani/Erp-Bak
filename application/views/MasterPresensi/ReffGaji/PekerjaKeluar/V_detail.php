<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <h3><b>Detail Pekerja</b></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                        
                        </div>
                        <div class="box-body">
                        <?php // Example vars
                            //$month = '6'; // 1-12
                            //$year = '2014'; // four digit year

                            $fmt = new IntlDateFormatter('id_ID',
                                IntlDateFormatter::FULL,
                                IntlDateFormatter::FULL,
                                'Asia/Jakarta',
                                IntlDateFormatter::GREGORIAN,
                                'dd MMMM yyyy');

                            // $lastMonth = mktime(0, 0, 0, $month -1, 1, $year);
                            // $showLastMonth =  $fmt->format($lastMonth);
                            // echo $showLastMonth; 
                        ?>
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                <img class="img img-thumbnail" src="<?php echo $pribadi->photo ?>" alt="<?php echo $pribadi->noind ?>" title="<?php echo $pribadi->noind." - ".$pribadi->nama ?>">
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table">
                                                <tr>
                                                    <td>No Induk</td><td>:</td>
                                                    <td><?php echo $pribadi->noind ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama</td><td>:</td>
                                                    <td><?php echo $pribadi->nama ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Seksi</td><td>:</td>
                                                    <td><?php echo $pribadi->seksi ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Unit</td><td>:</td>
                                                    <td><?php echo $pribadi->unit ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Masuk</td><td>:</td>
                                                    <td><?php echo $fmt->format(strtotime($pribadi->masukkerja)) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Diangkat</td><td>:</td>
                                                    <td><?php echo $fmt->format(strtotime($pribadi->diangkat)) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Keluar</td><td>:</td>
                                                    <td><?php echo $fmt->format(strtotime($pribadi->tglkeluar)) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="dataTable-pekerjaKeluar-detail table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="bg-info text-center">Tanggal</th>
                                                <th rowspan="2" class="bg-info text-center">Shift</th>
                                                <th colspan="4" class="bg-success text-center">Data Presensi</th>
                                                <th colspan="4" class="bg-danger text-center">Data Tim</th>
                                            </tr>
                                            <tr>
                                                <th class="bg-success text-center">Keterangan</th>
                                                <th class="bg-success text-center">Lembur</th>
                                                <th class="bg-success text-center">Masuk</th>
                                                <th class="bg-success text-center">Keluar</th>
                                                <th class="bg-danger text-center">Keterangan</th>
                                                <th class="bg-danger text-center">Point</th>
                                                <th class="bg-danger text-center">Keluar</th>
                                                <th class="bg-danger text-center">Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            foreach ($presensi as $key) { ?>
                                                <tr>
                                                    <td><?php echo $fmt->format(strtotime($key['tanggal'])) ?></td>
                                                    <td><?php echo $key['shift'] ?></td>
                                                    <td><?php echo $key['ket_dp'] ?></td>
                                                    <td><?php echo $key['total_lembur'] ?></td>
                                                    <td><?php echo $key['masuk_dp'] ?></td>
                                                    <td><?php echo $key['keluar_dp'] ?></td>
                                                    <td><?php echo $key['ket_dt'] ?></td>
                                                    <td><?php echo $key['point'] ?></td>
                                                    <td><?php echo $key['keluar_dt'] ?></td>
                                                    <td><?php echo $key['masuk_dt'] ?></td>
                                                </tr>
                                            <?php 
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>