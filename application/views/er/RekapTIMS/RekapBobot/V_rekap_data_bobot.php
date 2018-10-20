<?php
$ex_period1 = explode(' ', $periode1);
$ex_period2 = explode(' ', $periode2);
$begin = new DateTime(date('Y-m-01 00:00:00', strtotime($periode1)));
$end = new DateTime(date('Y-m-t 23:59:59', strtotime($periode2)));
$interval = new DateInterval('P1M');

$p = new DatePeriod($begin, $interval ,$end);
if (empty($bobot)) {
	$rekap_data['kode_status_kerja'] = '';
	$rekap_data['seksi'] = '';
}
foreach ($bobot as $rekap_data) {}
?>
<!--<section class="content-header">
	<h1>
		Rekap TIMS Kebutuhan Promosi Pekerja
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				
						<div class="box-body with-border">-->
						<form style="margin-right: 150px;" target="_blank" id="export_detail_form" method="post" action="<?php echo base_url("RekapTIMSPromosiPekerja/RekapBobot/ExportRekapDetailExcel") ?>">
							<input type="hidden" name="txtDetail" value="1">
							<input type="hidden" name="txtPeriode1_export" value="<?php echo $periode1 ?>">
							<input type="hidden" name="txtPeriode2_export" value="<?php echo $periode2 ?>">
							<input type="hidden" name="txtStatus" value="<?php echo $status ?>">
							<input type="hidden" name="txtNoInduk_export" value="<?php $count = count($bobot); foreach ($bobot as $rkp_export) { $count--; if ($count !== 0) { echo $rkp_export['noind'];} else { echo $rkp_export['noind'];} } ?>">
							<button class="btn btn-default pull-right">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
							</button>
						</form>
						

							<table class="table table-bordered table-hover table-striped" id="rekap-tims-detail" width="100%">
								<thead>
									<tr class="bg-primary">
										<th rowspan="2" width="3%" style="text-align: center;vertical-align:middle;font-size:20px;">
											<div style="width: 30px">
												NO
											</div>
										</th>
										<th rowspan="2" width="15%" style="text-align: center;vertical-align:middle;font-size:20px;">
											<div style="width: 100px">
												NIK
											</div>
										</th>
										<th rowspan="2" width="40%" style="text-align: center;vertical-align:middle;font-size:20px;">
											<div style="width: 300px">
												NAMA
											</div>
										</th>
										<th rowspan="2" width="15%" style="text-align: center;vertical-align:middle;font-size:20px;">
											<div style="width: 160px">
												MASA KERJA
											</div>
										</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px;">
											<div style="width: 160px">
												DEPARTEMEN
											</div>
										</th>
										<th rowspan="2"style="text-align: center;vertical-align:middle;font-size:20px;">
											<div style="width: 160px">
												BIDANG
											</div>
										</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px;">
											<div style="width: 160px">
												UNIT
											</div>
										</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px;">
											<div style="width: 160px">
												SEKSI
											</div>
										</th>

										<?php
											$no = 0;
											foreach ($p as $d) {
												$monthName = $d->format('M/Y');
												$monthNum = $d->format('Y-m');
										?>
										<th colspan="3" style="text-align: center">
											<div style="width: 120px">
												<form target="_blank" id="rekap_bulanan<?php echo $no ?>" method="post" action="<?php echo base_url("RekapTIMSPromosiPekerja/RekapPerPekerja/rekap-bulanan") ?>">
													<input type="hidden" name="txtPeriode_bulanan" value="<?php echo $monthNum ?>">
													<input type="hidden" name="txtNoInduk_bulanan" value="<?php $count = count($bobot); foreach ($bobot as $rkp_export) { $count--; if ($count !== 0) { echo "'".$rkp_export['noind']."'".",";} else { echo "'".$rkp_export['noind']."'";} } ?>">
												</form>
												<a style="color:#fff; cursor: pointer" onclick="document.getElementById('rekap_bulanan<?php echo $no ?>').submit()">
													<?php echo $monthName ?>
												</a>
											</div>
										</th>
										<?php
												$no++;
											}
										?>
										<th colspan="3" style="text-align: center"><div style="width: 120px">REKAP</div></th>
									</tr>
									<tr class="bg-primary">
									<?php
										foreach ($p as $d) {
									?>
											<th style="text-align: center">
												<div style="width: 20px">
													T
												</div>
											</th>
											<th style="text-align: center">
												<div style="width: 20px">
													I
												</div>
											</th>
											<th style="text-align: center">
												<div style="width: 20px">
													M
												</div>
											</th>
											
									<?php
										}
									?>
										<th style="text-align: center">
											<div style="width: 20px">
												T
											</div>
										</th>
										<th style="text-align: center">
											<div style="width: 20px">
												I
											</div>
										</th>
										<th style="text-align: center">
											<div style="width: 20px">
												M
											</div>
										</th>
																			
									</tr>
								</thead>
								<tbody>
									<?php
										$no = 1;
										foreach ($bobot as $rekap_data)
										{
									?>
											<tr>
												<td style="text-align:center;">
													<div style="width: 30px">
														<?php echo $no++ ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 100px">
														
															<?php echo $rekap_data['noind']?>
														
													</div>
													
												</td>
												<td>
													<div style="width: 300px">
														
															<?php echo $rekap_data['nama']?>
														
													</div>
													
												</td>
												<td style="text-align:center;">
														<?php echo $masakerja['tahun']?> tahun
														<?php echo $masakerja['bulan']?> bulan
														<?php echo $masakerja['hari']?> hari
												</td>
												<td style="text-align:center; vertical-align: middle; white-space: nowrap;">
													<?php echo $rekap_data['dept']; ?>
												</td>
												<td style="text-align:center; vertical-align: middle; white-space: nowrap;">
													<?php echo $rekap_data['bidang']; ?>
												</td>
												<td style="text-align:center; vertical-align: middle; white-space: nowrap;">
													<?php echo $rekap_data['unit']; ?>
												</td>
												<td style="text-align:center; vertical-align: middle; white-space: nowrap;">
													<?php echo $rekap_data['seksi']; ?>
												</td>
												<?php
													foreach ($p as $d) {
														$monthName = $d->format('M_y');
														foreach (${'rekap_'.$monthName} as $row) {
															if ($rekap_data['noind'] == $row['noind'])
															{
																$Terlambat = $row['pointtt'];
																$IjinPribadi = $row['pointtik'];
																$Mangkir = $row['pointtm'];
																
																if ($Terlambat == '0' or $Terlambat == '') {
																	$Terlambat = '-';
																}
																if ($IjinPribadi == '0' or $IjinPribadi == '') {
																	$IjinPribadi = '-';
																}
																if ($Mangkir == '0' or $Mangkir == '') {
																	$Mangkir = '-';
																}
															

															}
														}
												?>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $Terlambat; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $IjinPribadi; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $Mangkir; ?>
													</div>
												</td>
												
												<?php
													}
												?>

												<td style="text-align:center;">
													<div style="width: 20px">
													 	<?php if ($rekap_data['pointtt'] == '0' or $rekap_data['pointtt'] == '') {
																	echo "-";
																}else{echo $rekap_data['pointtt'];} ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php if ($rekap_data['pointtik'] == '0' or $rekap_data['pointtik'] == '') {
																	echo "-";
																}else{echo $rekap_data['pointtik'];} ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php if ($rekap_data['pointtm'] == '0' or $rekap_data['pointtm'] == '') {
																	echo "-";
																}else{echo $rekap_data['pointtm'];} ?>
													</div>
												</td>
																								
											</tr>
									<?php
										}
										
									?>
								</tbody>
							</table>
							<p style="margin-bottom: 0;font-style:normal;">
								Note&emsp;:&emsp;&emsp;&emsp;
								<strong>
									T : Terlambat&emsp;
									I : Izin Pribadi&emsp;
									M : Mangkir&emsp;
									S : Sakit&emsp;
									PSP : Pulang Sakit dari Perusahaan&emsp;
									IP : Izin Perusahaan&emsp;
									CT : Cuti Tahunan&emsp;
									SP : Surat Peringatan
								</strong>
							</p>
						<!--</div>
					
			</div>
		</div>
	</div>
</section>-->