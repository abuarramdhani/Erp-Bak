<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Hitung Gaji</h3>
			</div>
			<div class="panel-body">
				<br>
				<form method="POST" action="<?php echo base_url('HitungHlcm/HitungGaji/getData')?>">
				<div class="row">
					<div class="col-lg-1">
						<label class="control-label">Periode</label>		
					</div>
					<div class="col-lg-2">
						<input type="text" class="form-control" value="<?php if (isset($periodeGaji) and !empty($periodeGaji)) { echo $periodeGaji['0']['tahun'];} ?>" name="" disabled>
					</div>
					<div class="col-lg-2">
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
					<div class="col-lg-2">
						<select name="lokasi_kerja" class="form-control">
							<option disabled="disabled" selected="selected"><i>Lokasi Kerja</i></option>
							<option value="01">Jogja</option>
							<option value="02">Tuksono</option>
						</select>
					</div>
					<div class="col-lg-4">
						<div class="col-lg-3" style="padding-right: 0px;padding-left: 0px">
						<input type="checkbox" name="puasa"> Puasa
						</div>
						<div class="col-lg-9">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar">
										
									</span>
								</span>
								<input id="periodeGaji" name="periodePuasa" class="prosesgaji-daterangepicker form-control" placeholder="Periode"></input>		
							</div>
						</div>
					</div>
					<div class="col-lg-1">
						<button type="submit" class="btn btn-primary">Proses</button>
						<?php if (isset($valLink)): ?>
							<a target="_blank" href="<?php echo site_url('HitungHlcm/HitungGaji/printProses/xls/'.$valLink); ?>" class="btn btn-success">Excel</a>
							<a target="_blank" href="<?php echo site_url('HitungHlcm/HitungGaji/printProses/pdf/'.$valLink); ?>" class="btn btn-danger">PDF</a>
						<?php endif ?>
					</div>
				</div>
				</form>
				<br>
				<table id="table_prosesgaji" class="table table-hover table-bordered table-striped">
					<thead>
						<tr style="background-color: #00ccff;">
							<th style="text-align: center; vertical-align: middle;" rowspan="2">No</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="2">Nama</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="2">Status</th>
							<th style="text-align: center;" colspan="4">Komponen</th>
							<th style="text-align: center;" colspan="4">Nominal</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="2">Total Gaji</th>
						</tr>
						<tr style="background-color: #00ccff;">
							<th style="text-align: center;">Gaji Pokok</th>
							<th style="text-align: center;">Uang Makan</th>
							<th style="text-align: center;">Uang Makan Puasa</th>
							<th style="text-align: center;">Lembur</th>
							<th style="text-align: center;">Gaji Pokok</th>
							<th style="text-align: center;">Uang Makan</th>
							<th style="text-align: center;">Uang Makan Puasa</th>
							<th style="text-align: center;">Lembur</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no=1;
						foreach ($hasil as $key) {
							?>
							<tr>
								<td style="text-align: center;"><?php echo $no;?></td>
								<td><?php echo $key['nama'];?></td>
								<td style="text-align: center;"><?php echo $key['pekerjaan'];?></td>
								<td style="text-align: center;"><?php echo $key['jml_gp'];?></td>
								<td style="text-align: center;"><?php echo $key['jml_um'];?></td>
								<td style="text-align: center;"><?php echo $key['jml_ump'];?></td>
								<td style="text-align: center;"><?php echo $key['jml_lbr'];?></td>
								<td style="text-align: center;"><?php echo $key['gp'];?></td>
								<td style="text-align: center;"><?php echo $key['um'];?></td>
								<td style="text-align: center;"><?php echo $key['ump'];?></td>
								<td style="text-align: center;"><?php echo $key['lmbr'];?></td>
								<td style="text-align: center;"><?php echo $key['total_bayar'];?></td>
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