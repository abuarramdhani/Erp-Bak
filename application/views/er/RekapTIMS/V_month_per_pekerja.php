<?php
$ex_period1 = explode(' ', $periode1);
$ex_period2 = explode(' ', $periode2);
$tgl = explode('-', $ex_period2[0]);
$tgl_new = $tgl[2]-1;
$periode2_new = $tgl[0].'-'.$tgl[1].'-'.$tgl_new.' '.$ex_period2[1];
$begin = new DateTime($periode1);
$end = new DateTime($periode2_new);
$end = $end->modify('+1 day');

$interval = new DateInterval('P1D');

$p = new DatePeriod($begin, $interval ,$end);

foreach ($rekapPerMonth as $rekap_data) {}

?>
<section class="content-header">
	<form target="_blank" method="post" action="<?php echo base_url("RekapTIMSPromosiPekerja/RekapPerPekerja/export-rekap-bulanan") ?>">
		<input type="hidden" name="txtPeriode_bulanan_export" value="<?php echo $tgl[0].'-'.$tgl[1] ?>">
		<input type="hidden" name="txtNoInduk_bulanan_export" value="<?php $count = count($rekapPerMonth); foreach ($rekapPerMonth as $rkp_export) { $count--; if ($count !== 0) { echo "'".$rkp_export['noind']."'".",";} else { echo "'".$rkp_export['noind']."'";} } ?>">
		<button class="btn btn-default pull-right">
			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
		</button>
	</form>
	<h1>
		Rekap TIMS Kebutuhan Promosi Pekerja
	</h1>
</section>
<section class="content">
	<div class="inner" >
		<div class="box box-primary">
			<div class="box-body">
				<table class="table no-border">
					<tr>
						<td width="20%">Periode</td>
						<td>: <?php echo date('F Y', strtotime($ex_period1[0])) ?></td>
					</tr>
				</table>
			</div>
			<div class="box-body">
				<table id="rekap-tims" class="table table-striped table-bordered table-responsive table-hover">
					<thead class="bg-primary">
						<tr>
							<th rowspan="2" style="text-align: center;vertical-align:middle;">
								<div style="width: 30px">
									NO
								</div>
							</th>
							<th rowspan="2" style="text-align: center;vertical-align:middle;">
								<div style="width: 100px">
									NIK
								</div>
							</th>
							<th rowspan="2" style="text-align: center;vertical-align:middle;">
								<div style="width: 300px">
									NAMA
								</div>
							</th>
							<?php
								foreach ($p as $d) {
									$date = $d->format('d-m-Y');
							?>
							<th colspan="6" style="text-align:center;">
								<div style="width: 200px">
									<?php echo $date ?>
								</div>
							</th>
							<?php
								}
							?>
							<th colspan="6" style="text-align:center;">
								<div style="width: 200px">
									REKAP
								</div>
							</th>
						</tr>
						<tr>
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
							foreach ($rekapPerMonth as $rekap_data) {
						?>
						<tr>
							<td style="text-align:center;">
								<div style="width: 30px">
									<?php echo $no++ ?>
								</div>
							</td>
							<td style="text-align:center;">
								<div style="width: 100px">
									<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['nik']; ?>">
										<?php echo $rekap_data['noind']?>
									</a>
								</div>
								
							</td>
							<td>
								<div style="width: 300px">
									<a target="_blank" href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $ex_period1[0].'/'.$ex_period2[0].'/'.$rekap_data['nik']; ?>">
										<?php echo $rekap_data['nama']?>
									</a>
								</div>
								
							</td>
							<?php
								foreach ($p as $d) {
									$date = $d->format('d_M_y');
									foreach (${'rekap_'.$date} as ${'rek'.$date}) {
										if ($rekap_data['noind'] == ${'rek'.$date}['noind'] && $rekap_data['nama'] == ${'rek'.$date}['nama'] && $rekap_data['nik'] == ${'rek'.$date}['nik'] && $rekap_data['tgllahir'] == ${'rek'.$date}['tgllahir'])
										{
											$Terlambat = ${'rek'.$date}['frekt'.strtolower($date)]+${'rek'.$date}['frekts'.strtolower($date)];
											$IjinPribadi = ${'rek'.$date}['freki'.strtolower($date)]+${'rek'.$date}['frekis'.strtolower($date)];
											$Mangkir = ${'rek'.$date}['frekm'.strtolower($date)]+${'rek'.$date}['frekms'.strtolower($date)];
											$SuratKeterangan = ${'rek'.$date}['freksk'.strtolower($date)]+${'rek'.$date}['freksks'.strtolower($date)];
											$IjinPerusahaan = ${'rek'.$date}['frekip'.strtolower($date)]+${'rek'.$date}['frekips'.strtolower($date)];
											$SuratPeringatan = ${'rek'.$date}['freksp'.strtolower($date)]+${'rek'.$date}['freksps'.strtolower($date)];
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
		</div>
	</div>
	</div>
</section>