<?php
$ex_period = explode(' ', $periode2);
$tgl = explode('-', $ex_period[0]);
$tgl_new = $tgl[2]-1;
$periode2 = $tgl[0].'-'.$tgl[1].'-'.$tgl_new.' '.$ex_period[1];
$datetime = new DateTime;
$p = new DatePeriod(
		new DateTime($periode1),
		new DateInterval('P1D'),
		$datetime($periode2)->modify('+1 day')
	);

foreach ($rekapPerMonth as $rekap_data) {}

?>
<section class="content-header">
	<a class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-bulanan/'.$tgl[0].'-'.$tgl[1].'/'.$rekap_data['kd_jabatan'].'/'.str_replace(' ', '-',$rekap_data['seksi']))?>">
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
						<td>: <?php echo $periodeMonth ?></td>
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
									$date = $d->format('d_M_y');
									foreach (${'rekap_'.$date} as ${'rek'.$date}) {
										if ($rekap_data['noind'] == ${'rek'.$date}['noind'] && $rekap_data['nama'] == ${'rek'.$date}['nama'] && $rekap_data['nik'] == ${'rek'.$date}['nik'] && $rekap_data['tgllahir'] == ${'rek'.$date}['tgllahir'])
										{
											$Terlambat = ${'rek'.$date}['FrekT'.$date]+${'rek'.$date}['FrekTs'.$date];
											$IjinPribadi = ${'rek'.$date}['FrekI'.$date]+${'rek'.$date}['FrekIs'.$date];
											$Mangkir = ${'rek'.$date}['FrekM'.$date]+${'rek'.$date}['FrekMs'.$date];
											$SuratKeterangan = ${'rek'.$date}['FrekSK'.$date]+${'rek'.$date}['FrekSKs'.$date];
											$IjinPerusahaan = ${'rek'.$date}['FrekIP'.$date]+${'rek'.$date}['FrekIPs'.$date];
											$SuratPeringatan = ${'rek'.$date}['FrekSP'.$date]+${'rek'.$date}['FrekSPs'.$date];
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
		</div>
	</div>
	</div>
</section>