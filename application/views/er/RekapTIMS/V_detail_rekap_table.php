<?php
$ex_period1 = explode(' ', $periode1);
$ex_period2 = explode(' ', $periode2);
$begin = new DateTime($periode1);
$end = new DateTime($periode2);
$interval = new DateInterval('P1M');

$p = new DatePeriod($begin, $interval ,$end);
if (empty($rekap)) {
	$rekap_data['kode_status_kerja'] = '';
	$rekap_data['seksi'] = '';
}
foreach ($rekap as $rekap_data) {}
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
							<a target="_blank" class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-detail/'.$ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['kode_status_kerja'].'/'.str_replace(' ', '-', $rekap_data['seksi']))?>/1">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
							</a>
							<table class="table table-bordered table-hover table-striped" id="rekap-tims" width="100%">
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
											<div style="width: 100px">
												MASA KERJA
											</div>
										</th>
										<?php
											foreach ($p as $d) {
												$monthName = $d->format('M/Y');
												$monthNum = $d->format('Y-m');
										?>
										<th colspan="6" style="text-align: center">
											<div style="width: 200px">
												<a target="_blank" style="color:#fff;" href="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/rekap-bulanan/'.$monthNum.'/'.$rekap_data['kode_status_kerja'].'/'.str_replace(' ', '-', $rekap_data['seksi'])) ?>">
													<?php echo $monthName ?>
												</a>
											</div>
										</th>
										<?php
											}
										?>
										<th colspan="6" style="text-align: center"><div style="width: 200px">REKAP</div></th>
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
											<th style="text-align: center">
												<div style="width: 20px">
													S
												</div>
											</th>
											<th style="text-align: center">
												<div style="width: 20px">
													IP
												</div>
											</th>
											<th style="text-align: center">
												<div style="width: 20px">
													SP
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
											<th style="text-align: center">
												<div style="width: 20px">
													S
												</div>
											</th>
											<th style="text-align: center">
												<div style="width: 20px">
													IP
												</div>
											</th>
											<th style="text-align: center">
												<div style="width: 20px">
													SP
												</div>
											</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no = 1;
										foreach ($rekap as $rekap_data) {
									?>
											<tr>
												<td style="text-align:center;">
													<div style="width: 30px">
														<?php echo $no++ ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 100px">
														<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo date('Y-m-01',strtotime($ex_period1[0])).'/'.date('Y-m-t', strtotime($ex_period2[0])).'/'.$rekap_data['nik']; ?>">
															<?php echo $rekap_data['noind']?>
														</a>
													</div>
													
												</td>
												<td>
													<div style="width: 300px">
														<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo date('Y-m-01',strtotime($ex_period1[0])).'/'.date('Y-m-t', strtotime($ex_period2[0])).'/'.$rekap_data['nik']; ?>">
															<?php echo $rekap_data['nama']?>
														</a>
													</div>
													
												</td>
												<td style="text-align:center;">
													<div style="width: 100px">
														<?php
															$masukkerja = $rekap_data['masuk_kerja_sebelum'];
															if($rekap_data['masuk_kerja_sebelum'] == NULL || $rekap_data['masuk_kerja_sebelum'] == ''){
																$masukkerja = $rekap_data['masukkerja'];
															}
															$masa1 = strtotime($masukkerja);
															$masa2 = strtotime($periode2);

															$year1 = date('Y', $masa1);
															$year2 = date('Y', $masa2);

															$month1 = date('m', $masa1);
															$month2 = date('m', $masa2);

															$total_masa_kerja = (($year2 - $year1) * 12) + ($month2 - $month1);
															echo $total_masa_kerja;
														?>
													</div>
													
												</td>
												<?php
													foreach ($p as $d) {
														$monthName = $d->format('M_y');
														foreach (${'rekap_'.$monthName} as ${'rek'.$monthName}) {
															if ($rekap_data['noind'] == ${'rek'.$monthName}['noind'])
															{
																$Terlambat = ${'rek'.$monthName}['frekt'.strtolower($monthName)]+${'rek'.$monthName}['frekts'.strtolower($monthName)];
																$IjinPribadi = ${'rek'.$monthName}['freki'.strtolower($monthName)]+${'rek'.$monthName}['frekis'.strtolower($monthName)];
																$Mangkir = ${'rek'.$monthName}['frekm'.strtolower($monthName)]+${'rek'.$monthName}['frekms'.strtolower($monthName)];
																$SuratKeterangan = ${'rek'.$monthName}['freksk'.strtolower($monthName)]+${'rek'.$monthName}['freksks'.strtolower($monthName)];
																$IjinPerusahaan = ${'rek'.$monthName}['frekip'.strtolower($monthName)]+${'rek'.$monthName}['frekips'.strtolower($monthName)];
																$SuratPeringatan = ${'rek'.$monthName}['freksp'.strtolower($monthName)]+${'rek'.$monthName}['freksps'.strtolower($monthName)];
																if ($Terlambat == '0') {
																	$Terlambat = '-';
																}
																if ($IjinPribadi == '0') {
																	$IjinPribadi = '-';
																}
																if ($Mangkir == '0') {
																	$Mangkir = '-';
																}
																if ($SuratKeterangan == '0') {
																	$SuratKeterangan = '-';
																}
																if ($IjinPerusahaan == '0') {
																	$IjinPerusahaan = '-';
																}
																if ($SuratPeringatan == '0') {
																	$SuratPeringatan = '-';
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
															<td style="text-align:center;">
																<div style="width: 20px">
																	<?php echo $SuratKeterangan; ?>
																</div>
															</td>
															<td style="text-align:center;">
																<div style="width: 20px">
																	<?php echo $IjinPerusahaan; ?>
																</div>
															</td>
															<td style="text-align:center;">
																<div style="width: 20px">
																	<?php echo $SuratPeringatan; ?>
																</div>
															</td>
												<?php
													}
												?>

												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['frekt']+$rekap_data['frekts']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['freki']+$rekap_data['frekis']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['frekm']+$rekap_data['frekms']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['freksk']+$rekap_data['freksks']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['frekip']+$rekap_data['frekips']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['freksp']+$rekap_data['freksps']; ?>
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
									IP : Izin Perusahaan&emsp;
									SP : Surat Peringatan
								</strong>
							</p>
						<!--</div>
					
			</div>
		</div>
	</div>
</section>-->