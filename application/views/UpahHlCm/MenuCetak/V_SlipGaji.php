<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Slip Gaji</h3>
			</div>
			<div class="panel-body">
				<br>
				<form style="margin-left: 200px" method="POST" action="<?php echo base_url('HitungHlcm/SlipGaji/cetakpdf');?>">
					<div class="row">
						<div class="form-group">
							<div class="col-lg-1">
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
					<div style="margin-top: 5px" class="row">
						<div class="form-group">
							<div class="col-lg-1">
								<label class="control-label">Pekerja</label>
							</div>
							<div class="col-lg-3">
								<select name="noindPekerja" id="noindPekerja" class="form-control"></select>					
							</div>
							<div class="col-lg-3" style="padding-left: 0px">
								<p style="font-size: 10px;">*kosongi untuk cetak slip gaji semua pekerja dalam periode tsb</p>					
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-3">
							<button type="submit" class="btn btn-success pull-right">Cetak</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		
</section>
</body>