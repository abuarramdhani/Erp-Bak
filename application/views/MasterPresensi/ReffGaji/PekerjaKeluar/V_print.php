<html>
    <head>
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" />
    </head>
    <body>
        <div style='text-align: left'>
            <?php $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                $tgl_Cetak = explode('-',$pos['txtTglCetak2']);
                $prd = explode(" - ",$pos['txtPeriodeGaji2']);
                $prd_awal = explode("-", $prd[0]);
                $prd_akhir = explode("-", $prd[1]);
            ?>
            <h5>Data Pekerja Keluar Bulan : <?php echo $bulan[intval($tgl_Cetak[1])]." ".$tgl_Cetak[0] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tanggal Cetak : <?php echo $tgl_Cetak[2]."/".$tgl_Cetak[1]."/".$tgl_Cetak[0] ?></h5>
            <h6>(Periode Pekerja Keluar : <?php echo $prd_awal[2]."/".$prd_awal[1]."/".$prd_awal[0]." - ".$prd_akhir[2]."/".$prd_akhir[1]."/".$prd_akhir[0] ?>)</h6>
        </div>
        <div>
        <table style="width:100%" class="table table-bordered table-hover table-striped dataTable">
                <thead class=" bg-primary">
                    <tr>
                        <th style="text-align: center;font-size: 8pt;width: 3%">No</th>
                        <th style="text-align: center;font-size: 8pt;width: 6%">Noind</th>
                        <th style="text-align: center;font-size: 8pt;width: 10%">Nama</th>
                        <th style="text-align: center;font-size: 8pt;width: 15%">Seksi</th>
                        <th style="text-align: center;font-size: 8pt;width: 8%">Tanggal Keluar</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IP</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IK</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">UBT</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">UPAMK</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IF</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">LEMBUR</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">HTM</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">ABS</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">Ijin</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">Tambahan</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">UM Puasa</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IMS</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IMM</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IPT</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">UM Cabang</th>
                        <th style="text-align: center;font-size: 8pt;width: 8%">Pot. Seragam</th>
                        <th style="text-align: center;font-size: 8pt;width: 8%">Pot. Lain</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">JKN</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">JHT</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">JP</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JKN</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JHT</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data) && !empty($data)) {
                        $angka = 1;
                        foreach ($data as $key) { ?>
                            <tr>
                                <td style="text-align: center;font-size: 8pt"><?=$angka ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['noind'] ?></td>
                                <td style="text-align: left;font-size: 8pt"><?=$key['nama'] ?></td>
                                <td style="text-align: left;font-size: 8pt"><?=$key['seksi'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?php $t = strtotime($key['tgl_keluar']); echo date('d/m/Y',$t); ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ip'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ik'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ubt'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['upamk'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['if'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['lembur'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['htm'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['tm'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['tik'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['tambahan'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['um_puasa'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ims'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['imm'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ipt'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['um_cabang'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['pot_seragam'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['pot_lain'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jkn'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jht'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jp'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jml_jkn'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jml_jht'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jml_jp'] ?></td>
                            </tr>
                        <?php $angka++;
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
