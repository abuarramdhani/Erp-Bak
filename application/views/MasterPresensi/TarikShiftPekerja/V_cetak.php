<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
	$bulan = array (
		1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
	);
	$jumlah = count($tanggal);
	$sudah = 0;
	while ($sudah < $jumlah) {
		if ($sudah == 0) {
			?>
				<table style="border: 1px solid black;width: 100%" border="1">
					<thead >
						<tr>
							<th style='text-align: center;vertical-align: middle;width: 3%'>No</th>
							<th style='text-align: center;vertical-align: middle;width: 5%'>No. Induk</th>
							<th style='text-align: center;vertical-align: middle;width: 20%'>Nama</th>
							<th style='text-align: center;vertical-align: middle;width: 25%'>Seksi</th>	
							<th style='text-align: center;vertical-align: middle;width: 25%'>Jabatan</th>	
							<th style='text-align: center;vertical-align: middle;width: 12%'>Tempat Makan</th>										
							<th style='text-align: center;vertical-align: middle;width: 10%'>Lokasi Kerja</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$no = 1;
						foreach ($table as $key) {
							?>
							<tr>
								<td style='text-align: center;vertical-align: middle;'><?php echo $no; ?></td>
								<td style="padding-left: 5px;text-align: center;" ><?php echo $key['noind']; ?></td>
								<td style="padding-left: 5px" ><?php echo $key['nama']; ?></td>
								<td style="padding-left: 5px" ><?php echo $key['seksi']; ?></td>
								<td style="padding-left: 5px" ><?php echo $key['jabatan']; ?></td>
								<td style="padding-left: 5px" ><?php echo $key['tempat_makan']; ?></td>
								<td style="padding-left: 5px" ><?php echo $key['lokasi_kerja']; ?></td>
							</tr>
						<?php 
							$no++
						; } ?>
					</tbody>
				</table>
			<?php
		}

		$batas_bawah = $sudah;
		$jumlah_perhal = 23;
		if ($batas_bawah + $jumlah_perhal > $jumlah) {
			$batas_atas = $batas_bawah + ($jumlah - $batas_bawah);
		}else{
			$batas_atas = $batas_bawah + $jumlah_perhal;
		}
		?>
			<div style="page-break-after: always;"></div>
			<table style="border: 1px solid black;width: 100%" border="1">
				<thead >
					<tr>
						<th rowspan="2" style='text-align: center;vertical-align: middle;width: 3%'>No</th>
						<th rowspan="2" style='text-align: center;vertical-align: middle;width: 5%'>No. Induk</th>									
						<?php  
							$simpan_bulan_tahun = "";
							$simpan_bulan = "";
							$simpan_tahun = "";
							$hitung_colspan = 1;
							$no= 1;
							$tanggal_pertama = "";
							$tanggal_terakhir = "";
							
							for ($i=$batas_bawah; $i < $batas_atas; $i++) {
									if($tanggal[$i]['bulan'].$tanggal[$i]['tahun'] == $simpan_bulan_tahun){
										$hitung_colspan++;
									}else{
										if ($simpan_bulan !== "") {
											?>
												<th colspan="<?php echo $hitung_colspan ?>"><?php echo $bulan[$simpan_bulan]." ".$simpan_tahun ?></th>
											<?php
											$hitung_colspan = 1;
										}else{
											$tanggal_pertama = $tanggal[$i]['tanggal'];
										}
									}
									$simpan_bulan_tahun = $tanggal[$i]['bulan'].$tanggal[$i]['tahun'];
									$simpan_bulan = $tanggal[$i]['bulan'];
									$simpan_tahun = $tanggal[$i]['tahun'];
									
							}
							echo "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
							$tanggal_terakhir = $tanggal[$i]['tanggal'];
						?>
					</tr>
					<tr>
						<?php  
							
							for ($i=$batas_bawah; $i < $batas_atas; $i++) { 
								?>
									<th style='text-align: center;width: 4%'><?php echo $tanggal[$i]['hari'] ?></th>
								<?php
								if ($sudah > $jumlah) {
									echo "kesalahan teknis";exit();
								}
								$sudah++;	
							}
						?>
					</tr>
				</thead>
				<tbody>

					<?php 
					foreach ($table as $key) {
						?>
						<tr>
							<td style='text-align: center;vertical-align: middle;'><?php echo $no; ?></td>
							<td style="padding-left: 5px" ><?php echo $key['noind']; ?></td>
		                  	<?php 
							for ($i=$batas_bawah; $i < $batas_atas; $i++) { 
								?>
									<td style='text-align: center;vertical-align: middle;'><?php echo $key['data'][$tanggal[$i]['index_tanggal']] ?></td>
								<?php
							}
		                   	?>
						</tr>
						<?php $no++; 
					} ?>
				</tbody>
			</table>
		<?php
		
	}
	?>
</body>
</html>


