<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <h2>Lampiran</h2>
    <h2>Gaji <?php echo ucwords(strtolower($jenis)) ?> yang di-cut off pada penggajian bulan <?php echo strftime('%B %Y',strtotime($memo['periode']." - 1 month")) ?> dan Pekerja Keluar <?php echo $memo['cutawal'] !== "-" ? strftime("%d %B %Y",strtotime($memo['cutawal'])) : "-" ?> s.d <?php echo $memo['akhirbulan'] !== "-" ? strftime("%d %B %Y",strtotime($memo['akhirbulan'])) : "-" ?></h2>
    <small>* Pekerja yang dibayar cut off.</small>
	<table style="width:100%" style="border-collapse: collapse;border: 1px solid black">
        <thead>
            <tr>
                <?php 
                if ($jenis == "staff") { ?>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 2%">No</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 4%">Noind</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 13%">Nama</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 15%">Seksi</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 8%">Tanggal Keluar</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IK</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IP</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IPT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IF</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IMS</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IMM</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">LEMBUR</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">UM Puasa</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">UM Cabang</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">UBT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">UPAMK</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Sisa Cuti</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Keterangan</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">DL & Obat</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">I & ABS</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 8%">Pot. Lain</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Jumlah JKN</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Jumlah JHT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Jumlah JP</th>
                <?php   
                 }else{ ?>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 3%">No</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 6%">Noind</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 10%">Nama</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 15%">Seksi</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 8%">Tanggal Keluar</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IK</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IP</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IF</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">HTM</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">UBT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">UPAMK</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IMS</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">IMM</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">LEMBUR</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">UM Puasa</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Sisa Cuti</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Keterangan</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">DL & Obat</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 8%">Pot. Lain</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Jumlah JKN</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Jumlah JHT</th>
                    <th style="border: 1px solid black;text-align: center;font-size: 13pt;width: 5%">Jumlah JP</th>
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
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$angka.$key['remark_cutoff'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$key['noind'] ?></td>
                            <td style="border: 1px solid black;text-align: left;font-size: 8pt"><?=$key['nama'] ?></td>
                            <td style="border: 1px solid black;text-align: left;font-size: 8pt"><?=$key['seksi'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?php $t = strtotime($key['tanggal']); echo date('d/m/Y',$t); ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ika'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ipe'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ipet'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ief'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ims'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['imm'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['jam_lembur'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['um_puasa'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['um_cabang'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ubt'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['upamk'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ct'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$key['ket'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['dldobat'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['htm'] + $key['ijin']  ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['plain'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['jml_jkn'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['jml_jht'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['jml_jp'] ?></td>
                        </tr>
                <?php }else{ ?>
                        <tr>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$angka ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$key['noind'] ?></td>
                            <td style="border: 1px solid black;text-align: left;font-size: 8pt"><?=$key['nama'] ?></td>
                            <td style="border: 1px solid black;text-align: left;font-size: 8pt"><?=$key['seksi'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?php $t = strtotime($key['tanggal']); echo date('d/m/Y',$t); ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ika'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ipe'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ief'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['htm'] + $key['ijin'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ubt'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['upamk'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ims'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['imm'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['jam_lembur'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['um_puasa'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['ct'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 8pt"><?=$key['ket'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['dldobat'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['plain'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['jml_jkn'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['jml_jht'] ?></td>
                            <td style="border: 1px solid black;text-align: center;font-size: 13pt"><?=$key['jml_jp'] ?></td>
                        </tr>
                <?php } 
                    $angka++;
                }
            } ?>
        </tbody>
    </table>
</body>
</html>