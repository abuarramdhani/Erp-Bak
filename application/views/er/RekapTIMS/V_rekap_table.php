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
							<table id="rekap-tims" class="table table-bordered table-hover table-striped">
								<thead>
									<tr class="bg-primary">
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NO</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NIK</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NAMA</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">Masa Kerja</th>
										<th colspan="8" style="text-align: center">REKAP</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">TOTAL HARI KERJA</th>
										<th colspan="8" style="text-align: center">PERSENTASE</th>
									</tr>
									<tr class="bg-primary">
										<th style="text-align: center">T</th>
										<th style="text-align: center">I</th>
										<th style="text-align: center">M</th>
										<th style="text-align: center">S</th>
										<th style="text-align: center">PSP</th>
										<th style="text-align: center">IP</th>
										<th style="text-align: center">CT</th>
										<th style="text-align: center">SP</th>
										<th style="text-align: center">T</th>
										<th style="text-align: center">I</th>
										<th style="text-align: center">M</th>
										<th style="text-align: center">S</th>
										<th style="text-align: center">PSP</th>
										<th style="text-align: center">IP</th>
										<th style="text-align: center">CT</th>
										<th style="text-align: center">TOTAL</th>
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
												<?php echo $rekap_data['masa_kerja'];?>
											</td>
											<td style="text-align:center;"><?php echo $rekap_data['frekt']+$rekap_data['frekts']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['freki']+$rekap_data['frekis']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekm']+$rekap_data['frekms']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['freksk']+$rekap_data['freksks']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekpsp']+$rekap_data['frekpsps']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekip']+$rekap_data['frekips'] ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['frekct']+$rekap_data['frekcts'] ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['total_jmlsp']+$rekap_data['total_jmlsps']; ?></td>
											<td style="text-align:center;"><?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : ($rekap_data['totalhk']+$rekap_data['totalhks'])) ?></td>
											<td style="text-align:center;"><?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekt']+$rekap_data['frekts']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?></td>
											<td style="text-align:center;"><?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['freki']+$rekap_data['frekis']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?></td>
											<td style="text-align:center;"><?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekm']+$rekap_data['frekms']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?></td>
											<td style="text-align:center;"><?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['freksk']+$rekap_data['freksks']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?></td>
											<td style="text-align:center;"><?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekpsp']+$rekap_data['frekpsps']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?></td>
											<td style="text-align:center;"><?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekip']+$rekap_data['frekips']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?></td>
											<td style="text-align:center;"><?php echo ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekct']+$rekap_data['frekcts']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))) ?></td>
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
