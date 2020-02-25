<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div>
	<div style="width: 100%;text-align: center">
		<h2>Info Pegawai</h2>
	</div>
	<div>
		<?php 
		if (isset($_GET['kom_4']) and !empty($_GET['kom_4'])) {
			$range = (strtotime($_GET['kom_4']) - strtotime($_GET['kom_3']))/(60*60*24); 
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
			$awal_cutoff = $_GET['kom_3'];
			$akhir_cutoff = $_GET['kom_4'];
		}else{
			$range = (strtotime($awal) - strtotime($akhir))/(60*60*24); 
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
			$awal_cutoff = $awal;
			$akhir_cutoff = $akhir;

			$tanggal = $data['tanggal'];
			$absen = $data['absen'];
		}
			$tgl_aw = explode("-", $awal_cutoff);
			$tgl_ak = explode("-", $akhir_cutoff);
			echo "Data Pegawai Periode ".$tgl_aw['2']."/".$tgl_aw['1']."/".$tgl_aw['0']." - ".$tgl_ak['2']."/".$tgl_ak['1']."/".$tgl_ak['0'];
			$pembagi = 30;
			if ($range > $pembagi) { 
				for ($i=1; $i <= ceil($range/$pembagi); $i++) { ?> 
					<br>
					<table style="border-collapse: collapse;" border="1">
					<thead>
						<tr>
							<th rowspan="2" style='text-align: center;vertical-align: middle;width: 10px'>No</th>
							<th rowspan="2" style='text-align: center;vertical-align: middle;width: 50px'>No. Induk</th>
							<th rowspan="2" style='text-align: center;vertical-align: middle;width: 150px;'>Nama</th>
							<?php  
								$simpan_bulan_tahun = "";
								$simpan_bulan = "";
								$simpan_tahun = "";
								$hitung_colspan = 1;
								$tanggal_pertama = "";
								$tanggal_terakhir = "";
								
								$repeat_1 = 0;
								foreach ($tanggal as $dt_bulan) {
									if ($repeat_1 >= (($i*$pembagi) - $pembagi) && $repeat_1 < ($i*$pembagi)) {
										if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
											$hitung_colspan++;
										}else{
											if ($simpan_bulan !== "") {
												echo "<th colspan='".$hitung_colspan."'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
												$hitung_colspan = 1;
											}else{
												$tanggal_pertama = $dt_bulan['tanggal'];
											}
										}
										$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
										$simpan_bulan = $dt_bulan['bulan'];
										$simpan_tahun = $dt_bulan['tahun'];
									}
									$repeat_1++;
								}
								echo "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
								$tanggal_terakhir = $dt_bulan['tanggal'];
							?>
						</tr>
						<tr>
							<?php  
								$repeat_2 = 0;
								foreach ($tanggal as $dt_tanggal) {
									if ($repeat_2 >= (($i*$pembagi) - $pembagi) && $repeat_2 < ($i*$pembagi)) {
										echo "<th style='text-align: center;width: 30px;'>".$dt_tanggal['hari']."</th>";
									}
									$repeat_2++;
								}
							?>
						</tr>
					</thead>
					<tbody>
						<?php 
							$nomor=0;
							foreach ($absen as $abs) { 
								$nomor++;
								?>
								<tr>
									<td style="text-align: center;vertical-align: center"><?php echo $nomor;?></td>
									<td style="text-align: center;vertical-align: center">
										<?php echo $abs['noind'] ?>
									</td>
									<td>
										<?php if (strlen(trim($abs['nama'])) > 20) {
											echo substr(trim($abs['nama']), 0,20)."..";
										}else{
											echo trim($abs['nama']);
										} ?>	
									</td>
									<?php 
										$repeat_3 = 0;
										foreach ($tanggal as $dt_tanggal) {
											if ($repeat_3 >= (($i*$pembagi) - $pembagi) && $repeat_3 < ($i*$pembagi)) {
												$keterangan = "-";
												if (isset($abs['data'][$dt_tanggal['index_tanggal']]) and !empty($abs['data'][$dt_tanggal['index_tanggal']])) {
													$keterangan = $abs['data'][$dt_tanggal['index_tanggal']];
												}
												echo "<td style='text-align: center;vertical-align: middle'>$keterangan</td>";
											}
											$repeat_3++;
										}
									?>
								</tr> 
							<?php }
						?>
					</tbody>
				</table>
				<pagebreak />
			<?php 
				}
			}else{ 
			?>
				<table style="border-collapse: collapse;" border="1">
					<thead>
						<tr>
							<th rowspan="2" style='text-align: center;vertical-align: middle;width: 80px'>No. Induk</th>
							<th rowspan="2" style='text-align: center;vertical-align: middle;width: 200px;'>Nama</th>
							<?php  
								$simpan_bulan_tahun = "";
								$simpan_bulan = "";
								$simpan_tahun = "";
								$hitung_colspan = 1;
								$tanggal_pertama = "";
								$tanggal_terakhir = "";
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
								foreach ($tanggal as $dt_bulan) {
									if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
										$hitung_colspan++;
									}else{
										if ($simpan_bulan !== "") {
											echo "<th colspan='".$hitung_colspan."'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
											$hitung_colspan = 1;
										}else{
											$tanggal_pertama = $dt_bulan['tanggal'];
										}
									}
									$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
									$simpan_bulan = $dt_bulan['bulan'];
									$simpan_tahun = $dt_bulan['tahun'];
								}
								echo "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
								$tanggal_terakhir = $dt_bulan['tanggal'];
							?>
						</tr>
						<tr>
							<?php  
								foreach ($tanggal as $dt_tanggal) {
									echo "<th style='text-align: center;width: 30px;'>".$dt_tanggal['hari']."</th>";
								}
							?>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach ($absen as $abs) { ?>
								<tr>
									<td style="text-align: center;vertical-align: center">
										<?php echo $abs['noind'] ?>
									</td>
									<td>
										<?php if (strlen(trim($abs['nama'])) > 20) {
											echo substr(trim($abs['nama']), 0,20)."..";
										}else{
											echo trim($abs['nama']);
										} ?>	
									</td>
									<?php 
										foreach ($tanggal as $dt_tanggal) {
											$keterangan = "-";
											if (isset($abs['data'][$dt_tanggal['index_tanggal']]) and !empty($abs['data'][$dt_tanggal['index_tanggal']])) {
												$keterangan = $abs['data'][$dt_tanggal['index_tanggal']];
											}
											echo "<td style='text-align: center;vertical-align: middle'>$keterangan</td>";
										}
									?>
								</tr> 
							<?php }
						?>
					</tbody>
				</table>
		<?php 
			}
		?>
	</div>
</div>
</body>
</html>