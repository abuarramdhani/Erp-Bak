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
            <h4 style="color: black;">Data Pekerja Keluar</h4>
            <h5 style="color: black;">Periode Pekerja Keluar : <?php echo $prd_awal[2]." ".$bulan_pendek[intval($prd_awal[1])]." ".$prd_awal[0]." - ".$prd_akhir[2]." ".$bulan_pendek[intval($prd_akhir[1])]." ".$prd_akhir[0] ?></h5>
        </div>
        <div>
            <table style="width:100%" >
                <thead class=" bg-primary">
                    <tr>
                        <?php 
                        $staff = array("B","D","J","T");
                        if (in_array($pos['slcStatusPekerja2'], $staff)) { ?>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 3%">No</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 6%">Noind</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 300px">Nama</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 15%">Seksi</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 10%">Tanggal Keluar</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IK</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IP</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IPT</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IF</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IMS</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IMM</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 12pt;width: 5%">LEMBUR</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 12pt;width: 5%">UM Puasa</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 12pt;width: 5%">UM<br>Cabang</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">UBT</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 12pt;width: 5%">UPAMK</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">Sisa Cuti</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">Ket.</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">DL & Obat</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">I & ABS</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 8%">Pot. Lain</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">JKN</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">JHT</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">JP</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">Jml Duka</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 10%">Total Duka</th>
                        <?php   
                         }else{ ?>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 3%">No</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 6%">Noind</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 300px">Nama</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 15%">Seksi</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 10%">Tanggal Keluar</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IK</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IP</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IF</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">HTM</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">UBT</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 12pt;width: 5%">UPAMK</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IMS</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">IMM</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 12pt;width: 5%">LEMBUR</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">UM Puasa</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">Sisa Cuti</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">Ket.</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">DL & Obat</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 8%">Pot. Lain</th>
                            <?php  if ($pos['slcStatusPekerja2'] == "H") { ?>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 8%">Pot. Seragam</th>                                    
                            <?php } ?>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 8%">Tam.</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 8%">Pot.</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">JKN</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">JHT</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">JP</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 5%">Jml Duka</th>
                            <th style="color: black;padding: 3px;text-align: center;border: 1px solid black;font-size: 14pt;width: 10%">Total Duka</th>
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
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$angka ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['noind'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: left;font-size: 14pt"><?=$key['nama_lengkap'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: left;font-size: 14pt"><?=$key['seksi'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?php $t = strtotime($key['tgl_keluar']); echo date('d M Y',$t); ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ik'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ip'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ipt'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['if'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ims'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['imm'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['lembur'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['um_puasa'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['um_cabang'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ubt'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['upamk'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['sisa_cuti'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ket'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=number_format($key['um_dl']) ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['htm'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=number_format($key['pot_lain']) ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['jml_jkn'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['jml_jht'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['jml_jp'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['jml_duka'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=number_format($key['nom_duka']) ?></td>
                                </tr>
                        <?php }else{ ?>
                                <tr>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$angka ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['noind'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: left;font-size: 14pt"><?=$key['nama_lengkap'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: left;font-size: 14pt"><?=$key['seksi'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?php $t = strtotime($key['tgl_keluar']); echo date('d M Y',$t); ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ik'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ip'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['if'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['htm'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ubt'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['upamk'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ims'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['imm'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['lembur'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['um_puasa'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['sisa_cuti'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['ket'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=number_format($key['um_dl']) ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=number_format($key['pot_lain']) ?></td>
                                     <?php if ($pos['slcStatusPekerja2'] == "H") { ?>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=number_format(intval($key['pot_seragam'])) ?></td>
                                    <?php  } ?>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['tam_susulan'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['pot_susulan'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['jkn'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['jht'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['jp'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=$key['jml_duka'] ?></td>
                                    <td style="color: black;padding: 3px;border: 1px solid black;text-align: center;font-size: 14pt"><?=number_format($key['nom_duka']) ?></td>
                                </tr>
                        <?php } 
                            $angka++;
                        }
                    } ?>
                </tbody>
            </table>
            <br>
            <table style='width: 100%'>
            <tr>
                <td style="width: 75%"></td>
                <td style='text-align: center;font-size: 10pt'>Dicetak oleh,</td>
            </tr>
            <tr>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                   
                </td>
                <td style='text-align: center;font-size: 10pt'>(<?php echo $this->session->employee ?>)</td>
            </tr>
            </table>
        </div>
    </body>
</html>
