<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Data Gaji</h3>
			</div>
			<div class="panel-body">
				<br>
				<form style="margin-left: 200px;" method="POST" action="<?php echo base_url('HitungHlcm/DataGaji/simpanDataGaji')?>">
				<div class="row">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label for="select_pekerjacbg" class="control-label">Lokasi </label>
						</div>
						<div class="col-lg-3">
							<select name="pekerja_cbg" id="select_pekerjacbg" class="form-control">
								<option disabled="disabled" selected="selected"><i>Lokasi Kerja</i></option>
								<option value="01">Jogja</option>
								<option value="02">Tuksono</option>
							</select>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="form-group">
						<div class="col-lg-2"  align="right">
							<label class="control-label">Kepala Tukang </label>
						</div>
						<div class="col-lg-3">
							<input name="kepalatukang" id="kepalatukang" type="text" class="form-control" readonly="readonly"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2"  align="right">
							<label class="control-label">Tukang </label>
						</div>
						<div class="col-lg-3">
							<input name="tukang" id="tukang" type="text" class="form-control" readonly="readonly"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">Serabutan </label>
						</div>
						<div class="col-lg-3">
							<input name="serabutan" id="serabutan" type="text" class="form-control" readonly="readonly"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">Tenaga </label>
						</div>
						<div class="col-lg-3">
							<input name="tenaga" id="tenaga" type="text" class="form-control" readonly="readonly"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">Uang Makan </label>
						</div>
						<div class="col-lg-3">
							<input name="uang_makan" id="uangmakan" type="text" class="form-control" readonly="readonly"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 5px;">
					<div class="form-group">
						<div class="col-lg-2" align="right">
							<label class="control-label">Uang Makan Puasa</label>
						</div>
						<div class="col-lg-3">
							<input name="uang_makan_puasa" id="uangmakanpuasa" type="text" class="form-control" readonly="readonly"></input>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-3">
						<button type="button" id="button_edit" class="btn btn-warning pull-right" data="1">Edit</button>
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