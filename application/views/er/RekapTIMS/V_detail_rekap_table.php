<?php
$ex_period1 = explode(' ', $periode1);
$ex_period2 = explode(' ', $periode2);
$begin = new DateTime(date('Y-m-01 00:00:00', strtotime($periode1)));
$end = new DateTime(date('Y-m-t 23:59:59', strtotime($periode2)));
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
							<form target="_blank" id="export_detail_form" method="post" action="<?php echo base_url("RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-detail") ?>">
								<input type="hidden" name="txtDetail" value="1">
								<input type="hidden" name="txtPeriode1_export" value="<?php echo $periode1 ?>">
								<input type="hidden" name="txtPeriode2_export" value="<?php echo $periode2 ?>">
								<input type="hidden" name="txtStatus_export" value="<?php echo $statusExport ?>">
								<input type="hidden" name="txtDepartemen_export" value="<?php echo $departemen ?>">
								<input type="hidden" name="txtBidang_export" value="<?php echo $bidang ?>">
								<input type="hidden" name="txtUnit_export" value="<?php echo $unit ?>">
								<input type="hidden" name="txtSeksi_export" value="<?php echo $section ?>">
								<input type="hidden" name="txtLokasi_export" value="<?php echo $lokasi ?>">
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
										<th colspan="8" style="text-align: center">
											<div style="width: 200px">
												<form target="_blank" id="rekap_bulanan<?php echo $no ?>" method="post" action="<?php echo base_url("RekapTIMSPromosiPekerja/RekapTIMS/rekap-bulanan") ?>">
													<input type="hidden" name="txtPeriode_bulanan" value="<?php echo $monthNum ?>">
													<input type="hidden" name="txtStatus_bulanan" value="<?php echo $rekap_data['kode_status_kerja']; ?>">
													<input type="hidden" name="txtSeksi_bulanan" value="<?php echo $section; ?>">
												</form>
												<a target="_blank" style="color:#fff;cursor: pointer" onclick="document.getElementById('rekap_bulanan<?php echo $no ?>').submit()">
													<?php echo $monthName ?>
												</a>
											</div>
										</th>
										<?php
												$no++;
											}
										?>
										<th colspan="8" style="text-align: center"><div style="width: 200px">REKAP</div></th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">TOTAL HARI KERJA</th>
										<th colspan="8" style="text-align: center">PERSENTASE</th>
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
													PSP
												</div>
											</th>
											<th style="text-align: center">
												<div style="width: 20px">
													IP
												</div>
											</th>
											<th style="text-align: center">
												<div style="width: 20px">
													CT
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
												PSP
											</div>
										</th>
										<th style="text-align: center">
											<div style="width: 20px">
												IP
										</div>
										</th>
										<th style="text-align: center">
											<div style="width: 20px">
												CT
											</div>
										</th>
										<th style="text-align: center">
											<div style="width: 20px">
												SP
											</div>
										</th>
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
												PSP
											</div>
										</th>
										<th style="text-align: center">
											<div style="width: 20px">
												IP
											</div>
										</th>
										<th style="text-align: center">
											<div style="width: 20px">
												CT
											</div>
										</th>
										<th style="text-align: center">
											<div style="width: 20px">
												Total
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
													<div style="width: 160px">
														<?php echo $rekap_data['masa_kerja'];?>
													</div>

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
														foreach (${'rekap_'.$monthName} as ${'rek'.$monthName}) {
															if ($rekap_data['noind'] == ${'rek'.$monthName}['noind'])
															{
																$Terlambat = ${'rek'.$monthName}['frekt'.strtolower($monthName)]+${'rek'.$monthName}['frekts'.strtolower($monthName)];
																$IjinPribadi = ${'rek'.$monthName}['freki'.strtolower($monthName)]+${'rek'.$monthName}['frekis'.strtolower($monthName)];
																$Mangkir = ${'rek'.$monthName}['frekm'.strtolower($monthName)]+${'rek'.$monthName}['frekms'.strtolower($monthName)];
																$SuratKeterangan = ${'rek'.$monthName}['freksk'.strtolower($monthName)]+${'rek'.$monthName}['freksks'.strtolower($monthName)];
																$SakitPerusahaan = ${'rek'.$monthName}['frekpsp'.strtolower($monthName)]+${'rek'.$monthName}['frekpsps'.strtolower($monthName)];
																$IjinPerusahaan = ${'rek'.$monthName}['frekip'.strtolower($monthName)]+${'rek'.$monthName}['frekips'.strtolower($monthName)];
																$CutiTahunan = ${'rek'.$monthName}['frekct'.strtolower($monthName)]+${'rek'.$monthName}['frekcts'.strtolower($monthName)];
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
																if ($SakitPerusahaan == '0') {
																	$SakitPerusahaan = '-';
																}
																if ($IjinPerusahaan == '0') {
																	$IjinPerusahaan = '-';
																}
																if ($CutiTahunan == '0') {
																	$CutiTahunan = '-';
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
																	<?php echo $SakitPerusahaan; ?>
																</div>
															</td>
															<td style="text-align:center;">
																<div style="width: 20px">
																	<?php echo $IjinPerusahaan; ?>
																</div>
															</td>
															<td style="text-align:center;">
																<div style="width: 20px">
																	<?php echo $CutiTahunan; ?>
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
														<?php echo $rekap_data['frekpsp']+$rekap_data['frekpsps']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['frekip']+$rekap_data['frekips']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['frekct']+$rekap_data['frekcts']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['total_jmlsp']+$rekap_data['total_jmlsps']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : ($rekap_data['totalhk']+$rekap_data['totalhks'])) ?>
												</td>
												<td style="text-align:center;">
													<?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekt']+$rekap_data['frekts']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?>
												</td>
												<td style="text-align:center;">
													<?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['freki']+$rekap_data['frekis']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?>
												</td>
												<td style="text-align:center;">
													<?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekm']+$rekap_data['frekms']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?>
												</td>
												<td style="text-align:center;">
													<?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['freksk']+$rekap_data['freksks']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?>
												</td>
												<td style="text-align:center;">
													<?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekpsp']+$rekap_data['frekpsps']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?>
												</td>
												<td style="text-align:center;">
													<?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekip']+$rekap_data['frekips']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?>
												</td>
												<td style="text-align:center;">
													<?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekct']+$rekap_data['frekcts']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?>
												</td>
												<td style="text-align: center;">
													<?php
														if (($rekap_data['totalhk']+$rekap_data['totalhks'])==0)
														{
															echo '-';
														}
														else
														{
															echo
																round(
																	(
																		(float)
																		(
																			(
																				($rekap_data['totalhk']+$rekap_data['totalhks'])
																				-
																				(
																					($rekap_data['freki']+$rekap_data['frekis'])
																					+
																					($rekap_data['frekm']+$rekap_data['frekms'])
																					+
																					($rekap_data['freksk']+$rekap_data['freksks'])
																					+
																					($rekap_data['frekpsp']+$rekap_data['frekpsps'])
																					+
																					($rekap_data['frekip']+$rekap_data['frekips'])
																					+
																					($rekap_data['frekct']+$rekap_data['frekcts'])
																					+
																					($rekap_data['frekmnon']+$rekap_data['frekmsnon'])
																				)
																			)
																			/
																			(($rekap_data['totalhk']+$rekap_data['totalhks']) - ($rekap_data['frekct']+$rekap_data['frekcts']) - ($rekap_data['frekmnon']+$rekap_data['frekmsnon']))
																		)
																		*100
																	),
																2).'%';
														}
													?>
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
