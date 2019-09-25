<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Memo</h3>
			</div>
			<div class="panel-body">
				<br>
				<form target="_blank" style="margin-left: 200px" method="POST" action="<?php echo base_url('HitungHlcm/Memo/cetakpdf');?>">
					<div class="row">
						<div class="form-group">
							<div class="col-lg-2" style="text-align: right;">
								<label class="control-label">Periode</label>
							</div>
							<div class="col-lg-3">
								<select class="select select2" data-placeholder="Bulan" name="periode" style="width: 100%">
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
						<div class="form-group">
							<div class="col-lg-2" style="text-align: right;">
								<label class="control-label">No Memo</label>
							</div>
							<div class="col-lg-3">
								<input name="nmr_memo" class="form-control"></input>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="form-group">
							<div class="col-lg-2" style="text-align: right;">
								<label class="control-label">Status</label>
							</div>
							<div class="col-lg-3">
								<select name="statusPekerja" id="statusPekerja" data-placeholder="Status Pekerja" class="select2" style="width: 100%" required>
									<option value="1">Semua Pekerja</option>
									<option value="2">Pekerja Aktif</option>
									<option value="3">Pekerja Keluar</option>
								</select>					
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-4">
							<input type="submit" name="txtSubmit" class="btn btn-danger pull-right" value="Cetak Pdf">
							<input type="submit" name="txtSubmit" class="btn btn-success pull-right" value="Cetak Excel" style="margin-right: 10px">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		
</section>
</body>