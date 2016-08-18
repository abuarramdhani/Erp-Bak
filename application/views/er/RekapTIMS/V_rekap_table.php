<?php
$ex_period1 = explode(' ', $periode1);
$ex_period2 = explode(' ', $periode2);
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
							<a class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-detail/'.$ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['kd_jabatan'].'/'.str_replace(' ', '-', $rekap_data['seksi']))?>/0">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
							</a>
							<table id="rekap-tims" class="table table-bordered table-hover table-striped">
								<thead>
									<tr class="bg-primary">
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NO</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NIK</th>
										<th rowspan="2" style="text-align: center;vertical-align:middle;font-size:20px">NAMA</th>
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
												<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $rekap_data['nik']; ?>">
													<?php echo $rekap_data['noind']; ?>
												</a>
											</td>
											<td>
												<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $rekap_data['nik']; ?>">
													<?php echo $rekap_data['nama']; ?>
												</a>
											</td>
											<td style="text-align:center;"><?php echo $rekap_data['FrekT']+$rekap_data['FrekTs']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['FrekI']+$rekap_data['FrekIs']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['FrekM']+$rekap_data['FrekMs']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['FrekSK']+$rekap_data['FrekSKs']; ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['FrekIP']+$rekap_data['FrekIPs'] ?></td>
											<td style="text-align:center;"><?php echo $rekap_data['FrekSP']+$rekap_data['FrekSPs'] ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<!--</div>
			</div>
		</div>
	</div>
</section>-->