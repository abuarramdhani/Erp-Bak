<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="font-family: times-new-roman">
    <h2>Lampiran</h2>
    <h2>Gaji <?php echo ucwords(strtolower($jenis)) ?> yang di-cut off pada penggajian bulan <?php echo strftime('%B %Y',strtotime($memo['periode'])) ?> dan Pekerja Keluar <?php echo $memo['cutawal'] !== "-" ? strftime("%d %B %Y",strtotime($memo['cutawal'])) : "-" ?> s.d <?php echo $memo['akhirbulan'] !== "-" ? strftime("%d %B %Y",strtotime($memo['akhirbulan'])) : "-" ?></h2>
    <small><span style="color: red">*</span> Pekerja yang dibayar cut off.</small>
	<table style="width:100%" style="border-collapse: collapse;border: 1px solid black">
        <thead>
            <tr>
                <?php 
                if ($jenis == "staff") { ?>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;width: 2%">No</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;width: 4%">Noind</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;width: 13%">Nama</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;width: 15%">Seksi</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">Tgl Klr</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IK</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IP</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IPT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IF</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IMS</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IMM</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">LEMBUR</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">UMP</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">UMC</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">UBT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">UPAMK</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">CT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">Ket</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">DL&Obat</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">I&ABS</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">Pot.Lain</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">JKN</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">JHT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">JP</th>
                <?php   
                 }else{ ?>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;width: 3%">No</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;width: 6%">Noind</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;width: 10%">Nama</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;width: 15%">Seksi</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">Tgl Klr</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IK</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IP</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IF</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">HTM</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">UBT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">UPAMK</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IMS</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">IMM</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">LEMBUR</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">UMP</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">CT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">Ket</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">DL&Obat</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">Pot.Lain</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">JKN</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">JHT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 10pt;padding-left: 4px;padding-right: 4px;">JP</th>
                <?php 
                 } 
                ?>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($data) && !empty($data)) {
                $angka = 1;
                foreach ($data as $key) { 
                    if ($jenis == "staff") { ?>
                        <tr>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$angka.'<span style="color: red">'.$key['remark_cutoff'].'</span>' ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$key['noind'] ?></td>
                            <td style="border: 1px solid black;text-align: left;font-size: 8pt"><?=$key['nama'] ?></td>
                            <td style="border: 1px solid black;text-align: left;font-size: 8pt"><?=$key['seksi'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?php $t = strtotime($key['tanggal']); echo date('d/m/Y',$t); ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ika'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ipe'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ipet'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ief'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ims'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['imm'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['jam_lembur'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['um_puasa'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['um_cabang'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ubt'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['upamk'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ct'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$key['ket'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['dldobat'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['htm'] + $key['ijin']  ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['plain'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['jml_jkn'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['jml_jht'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['jml_jp'] ?></td>
                        </tr>
                <?php }else{ ?>
                        <tr>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$angka.'<span style="color: red">'.$key['remark_cutoff'].'</span>' ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$key['noind'] ?></td>
                            <td style="border: 1px solid black;text-align: left;font-size: 8pt"><?=$key['nama'] ?></td>
                            <td style="border: 1px solid black;text-align: left;font-size: 8pt"><?=$key['seksi'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?php $t = strtotime($key['tanggal']); echo date('d/m/Y',$t); ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ika'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ipe'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ief'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['htm'] + $key['ijin'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ubt'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['upamk'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ims'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['imm'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['jam_lembur'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['um_puasa'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['ct'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$key['ket'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['dldobat'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['plain'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['jml_jkn'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['jml_jht'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 10pt"><?=$key['jml_jp'] ?></td>
                        </tr>
                <?php } 
                    $angka++;
                }
            } ?>
        </tbody>
    </table>
</body>
</html>