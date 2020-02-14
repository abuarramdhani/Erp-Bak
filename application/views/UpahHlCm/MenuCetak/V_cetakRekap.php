<html>
<head>
</head>
<body>
<?php 
		set_time_limit(0);
		ini_set("memory_limit", "2048M");
							
	?>
<div style="width: 100%; height: 100%; padding: 0px;">
	<table style="width: 100%; font-size: 14px;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black">
		<tr>
			<td height="30px" colspan="2" style="text-align: center;">PENGGAJIAN HARIAN LEPAS</td>
		</tr>
		<tr>
			<td style="width: 30%;">PERIODE BULAN TAHUN :</td>
			<td><?php $period=explode(" - ", $periode);echo date('d F Y',strtotime($period[0]));echo " - ";echo date('d F Y',strtotime($period[1]));;?></td>
		</tr>
	</table>
	<div style="width: 100%;height: 10px; border-left: 1px solid black; border-right: 1px solid black">
		
	</div>
	<table style="width: 100%;border-collapse: collapse;font-size: 12px;page-break-after: always;border: 1px solid black;">
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
		$no = 1;
		foreach ($res as $key) {
			if ($key['lokasi_kerja'] == '02' and $no <= 37) { ?>
				<tr>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $no; ?></td>
					<td style="border: 1px solid black; text-align: center;"><?php echo $tglterima; ?></td>
					<td style="border: 1px solid black; text-align: center;"><?php echo $key['rekening'] ?></td>
					<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['nama'] ?></td>
					<td style="border: 1px solid black;padding-left: 3px;text-align: center;"><?php echo number_format($key['total_terima'],0,'','.') ?></td>
					<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['atas_nama'] ?></td>
					<td style="border: 1px solid black; text-align: center;"><?php echo $key['bank'] ?></td>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
				</tr>
			<?php 
			$no++; }
		}	?>
		</table>
		<table style="width: 100%;border-collapse: collapse;font-size: 12px;margin-top: 10px; border: 1px solid black;border-bottom-width: 0px">
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
		<?php 
		$no = 1;
		foreach ($res as $key) {
			if ($key['lokasi_kerja'] == '02') { 
					if ($no > 37) {
					?>
						<tr>
							<td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $no; ?></td>
							<td style="border: 1px solid black; text-align: center;"><?php echo $tglterima; ?></td>
							<td style="border: 1px solid black; text-align: center;"><?php echo $key['rekening'] ?></td>
							<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['nama'] ?></td>
							<td style="border: 1px solid black;padding-left: 3px;text-align: center;"><?php echo number_format($key['total_terima'],0,'','.') ?></td>
							<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['atas_nama'] ?></td>
							<td style="border: 1px solid black; text-align: center;"><?php echo $key['bank'] ?></td>
							<td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
						</tr>
			<?php } $no++; 
			}
		}	?>
		<tr>
			<td style="text-align: center;background-color: #ccffcc;" colspan="8">PUSAT</td>
		</tr>
		<?php 
		foreach ($res as $key) {
			if ($key['lokasi_kerja'] == '01') { ?>
				<tr>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $no; ?></td>
					<td style="border: 1px solid black; text-align: center;"><?php echo $tglterima; ?></td>
					<td style="border: 1px solid black; text-align: center;"><?php echo $key['rekening'] ?></td>
					<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['nama'] ?></td>
					<td style="border: 1px solid black;padding-left: 3px;text-align: center;"><?php echo number_format($key['total_terima'],0,'','.') ?></td>
					<td style="border: 1px solid black;padding-left: 2px;"><?php echo $key['atas_nama'] ?></td>
					<td style="border: 1px solid black; text-align: center;"><?php echo $key['bank'] ?></td>
					<td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
				</tr>
			<?php 
			$no++; }
		}	?>
		<tr>
			<td height="20px;"></td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td style="border: 1px solid black;"><b>TOTAL</b></td>
			<td style="border: 1px solid black;text-align: center;"><?php echo number_format($total_semua,0,'','.');?></td>
			<td colspan="3" style="text-align: center;">Yogyakarta, <?php 
				echo date('d');
				$month=date('m');
				if ($month=='01') {
					echo " Januari ";
				}elseif ($month=='02') {
					echo " Februari ";
				}elseif ($month=='03') {
					echo " Maret ";
				}elseif ($month=='04') {
					echo " April ";
				}elseif ($month=='05') {
					echo " Mei ";
				}elseif ($month=='06') {
					echo " Juni ";
				}elseif ($month=='07') {
					echo " Juli ";
				}elseif ($month=='08') {
					echo " Agustus ";
				}elseif ($month=='09') {
					echo " September ";
				}elseif ($month=='10') {
					echo " Oktober ";
				}elseif ($month=='11') {
					echo " November ";
				}elseif ($month=='12') {
					echo " Desember ";
				};
				echo date('Y');
			?></td>
		</tr>
		<tr>
			<td height="20px"></td>
		</tr>
	</table>
	<table style="width: 100%;border-collapse: collapse;font-size: 12px;page-break-after: always;border: 1px solid black;border-top-width: 0px">
		<tr>
			<td style="text-align: center">Mengetahui,</td>
			<td style="text-align: center">Menyetujui,</td>
			<td style="text-align: center">Dibuat Oleh</td>
		</tr>
		<tr>
			<td style="height: 50px" colspan="8"></td>
		</tr>
		<tr>
			<td style="text-align: center">
				<?php 
				foreach ($dibuat as $ttd_dibuat) {
					if ($ttd_dibuat['posisi'] == "mengetahui") {
						echo "<u>".ucwords(strtolower($ttd_dibuat['nama']))."</u>";
					}
				}
				?>
			</td>
			<td style="text-align: center">
				<?php 
				foreach ($dibuat as $ttd_dibuat) {
					if ($ttd_dibuat['posisi'] == "menyetujui") {
						echo "<u>".ucwords(strtolower($ttd_dibuat['nama']))."</u>";
					}
				}
				?>
			</td>
			<td style="text-align: center">
				<?php 
				foreach ($dibuat as $ttd_dibuat) {
					if ($ttd_dibuat['posisi'] == "dibuat") {
						echo "<u>".ucwords(strtolower($ttd_dibuat['nama']))."</u>";
					}
				}
				?>
			</td>
		</tr>
		<tr>
			<td style="text-align: center">
				<?php 
				foreach ($dibuat as $ttd_dibuat) {
					if ($ttd_dibuat['posisi'] == "mengetahui") {
						echo ucwords(strtolower($ttd_dibuat['jabatan']));
					}
				}
				?>
			</td>
			<td style="text-align: center">
				<?php 
				foreach ($dibuat as $ttd_dibuat) {
					if ($ttd_dibuat['posisi'] == "menyetujui") {
						echo ucwords(strtolower($ttd_dibuat['jabatan']));
					}
				}
				?>
			</td>
			<td style="text-align: center">
				<?php 
				foreach ($dibuat as $ttd_dibuat) {
					if ($ttd_dibuat['posisi'] == "dibuat") {
						echo ucwords(strtolower($ttd_dibuat['jabatan']));
					}
				}
				?>
			</td>
		</tr>
	</table>
</div>
</body>
</html>

