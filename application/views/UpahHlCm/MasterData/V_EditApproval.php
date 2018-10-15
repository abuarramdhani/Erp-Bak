<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Setup Approval</h3>
			</div>
			<div class="panel-body">
				<br>
				<form style="margin-left: 200px;" method="POST" action="<?php echo base_url('HitungHlcm/Approval/simpanEdit')?>">
					<input name="id_appproval" hidden="hidden" value="<?php echo $id?>"></input>
					<div class="row">
						<div class="form-group">
							<div align="right" class="col-lg-2">
								<label class="control-label">Lokasi Kerja</label>
							</div>
							<div class="col-lg-5">
								<select name="lokasikerja" id="lokasikerja_select" class="form-control" required="required">
									<option disabled="disabled"><i>Lokasi Kerja</i></option>
									<option value="01" 
									<?php if ($data[0]['lokasi_kerja'] == '01') {
										echo "selected='selected'";
									}?>>Jogja</option>
									<option value="02" 
									<?php if ($data[0]['lokasi_kerja'] == '02') {
										echo "selected='selected'";
									}?>>Tuksono</option>
								</select>
							</div>
						</div>
					</div>
					<div style="margin-top: 5px" class="row">
						<div class="form-group">
							<div align="right" class="col-lg-2">
								<label class="control-label">Posisi</label>
							</div>
							<div class="col-lg-5">
								<select name="posisipekerja" id="posisipekerja" class="form-control" required="required">
									<option disabled="disabled"></option>
									<option value="1" 
									<?php if ($data[0]['id_status'] == '1') {
										echo "selected='selected'";
									}?>>penanggung jawab</option>
									<option value="2"
									<?php if ($data[0]['id_status'] == '2') {
										echo "selected='selected'";
									}?>>mengetahui</option>
									<option value="3"
									<?php if ($data[0]['id_status'] == '3') {
										echo "selected='selected'";
									}?>>menyetujui</option>
								</select>
							</div>
						</div>
					</div>
					<div style="margin-top: 5px" class="row">
						<div class="form-group">
							<div align="right" class="col-lg-2">
								<label class="control-label">No Induk</label>
							</div>
							<div class="col-lg-5">
								<select name="noindukpekerja" id="noinduk_pekerja" class="form-control">
									<option selected="selected"><?php echo $data[0]['noind']?></option>
								</select>
							</div>
						</div>
					</div>
					<div style="margin-top: 5px" class="row">
						<div class="form-group">
							<div align="right" class="col-lg-2">
								<label class="control-label">Nama</label>
							</div>
							<div class="col-lg-5">
								<input class="form-control" id="namapekerja" name="namapekerja" readonly="readonly" value="<?php echo $data[0]['nama']?>"></input>
							</div>
						</div>
					</div>
					<div style="margin-top: 5px; margin-left: 10px" class="row">
						<div class="form-group">
							<div align="right" class="col-lg-4">
								<a class="btn btn-danger" style="color: white;" href="<?php echo base_url('HitungHlcm/Approval/batalkan');?>">Batal</a>
							</div>
							<div align="right" class="col-lg-1">
								<button type="submit" class="btn btn-success">Simpan</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		
</section>
</body>