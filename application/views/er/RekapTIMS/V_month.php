<section class="content">
	<div class="inner" >
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h4 class="pull-left"><strong>Rekap TIMS Kebutuhan Promosi Pekerja</strong></h4>
			<a class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/month/#')?>">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
			</a>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-2">
					Periode
				</div>
				<div class="col-md-3">
					Januari 2015
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					Status Hubungan Kerja
				</div>
				<div class="col-md-3">
					F-PKL
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					Seksi
				</div>
				<div class="col-md-3">
					ICT
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					Note
				</div>
				<div class="col-md-10">
					<strong>
						T : Terlambat
						I : Izin Pribadi
						M : Mangkir
						S : Sakit
						IP : Izin Perusahaan
						SP : Surat Peringatan
					</strong>
				</div>
			</div>
		</div>
		<div class="box-body">
				<table style="max-width: 90%" id="monthRekap" class="table table-striped table-bordered table-responsive table-hover ">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<tr>
							<td rowspan="2" style="width:5%; text-align:center;">NO</td>
							<td rowspan="2" style="text-align:center;">NIK</td>
							<td rowspan="2" style="text-align:center;">NAMA</td>
							<td colspan="6" style="text-align:center;">01/02/2015</td>
							<td colspan="6" style="text-align:center;">REKAP</td>
						</tr>
						<tr>
							<?php /*$tgl=1; foreach($bulan as $schedule_item){ 
								if($schedule_item['day'] == 1){
									$max_day = 30;
								}
								else if($schedule_item['day'] == 2){
									$max_day = 31;
								}
								else if($schedule_item['day'] == 3){
									$max_day = 28;
								}
								else if($schedule_item['day'] == 4){
									$day = 'Kamis';
								}
								else if($schedule_item['day'] == 5){
									$day = 'Jumat';
								}
								else if($schedule_item['day'] == 6){
									$day = 'Sabtu';
								}
								else $day = 'Minggu'; */?>
						<!-- LOOPING -->
							<td>T</td>
							<td>I</td>
							<td>M</td>
							<td>S</td>
							<td>IP</td>
							<td>SP</td>
						<!-- LOOPING -->
							<td>T</td>
							<td>I</td>
							<td>M</td>
							<td>S</td>
							<td>IP</td>
							<td>SP</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:center;">1</td>
							<td>132564</td>
							<td style="text-align:center;">Joko Prayitno</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
							<td style="text-align:center;">1</td>
						</tr>
					</tbody>
				</table>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	</div>
</section>