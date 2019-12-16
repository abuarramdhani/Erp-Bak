<html>
    <head>
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" />
    </head>
    <body>
        <div style='text-align: left'>
            <?php $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                $bulan_pendek = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
                $tgl_Cetak = explode('-',$pos['txtTglCetak2']);
                $prd = explode(" - ",$pos['txtPeriodeGaji2']);
                $prd_awal = explode("-", $prd[0]);
                $prd_akhir = explode("-", $prd[1]);
            ?>
            <h5>Data Pekerja Keluar</h5>
            <h6>Periode Pekerja Keluar : <?php echo $prd_awal[2]." ".$bulan_pendek[intval($prd_awal[1])]." ".$prd_awal[0]." - ".$prd_akhir[2]." ".$bulan_pendek[intval($prd_akhir[1])]." ".$prd_akhir[0] ?></h6>
        </div>
        <div>
        <table style="width:100%" class="table table-bordered table-hover table-striped dataTable">
                <thead class=" bg-primary">
                    <tr>
                        <?php 
                        $staff = array("B","D","J","T");
                        if (in_array($pos['slcStatusPekerja2'], $staff)) { ?>
                            <th style="text-align: center;font-size: 8pt;width: 3%">No</th>
                            <th style="text-align: center;font-size: 8pt;width: 6%">Noind</th>
                            <th style="text-align: center;font-size: 8pt;width: 10%">Nama</th>
                            <th style="text-align: center;font-size: 8pt;width: 15%">Seksi</th>
                            <th style="text-align: center;font-size: 8pt;width: 8%">Tanggal Keluar</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IK</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IP</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IPT</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IF</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IMS</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IMM</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">LEMBUR</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">UM Puasa</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">UM Cabang</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">UBT</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">UPAMK</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Sisa Cuti</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Keterangan</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">DL & Obat</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">I & ABS</th>
                            <th style="text-align: center;font-size: 8pt;width: 8%">Pot. Lain</th>
                            <th style="text-align: center;font-size: 8pt;width: 8%">Pot. Seragam</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JKN</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JHT</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JP</th>
                        <?php   
                         }else{ ?>
                            <th style="text-align: center;font-size: 8pt;width: 3%">No</th>
                            <th style="text-align: center;font-size: 8pt;width: 6%">Noind</th>
                            <th style="text-align: center;font-size: 8pt;width: 10%">Nama</th>
                            <th style="text-align: center;font-size: 8pt;width: 15%">Seksi</th>
                            <th style="text-align: center;font-size: 8pt;width: 8%">Tanggal Keluar</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IK</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IP</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IF</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">HTM</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">UBT</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">UPAMK</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IMS</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">IMM</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">LEMBUR</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">UM Puasa</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Sisa Cuti</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Keterangan</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">DL & Obat</th>
                            <th style="text-align: center;font-size: 8pt;width: 8%">Pot. Lain</th>
                            <th style="text-align: center;font-size: 8pt;width: 8%">Pot. Seragam</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JKN</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JHT</th>
                            <th style="text-align: center;font-size: 8pt;width: 5%">Jumlah JP</th>
                        <?php 
                         } 
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data) && !empty($data)) {
                        $angka = 1;
                        foreach ($data as $key) { 
                            if (in_array($pos['slcStatusPekerja2'], $staff)) { ?>
                                <tr>
                                    <td style="text-align: center;font-size: 8pt"><?=$angka ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['noind'] ?></td>
                                    <td style="text-align: left;font-size: 8pt"><?=$key['nama'] ?></td>
                                    <td style="text-align: left;font-size: 8pt"><?=$key['seksi'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?php $t = strtotime($key['tgl_keluar']); echo date('d/m/Y',$t); ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ik'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ip'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ipt'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['if'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ims'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['imm'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['lembur'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['um_puasa'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['um_cabang'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ubt'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['upamk'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['sisa_cuti'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['sk_susulan']+$key['cuti_susulan'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?="" ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['htm'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['pot_lain'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['pot_seragam'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['jml_jkn'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['jml_jht'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['jml_jp'] ?></td>
                                </tr>
                        <?php }else{ ?>
                                <tr>
                                    <td style="text-align: center;font-size: 8pt"><?=$angka ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['noind'] ?></td>
                                    <td style="text-align: left;font-size: 8pt"><?=$key['nama'] ?></td>
                                    <td style="text-align: left;font-size: 8pt"><?=$key['seksi'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?php $t = strtotime($key['tgl_keluar']); echo date('d/m/Y',$t); ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ik'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ip'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['if'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['htm'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ubt'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['upamk'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['ims'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['imm'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['lembur'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['um_puasa'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['sisa_cuti'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['sk_susulan']+$key['cuti_susulan'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?="" ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['pot_lain'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['pot_seragam'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['jml_jkn'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['jml_jht'] ?></td>
                                    <td style="text-align: center;font-size: 8pt"><?=$key['jml_jp'] ?></td>
                                </tr>
                        <?php } 
                            $angka++;
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
