<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="row">
									<div class="col-sm-12">
										<h3 style="text-align: center;vertical-align: middle;">Data Absen Pekerja</h3>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="col-lg-6">
												<div class="form-group">
													<label class="control-label col-lg-4">Departement</label>
													<div class="col-lg-8">
														<select id="slc-CM-PresensiPekerja-Dept" style="width: 100%" autocomplete="off">
															<option></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Bidang</label>
													<div class="col-lg-8">
														<select id="slc-CM-PresensiPekerja-Bidang" style="width: 100%" disabled autocomplete="off">
															<option></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Unit</label>
													<div class="col-lg-8">
														<select id="slc-CM-PresensiPekerja-Unit" style="width: 100%" disabled autocomplete="off">
															<option></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Seksi</label>
													<div class="col-lg-8">
														<select id="slc-CM-PresensiPekerja-Seksi" style="width: 100%" disabled autocomplete="off">
															<option></option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label class="control-label col-lg-4">Tanggal Awal</label>
													<div class="col-lg-8">
														<input type="text" id="txt-CM-PresensiPekerja-TanggalAwal" class="form-control" autocomplete="off">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Tanggal Akhir</label>
													<div class="col-lg-8">
														<input type="text" id="txt-CM-PresensiPekerja-TanggalAkhir" class="form-control" autocomplete="off">
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-6 text-right">
														<button type="button" class="btn btn-primary" id="btn-CM-PresensiPekerja-Tampil">Tampil</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}

											.dataTables_info {
												float: left
											}
										</style>
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-PresensiPekerja-Table">
											<thead>
												<tr>
													<th rowspan="3" class="bg-primary" style="text-align: center;vertical-align: middle;">No.</th>
													<th rowspan="3" class="bg-primary" style="text-align: center;vertical-align: middle;">Dept</th>
													<th rowspan="3" class="bg-primary" style="text-align: center;vertical-align: middle;">Bidang</th>
													<th rowspan="3" class="bg-primary" style="text-align: center;vertical-align: middle;">Unit</th>
													<th rowspan="3" class="bg-primary" style="text-align: center;vertical-align: middle;">Seksi</th>
													<th rowspan="3" class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal</th>
													<th colspan="24" class="bg-primary" style="text-align: center;vertical-align: middle;">Shift</th>
												</tr>
												<tr>
													<th class="bg-primary" colspan="6" style="text-align: center;vertical-align: middle;">Shift 1</th>
													<th class="bg-primary" colspan="6" style="text-align: center;vertical-align: middle;">Shift 2</th>
													<th class="bg-primary" colspan="6" style="text-align: center;vertical-align: middle;">Shift 3</th>
													<th class="bg-primary" colspan="6" style="text-align: center;vertical-align: middle;">Shift Umum</th>
												</tr>
												<tr>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">E</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">R</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">CT</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">SK</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">M</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">L</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">E</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">R</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">CT</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">SK</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">M</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">L</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">E</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">R</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">CT</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">SK</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">M</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">L</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">E</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">R</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">CT</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">SK</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">M</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">L</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style type="text/css">
	.loading {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0,0,0,.5);
    z-index: 9999 !important;
}
.loading-wheel {
    width: 40px;
    height: 40px;
    margin-top: -80px;
    margin-left: -40px;
    
    position: absolute;
    top: 50%;
    left: 50%;
}
.loading-wheel-2 {
    width: 100%;
    height: 20px;
    margin-top: -50px;
    
    position: absolute;
    top: 70%;
    font-weight: bold;
    font-size: 30pt;
    color: white;
    text-align: center;
}

</style>
<div class="loading" id="ldg-CM-PresensiPekerja-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>