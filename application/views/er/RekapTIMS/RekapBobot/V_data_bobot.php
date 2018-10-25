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
						<form target="_blank" id="export_form" method="post" action="<?php echo base_url("RekapTIMSPromosiPekerja/RekapBobot/ExportRekapDetail") ?>">
							<input type="hidden" name="txtDetail" value="0">
							<input type="hidden" name="txtPeriode1_export" value="<?php echo $periode1 ?>">
							<input type="hidden" name="txtPeriode2_export" value="<?php echo $periode2 ?>">
							<input type="hidden" name="txtStatus" value="<?php echo $status ?>">
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
										<th colspan="3" style="text-align: center">REKAP</th>
									</tr>
									<tr class="bg-primary">
										<th style="text-align: center">T</th>
										<th style="text-align: center">I</th>
										<th style="text-align: center">M</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=1; 
									foreach ($rekap as $rekap_data) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td style="text-align:center;">
												<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['noind']; ?>">
													<?php echo $rekap_data['noind']; ?>
												</a>
											</td>
											<td>
												<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['noind']; ?>">
													<?php echo $rekap_data['nama']; ?>
												</a>
											</td>
											<td style="text-align:center;">
												<?php echo $rekap_data['masa_kerja'];?>
											</td>
											<td style="text-align:center;"><?php echo $rekap_data['pointtt']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['pointtik']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['pointtm']; ?></td>
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