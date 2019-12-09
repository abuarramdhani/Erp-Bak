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
					<td style="width: 10%">No</td>
					<td style="width: 3%">:</td>
					<td style="width: 62%"><?php echo $memo['nomor_surat']; ?></td>
					<td style="width: 25%"><?php echo strftime('%d %B %Y'); ?></td>
				</tr>
				<tr>
					<td>Hal</td>
					<td>:</td>
					<td colspan="2">Memo Gaji Staff yang Dibayar Cut Off & <br> Pekerja Keluar <?php echo $memo['cutawal'] !== "-" ? strftime("%d %B %Y",strtotime($memo['cutawal'])) : "-" ?> s.d <?php echo $memo['akhirbulan'] !== "-" ? strftime("%d %B %Y",strtotime($memo['akhirbulan'])) : "-" ?></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td><b>Dari</b></td>
					<td><b>:</b></td>
					<td colspan="2"><b>Seksi <?php echo ucwords(strtolower($memo['seksi'])); ?></b></td>
				</tr>
				<tr>
					<td><b>kepada</b></td>
					<td><b>:</b></td>
					<td colspan="2"><b><?php echo $memo['kepada_staff']; ?></b></td>
				</tr>
			</table>
			<br>
			<p style="font-size: 12pt;">Dengan Hormat, </p>
			<p style="font-size: 12pt;">Mohon diperhitungkan dan dibayarkan pada tanggal 10 <?php echo strftime('%B %Y',strtotime($memo['periode'])) ?> Gaji Staff yang kami Cut Off di bulan <?php echo strftime('%B %Y',strtotime($memo['periode']." - 1 month")) ?> dan Pekerja Keluar antara <?php echo $memo['cutawal'] !== "-" ? strftime("%d %B %Y",strtotime($memo['cutawal'])) : "-" ?> s.d <?php echo $memo['akhirbulan'] !== "-" ? strftime("%d %B %Y",strtotime($memo['akhirbulan'])) : "-" ?>. Data pekerja terlampir.</p>
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
					<td style="width: 10%">No</td>
					<td style="width: 3%">:</td>
					<td style="width: 62%"><?php echo $memo['nomor_surat']; ?></td>
					<td style="width: 25%"><?php echo strftime('%d %B %Y'); ?></td>
				</tr>
				<tr>
					<td>Hal</td>
					<td>:</td>
					<td colspan="2">Memo Gaji Non Staff yang Dibayar Cut Off dan Pekerja Keluar <?php echo $memo['cutawal'] !== "-" ? strftime("%d %B %Y",strtotime($memo['cutawal'])) : "-" ?> s.d <?php echo $memo['akhirbulan'] !== "-" ? strftime("%d %B %Y",strtotime($memo['akhirbulan'])) : "-" ?></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td><b>Dari</b></td>
					<td><b>:</b></td>
					<td colspan="2"><b>Seksi <?php echo ucwords(strtolower($memo['seksi'])); ?></b></td>
				</tr>
				<tr>
					<td><b>kepada</b></td>
					<td><b>:</b></td>
					<td colspan="2"><b><?php echo $memo['kepada_staff']; ?></b></td>
				</tr>
			</table>
			<br>
			<p style="font-size: 12pt;">Dengan Hormat, </p>
			<p style="font-size: 12pt;">Mohon diperhitungkan dan dibayarkan pada tanggal 10 <?php echo strftime('%B %Y',strtotime($memo['periode'])) ?> Gaji Staff yang kami Cut Off di bulan <?php echo strftime('%B %Y',strtotime($memo['periode']." - 1 month")) ?> dan Pekerja Keluar antara <?php echo $memo['cutawal'] !== "-" ? strftime("%d %B %Y",strtotime($memo['cutawal'])) : "-" ?> s.d <?php echo $memo['akhirbulan'] !== "-" ? strftime("%d %B %Y",strtotime($memo['akhirbulan'])) : "-" ?>. Data pekerja terlampir.</p>
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
		<?php 
		}
	?>
</body>
</html>