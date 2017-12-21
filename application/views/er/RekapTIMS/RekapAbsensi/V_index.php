<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-11">
                        <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                    </div>
                    <div class="col-lg-1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <form method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/RekapAbsensiPekerja');?>" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtTanggalRekap" class="control-label col-lg-4">Tanggal Rekap</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="txtTanggalRekap" class="RekapAbsensi-daterangepicker form-control" />
                                                </div>
                                                <div class="col-lg-2"></div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label for="cmbDepartemen" class="control-label col-lg-4">Departemen</label>
                                                <div class="col-lg-6">
                                                    <select name="cmbDepartemen" class="select2 RekapAbsensi-cmbDepartemen" style="width: 100%" required="">
                                                    </select>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label for="cmbBidang" class="control-label col-lg-4">Bidang</label>
                                                <div class="col-lg-6">
                                                    <select name="cmbBidang" class="select2 RekapAbsensi-cmbBidang" style="width: 100%">
                                                    </select>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label for="cmbUnit" class="control-label col-lg-4">Unit</label>
                                                <div class="col-lg-6">
                                                    <select name="cmbUnit" class="select2 RekapAbsensi-cmbUnit" style="width: 100%">
                                                    </select>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label for="cmbSeksi" class="control-label col-lg-4">Seksi</label>
                                                <div class="col-lg-6">
                                                    <select name="cmbSeksi" class="select2 RekapAbsensi-cmbSeksi" style="width: 100%">
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                Proses
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                            if(isset($tanggalHitungRekap))
                            {
                                foreach ($tanggalHitungRekap as $tanggalPerhitungan) 
                                {
                                    $tanggalHitung  =   $tanggalPerhitungan->format('Y-m-d');
                                    $tanggalFormat  =   $tanggalPerhitungan->format('Ymd');
                                    if(count(${'daftarPresensi'.$tanggalFormat})>0)
                                    {
                        ?>
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h2 class="box-title">Rekap Presensi Tanggal <?php echo date('d-m-Y', strtotime($tanggalHitung));?></h2>
                            </div>
                            <div class="box-body">
                                <?php
                                    if(count(${'statistikPresensi'.$tanggalFormat})>0)
                                    {
                                ?>
                                <table class="table table-bordered RekapTIMS-StatistikPresensiHarian">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;">Tanggal Presensi</th>
                                            <th style="text-align: center; vertical-align: middle;">Jumlah Pekerja Hadir</th>
                                            <th style="text-align: center; vertical-align: middle;">Jumlah Pekerja Tidak Hadir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;"><h4><?php echo date('d-m-Y', strtotime($tanggalHitung));?></h4></td>
                                            <td style="text-align: center; vertical-align: middle;"><h4><b><?php echo ${'statistikPresensi'.$tanggalFormat}[0]['jumlah_pekerja_hadir'];?></b></h4></td>
                                            <td style="text-align: center; vertical-align: middle;"><h4><b><?php echo ${'statistikPresensi'.$tanggalFormat}[0]['jumlah_pekerja_tidak_hadir'];?></b></h4></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                    }
                                ?>
                                <table class="table table-bordered table-hover table-striped RekapTIMS-DaftarPresensiHarian">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">No.</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Tanggal</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Nomor Induk</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Nama</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Departemen</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Bidang</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Unit</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Seksi</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Shift</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Keterangan</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu 1</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu 2</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu 3</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu 4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no     =   1;
                                        foreach (${'daftarPresensi'.$tanggalFormat} as $daftarPresensi) 
                                        {
                                            $waktu  =   explode('; ', $daftarPresensi['waktu']);
                                            for($i = 0; $i < count($waktu); $i++)
                                            {
                                                $waktu{($i)}  =   $waktu[($i)];

                                                // if($waktu{$i}=='')
                                                // {
                                                //     $waktu{$i}  =   '-';
                                                // }
                                            }
                                    ?>
                                    
                                        <tr>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $no;?></td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $daftarPresensi['tanggal_presensi'];?></td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $daftarPresensi['nomor_induk'];?></td>
                                            <td style="white-space: nowrap; vertical-align: middle;"><?php echo $daftarPresensi['nama'];?></td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $daftarPresensi['nama_departemen'];?></td>
                                            <td style="white-space: nowrap; vertical-align: middle;"><?php echo $daftarPresensi['nama_bidang'];?></td>
                                            <td style="white-space: nowrap; vertical-align: middle;"><?php echo $daftarPresensi['nama_unit'];?></td>
                                            <td style="white-space: nowrap; vertical-align: middle;"><?php echo $daftarPresensi['nama_seksi'];?></td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $daftarPresensi['shift'];?></td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $daftarPresensi['keterangan'];?></td>
                                            <?php
                                                for($k = 1; $k <= 4; $k++)
                                                {
                                            ?>
                                            <td style="white-space: nowrap;">
                                                <?php 
                                                    if(isset($waktu{$k-1}))
                                                    {
                                                        echo $waktu{$k-1};
                                                    }
                                                    else
                                                    {
                                                        echo '-';
                                                    }
                                                ?>
                                            </td>
                                            <?php
                                                }
                                            ?>
                                           
                                        </tr>
                                    
                                    <?php
                                            $no++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>