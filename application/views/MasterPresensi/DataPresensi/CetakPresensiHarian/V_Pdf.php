<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php 
	$bulan = array(
			1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'
		);
	$prd = explode(" - ", $periode);

	$awal = date("d",strtotime($prd[0]))." ".$bulan[intval(date("m",strtotime($prd[0])))]." ".date("Y",strtotime($prd[0]));
	$akhir = date("d",strtotime($prd[1]))." ".$bulan[intval(date("m",strtotime($prd[1])))]." ".date("Y",strtotime($prd[1]));
	?>
	<table style="width: 100%;border-bottom: 1px solid black;">
		<tr>
			<td style="width: 20%">Periode</td>
			<td style="width: 5%">:</td>
			<td><?php echo $awal." s/d ".$akhir ?></td>
		</tr>
	<?php 
	if (isset($lokasi_kerja) && !empty($lokasi_kerja)) {
	?>
		<tr>
			<td>Lokasi Kerja</td>
			<td>:</td>
			<td><?php echo $lokasi_kerja ?></td>
		</tr>
	<?php
	}

	if (isset($kode_induk) && !empty($kode_induk)) {
	?>
		<tr>
			<td>Kode Induk</td>
			<td>:</td>
			<td><?php echo $kode_induk ?></td>
		</tr>
	<?php 
	}

	if (isset($kodesie) && !empty($kodesie)) {
	?>
		<tr>
			<td>Kodesie</td>
			<td>:</td>
			<td><?php echo implode(", ", explode(",", $kodesie)) ?></td>
		</tr>
	<?php
	}

	if (isset($noind) && !empty($noind)) {
	?>
		<tr>
			<td>No. Induk</td>
			<td>:</td>
			<td><?php echo implode(", ", explode(",", $noind)) ?></td>
		</tr>
	<?php 
	}
	?>
	</table>
	<?php 
	foreach ($data as $key => $dt) {
		?>
		<table style="page-break-inside: avoid;">
			<tr>
				<td>No. Induk</td>
				<td>&nbsp;:&nbsp;<td>
				<td><?php echo $dt["noind"] ?></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>&nbsp;:&nbsp;<td>
				<td><?php echo $dt["nama"] ?></td>
			</tr>
			<tr>
				<td>Seksi/Unit</td>
				<td>&nbsp;:&nbsp;<td>
				<td><?php echo $dt["seksi"]." / ".$dt["unit"] ?></td>
			</tr>
		</table>
		<table style="width: 100%; border: 1px solid black; border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th style="width: 15%;">Tanggal</th>
					<th style="width: 15%;">Shift</th>
					<th style="width: 10%;">Point</th>
					<?php 
						for ($i=0; $i < $dt["max_kolom"]; $i++) { 
							?>
							<th>Waktu <?php echo $i+1 ?></th>
							<?php
						}
					?>
					<th style="width: 15%;">Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if (isset($dt["presensi_harian"]) && !empty($dt["presensi_harian"])) {
					foreach ($dt["presensi_harian"] as $harian) {
						?>
						<tr>
							<td style="text-align: center">
								<?php echo date("d",strtotime($harian["tanggal"]))." ".$bulan[intval(date("m",strtotime($harian["tanggal"])))]." ".date("Y",strtotime($harian["tanggal"])) ?>
							</td>
							<td style="text-align: center">
								<?php echo $harian["shift"] ?>
							</td>
							<td style="text-align: center">
								<?php echo $harian["point"] != "0" ? $harian['point'] : '' ?>
							</td>
							<?php
							for ($i=0; $i < $dt["max_kolom"]; $i++) { 
								if (isset($harian["absen"]) && !empty($harian["absen"]) && isset($harian["absen"][$i]) && !empty($harian["absen"][$i])) {
									?>
									<td style="text-align: center">
										<?php echo $harian["absen"][$i]["waktu"] ?>
									</td>
									<?php
								}else{
									?>
									<td></td>
									<?php
								}
							}
							?>
							<td style="text-align: center">
								<?php echo $harian["ket"] ?>
							</td>
						</tr>
						<?php
					}
				}
				?>	
			</tbody>
		</table>
		<br>
		<?php 
	}

?>
</body>
</html>