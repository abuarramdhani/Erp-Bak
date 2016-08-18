<?php
$ex_period1 = explode(' ', $periode1);
$ex_period2 = explode(' ', $periode2);
$tgl = explode('-', $ex_period2[0]);
$bln_new = $tgl[1]-1;
$periode2 = $tgl[0].'-'.$bln_new.'-'.$tgl[2].' '.$ex_period2[1];
$datetime = new DateTime;
$p = new DatePeriod(
		new DateTime($periode1),
		new DateInterval('P1M'),
		$datetime($periode2)->modify('+1 month')
	);
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
							<a class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-detail/'.$ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['kd_jabatan'].'/'.str_replace(' ', '-', $rekap_data['seksi']))?>/1">
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
										<?php
											foreach ($p as $d) {
												$monthName = $d->format('M/Y');
												$monthNum = $d->format('Y-m');
										?>
										<th colspan="6" style="text-align: center">
											<div style="width: 200px">
												<a target="_blank" style="color:#fff;" href="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/rekap-bulanan/'.$monthNum.'/'.$rekap_data['kd_jabatan'].'/'.str_replace(' ', '-', $rekap_data['seksi'])) ?>">
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
														<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $rekap_data['nik']; ?>">
															<?php echo $rekap_data['noind']?>
														</a>
													</div>
													
												</td>
												<td>
													<div style="width: 300px">
														<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $rekap_data['nik']; ?>">
															<?php echo $rekap_data['nama']?>
														</a>
													</div>
													
												</td>
												<?php
													foreach ($p as $d) {
														$monthName = $d->format('M_y');
														foreach (${'rekap_'.$monthName} as ${'rek'.$monthName}) {
															if ($rekap_data['noind'] == ${'rek'.$monthName}['noind'] && $rekap_data['nama'] == ${'rek'.$monthName}['nama'] && $rekap_data['nik'] == ${'rek'.$monthName}['nik'] && $rekap_data['tgllahir'] == ${'rek'.$monthName}['tgllahir'])
															{
																$Terlambat = ${'rek'.$monthName}['FrekT'.$monthName]+${'rek'.$monthName}['FrekTs'.$monthName];
																$IjinPribadi = ${'rek'.$monthName}['FrekI'.$monthName]+${'rek'.$monthName}['FrekIs'.$monthName];
																$Mangkir = ${'rek'.$monthName}['FrekM'.$monthName]+${'rek'.$monthName}['FrekMs'.$monthName];
																$SuratKeterangan = ${'rek'.$monthName}['FrekSK'.$monthName]+${'rek'.$monthName}['FrekSKs'.$monthName];
																$IjinPerusahaan = ${'rek'.$monthName}['FrekIP'.$monthName]+${'rek'.$monthName}['FrekIPs'.$monthName];
																$SuratPeringatan = ${'rek'.$monthName}['FrekSP'.$monthName]+${'rek'.$monthName}['FrekSPs'.$monthName];
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
														<?php echo $rekap_data['FrekT']+$rekap_data['FrekTs']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['FrekI']+$rekap_data['FrekIs']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['FrekM']+$rekap_data['FrekMs']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['FrekSK']+$rekap_data['FrekSKs']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['FrekIP']+$rekap_data['FrekIPs']; ?>
													</div>
												</td>
												<td style="text-align:center;">
													<div style="width: 20px">
														<?php echo $rekap_data['FrekSP']+$rekap_data['FrekSPs']; ?>
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