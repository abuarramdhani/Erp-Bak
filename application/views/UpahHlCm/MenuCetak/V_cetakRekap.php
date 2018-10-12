<html>
<head>
</head>
<body>
<?php 
		set_time_limit(0);
		ini_set("memory_limit", "2048M");
							
	?>
<div style="width: 100%; height: 100%; border: 1px solid black; padding: 0px;">
	<table style="width: 100%; font-size: 14px;">
		<tr>
			<td height="30px" colspan="2" style="text-align: center;">PEMBAYARAN UPAH PEKERJA HARIAN KHS PUSAT & KHS TUKSONO</td>
		</tr>
		<tr>
			<td style="width: 30%;">PERIODE TANGGAL :</td>
			<td><?php $period=explode(" - ", $periode);echo date('d F Y',strtotime($period[0]));echo " - ";echo date('d F Y',strtotime($period[1]));;?></td>
		</tr>
	</table>
	<table style="width: 100%;border-collapse: collapse;font-size: 12px;margin-top: 10px;">
		<tr style="background-color: #ccffcc;">
			<td style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center; width: 4%; height: 25px;">NO</td>
			<td style="border: 1px solid black; text-align: center; width: 10%">TGL TERIMA</td>
			<td style="border: 1px solid black; text-align: center; width: 16%">NO REKENING</td>
			<td style="border: 1px solid black; text-align: center; width: 15%">NAMA</td>
			<td style="border: 1px solid black; text-align: center; width: 13%;">TERIMA</td>
			<td style="border: 1px solid black; text-align: center; width: 15%">NAMA PENERIMA REKENING</td>
			<td style="border: 1px solid black; text-align: center; width: 13%">BANK</td>
			<td style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center;">KETERANGAN</td>
		</tr>
		<tr>
			<td style="text-align: center;background-color: #ccffcc;" colspan="8">TUKSONO</td>
		</tr>
		<?php
		$total_semua = "";
		$no=1;
		foreach ($kom as $key) {
			$gpokok  = $key['gpokok'];
			$um		 = $key['um'];
			$lembur  = $key['lembur'];
			for ($i=0; $i < 8; $i++) { 
				if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
					$nomgpokok = $nom[$i]['nominal'];
				}
				if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
					$nomum = $nom[$i]['uang_makan'];
				}
			}
			$gajipokok = $gpokok*$nomgpokok;
			$gajium    = $um*$nomum;
			$gajilembur= $lembur*($nomgpokok/7);
			$total 	   = $gajipokok+$gajilembur+$gajium;
			$total_semua = $total_semua+$total;
			if ($key['lokasi_kerja'] == '02') {
				?>
				<tr>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $no;?></td>
					<td style="border: 1px solid black; text-align: center;"><?php ?></td>
					<td style="border: 1px solid black; text-align: center;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['no_rekening'];
								}
							}
						?>
					</td>
					<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['nama'];?></td>
					<td style="border: 1px solid black;padding-left: 3px;"><?php echo $total;?></td>
					<td style="border: 1px solid black;padding-left: 2px;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['atas_nama'];
								}
							}
						?>
					</td>
					<td style="border: 1px solid black; text-align: center;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['bank'];
								}
							}
						?>
					</td>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
				</tr>
				<?php
			$no++;
			}
		}
		?>
		<tr>
			<td style="text-align: center;background-color: #ccffcc;" colspan="8">PUSAT</td>
		</tr>
		<?php
		$jml_tuk ="";
		foreach ($kom as $op) {
			if ($op['lokasi_kerja'] == '02') {
				$jml_tuk = $jml_tuk+1;
			}
		}
		$nom = $jml_tuk+1;
		foreach ($kom as $key) {
			$gpokok  = $key['gpokok'];
			$um		 = $key['um'];
			$lembur  = $key['lembur'];
			for ($i=0; $i < 8; $i++) { 
				if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
					$nomgpokok = $nom[$i]['nominal'];
				}
				if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
					$nomum = $nom[$i]['uang_makan'];
				}
			}
			$gajipokok = $gpokok*$nomgpokok;
			$gajium    = $um*$nomum;
			$gajilembur= $lembur*($nomgpokok/7);
			$total 	   = $gajipokok+$gajilembur+$gajium;
			if ($key['lokasi_kerja'] == '01') {
				?>
				<tr>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $nom;?></td>
					<td style="border: 1px solid black; text-align: center;"><?php ?></td>
					<td style="border: 1px solid black; text-align: center;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['no_rekening'];
								}
							}
						?>
					</td>
					<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['nama'];?></td>
					<td style="border: 1px solid black;padding-left: 3px;"><?php echo $total;?></td>
					<td style="border: 1px solid black;padding-left: 2px;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['atas_nama'];
								}
							}
						?>
					</td>
					<td style="border: 1px solid black; text-align: center;">
						<?php 
							foreach ($rekap as $ker) {
								if ($key['noind'] == $ker['noind']) {
									echo $ker['bank'];
								}
							}
						?>
					</td>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
				</tr>
				<?php
			$nom++;
			}
		}
		?>
		<tr>
			<td height="20px;"></td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td style="border: 1px solid black;"><b>TOTAL</b></td>
			<td style="border: 1px solid black;"><?php echo $total_semua;?></td>
			<td></td>
			<td colspan="2">Yogyakarta, <?php echo date('d F Y');?></td>
		</tr>
		<tr>
			<td height="50px"></td>
		</tr>
		<tr>
			<td colspan="6"></td>			
			<td colspan="2"><u>Eko Prasetyo Adhi</u></td>
		</tr>
		<tr style="margin-top: 10px;">
			<td colspan="6"></td>			
			<td colspan="2">Kepala Seksi Civil Maintenance</td>
		</tr>
	</table>

</div>
</body>
</html>

