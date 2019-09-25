<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Rekap Presensi</h3>
			</div>
			<div class="panel-body">
				<br>
				<form target="_blank" method="POST" action="<?php echo base_url('HitungHlcm/RekapPresensi/cetakpdf');?>">
					<div class="row">
						<div class="form-group">
							<div class="col-lg-4 text-right">
								<label class="control-label">Periode</label>
							</div>
							<div class="col-lg-3">
								<select class="select select2" id="hlcm-rekappresensi-cutoff" data-placeholder="Bulan" name="periode" style="width: 100%" required>
									<option></option>
									<?php if (isset($periodeGaji) and !empty($periodeGaji)) {
										foreach ($periodeGaji as $key) {
											echo '<option value="'.$key['rangetanggal'].'" >'.$key['bulan']." ".$key['tahun'].'</option>';
										}
									} ?>
								</select>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-4 text-right">
							<input type="submit" name="txtSubmit" class="btn btn-danger" value="Cetak Pdf">
						</div>
						<div class="col-lg-4 text-center">
							<input type="submit" name="txtSubmit" class="btn btn-success" value="Cetak Excel">
						</div>
						<div class="col-lg-4 text-left">
							<div class="col-lg-12">
								<button type="button" class="btn btn-primary" onclick="hlcmRekapPresensiPekerjaSimpan()">Simpan</button>
								<input type="submit" name="txtSubmit" id="hlcm-rekappresensi-simpan" class="btn btn-primary pull-right" value="Simpan Data" style="display: none;">
							</div>
							<div class="col-lg-12">
								<div class="collapse" id="hlcm-detailpresensi-collapse">
									<div class="col-lg-12 text-center">
										<span style="color: red" id="hlcm-detailpresensi-collapse-ket"><i>Mohon untuk mengisi Keterangan</i></span>
									</div>
									<div class="col-lg-12">
										<textarea class="form-control" name="txtKeterangan" id="hlcm-detailpresensi-keterangan"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		
</section>
</body>