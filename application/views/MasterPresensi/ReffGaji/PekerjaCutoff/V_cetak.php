<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
		$noind_cut = array();
		if (!empty($cut)) {
			foreach ($cut as $value) {
				$noind_cut[] = $value['noind'];
			}
		}
		if($jenis == "staff"){ ?>
			<table style="width: 100%;border-bottom: 1px solid black">
				<tbody>
					<tr>
						<td rowspan="6"><img width="100px" src="<?php echo site_url('assets/img/logo.png') ?>"></td>
						<td style="text-align: justify;font-weight: bold;font-size: 20pt">
							CV. KARYA HIDUP SENTOSA
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;font-weight: bold;font-size: 9pt">
							PABRIK MESIN ALAT PERTANIAN <span style="font-size: 5pt">●</span> PENGECORAN LOGAM <span style="font-size: 5pt">●</span> DEALER UTAMA DIESEL KUBOTA
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;">
							Kantor Pusat : Jl. Magelang No. 144 Jogjakarta 55241 Indonesia
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;">
							Telp. : (0274) 512095 (hunting), 563217, 583874, 513025, 556923
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;">
							Fax. : (0274) 563523 (Umum), 554069 (Pembelian) E-mail : operator1@quick.co.id
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;font-weight: bold;">
							Website : www.quick.co.id <span style="font-size: 5pt">●</span> M-Web : m.quick.co.id <span style="font-size: 5pt">●</span> Facebook : facebook.com/quicktracktor
						</td>
					</tr>
				</tbody>
			</table>
			<h1 style="text-align: center">MEMO</h1>
			<table style="width: 100%;font-size: 12pt;">
				<tr>
					<td>No</td>
					<td>:</td>
					<td><?php echo $memo['nomor_surat']; ?></td>
					<td><?php echo strftime('%d %B %Y'); ?></td>
				</tr>
				<tr>
					<td>Hal</td>
					<td>:</td>
					<td>Memo Gaji Staff yang Dibayar Cut Off</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td><b>Dari</b></td>
					<td><b>:</b></td>
					<td><b>Seksi <?php echo ucwords(strtolower($memo['seksi'])); ?></b></td>
					<td></td>
				</tr>
				<tr>
					<td><b>kepada</b></td>
					<td><b>:</b></td>
					<td><b><?php echo $memo['kepada_staff']; ?></b></td>
					<td></td>
				</tr>
			</table>
			<br>
			<p style="font-size: 12pt;">Dengan Hormat, </p>
			<p style="font-size: 12pt;">Mohon diperhitungkan dan dibayarkan pada tanggal 10 <?php echo strftime('%B %Y',strtotime($memo['periode'])) ?> Gaji Staff yang kami Cut Off di bulan <?php echo strftime('%B %Y',strtotime($memo['periode']." - 1 month")) ?>. Data sebagai berikut.</p>
			<table style="border-collapse: collapse;border: 1px solid black;width: 100%;font-size: 10pt;">
				<thead>
					<tr>
						<th style="border: 1px solid black;" rowspan="2">NO</th>
						<th style="border: 1px solid black;" rowspan="2">NO INDUK</th>
						<th style="border: 1px solid black;" rowspan="2">NAMA</th>
						<th style="border: 1px solid black;" rowspan="2">SEKSI</th>
						<th style="border: 1px solid black;" colspan="2">Komponen</th>
						<th style="border: 1px solid black;" rowspan="2">Pot. JHT,JKN & JP</th>
					</tr>
					<tr>
						<th style="border: 1px solid black;">GP</th>
						<th style="border: 1px solid black;">IF</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (isset($data) and !empty($data)) {
						$nomor = 1;
						foreach ($data as $key) { 
							if (in_array($key['noind'], $noind_cut)) { ?>
								<tr>
									<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$nomor ?></td>
									<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['noind'] ?></td>
									<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;"><?=$key['nama'] ?></td>
									<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;"><?=$key['seksi'] ?></td>
									<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['ief'] ?></td>
									<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['ief'] ?></td>
									<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center">Tidak dipotong</td>
								</tr>
							 	
							<?php 
								$nomor++;
							 } 
						}
					}
					?>
				</tbody>
			</table>
			<p style="font-size: 12pt;">Demikian permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
			<br>
			<table style="width: 100%;font-size: 12pt;">
				<tr>
					<td style="width: 50%;text-align: center;">Mengetahui,</td>
					<td style="width: 50%;text-align: center">Hormat kami,</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="width: 50%;text-align: center;"><b><u><?php echo ucwords(strtolower($memo['mengetahui'])) ?></u></b></td>
					<td style="width: 50%;text-align: center;"><b><u><?php echo ucwords(strtolower($memo['dibuat'])) ?></u></b></td>
				</tr>
				<tr>
					<td style="width: 50%;text-align: center;"><?php echo ucwords(strtolower($memo['jabatan_1'])) ?></td>
					<td style="width: 50%;text-align: center;"><?php echo ucwords(strtolower($memo['jabatan_2'])) ?></td>
				</tr>
			</table>
		<?php }else{ ?>
			<table style="width: 100%;border-bottom: 1px solid black">
				<tbody>
					<tr>
						<td rowspan="6"><img width="100px" src="<?php echo site_url('assets/img/logo.png') ?>"></td>
						<td style="text-align: justify;font-weight: bold;font-size: 20pt">
							CV. KARYA HIDUP SENTOSA
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;font-weight: bold;font-size: 9pt">
							PABRIK MESIN ALAT PERTANIAN <span style="font-size: 5pt">●</span> PENGECORAN LOGAM <span style="font-size: 5pt">●</span> DEALER UTAMA DIESEL KUBOTA
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;">
							Kantor Pusat : Jl. Magelang No. 144 Jogjakarta 55241 Indonesia
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;">
							Telp. : (0274) 512095 (hunting), 563217, 583874, 513025, 556923
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;">
							Fax. : (0274) 563523 (Umum), 554069 (Pembelian) E-mail : operator1@quick.co.id
						</td>
					</tr>
					<tr>
						<td style="text-align: justify;font-weight: bold;">
							Website : www.quick.co.id <span style="font-size: 5pt">●</span> M-Web : m.quick.co.id <span style="font-size: 5pt">●</span> Facebook : facebook.com/quicktracktor
						</td>
					</tr>
				</tbody>
			</table>
			<h1 style="text-align: center">MEMO</h1>
			<table style="width: 100%;font-size: 12pt;">
				<tr>
					<td>No</td>
					<td>:</td>
					<td><?php echo $memo['nomor_surat']; ?></td>
					<td><?php echo strftime('%d %B %Y'); ?></td>
				</tr>
				<tr>
					<td>Hal</td>
					<td>:</td>
					<td>Memo Gaji Non Staff yang Dibayar Cut Off</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td><b>Dari</b></td>
					<td><b>:</b></td>
					<td><b>Seksi <?php echo ucwords(strtolower($memo['seksi'])); ?></b></td>
					<td></td>
				</tr>
				<tr>
					<td><b>kepada</b></td>
					<td><b>:</b></td>
					<td><b><?php echo $memo['kepada_staff']; ?></b></td>
					<td></td>
				</tr>
			</table>
			<br>
			<p style="font-size: 12pt;">Dengan Hormat, </p>
			<p style="font-size: 12pt;">Mohon diperhitungkan dan dibayarkan pada tanggal 10 <?php echo strftime('%B %Y',strtotime($memo['periode'])) ?> Gaji Staff yang kami Cut Off di bulan <?php echo strftime('%B %Y',strtotime($memo['periode']." - 1 month")) ?>. Data pekerja terlampir.</p>
			<p style="font-size: 12pt;">Demikian permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
			<br>
			<table style="width: 100%;font-size: 12pt;">
				<tr>
					<td style="width: 50%;text-align: center;">Mengetahui,</td>
					<td style="width: 50%;text-align: center">Hormat kami,</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="width: 50%;text-align: center;"><b><u><?php echo ucwords(strtolower($memo['mengetahui'])) ?></u></b></td>
					<td style="width: 50%;text-align: center;"><b><u><?php echo ucwords(strtolower($memo['dibuat'])) ?></u></b></td>
				</tr>
				<tr>
					<td style="width: 50%;text-align: center;"><?php echo ucwords(strtolower($memo['jabatan_1'])) ?></td>
					<td style="width: 50%;text-align: center;"><?php echo ucwords(strtolower($memo['jabatan_2'])) ?></td>
				</tr>
			</table>
			<pagebreak>
			<h2>Lampiran</h2>
			<h2>Gaji Non Staff yang di-cut off pada penggajian bulan <?php echo strftime('%B %Y',strtotime($memo['periode']." - 1 month")) ?></h2>
			<table style="border-collapse: collapse;border: 1px solid black;width: 100%">
				<thead>
					<tr>
						<th style="border: 1px solid black;">NO</th>
						<th style="border: 1px solid black;">NO INDUK</th>
						<th style="border: 1px solid black;">NAMA</th>
						<th style="border: 1px solid black;">SEKSI</th>
						<th style="border: 1px solid black;">Potongan HTM</th>
						<th style="border: 1px solid black;">Pot. JHT, JKN & JP</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (isset($data) and !empty($data)) {
						$nomor = 1;
						foreach ($data as $key) { 
							if (in_array($key['noind'], $noind_cut)) { ?>
							<tr>
								<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$nomor ?></td>
								<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['noind'] ?></td>
								<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;"><?=$key['nama'] ?></td>
								<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;"><?=$key['seksi'] ?></td>
								<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['htm'] ?> hari</td>
								<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center">Tidak dipotong</td>
							</tr>
							<?php 
							$nomor++;
							}
						}
					}
					?>
				</tbody>
			</table>			
		<?php 
		}
	?>
</body>
</html>