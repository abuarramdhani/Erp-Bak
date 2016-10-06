<?php
$ex_period1 = explode(' ', $periode1_ori);
$ex_period2 = explode(' ', $periode2_ori);
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
						<form target="_blank" id="export_form" method="post" action="<?php echo base_url("RekapTIMSPromosiPekerja/RekapPerPekerja/export-rekap-detail") ?>">
							<input type="hidden" name="txtDetail" value="0">
							<input type="hidden" name="txtPeriode1_export" value="<?php echo $periode1_ori ?>">
							<input type="hidden" name="txtPeriode2_export" value="<?php echo $periode2_ori ?>">
							<input type="hidden" name="txtNoInduk_export" value="<?php $count = count($rekap); foreach ($rekap as $rkp_export) { $count--; if ($count !== 0) { echo "'".$rkp_export['noind']."'".",";} else { echo "'".$rkp_export['noind']."'";} } ?>">
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
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">MASA KERJA</th>
										<th colspan="6" style="text-align: center">REKAP</th>
									</tr>
									<tr class="bg-primary">
										<th style="text-align: center">T</th>
										<th style="text-align: center">I</th>
										<th style="text-align: center">M</th>
										<th style="text-align: center">S</th>
										<th style="text-align: center">IP</th>
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
													$masukkerja = $rekap_data['masuk_kerja_sebelum'];
													if($rekap_data['masuk_kerja_sebelum'] == NULL || $rekap_data['masuk_kerja_sebelum'] == ''){
														$masukkerja = $rekap_data['masukkerja'];
													}
													$masa1 = strtotime($masukkerja);
													$masa2 = strtotime($periode2_ori);

													$year1 = date('Y', $masa1);
													$year2 = date('Y', $masa2);

													$month1 = date('m', $masa1);
													$month2 = date('m', $masa2);

													$total_masa_kerja = (($year2 - $year1) * 12) + ($month2 - $month1);
													echo $total_masa_kerja;
												?>
											</td>
											<td style="text-align:center;"><?php echo $rekap_data['frekt']+$rekap_data['frekts']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['freki']+$rekap_data['frekis']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekm']+$rekap_data['frekms']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['freksk']+$rekap_data['freksks']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekip']+$rekap_data['frekips'] ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['freksp']+$rekap_data['freksps'] ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<!--</div>
			</div>
		</div>
	</div>
</section>-->