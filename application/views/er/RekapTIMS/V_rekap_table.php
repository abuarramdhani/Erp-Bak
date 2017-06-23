<?php
$ex_period1 = explode(' ', $periode1);
$ex_period2 = explode(' ', $periode2);
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
								<input type="hidden" name="txtDetail" value="0">
								<input type="hidden" name="txtPeriode1_export" value="<?php echo $periode1 ?>">
								<input type="hidden" name="txtPeriode2_export" value="<?php echo $periode2 ?>">
								<input type="hidden" name="txtStatus_export" value="<?php echo $rekap_data['kode_status_kerja'] ?>">
								<input type="hidden" name="txtSeksi_export" value="<?php echo $section ?>">
								<button class="btn btn-default pull-right">
									<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
								</button>
							</form>
							<table id="rekap-tims" class="table table-bordered table-hover table-striped">
								<thead>
									<tr class="bg-primary">
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NO</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NIK</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NAMA</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">Masa Kerja</th>
										<th colspan="7" style="text-align: center">REKAP</th>
									</tr>
									<tr class="bg-primary">
										<th style="text-align: center">T</th>
										<th style="text-align: center">I</th>
										<th style="text-align: center">M</th>
										<th style="text-align: center">S</th>
										<th style="text-align: center">IP</th>
										<th style="text-align: center">CT</th>
										<th style="text-align: center">SP</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=1; foreach ($rekap as $rekap_data) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td style="text-align:center;">
												<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['nik']; ?>">
													<?php echo $rekap_data['noind']; ?>
												</a>
											</td>
											<td>
												<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['nik']; ?>">
													<?php echo $rekap_data['nama']; ?>
												</a>
											</td>
											<td style="text-align:center;">
												<?php
													$masukkerja_s = '';
													${'masa_kerja'.$rekap_data['nama']} = array();
													$index_masakerja = 0;
													$aktif=0;
													foreach ($rekap_masakerja as $row) {
														if ($row['nama'] == $rekap_data['nama'] AND $row['nik'] == $row['nik']) {
															if ($row['masukkerja'] != $masukkerja_s) {
																$masukkerja = new DateTime($row['masukkerja']);
																$tglkeluar = new DateTime($row['tglkeluar']);
																$masa_kerja = $masukkerja->diff($tglkeluar);
																${'masa_kerja'.$rekap_data['nama']}[$index_masakerja] = $masa_kerja;
																$index_masakerja++;
															}
															
															if ('f' == $row['keluar'])
																{
																	$aktif=1;
																	$amasukkerja=$row['masukkerja'];
																	$aperiode2=$ex_period2[0].' '.$ex_period2[1];
																}
															if(1==$index_masakerja && 1==$aktif)
															{
																$bmasukkerja = new DateTime($amasukkerja);
																$bperiode2 = new DateTime($aperiode2);
																$masa_kerja = $bmasukkerja->diff($bperiode2);		
																${'masa_kerja'.$rekap_data['nama']}[0] = $masa_kerja;		
															}

															$masukkerja_s = $row['masukkerja'];
														}
													}
													
													$e = new DateTime();
													$f = clone $e;
													if (!empty(${'masa_kerja'.$rekap_data['nama']}[0])) {
														$e->add(${'masa_kerja'.$rekap_data['nama']}[0]);
													}
													if (!empty(${'masa_kerja'.$rekap_data['nama']}[1])) {
														$e->add(${'masa_kerja'.$rekap_data['nama']}[1]);
													}
													echo $f->diff($e)->format("%Y Tahun %m Bulan %d Hari");
												?>
											</td>
											<td style="text-align:center;"><?php echo $rekap_data['frekt']+$rekap_data['frekts']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['freki']+$rekap_data['frekis']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekm']+$rekap_data['frekms']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['freksk']+$rekap_data['freksks']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekip']+$rekap_data['frekips'] ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekct']+$rekap_data['frekcts'] ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['freksp']+$rekap_data['freksps'] ?></td>
										</tr>
									<?php } ?>
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
									CT : Cuti Tahunan&emsp;
									SP : Surat Peringatan
								</strong>
							</p>
						<!--</div>
			</div>
		</div>
	</div>
</section>-->