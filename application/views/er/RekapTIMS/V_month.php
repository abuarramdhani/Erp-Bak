<?php
$ex_period1 = explode(' ', $periode1);
$ex_period2 = explode(' ', $periode2);
$tgl = explode('-', $ex_period2[0]);
$begin = new DateTime($periode1);
$end = new DateTime($periode2);

$interval = new DateInterval('P1D');

$p = new DatePeriod($begin, $interval ,$end);

foreach ($rekapPerMonth as $rekap_data) {}

?>
<section class="content-header">
	<a class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-bulanan/'.$tgl[0].'-'.$tgl[1].'/'.$rekap_data['kode_status_kerja'].'/'.str_replace(' ', '-',$rekap_data['seksi']))?>">
		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
	</a>
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
					<tr>
						<td width="20%">Status Hubungan Kerja</td>
						<td>: <?php echo $kode_status." - ".$statusJabatan ?></td>
					</tr>
					<tr>
						<td width="20%">Seksi</td>
						<td>: <?php echo "Program Komputer" ?></td>
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
							<th rowspan="2" style="text-align: center;vertical-align:middle;">
								<div style="width: 100px">
									Masa Kerja
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