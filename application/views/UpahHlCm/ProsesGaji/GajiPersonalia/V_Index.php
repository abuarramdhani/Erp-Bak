<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Hitung Gaji</h3>
			</div>
			<div class="panel-body">
				<br>
				<form method="POST" action="<?php echo base_url('HitungHlcm/GajiPersonalia/getData')?>">
				<div class="row">
					<div class="col-lg-4">
						<div class="col-lg-3">
							<label class="control-label">Periode</label>		
						</div>
						<div class="col-lg-4">
							<input type="text" class="form-control" value="<?php if (isset($periodeGaji) and !empty($periodeGaji)) { echo $periodeGaji['0']['tahun'];} ?>" name="" disabled>
						</div>
						<div class="col-lg-5" style="margin-right: 0px;padding-right: 0px;margin-left: 0px;padding-left: 0px">
							<select class="select select2" data-placeholder="Bulan" name="periodeData" style="width: 100%">
								<option></option>
								<?php if (isset($periodeGaji) and !empty($periodeGaji)) {
									foreach ($periodeGaji as $key) {
										$select = '';
										if ($key['rangetanggal'] == $periodeGajiSelected) {
											$select = 'selected';
										}
										echo '<option value="'.$key['rangetanggal'].'" '.$select.'>'.$key['bulan'].'</option>';
									}
								} ?>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<label class=" control-label col-lg-5" style="margin-right: 0px;padding-right: 0px ">Lokasi Kerja</label>
						<div class="col-lg-7">
							<select name="lokasi_kerja" class="form-control">
								<option disabled="disabled" selected="selected"><i>Lokasi Kerja</i></option>
								<option value="01">Jogja</option>
								<option value="02">Tuksono</option>
							</select>
						</div>
						
					</div>
					<div class="col-lg-5">
						<div class="col-lg-3 text-right" style="padding-right: 0px;padding-left: 0px">
						<input type="checkbox" id="hlcm-prosesgaji-puasa" name="puasa"> Puasa
						</div>
						<div class="col-lg-9">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar">
										
									</span>
								</span>
								<input id="periodeGaji" disabled="disabled" name="periodePuasa" class="prosesgaji-daterangepicker form-control" placeholder="Periode"></input>		
							</div>
						</div>
					</div>
					
				</div>
				<div class="row" style="margin-top: 10px">
					<div class="col-lg-4">
						<label class="control-label col-lg-3">Status</label>
						<div class="col-lg-9" style="margin-right: 0px;padding-right: 0px">
							<select class="select2" name="keluar" style="width: 100%">
								<option value="1">Semua Pekerja</option>
								<option value="2">Pekerja Aktif</option>
								<option value="3">Pekerja Keluar</option>
							</select>
						</div>
					</div>
					<div class="col-lg-8 text-center">
						<button type="submit" class="btn btn-primary">Proses</button>
						<?php if (isset($valLink)): ?>
							<a target="_blank" href="<?php echo site_url('HitungHlcm/GajiPersonalia/printProses/xls/'.$valLink); ?>" class="btn btn-success">Excel</a>
						<?php endif ?>
					</div>
				</div>
				</form>
				<br>
				<table id="table_prosesgaji" class="table table-hover table-bordered table-striped">
					<thead>
						<tr style="background-color: #00ccff;">
							<th style="text-align: center; vertical-align: middle;" rowspan="3">No</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="3">No. Induk</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="3">Nama</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="3">Status</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="3">Lokasi Kerja</th>
							<th style="text-align: center;" colspan="4">Proses Gaji</th>
							<th style="text-align: center;" colspan="3">Tambahan</th>
							<th style="text-align: center;" colspan="3">Potongan</th>
						</tr>
						<tr style="background-color: #00ccff;">
							<th style="text-align: center;" colspan="4">Komponen</th>
							<th style="text-align: center;" colspan="3">Komponen</th>
							<th style="text-align: center;" colspan="3">Komponen</th>
						</tr>
						<tr style="background-color: #00ccff;">
							<!-- Proses Gaji -->
							<th style="text-align: center;">Gaji Pokok</th>
							<th style="text-align: center;">Lembur</th>
							<th style="text-align: center;">Uang Makan</th>
							<th style="text-align: center;">Uang Makan Puasa</th>							
							<!-- Tambahan -->
							<th style="text-align: center;">Gaji Pokok</th>
							<th style="text-align: center;">Lembur</th>
							<th style="text-align: center;">Uang Makan</th>							
							<!-- Potongan -->
							<th style="text-align: center;">Gaji Pokok</th>
							<th style="text-align: center;">Lembur</th>
							<th style="text-align: center;">Uang Makan</th>							
						</tr>
					</thead>
					<tbody>
						<?php
						$no=1;
						foreach ($hasil as $key) {
							?>
							<tr>
								<td style="text-align: center;"><?php echo $no;?></td>
								<td><?php echo $key['noind'];?></td>
								<td><?php echo $key['nama'];?></td>
								<td style="text-align: center;"><?php echo $key['pekerjaan'];?></td>
								<td style="text-align: center;"><?php echo $key['lokasi'];?></td>
								<td style="text-align: center;"><?php echo $key['jml_gp'];?></td>
								<td style="text-align: center;"><?php echo $key['jml_lbr'];?></td>
								<td style="text-align: center;"><?php echo $key['jml_um'];?></td>
								<td style="text-align: center;"><?php echo $key['jml_ump'];?></td>								
								<?php 
								if (!empty($key['tambahan'])) {
									?>
									<td style="text-align: center;"><?php echo $key['tambahan']->gp ?></td>
									<td style="text-align: center;"><?php echo $key['tambahan']->lembur ?></td>
									<td style="text-align: center;"><?php echo $key['tambahan']->um ?></td>	
									<?php
									$key['total_bayar'] += ($key['tambahan']->nominal_gp + $key['tambahan']->nominal_um + $key['tambahan']->nominal_lembur);
								}else{
									?>
									<td style="text-align: center;">0</td>
									<td style="text-align: center;">0</td>
									<td style="text-align: center;">0</td>
									<?php
								} ?>
								<?php 
								if (!empty($key['potongan'])) {
									?>
									<td style="text-align: center;"><?php echo $key['potongan']->gp ?></td>
									<td style="text-align: center;"><?php echo $key['potongan']->lembur ?></td>	
									<td style="text-align: center;"><?php echo $key['potongan']->um ?></td>
									
									<?php
									$key['total_bayar'] -= ($key['potongan']->nominal_gp + $key['potongan']->nominal_um + $key['potongan']->nominal_lembur);
								}else{
									?>
									<td style="text-align: center;">0</td>
									<td style="text-align: center;">0</td>
									<td style="text-align: center;">0</td>
									<?php
								} ?>
							</tr>
							<?php
							$no++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
		
</section>
</body>