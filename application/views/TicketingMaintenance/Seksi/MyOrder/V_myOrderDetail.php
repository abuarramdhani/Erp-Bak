<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('TicketingMaintenance/Seksi/MyOrder'); ?>">
                                    <i class="fa fa-ticket fa-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!---->
                <br />
                <div class="col-lg-12">
                    <?php foreach ($orderDetail as $yoKuduDetail) { 
                        // echo"<pre>";print_r($yoKuduDetail);exit;  
                    ?>
                    <div class="row">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <div class="col-lg-6">
                                    <b><?= 'No Order : '.$yoKuduDetail['no_order']?></b>
                                </div>
                                <div class="col-lg-6">
                                    <?php if ($yoKuduDetail['status_order'] == 'done') { ?>
                                        <!-- href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/closeOrder/".$yoKuduDetail['no_order']) ?>" -->
                                        <a class="btn btn-danger btn-md" style="margin-left:355px;" title="Close Order" onclick="AreYouSureWantToCloseYourOrder(this)"><span class="fa fa-times"> CLOSE ORDER</span></a> 
                                    <?php } ?>
                                        <b style="font-size:20px;margin-left:400px;">
                                            <?php 
                                                if ($yoKuduDetail['perkiraan_selesai'] < date('Y-m-d') && $yoKuduDetail['status_order'] !== 'open' && $yoKuduDetail['status_order'] !== 'done' && $yoKuduDetail['status_order'] !== 'close' ) {
                                                    echo "OVERDUE";
                                                }elseif ($yoKuduDetail['status_order'] == 'done') {
                                                    echo "";    
                                                }else{
                                                    echo strtoupper($yoKuduDetail['status_order']);
                                                }
                                            ?>
                                        </b>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                        <?php if ($yoKuduDetail['status_order'] == 'open' && $yoKuduDetail['noind_pengorder'] == $noind) {?>
                                            <a href="<?= base_url('TicketingMaintenance/Seksi/NewOrder/editDataOrder/'. $yoKuduDetail['no_order']) ?>"  class="btn btn-warning btn-md" style="float:right;"><i class="fa fa-pencil"></i> Edit Data Order</a>
                                        <?php } ?>
                                        <input type="hidden" name="no_order" class="idLaporan" value="<?= $yoKuduDetail['no_order'] ?>"> <br />
                                        <input type="hidden" name="no_order" class="noIndukOppm" value="<?= $noInduk ?>"> <br />
                                        <table class="datatable table table-bordered text-left" style="">
                                        <tr>
                                                <td class="title">Nama Mesin</td>
                                                <td>: <?= $yoKuduDetail['nama_mesin']?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">No Mesin</td>
                                                <td>: <?= $yoKuduDetail['nomor_mesin']?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Line</td>
                                                <td>:  <?= $yoKuduDetail['line']?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Analisis Kerusakan awal</td>
                                                <td>: <?= $yoKuduDetail['kerusakan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Due Date</td>
                                                <td>:  <?= $yoKuduDetail['tgl_order'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Reason Need by Date</td>
                                                <td>:  <?= $yoKuduDetail['reason_need_by_date'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Kondisi Mesin saat Order</td>
                                                <td>: <?= $yoKuduDetail['kondisi_mesin']?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Running Hour</td>
                                                <td>: <?= $yoKuduDetail['running_hour']?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-lg-2"></div>
                                </div>
                                
                                <!--NAVIGATION TAB AT THE BOTTOM-->
                            <?php if ($yoKuduDetail['status_order'] !== 'acc' && $yoKuduDetail['status_order'] !== 'open') { ?>
                                <div class="row">   
                                    <div class="col-lg-12">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item active">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#pg_1" role="tab" aria-controls="pg_1" aria-selected="true">Laporan Perbaikan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#pg_2" role="tab" aria-controls="pg_2" aria-selected="false">Riwayat Reparasi</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#pg_3" role="tab" aria-controls="pg_3" aria-selected="false">Sparepart</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#pg_4" role="tab" aria-controls="pg_4" aria-selected="false">Keterlambatan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade active in" id="pg_1" role="tabpanel" aria-labelledby="#pg_1">
                                                <div class="col-lg-12"> <br />
                                                <table class="datatable table table-bordered text-left" style="">
                                                <?php
                                                    if (empty($viewLaporanPerbaikan)) {
                                                            echo 'Laporan Perbaikan Belum Diisi';
                                                            $kerusakan = null;
                                                            $penyebab_kerusakan = null;
                                                            $langkah_pencegahan = null;
                                                            $verifikasi_perbaikan = null;                               
                                                    }else{
                                                        foreach ($viewLaporanPerbaikan as $pb) {
                                                            $kerusakan = $pb['kerusakan'];
                                                            $penyebab_kerusakan = $pb['penyebab_kerusakan'];
                                                            $langkah_pencegahan = $pb['langkah_pencegahan'];
                                                            $verifikasi_perbaikan = $pb['verifikasi_perbaikan'];
                                                        }
                                                    }
                                                ?>
                                                <table class="datatable table table-bordered text-left" style="">
                                                        <tr>
                                                            <td class="title">Kerusakan</td>
                                                            <td> <?= $kerusakan?> </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="title">Penyebab Kerusakan</td>
                                                            <td> <?= $penyebab_kerusakan?> </td>
                                                            <tr>
                                                            </tr>
                                                            <td class="title" style="width:250px;">Langkah yang dilakukan</td>
                                                            <td>
                                                                <?php 
                                                            // echo "<pre>";print_r($viewLangkahPerbaikan);exit();
                                                                if (empty($viewLangkahPerbaikan)) {
                                                                        $urutan = null;
                                                                        $langkah = null;
                                                                }else{
                                                                    foreach ($viewLangkahPerbaikan as $lp) {
                                                                        $urutan = $lp['urutan'];
                                                                        $langkah = $lp['langkah'];
                                                                        echo $urutan.". ".$langkah."<br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="title">Langkah Pencegahan</td>
                                                            <td> <?= $langkah_pencegahan?> </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="title">Verifikasi Perbaikan</td>
                                                            <td> <?= $verifikasi_perbaikan?> </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pg_2" role="tabpanel" aria-labelledby="#pg_2">
                                                <div class="col-lg-12">
                                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblReparasi" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Jam Mulai</th>
                                                            <th class="text-center">Jam Selesai</th>
                                                            <th class="text-center">Pelaksana</th>
                                                        </thead>
                                                        <?php 
                                                            $no = 1;
                                                            // echo "<pre>";print_r($viewReparasi);exit();
                                                            if (empty($viewAllReparation)) {
                                                                    echo 'Riwayat Reparasi Belum Diisi';
                                                                    $tanggal = null;
                                                                    $jamMulai = null;                                                                
                                                                    $jamSelesai = null;                                                                
                                                                    $nama = null;       
                                                            }else{
                                                                foreach ($viewAllReparation as $rp) {
                                                                    $tanggal = $rp['tgl_reparasi'];
                                                                    $jamMulai = $rp['jam_mulai_reparasi'];                                                                
                                                                    $jamSelesai = $rp['jam_selesai_reparasi'];                                                                
                                                                    $nama = $rp['nama'];         
                                                            ?>
                                                        <tbody>
                                                            <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td class="text-center"><?php echo $tanggal; ?></td>
                                                            <td class="text-center"><?php echo $jamMulai; ?></td>
                                                            <td class="text-center"><?php echo $jamSelesai; ?></td>
                                                            <td><?php echo $nama; ?></td>
                                                            </tr>
                                                            <?php $no++; } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pg_3" role="tabpanel" aria-labelledby="#pg_3">
                                                <div class="col-lg-12">
                                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblSparepart" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Nama Sparepart Yang Digunakan</th>
                                                            <th class="text-center">Spesifikasi</th>
                                                            <th class="text-center">Jumlah</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $no = 1;
                                                            if (empty($viewSparepart)) {
                                                                    echo 'Sparepart Belum Diisi';
                                                                    $nama_sparepart = null;
                                                                    $spesifikasi = null;
                                                                    $jumlah = null;
                                                            }else{
                                                                foreach ($viewSparepart as $sp) {
                                                                    $nama_sparepart = $sp['nama_sparepart'];
                                                                    $spesifikasi = $sp['spesifikasi'];                                                                
                                                                    $jumlah = $sp['jumlah'];         
                                                            ?>
                                                            <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td><?php echo $nama_sparepart; ?></td>
                                                            <td><?php echo $spesifikasi; ?></td>
                                                            <td><?php echo $jumlah; ?></td>
                                                            <!-- <td>Tanpa Keterangan</td> -->
                                                            </tr> 
                                                            <?php
                                                                $no++;
                                                            } }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pg_4" role="tabpanel" aria-labelledby="#pg_4">
                                                <div class="col-lg-12">
                                                <table class="datatable table table-striped table-bordered table-hover text-left" id="tblKeterlambatan" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Alasan Keterlambatan</th>
                                                            <th class="text-center">Waktu Mulai</th>
                                                            <th class="text-center">Waktu Selesai</th>
                                                        </thead>
                                                        <tbody>
                                                        <?php 
                                                            $no = 1;
                                                        if (empty($viewKeterlambatan)) {
                                                                echo 'Alasan Keterlambatan Belum Diisi';
                                                                $alasan = null;
                                                                $waktu_mulai = null;
                                                                $waktu_selesai = null;
                                                        }else{
                                                        foreach ($viewKeterlambatan as $kt) {
                                                                $alasan = $kt['alasan'];
                                                                $waktu_mulai = $kt['waktu_mulai'];                                                                
                                                                $waktu_selesai = $kt['waktu_selesai'];                                                                
                                                            ?>
                                                            <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td><?php echo $alasan; ?></td>
                                                            <td><?php echo $waktu_mulai; ?></td>
                                                            <td><?php echo $waktu_selesai; ?></td>
                                                            </tr>
                                                            <?php
                                                                $no++;
                                                            }  }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <!--NAVIGATION TAB AT THE BOTTOM-->
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>