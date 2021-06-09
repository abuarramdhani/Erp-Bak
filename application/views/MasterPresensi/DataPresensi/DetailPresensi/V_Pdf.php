<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php 
	if (count($tanggal) > 40) {
		$batas = 35;
	}else{
		$batas = count($tanggal);
	}
	
	if ($jenis_presensi == "Presensi") {
		$sisa = 84;
		$warna= "#6EE7B7";
	}else{
		$sisa = 80;
		$warna = "#C4B5FD";
	}

	$jumlah = ceil(count($tanggal)/$batas);
	$up = 0;

	for ($h=0; $h < $jumlah; $h++) { 
		?>
		<table style="width: 100%;border: 1px solid black;border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th rowspan="2" style="width: 3%;background-color: <?php echo $warna ?>;">No.</th>
					<th rowspan="2" style="width: 4%;background-color: <?php echo $warna ?>;">No. Induk</th>
					<th rowspan="2" style="width: 9%;background-color: <?php echo $warna ?>;">Nama</th>
					<?php 
					$span = 1;
					for ($i=0; $i < $batas; $i++) { 
						if(isset($tanggal[($batas*$h)+$i])){
							if ($tanggal[($batas*$h)+$i]['bulan'] != $tanggal[($batas*$h)+$i+1]['bulan'] || $i == $batas -1) {
								?>
								<th colspan="<?php echo $span ?>" style="background-color: <?php echo $warna ?>;"><?php echo $bulan[$tanggal[($batas*$h)+$i]['bulan']]." ".$tanggal[($batas*$h)+$i]['tahun'] ?></th>
								<?php
								$span = 1;
							}else{
								$span++;
							}
						}
					}
					if ($jenis_presensi != "Presensi") {
						?>
						<th rowspan="2" style="width: 4%;background-color: <?php echo $warna ?>;">Total Lembur</th>
						<?php 
					}
					?>
				</tr>
				<tr>
					<?php 
						for ($i=0; $i < $batas; $i++) { 
							if(isset($tanggal[($batas*$h)+$i])){
								if (count($tanggal) > 40) {
									if(count($tanggal) - ($batas*$h) >= 35){
										$lebar = $sisa / $batas;
									}else{
										$lebar = $sisa / (count($jumlah) - ($batas*$h));
									}
								}else{
									$lebar = $sisa / $batas;
								}
								?>
								<th style="width: <?php echo $lebar ?>%;background-color: <?php echo $warna ?>;"><?php echo $tanggal[($batas*$h)+$i]['hari'] ?></th>
								<?php
							}
						}
					?>
				</tr>
			</thead>
			<tbody>
			<?php 
				if (isset($datareal) && !empty($datareal)) {
					foreach ($datareal as $key => $abs) {
						?>
						<tr>
							<td style="text-align: center;height: 30px;"><?php echo $key ?></td>
							<td style="text-align: center;"><?php echo $abs['noind'] ?></td>
							<td style="padding-left: 3px;padding-right: 3px;"><?php echo $abs['nama'] ?></td>
							<?php 
							$total = 0;
							for ($i=0; $i < $batas; $i++) { 
								if(isset($tanggal[($batas*$h)+$i])){
									$keterangan = "-";
									if (isset($abs['data'][$tanggal[($batas*$h)+$i]['index_tanggal']])) {
										$keterangan = $abs['data'][$tanggal[($batas*$h)+$i]['index_tanggal']];
										if ($jenis_presensi != "Presensi") {
											$total += $keterangan;
										}
									}
									?>
									<td style="text-align: center;"><?php echo $keterangan ?></td>
									<?php
								}
							}
							if ($jenis_presensi != "Presensi") {
								?>
								<td style="text-align: center;"><?php echo $total ?></td>
								<?php
							}
							?>
						</tr>
						<?php
					}
				}
			?>
			</tbody>
		</table>
		<?php 
		if ($jenis_presensi != "Presensi") {
			?>
			<span style="color: red">[Total Lembur] merupakan total lembur per halaman per pekerja</span>
			<?php
		}
		?>
		<?php 
		if ($h < $jumlah - 1) {
			?>
			<div style="page-break-after: always;"></div>
			<?php
		}
		?>
		<?php
	}
	?>
			
</body>
</html>