<html>
    <head>
    </head>
    <body style="color: black;font-family: monospace;font-size: 8pt;">
        <div style='text-align: left'>
            <?php $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                $bulan_pendek = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
                $prd_awal = explode("-", $awal);
                $prd_akhir = explode("-", $akhir);
            ?>
            <h4 style="color: black;">Data Pekerja Keluar</h4>
            <h5 style="color: black;">Periode Pekerja Keluar : <?php echo $prd_awal[2]." ".$bulan_pendek[intval($prd_awal[1])]." ".$prd_awal[0]." - ".$prd_akhir[2]." ".$bulan_pendek[intval($prd_akhir[1])]." ".$prd_akhir[0] ?></h5>
        </div>
        <table style="border-collapse: collapse;" >
            <thead class=" bg-primary">
                <tr>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">No.</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">No Induk</th>
                    <th style="border: 1px solid grey;text-align: center;width: 100px;">Nama</th>
                    <th style="border: 1px solid grey;text-align: center;width: 80px;">Tanggal Keluar</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IP</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IK</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">UBT</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">UPAMK</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IF</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">LEMBUR</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">HTM</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">Ijin</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">Sisa Cuti</th>
                    <th style="border: 1px solid grey;text-align: center;width: 90px;">Ket</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">UM Puasa</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IMS</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IMM</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IPT</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">UM Cabang</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Total Duka</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Uang DL</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Pot. Lain</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Tamb.</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Pot.</th>
                    <th style="border: 1px solid grey;text-align: center;width: 10px;">Jml JKN</th>
                    <th style="border: 1px solid grey;text-align: center;width: 10px;">Jml JHT</th>
                    <th style="border: 1px solid grey;text-align: center;width: 10px;">Jml JP</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if (isset($data) && !empty($data)) {
                        $nomor = 1;
                        $simpanNoind = "";
                        foreach ($data as $key => $value) {
                            if ($simpanNoind != "" && $simpanNoind != substr($value['noind'], 0,1)) {
                                $nomor = 1;
                                ?>
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
                <td></td>
                <td style='text-align: center;font-size: 10pt'>(<?php echo $this->session->employee ?>)</td>
            </tr>
        </table>
        <div style="page-break-after: always;"></div>
        <div style='text-align: left'>
            <?php $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                $bulan_pendek = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
                $prd_awal = explode("-", $awal);
                $prd_akhir = explode("-", $akhir);
            ?>
            <h4 style="color: black;">Data Pekerja Keluar</h4>
            <h5 style="color: black;">Periode Pekerja Keluar : <?php echo $prd_awal[2]." ".$bulan_pendek[intval($prd_awal[1])]." ".$prd_awal[0]." - ".$prd_akhir[2]." ".$bulan_pendek[intval($prd_akhir[1])]." ".$prd_akhir[0] ?></h5>
        </div>
        <table style="border-collapse: collapse;" >
            <thead class=" bg-primary">
                <tr>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">No.</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">No Induk</th>
                    <th style="border: 1px solid grey;text-align: center;width: 100px;">Nama</th>
                    <th style="border: 1px solid grey;text-align: center;width: 80px;">Tanggal Keluar</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IP</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IK</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IF</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">UBT</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">UPAMK</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">HTM</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">Ijin</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">UM Puasa</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">LEMBUR</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IMM</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IMS</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">IPT</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">UM Cabang</th>
                    <th style="border: 1px solid grey;text-align: center;width: 30px;">Sisa Cuti</th>
                    <th style="border: 1px solid grey;text-align: center;width: 90px;">Ket</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Total Duka</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Uang DL</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Pot. Lain</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Tamb.</th>
                    <th style="border: 1px solid grey;text-align: center;width: 40px;">Pot.</th>
                    <th style="border: 1px solid grey;text-align: center;width: 10px;">Jml JKN</th>
                    <th style="border: 1px solid grey;text-align: center;width: 10px;">Jml JHT</th>
                    <th style="border: 1px solid grey;text-align: center;width: 10px;">Jml JP</th>
                </tr>
            </thead>
            <tbody>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border: 1px solid grey;text-align: center;"><?php echo $nomor ?></td>
                                <td style="border: 1px solid grey;text-align: center;"><?php echo $value['noind'] ?></td>
                                <td style="border: 1px solid grey;"><?php echo substr($value['nama'],0, 15) ?></td>
                                <td style="border: 1px solid grey;text-align: center;"><?php echo date('d M Y',strtotime($value['tanggal_keluar'])) ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ipe'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ika'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ief'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ubt'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['upamk'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['htm'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ijin'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['um_puasa'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['jam_lembur'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['imm'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ims'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ipet'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['um_cabang'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ct'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['ket'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo number_format($value['pduka'],0,',','.') ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['dldobat'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['plain'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['tambahan_str'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['potongan_str'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['jml_jkn'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['jml_jht'] ?></td>
                                <td style="border: 1px solid grey;text-align: right;"><?php echo $value['jml_jp'] ?></td>
                            </tr>
                            <?php
                            $simpanNoind = substr($value['noind'], 0,1);
                            $nomor++;
                        }
                    }
                    ?>
            </tbody>
        </table>
        <br>
        <table style='width: 100%'>
            <tr>
                <td style="width: 75%"></td>
                <td style='text-align: center;font-size: 10pt'>Yogyakarta, <?php echo date('d').' '.$bulan[intval(date('m'))].' '.date('Y') ?></td>
            </tr>
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
                <td></td>
                <td style='text-align: center;font-size: 10pt'>(<?php echo $this->session->employee ?>)</td>
            </tr>
        </table>
    </body>
</html>
