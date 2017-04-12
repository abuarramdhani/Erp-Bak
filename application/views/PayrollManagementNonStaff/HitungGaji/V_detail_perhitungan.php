<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Detail Perhitungan</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <div class="row2">
                                        <div class="col-md-12">
                                        <?php
                                            foreach ($getDetailPekerja as $dataDetailPekerja) {
                                        ?>
                                            <table class="table">
                                                <tr>
                                                    <td width="10%"><b>No Induk</b></td>
                                                    <td width="1%">:</td>
                                                    <td width="39%"><?php echo $dataDetailPekerja['employee_code'];?></td>
                                                    <td width="10%"><b>Seksi</b></td>
                                                    <td width="1%">:</td>
                                                    <td width="39%"><?php echo $dataDetailPekerja['section_name'];?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama</b></td>
                                                    <td>:</td>
                                                    <td><?php echo $dataDetailPekerja['employee_name'];?></td>
                                                    <td><b>Unit</b></td>
                                                    <td>:</td>
                                                    <td><?php echo $dataDetailPekerja['unit_name'];?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Periode Gaji</b></td>
                                                    <td>:</td>
                                                    <td><?php echo date('F', mktime(0, 0, 0, $dataDetailPekerja['bln_gaji'], 1)).' '.$dataDetailPekerja['thn_gaji'];?></td>
                                                    <td><b>Department</b></td>
                                                    <td>:</td>
                                                    <td><?php echo $dataDetailPekerja['department_name'];?></td>
                                                </tr>
                                            </table>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="row2">
                                        <div class="col-md-12">
                                            <div class="box" style="border-top-color: #3c8dbc;">
                                                <div class="box-header with border" style="background-color: #f8f8f8">
                                                    <h3 class="box-title">Master Gaji</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body" style="display: block; background-color: #f8f8f8">
                                                <?php
                                                    foreach ($getDetailPekerja as $dataDetailPekerja) {
                                                ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td width="15%"><b>Gaji Pokok (bulan)</b></td>
                                                            <td width="1%">:</td>
                                                            <td width="34%"><?php echo 'Rp '.number_format($dataDetailPekerja['gaji_pokok'], 0, '', '.').',-';?></td>
                                                            <td width="15%"><b>Ins. Masuk Malam</b></td>
                                                            <td width="1%">:</td>
                                                            <td width="34%"><?php echo 'Rp '.number_format($dataDetailPekerja['insentif_masuk_malam'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Gaji Pokok (<?php echo $pembagi_gp_bulanan?> hari)</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['gaji_pokok']/$pembagi_gp_bulanan, 0, '', '.').',-';?></td>
                                                            <td><b>UPAMK</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['upamk'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Ins. Prest. Standard</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['insentif_prestasi'], 0, '', '.').',-';?></td>
                                                            <td><b>UBT</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['ubt'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Ins. Masuk Sore</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['insentif_masuk_sore'], 0, '', '.').',-';?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row2">
                                        <div class="col-md-12">
                                            <div class="box" style="border-top-color: #3c8dbc;">
                                                <div class="box-header with border" style="background-color: #f8f8f8">
                                                    <h3 class="box-title">LKH Seksi</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding" style="display: block; background-color: #f8f8f8">
                                                <?php
                                                    foreach ($getDetailPekerja as $dataDetailPekerja) {
                                                ?>
                                                    <table class="table table-bordered table-striped datatables">
                                                        <thead class="bg-primary">
                                                            <tr>
                                                                <th class="text-center" width="30px">No</th>
                                                                <th class="text-center" width="100px">Tanggal</th>
                                                                <th class="text-center" width="200px">Kode Barang</th>
                                                                <th class="text-center" width="200px">Nama Barang</th>
                                                                <th class="text-center" width="100px">Kode Proses</th>
                                                                <th class="text-center" width="100px">Nama Proses</th>
                                                                <th class="text-center" width="100px">Jml Barang</th>
                                                                <th class="text-center" width="100px">Afmat</th>
                                                                <th class="text-center" width="100px">Afmch</th>
                                                                <th class="text-center" width="100px">Repair</th>
                                                                <th class="text-center" width="100px">Reject</th>
                                                                <th class="text-center" width="100px">Setting Time</th>
                                                                <th class="text-center" width="100px">Shift</th>
                                                                <th class="text-center" width="100px">Status</th>
                                                                <th class="text-center" width="200px">Kode Barang Target Sementara</th>
                                                                <th class="text-center" width="200px">Kode Proses Target Sementara</th>
                                                                <th class="text-center" width="150px">Equivalent Setting</th>
                                                                <th class="text-center" width="150px">Proposional Target</th>
                                                                <th class="text-center" width="100px">Cycle Time</th>
                                                                <th class="text-center" width="150px">Target Porposional</th>
                                                                <th class="text-center" width="100px">Pencapaian</th>
                                                                <th class="text-center" width="150px">Pencapaian Total</th>
                                                                <th class="text-center" width="150px">Insentif Prestasi</th>
                                                                <th class="text-center" width="150px">Insentif Kelebihan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $begin = new DateTime($firstdate);
                                                            $end = new DateTime($lastdate);

                                                            $interval = new DateInterval('P1D');

                                                            $p = new DatePeriod($begin, $interval ,$end);
                                                            $harike = 0;
                                                            $ip = 0;
                                                            $kelebihan = 0;
                                                            $pk_kondite = array();
                                                            $no = 1;
                                                            foreach ($p as $d) {
                                                                $pencapaian_hari_ini = 0;
                                                                $tanggal = 0;
                                                                $day = $d->format('Y-m-d');
                                                                foreach ($getDetailLKHSeksi as $dataLKHSeksi) {
                                                                    if ($dataLKHSeksi['tgl'] == $day) {
                                                                        $jml_baik = $dataLKHSeksi['jml_barang'] - $dataLKHSeksi['reject'];
                                                                        // echo $dataLKHSeksi['tgl']."<br>";
                                                                        if (date('l', strtotime($dataLKHSeksi['tgl'])) == 'Sunday') {
                                                                            $target = 0;
                                                                        }
                                                                        elseif (date('l', strtotime($dataLKHSeksi['tgl'])) == 'Friday' || date('l', strtotime($dataLKHSeksi['tgl'])) == 'Saturday') {
                                                                            $target = $dataLKHSeksi['target_jumat_sabtu'];
                                                                        }
                                                                        else{
                                                                            $target = $dataLKHSeksi['target_senin_kamis'];
                                                                        }

                                                                        if ($dataLKHSeksi['kd_brg'] == 'ABSEN') {
                                                                            $target = 0;
                                                                        }

                                                                        if ($dataLKHSeksi['waktu_setting'] != 0) {
                                                                            $targe_proposional = $target/360 * (360-$dataLKHSeksi['waktu_setting']);
                                                                        }
                                                                        else{
                                                                            $targe_proposional = 0;
                                                                        }
                                                                        
                                                                        if ($target == 0 || $target == '') {
                                                                            $proposional_target = 0;
                                                                            $cycle_time = 0;
                                                                            $equivalent = 0;
                                                                        }
                                                                        else{
                                                                            $proposional_target = 100/$target;
                                                                            $cycle_time = $dataLKHSeksi['waktu_setting']/$target;
                                                                            if ($cycle_time == 0) {
                                                                                $equivalent = 0;
                                                                            }
                                                                            else{
                                                                                $equivalent = $target/$cycle_time;
                                                                            }
                                                                        }

                                                                        $pencapaian = ($jml_baik + $equivalent) * $proposional_target;
                                                                        // echo $pencapaian." pencapaian<br>";
                                                                        $pencapaian_hari_ini = $pencapaian_hari_ini + $pencapaian;
                                                                        $tanggal = $dataLKHSeksi['tgl'];
                                                                        if ($pencapaian_hari_ini >= 110) {
                                                                            $ip_table = 1;
                                                                            $ik_table = 10;
                                                                        }
                                                                        elseif ($pencapaian_hari_ini >= 100 && $pencapaian_hari_ini < 110) {
                                                                            $ip_table = 1;
                                                                            $ik_table = $pencapaian_hari_ini - 100;;
                                                                        }
                                                                        else{
                                                                            $ip_table = 0;
                                                                            $ik_table = 0;
                                                                        }
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $no++;?></td>
                                                                <td><?php echo $dataLKHSeksi['tgl'];?></td>
                                                                <td><?php echo $dataLKHSeksi['kode_barang'];?></td>
                                                                <td><?php echo $dataLKHSeksi['nama_barang'];?></td>
                                                                <td><?php echo $dataLKHSeksi['kode_proses'];?></td>
                                                                <td><?php echo $dataLKHSeksi['nama_proses'];?></td>
                                                                <td><?php echo $dataLKHSeksi['jml_barang'];?></td>
                                                                <td><?php echo $dataLKHSeksi['afmat'];?></td>
                                                                <td><?php echo $dataLKHSeksi['afmch'];?></td>
                                                                <td><?php echo $dataLKHSeksi['repair'];?></td>
                                                                <td><?php echo $dataLKHSeksi['reject'];?></td>
                                                                <td><?php echo $dataLKHSeksi['setting_time'];?></td>
                                                                <td><?php echo $dataLKHSeksi['shift'];?></td>
                                                                <td><?php echo $dataLKHSeksi['status'];?></td>
                                                                <td><?php echo $dataLKHSeksi['kode_barang_target_sementara'];?></td>
                                                                <td><?php echo $dataLKHSeksi['kode_proses_target_sementara'];?></td>
                                                                <td><?php echo $equivalent;?></td>
                                                                <td><?php echo $proposional_target;?></td>
                                                                <td><?php echo $cycle_time;?></td>
                                                                <td><?php echo $targe_proposional;?></td>
                                                                <td><?php echo $pencapaian;?></td>
                                                                <td><?php echo $pencapaian_hari_ini;?></td>
                                                                <td><?php echo $ip_table;?></td>
                                                                <td><?php echo $ik_table;?></td>
                                                            </tr>
                                                        <?php
                                                                    }
                                                                }

                                                                if ($tanggal != 0) {
                                                                    if ($pencapaian_hari_ini >= 110) {
                                                                        $ip = $ip + 1;
                                                                        $kelebihan = $kelebihan + 10;
                                                                        $pk_kondite[] = array(
                                                                            'tanggal' => date('j', strtotime($tanggal)),
                                                                            'PK_p' => 50,
                                                                        );
                                                                    }
                                                                    elseif ($pencapaian_hari_ini >= 100 && $pencapaian_hari_ini < 110) {
                                                                        $ip = $ip + 1;
                                                                        $kelebihan = $kelebihan + $pencapaian_hari_ini - 100;
                                                                        $pk_kondite[] = array(
                                                                            'tanggal' => date('j', strtotime($tanggal)),
                                                                            'PK_p' => 50,
                                                                        );
                                                                    }
                                                                    else{
                                                                        $ip = $ip + 0;
                                                                        $kelebihan = $kelebihan + 0;
                                                                        $pk_kondite[] = array(
                                                                            'tanggal' => date('j', strtotime($tanggal)),
                                                                            'PK_p' => 5,
                                                                        );
                                                                    }
                                                                }
                                                            }

                                                            $resultLKHSeksi[] = array(
                                                                'IP' => $ip,
                                                                'totalInsentifPrestasi' => $ip * $dataDetailPekerja['insentif_prestasi'],
                                                                'IK' => number_format($kelebihan, 2, '.', ''),
                                                                'totalInsentifKelebihan' => number_format($kelebihan / 10 * ($insentif_prestasi_mask - $dataDetailPekerja['insentif_prestasi']), 0, '.', ''),
                                                                'pk_kondite' => $pk_kondite,
                                                            );
                                                    ?>
                                                            
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                    <table class="table" style="width: 50%">
                                                        <tr>
                                                            <td width="30%"><b>Insentif Prestasi</b></td>
                                                            <td width="2%">:</td>
                                                            <td width="68%"><?php echo $ip * $dataDetailPekerja['insentif_prestasi']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Insentif Kelebihan</b></td>
                                                            <td>:</td>
                                                            <td><?php echo number_format($kelebihan / 10 * ($insentif_prestasi_mask - $dataDetailPekerja['insentif_prestasi']), 0, '.', ''); ?></td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row2">
                                        <div class="col-md-12">
                                            <div class="box" style="border-top-color: #3c8dbc;">
                                                <div class="box-header with border" style="background-color: #f8f8f8">
                                                    <h3 class="box-title">Insentif Kondite</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding" style="display: block; background-color: #f8f8f8">
                                                    <table class="table table-bordered table-striped datatables" style="width: 100%">
                                                        <thead class="bg-primary">
                                                            <tr>
                                                                <th rowspan="2" class="text-center" width="5%" style="vertical-align: middle;">No</th>
                                                                <th rowspan="2" class="text-center" width="15%" style="vertical-align: middle;">Tanggal</th>
                                                                <th colspan="2" class="text-center" width="8%">MK</th>
                                                                <th colspan="2" class="text-center" width="8%">BKI</th>
                                                                <th colspan="2" class="text-center" width="8%">BKP</th>
                                                                <th colspan="2" class="text-center" width="8%">TKP</th>
                                                                <th colspan="2" class="text-center" width="8%">KB</th>
                                                                <th colspan="2" class="text-center" width="8%">KK</th>
                                                                <th colspan="2" class="text-center" width="8%">KS</th>
                                                                <th colspan="2" class="text-center" width="8%">PK</th>
                                                                <th colspan="3" class="text-center" width="16%">Insentif Kondite</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-center">N</th>
                                                                <th class="text-center">P</th>
                                                                <th class="text-center">N</th>
                                                                <th class="text-center">P</th>
                                                                <th class="text-center">N</th>
                                                                <th class="text-center">P</th>
                                                                <th class="text-center">N</th>
                                                                <th class="text-center">P</th>
                                                                <th class="text-center">N</th>
                                                                <th class="text-center">P</th>
                                                                <th class="text-center">N</th>
                                                                <th class="text-center">P</th>
                                                                <th class="text-center">N</th>
                                                                <th class="text-center">P</th>
                                                                <th class="text-center">N</th>
                                                                <th class="text-center">P</th>
                                                                <th class="text-center">Nilai</th>
                                                                <th class="text-center">Gol</th>
                                                                <th class="text-center">Hasil</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row2">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <tr>
                                                    <td width="15%"><b>Ins. Masuk Sore</b></td>
                                                    <td width="1%">:</td>
                                                    <td width="84%"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Ins. Masuk Sore</b></td>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>   
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row2">
                                        <div class="col-md-12">
                                            <div class="box" style="border-top-color: #3c8dbc;">
                                                <div class="box-header with border" style="background-color: #f8f8f8">
                                                    <h3 class="box-title">Tambahan oleh Akuntansi</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding" style="display: block; background-color: #f8f8f8">
                                                <?php
                                                    foreach ($getDetailPekerja as $dataDetailPekerja) {
                                                ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td width="15%"><b>Kurang Bayar</b></td>
                                                            <td width="1%">:</td>
                                                            <td width="34%"><?php echo $dataDetailPekerja['kurang_bayar'];?></td>
                                                            <td width="15%"></td>
                                                            <td width="1%"></td>
                                                            <td width="34%"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Lain-Lain</b></td>
                                                            <td>:</td>
                                                            <td><?php echo $dataDetailPekerja['tambahan_lain'];?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row2">
                                        <div class="col-md-12">
                                            <div class="box" style="border-top-color: #3c8dbc;">
                                                <div class="box-header with border" style="background-color: #f8f8f8">
                                                    <h3 class="box-title">Potongan oleh Akuntansi</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding" style="display: block; background-color: #f8f8f8">
                                                <?php
                                                    foreach ($getDetailPekerja as $dataDetailPekerja) {
                                                ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td width="15%"><b>Pot. Lebih Bayar</b></td>
                                                            <td width="1%">:</td>
                                                            <td width="34%"><?php echo 'Rp '.number_format($dataDetailPekerja['pot_lebih_bayar'], 0, '', '.').',-';?></td>
                                                            <td width="15%"><b>Pot. Koperasi</b></td>
                                                            <td width="1%">:</td>
                                                            <td width="34%"><?php echo 'Rp '.number_format($dataDetailPekerja['pot_koperasi'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Pot. Gaji Pokok</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['pot_gp'], 0, '', '.').',-';?></td>
                                                            <td><b>Pot. Hutang lain</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['pot_hutang_lain'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Pot. DL</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['pot_dl'], 0, '', '.').',-';?></td>
                                                            <td><b>Pot. DPLK</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['pot_dplk'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Pot. SPSI</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['pot_spsi'], 0, '', '.').',-';?></td>
                                                            <td><b>Pot. TKP</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['pot_tkp'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Pot. Duka</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['pot_duka'], 0, '', '.').',-';?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                    }
                                                ?>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row2">
                                        <div class="col-md-12">
                                            <div class="box" style="border-top-color: #3c8dbc;">
                                                <div class="box-header with border" style="background-color: #f8f8f8">
                                                    <h3 class="box-title">Tambahan dan Potongan dari data Personalia</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding" style="display: block; background-color: #f8f8f8">
                                                <?php
                                                    foreach ($getDetailPekerja as $dataDetailPekerja) {
                                                ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td width="15%"><b>DL</b></td>
                                                            <td width="1%">:</td>
                                                            <td width="34%"><?php echo 'Rp '.number_format($dataDetailPekerja['DL'], 0, '', '.').',-';?></td>
                                                            <td width="15%"><b>Pot. Koperasi</b></td>
                                                            <td width="1%">:</td>
                                                            <td width="34%"><?php echo 'Rp '.number_format($dataDetailPekerja['potongan_koperasi'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Tambahan</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['tambahan'], 0, '', '.').',-';?></td>
                                                            <td><b>UBS</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['UBS'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Duka</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['duka'], 0, '', '.').',-';?></td>
                                                            <td><b>Uang makan puasa</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['UM_puasa'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Potongan</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['potongan'], 0, '', '.').',-';?></td>
                                                            <td><b>SK CT</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['SK_CT'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>HC</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['HC'], 0, '', '.').',-';?></td>
                                                            <td><b>Potongan 2</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['POT_2'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Jml Uang Makan</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['jml_UM'], 0, '', '.').',-';?></td>
                                                            <td><b>Tambahan 2</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['TAMB_2'], 0, '', '.').',-';?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Cicilan</b></td>
                                                            <td>:</td>
                                                            <td><?php echo 'Rp '.number_format($dataDetailPekerja['cicil'], 0, '', '.').',-';?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>