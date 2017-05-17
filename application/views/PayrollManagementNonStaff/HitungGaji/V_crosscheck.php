 <body>
    <div style="margin-left:20px;margin-right:20px;">
        <div class="row" style="margin-left:3px;margin-right:3px;">
            <table style="margin: 0 auto;width: 100%">
                <tr>
                    <td colspan='11' align="left">
                        <span style="padding: 10px;">LAPORAN PRODUKSI <?php echo $unit_name;?></span><br>
                    </td>
                </tr>
                <tr>
                    <td colspan='4' align="left">
                        <span style="padding: 10px;">Nama Opr : <?php echo $namapkj;?></span>
                    </td>
                    <td colspan='4' align="left">
                        <span style="padding: 10px;">No. Induk : <?php echo $noinduk;?></span>
                    </td>
                    <td colspan='4' align="left">
                        <span style="padding: 10px;">Kelas : <?php echo $kelas;?></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row" style="margin-left:3px;margin-right:3px;" border="1">
            <table style="margin: 0 auto;width: 100%;border: 1px solid black;" border="1">
                <thead>
                    <tr >
                        <th  class="text-center" width="17%">
                            Tanggal - Hari
                        </th>
                        <th class="text-center" width="3%">
                            No
                        </th>
                        <th class="text-center" width="16%">
                            Kode Barang    
                        </th>
                        <th class="text-center" width="4%">
                            Pro
                        </th>
                        <th class="text-center" width="30%">
                            Nama Barang
                        </th>
                        <th class="text-center" width="5%">
                            TGT
                        </th>
                        <th class="text-center" width="5%">
                            Baik
                        </th>
                        <th class="text-center" width="7%">
                            Point
                        </th>
                        <th class="text-center" width="9%">
                            Prestasi
                        </th>
                        <th class="text-center" width="5%">
                            Sett
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php

                        $begin = new DateTime(date('Y-m-01 00:00:00', strtotime($firstdate)));
                        $end = new DateTime(date('Y-m-t 23:59:59', strtotime($lastdate)));

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
                            $checkjmlpengerjaan=0;
                            $historijmlpengerjaan=0;
                            $tglpengerjaan=0;
                            //print_r($getDetailLKHSeksi);

                            $arr = array();

                            foreach($getDetailLKHSeksi as $key => $item)
                                {
                                   $arr[$item['tgl']][] = $item;
                                }
                            
                        foreach ($arr as $dataTanggal) {
                           
                            $jmldata=count($dataTanggal);
                            $cetakdata=$jmldata;
                            $nomorbaris=0;

                            switch(date('w', strtotime($day))){      
                                        case 0 : { $hari='Minggu'; }break;
                                        case 1 : { $hari='Senin'; }break;
                                        case 2 : { $hari='Selasa'; }break;
                                        case 3 : { $hari='Rabu'; }break;
                                        case 4 : { $hari='Kamis'; }break;
                                        case 5 : { $hari="Jum'at"; }break;
                                        case 6 : { $hari='Sabtu'; }break;
                                        default: { $hari='UnKnown'; } break; }
                            
                            foreach ($dataTanggal as $dataLKHSeksi) {
                                //get tanggal sebelumnya

                            if ($dataLKHSeksi['tgl'] == $day) {
                                    //$jml_baik = $dataLKHSeksi['jml_barang'] - $dataLKHSeksi['reject'];
                                    $jml_baik = $dataLKHSeksi['jml_barang'] - $dataLKHSeksi['repair'] - (1.5*$dataLKHSeksi['reject']);
                                    // echo $dataLKHSeksi['tgl']."<br>";
                                    if (date('l', strtotime($dataLKHSeksi['tgl'])) == 'Sunday') {
                                        $target = 0;
                                    }
                                    elseif (date('l', strtotime($dataLKHSeksi['tgl'])) == 'Friday' || date('l', strtotime($dataLKHSeksi['tgl'])) == 'Saturday') {
                                        $target = $dataLKHSeksi['target_jumat_sabtu'];
                                        $waktu_cycletime=$waktu_cycletime_jumat_sabtu;
                                    }
                                    else{
                                        $target = $dataLKHSeksi['target_senin_kamis'];
                                        $waktu_cycletime=$waktu_cycletime_senin_kamis;
                                    }

                                    if ($dataLKHSeksi['kd_brg'] == 'ABSEN') {
                                        $target = 0;
                                    }

                                    $targe_proposional = $target/360 * (360-$dataLKHSeksi['setting_time']);
                                    
                                    if ($target == 0 || $target == '') {
                                        $proposional_target = 0;
                                        $cycle_time = 0;
                                        $equivalent = 0;
                                    }
                                    else{
                                        $proposional_target = 100/$target;
                                        $cycle_time = $waktu_cycletime/$target;
                                        if ($cycle_time == 0) {
                                            $equivalent = 0;
                                        }
                                        else{
                                            //bila waktu setting 0 maka equivalent 0
                                        if (0==$dataLKHSeksi['setting_time']) {
                                            $equivalent = 0;
                                        }
                                        else
                                        {
                                            $equivalent = $dataLKHSeksi['waktu_setting']/$cycle_time;
                                        }
                                        }
                                    }

                                    $pencapaian = ($jml_baik + $equivalent) * $proposional_target;
                                    // echo $pencapaian." pencapaian<br>";
                                    $pencapaian_hari_ini = $pencapaian_hari_ini + $pencapaian;
                                    //check pencapaian
                                    if ($dataLKHSeksi['tgl']!=$tglpengerjaan) {
                                    $tanggal = $dataLKHSeksi['tgl'];
                                    }

                                    if ($pencapaian_hari_ini >= 110 ) {
                                        $ip_table = 1;
                                        $ik_table = 10;
                                        $historijmlpengerjaan++;
                                    }
                                    elseif ($pencapaian_hari_ini >= 100 && $pencapaian_hari_ini < 110 ) {
                                        $ip_table = 1;
                                        $ik_table = $pencapaian_hari_ini - 100;
                                        $historijmlpengerjaan++;
                                    }
                                    else{
                                        $ip_table = 0;
                                        $ik_table = 0;
                                    }

                                    $nomorbaris++;
                    ?>
                            <tr>    
                                <?php if ($jmldata==$cetakdata) { ?>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' valign="top" rowspan='<?php echo $jmldata;?>'>
                                  <?php 
                                  $date=date_create($dataLKHSeksi['tgl']);
                                  echo date_format($date,"d-m-Y").' '.$hari; ?> 
                                </td>
                                <?php } ?>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center"><?php echo $nomorbaris;?></td>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center"><?php echo $dataLKHSeksi['kd_brg'];?></td>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center"><?php echo $dataLKHSeksi['kode_proses'];?> </td>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000; padding-left: 10px;' ><?php echo $dataLKHSeksi['nama_barang'];?> </td>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ><?php echo $target;?></td>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ><?php echo $jml_baik;?></td>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ><?php echo number_format($pencapaian, 2, '.', '');?></td>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ><?php echo number_format($pencapaian_hari_ini, 2, '.', '');?></td>
                                <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ><?php if (0!=$dataLKHSeksi['setting_time']) {echo $dataLKHSeksi['setting_time'];}?> </td>
                            </tr>
                             <?php
                             $jmldata--;
                                if ($tanggal != 0) {
                                    if ($pencapaian_hari_ini >= 110) {
                                        $ip = $ip + 1;
                                        $kelebihan = $kelebihan + 10;
                                        $pk_kondite[] = array(
                                            'tanggal' => date('j', strtotime($tanggal)),
                                            'PK_p' => 50,
                                        );
                                        $nilaiPK=50;
                                        $textNilaiPK=51;
                                    }
                                    elseif ($pencapaian_hari_ini == 100) {
                                        $ip = $ip + 1;
                                        $kelebihan = $kelebihan + $pencapaian_hari_ini - 100;
                                        $pk_kondite[] = array(
                                            'tanggal' => date('j', strtotime($tanggal)),
                                            'PK_p' => 50,
                                        );
                                        $nilaiPK=50;
                                        $textNilaiPK=50;
                                    }
                                    elseif ($pencapaian_hari_ini > 100 && $pencapaian_hari_ini < 110) {
                                        $ip = $ip + 1;
                                        $kelebihan = $kelebihan + $pencapaian_hari_ini - 100;
                                        $pk_kondite[] = array(
                                            'tanggal' => date('j', strtotime($tanggal)),
                                            'PK_p' => 50,
                                        );
                                        $nilaiPK=50;
                                        $textNilaiPK=51;
                                    }
                                    else{
                                        $ip = $ip + 0;
                                        $kelebihan = $kelebihan + 0;
                                        $pk_kondite[] = array(
                                            'tanggal' => date('j', strtotime($tanggal)),
                                            'PK_p' => 5,
                                        );
                                        $nilaiPK=5;
                                        $textNilaiPK=5;
                                    }
                                }
                             if (0==$jmldata) {
                                 ?>
                                 <tr>    
                                       <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' valign="top"></td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center"></td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center"></td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center"></td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000; padding-left: 10px;' >
                                        <?php
                                        foreach ($getDetailKondite as $dataKondite) {
                                        }

                                        $MK = $dataKondite['MK'];
                                        $BKI = $dataKondite['BKI'];
                                        $BKP = $dataKondite['BKP'];
                                        $TKP = $dataKondite['TKP'];
                                        $KB = $dataKondite['KB'];
                                        $KK = $dataKondite['KK'];
                                        $KS = $dataKondite['KS'];
                                        $PK_p= $nilaiPK;

                                            if ($MK == 'A') {$MK_p = 8; }elseif ($MK == 'B') {$MK_p = 4; }else{$MK_p = 0; }

                                            if ($BKI == 'A') {$BKI_p = 10; }elseif ($BKI == 'B') {$BKI_p = 5; }elseif ($BKI == 'C') {$BKI_p = 2; }else{$BKI_p = 0; }

                                            if ($BKP == 'A') {$BKP_p = 8; }elseif ($BKP == 'B') {$BKP_p = 4; }else{$BKP_p = 0; }

                                            if ($TKP == 'A') {$TKP_p = 8; }elseif ($TKP == 'B') {$TKP_p = 4; }else{$TKP_p = 0; }

                                            if ($KB == 'A') {$KB_p = 7; }elseif ($TKP == 'B') {$KB_p = 3; }else{$KB_p = 0; }

                                            if ($KK == 'A') {$KK_p = 5; }elseif ($KK == 'B') {$KK_p = 3; }elseif ($KK == 'C') {$KK_p = 1;}else{$KK_p = 0; }

                                            if ($KS == 'A') {$KS_p = 4; }elseif ($TKP == 'B') {$KS_p = 2; }else{$KS_p = 0; }

                                            $nilai = $MK_p + $BKI_p + $BKP_p + $TKP_p + $KB_p + $KK_p + $KS_p + $PK_p;

                                            if ($nilai >= 91 && $nilai <= 100) {
                                                $gol = 'A';
                                            }
                                            elseif ($nilai >= 71 && $nilai <= 90) {
                                                $gol = 'B';
                                            }
                                            elseif ($nilai >= 30 && $nilai <= 70) {
                                                $gol = 'C';
                                            }
                                            elseif ($nilai >= 10 && $nilai <= 29) {
                                                $gol = 'D';
                                            }
                                            else{
                                                $gol = 'E';
                                            }

                                            echo $dataKondite['MK'].' ';
                                            echo $dataKondite['BKI'].' ';
                                            echo $dataKondite['BKP'].' ';
                                            echo $dataKondite['TKP'].' ';
                                            echo $dataKondite['KB'].' ';
                                            echo $dataKondite['KK'].' ';
                                            echo $dataKondite['KS'].' ';
                                            echo $dataKondite['KS'].' '; 
                                            
                                            switch ($textNilaiPK) {
                                                        case "51":
                                                            echo '  STD+ -> ';
                                                            break;
                                                        case "50":
                                                             echo '  STD -> ';
                                                            break;
                                                        default:
                                                            echo '  &lt;STD -> ';
                                                    }
                                            
                                            echo $gol;


                                        ?>
                                        </td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ></td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ></td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ></td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ><?php echo $gol;?></td>
                                        <td style='border-top: none;border-bottom: none; border-right: 1px solid #000;' class="text-center" ></td>
                                 </tr>
                                 <?php
                             }

                                            } //end if
                                        } //end lopp data lkh
                                    } //end loop arr

                                    }
                                    foreach ($getDetailPekerja as $dataDetailPekerja) {
                                    $resultLKHSeksi[] = array(
                                        'IP' => $ip,
                                        'totalInsentifPrestasi' => $ip * $dataDetailPekerja['insentif_prestasi'],
                                        'IK' => number_format($kelebihan, 2, '.', ''),
                                        'totalInsentifKelebihan' => number_format($kelebihan / 10 * ($insentif_prestasi_mask - $dataDetailPekerja['insentif_prestasi']), 0, '.', ''),
                                        'pk_kondite' => $pk_kondite);
                                    }
                            ?>

                </tbody>
            </table>
        </div>

    </div>