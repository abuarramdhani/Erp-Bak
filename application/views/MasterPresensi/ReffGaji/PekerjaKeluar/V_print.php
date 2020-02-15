<html>
    <head>
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" />
    </head>
    <body style="color: black">
        <div style='text-align: left'>
            <?php $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                $bulan_pendek = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
                $tgl_Cetak = explode('-',$pos['txtTglCetak2']);
                $prd = explode(" - ",$pos['txtPeriodeGaji2']);
                $prd_awal = explode("-", $prd[0]);
                $prd_akhir = explode("-", $prd[1]);
            ?>
            <h3>Data Pekerja Keluar</h3>
            <h4>Periode Pekerja Keluar : <?php echo $prd_awal[2]." ".$bulan_pendek[intval($prd_awal[1])]." ".$prd_awal[0]." - ".$prd_akhir[2]." ".$bulan_pendek[intval($prd_akhir[1])]." ".$prd_akhir[0] ?></h4>
        </div>
        <div>
        <table style="width:100%" >
                <thead class=" bg-primary">
                    <tr>
                        <?php 
                        $staff = array("B","D","J","T");
                        if (in_array($pos['slcStatusPekerja2'], $staff)) { ?>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 3%">No</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 6%">Noind</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 300px">Nama</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 15%">Seksi</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 10%">Tanggal Keluar</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IK</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IP</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IPT</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IF</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IMS</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IMM</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">LEMBUR</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">UM Puasa</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">UM Cabang</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">UBT</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">UPAMK</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Sisa Cuti</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Keterangan</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">DL & Obat</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">I & ABS</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 8%">Pot. Lain</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 8%">Pot. Seragam</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Jumlah JKN</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Jumlah JHT</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Jumlah JP</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Jumlah Duka</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Total Duka</th>
                        <?php   
                         }else{ ?>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 3%">No</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 6%">Noind</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 300px">Nama</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 15%">Seksi</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 10%">Tanggal Keluar</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IK</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IP</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IF</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">HTM</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">UBT</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">UPAMK</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IMS</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">IMM</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">LEMBUR</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">UM Puasa</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Sisa Cuti</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Keterangan</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">DL & Obat</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 8%">Pot. Lain</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 8%">Pot. Seragam</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 8%">Tambahan</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 8%">Potongan</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Jumlah JKN</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Jumlah JHT</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Jumlah JP</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Jumlah Duka</th>
                            <th style="padding: 5px;text-align: center;border: 1px solid black;font-size: 15pt;width: 5%">Total Duka</th>
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
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$angka ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['noind'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: left;font-size: 15pt;color: black"><?=$key['nama_lengkap'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: left;font-size: 15pt"><?=$key['seksi'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?php $t = strtotime($key['tgl_keluar']); echo date('d M Y',$t); ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ik'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ip'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ipt'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['if'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ims'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['imm'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['lembur'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['um_puasa'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['um_cabang'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ubt'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['upamk'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['sisa_cuti'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ket'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['um_dl'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['htm'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=number_format($key['pot_lain']) ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=number_format($key['pot_seragam']) ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['jml_jkn'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['jml_jht'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['jml_jp'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['jml_duka'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=number_format($key['nom_duka']) ?></td>
                                </tr>
                        <?php }else{ ?>
                                <tr>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$angka ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt;color: black"><?=$key['noind'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: left;font-size: 15pt"><?=$key['nama_lengkap'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: left;font-size: 15pt"><?=$key['seksi'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?php $t = strtotime($key['tgl_keluar']); echo date('d M Y',$t); ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ik'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ip'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['if'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['htm'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ubt'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['upamk'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ims'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['imm'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['lembur'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['um_puasa'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['sisa_cuti'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['ket'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['um_dl'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=number_format($key['pot_lain']) ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=number_format($key['pot_seragam']) ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['tam_susulan'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['pot_susulan'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['jml_jkn'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['jml_jht'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['jml_jp'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=$key['jml_duka'] ?></td>
                                    <td style="padding: 5px;border: 1px solid black;text-align: center;font-size: 15pt"><?=number_format($key['nom_duka']) ?></td>
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
