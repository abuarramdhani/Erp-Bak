<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<table class="table table-bordered">
	<thead >
		<tr>
			<th rowspan="2" style='text-align: center;vertical-align: middle;'>No</th>
			<th rowspan="2" style='text-align: center;vertical-align: middle;'>No. Induk</th>
			<th rowspan="2" style='text-align: center;vertical-align: middle;'>Nama</th>
			<th rowspan="2" style='text-align: center;vertical-align: middle;'>Seksi</th>	
			<th rowspan="2" style='text-align: center;vertical-align: middle;'>Jabatan</th>	
			<th rowspan="2" style='text-align: center;vertical-align: middle;'>Tempat Makan</th>										
<?php  
														$simpan_bulan_tahun = "";
														$simpan_bulan = "";
														$simpan_tahun = "";
														$hitung_colspan = 1;
														$no= 1;
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
															echo "<th style='text-align: center'>".$dt_tanggal['hari']."</th>";
														}
													?>
												</tr>
											</thead>
													<tbody>

														<?php foreach ($table as $key) {
															?>

															<tr>

																<td style='text-align: center;vertical-align: middle;'><?php echo $no; ?></td>
																<td style="padding-left: 5px" ><?php echo $key['noind']; ?></td>
																<td style="padding-left: 5px" ><?php echo $key['nama']; ?></td>
																<td style="padding-left: 5px" ><?php echo $key['seksi']; ?></td>
																<td style="padding-left: 5px" ><?php echo $key['jabatan']; ?></td>
																<td style="padding-left: 5px" ><?php echo $key['tempat_makan']; ?></td>
										                       <?php 
										                       foreach ($tanggal as $dt_tanggal) {
																	?>
																	<td style='text-align: center;vertical-align: middle;'><?php echo $key['data'][str_replace("-", "", $dt_tanggal['tanggal'])] ?></td>
																	<?php 
																}
										                       ?>
															</tr>
														<?php $no++; } ?>
													</tbody>
													<footer>
													<h4>Dicetak Oleh  pada Tanggal <?php echo date('d F Y H:i:s'); ?> WIB</h4>
													</footer>
												</table>
</body>
</html>


