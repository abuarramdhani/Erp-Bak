<style type="text/css">
	.dataTables_filter { 
		float: right;
	}
	.dataTables_info { 
		float: left;
	}
</style>
<section class="content-header">
	<h1>
		<?= $Title?>
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="table-responsive">
					<fieldset class="row2">
						<div class="box-body with-border">
							<form id="filter-rekap" method="post" action="">
								<div class="form-group">
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Tanggal</label>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" id="rjpTglRekap" class="form-control" name="tglRekap" required>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Status Hubungan Kerja</label>
										</div>
										<div class="col-md-7">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-briefcase"></i>
													</div>
													<select id="er-status" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name ="statushubker[]" required multiple="multiple">
														<?php foreach ($status as $status_item){ ?>
														<option value="<?php echo $status_item['fs_noind'];?>">
															<?php echo $status_item['fs_noind'].' - '.$status_item['fs_ket'];?>
														</option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-1">
											<label style="margin-top: 5px" class="pull-center">
												<input class="azek" type="checkbox" id="er_all" class="form-control" name="statusAll" value="1">
												ALL
											</label>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Departemen</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select data-placeholder="Pilih Salah Satu!" class="form-control select2 RekapAbsensi-cmbDepartemen" style="width:100%" name="cmbDepartemen" required>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Bidang</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select data-placeholder="Pilih Salah Satu!" class="form-control select2 RekapAbsensi-cmbBidang" style="width:100%" name="cmbBidang" required>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Unit</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select data-placeholder="Pilih Salah Satu!" class="form-control select2 RekapAbsensi-cmbUnit" style="width:100%" name="cmbUnit" required>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Seksi</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select data-placeholder="Pilih Salah Satu!" class="form-control select2 RekapAbsensi-cmbSeksi" style="width:100%" name="cmbSeksi" required>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Lokasi Kerja</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-briefcase"></i>
													</div>
													<select data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="cmbloker" required>
														<option value="00">SEMUA LOKASI KERJA</option>
														<?php 
														foreach ($loker as $lok) { ?>
														<option value="<?php echo $lok['id_'] ?>"><?php echo $lok['id_']." - ".$lok['lokasi_kerja'] ?></option>
														<?php }
														?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px;vertical-align: middle">
										<div class="col-md-7">
										</div>
										<div class="col-md-3">
										</div>
										<div class="col-md-1">
											<span id="rjp_Sub" class="btn btn-primary pull-right" style="vertical-align: middle">
												PROSES
											</span>
										</div>
									</div>
								</div>
							</form>
							<div id="table-div">
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<div class="box box-primary">
				<div class="box-body with-border">
					<div class="col-md-12" id="rjpTbl">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
	<div class="col-md-6" style="position: fixed; top: 40%;left: 0;right: 0;bottom: 0; margin: auto; padding-left: 0px; padding-right: 0px;">
		<div class="col-md-12 text-center" style="height: 100px; background-color: #fff; border-radius: 10px;">
			<h3>Now Loading ...</h3>
			<div class="progress">
				<div class="progress-bar progress-bar-striped active rjpProgres" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
				</div>
			</div>
		</div>
	</div>
</div>