<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Data Pekerja</h3>
			</div>
			<div class="panel-body">
				<br>
				<form style="margin-left: 200px;" method="POST" action="<?php echo base_url('HitungHlcm/DataPekerja/simpanEditDataPekerja')?>">
				<input name="noind_pekerja" hidden="hidden" value="<?php echo $id;?>"></input>
				<div class="row">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label for="select_pekerjacbg" class="control-label">Lokasi Kerja</label>
						</div>
						<div class="col-lg-3">
							<select name="pekerja_cbg" id="select_pekerjacbg" class="form-control" required="required">
								<option disabled="disabled" selected="selected"><i>Lokasi Kerja</i></option>
								<option value="01" <?php if ($data[0]['lokasi_kerja'] == '01') {
									echo "selected='selected'";
								}?>>Jogja</option>
								<option value="02" <?php if ($data[0]['lokasi_kerja'] == '02') {
									echo "selected='selected'";
								}?>>Tuksono</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row"  style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2"  align="right">
							<label class="control-label">Nomor Induk</label>
						</div>
						<div class="col-lg-5">
							<select class="form-control" name="noindpekerja" id="slc_noinddatapekerja" required="required">
								<option selected="selected"><?php echo $data[0]['noind']?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2"  align="right">
							<label class="control-label">Nama </label>
						</div>
						<div class="col-lg-5">
							<input name="namapekerja" id="namapekerja" type="text" class="form-control" readonly="readonly" value="<?php echo $data[0]['nama'];?>"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">Pekerjaan </label>
						</div>
						<div class="col-lg-5">
							<input name="pekerjaan" id="pekerjaanpekerja" type="text" class="form-control" readonly="readonly" value="<?php echo $pekerjaan[0]['pekerjaan'];?>"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">No Rekening </label>
						</div>
						<div class="col-lg-5">
							<input name="norekening" id="norekening" type="text" class="form-control" required="required" value="<?php echo $data[0]['no_rekening']?>"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">Atas Nama </label>
						</div>
						<div class="col-lg-5">
							<input name="atasnama" id="atasnama" type="text" class="form-control" required="required" value="<?php echo $data[0]['atas_nama']?>"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">Bank </label>
						</div>
						<div class="col-lg-5">
							<select id="slc_bank" name="bankpekerja" class="form-control" required="required">
								<option selected="selected"><?php echo $bank?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">Cabang </label>
						</div>
						<div class="col-lg-5">
							<input name="cabangbank" id="cabangbank" type="text" class="form-control" required="required" value="<?php echo $data[0]['cabang'];?>"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-4">
						<button type="button" id="btn_batal" class="btn btn-danger pull-right"><a style="color: white;" href="<?php echo base_url('HitungHlcm/DataPekerja/batalkan');?>">Batal</a></button>
					</div>
					<div class="col-lg-2">
						<button type="submit" id="btn_save" class="btn btn-success pull-right">Simpan</button>						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
		
</section>
</body>