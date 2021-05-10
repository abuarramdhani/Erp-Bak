<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<b><h3><?=$Title ?></h3></b>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-2">
													Tanggal
												</label>
												<div class="col-lg-4">
													<input type="text" id="txtMPRPresensiHarianTanggal" placeholder="YYYY-MM-DD - YYYY-MM-DD" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">
													Filter
												</label>
												<div class="col-lg-6">
													<div class="col-lg-3">
														<input type="checkbox" id="chkMPRPresensiHarianLokasiKerja">&nbsp;
														<label for="chkMPRPresensiHarianLokasiKerja">Lokasi Kerja</label>
													</div>
													<div class="col-lg-3">
														<input type="checkbox" id="chkMPRPresensiHarianKodeInduk">&nbsp;
														<label for="chkMPRPresensiHarianKodeInduk">Kode Induk</label>
													</div>
													<div class="col-lg-3">
														<input type="checkbox" id="chkMPRPresensiHarianKodesie">&nbsp;
														<label for="chkMPRPresensiHarianKodesie">
															Kodesie
															<span style="color: red">*</span>
														</label>
													</div>
													<div class="col-lg-3">
														<input type="checkbox" id="chkMPRPresensiHarianPekerja">&nbsp;
														<label for="chkMPRPresensiHarianPekerja">
															Pekerja
															<span style="color: red">*</span>
														</label>
													</div>
												</div>
											</div>
											<div class="form-group" style="display: none;" id="divMPRPresensiHarianLokasiKerja">
												<label class="control-label col-lg-2">
													Lokasi Kerja
												</label>
												<div class="col-lg-4">
													<select class="select2" id="slcMPRPresensiHarianLokasiKerja" style="width: 100%" data-placeholder="Lokasi Kerja" multiple="multiple">
														<?php 
														if (isset($lokasi_kerja) && !empty($lokasi_kerja)) {
															foreach ($lokasi_kerja as $lk) {
																?>
																<option value="<?php echo $lk['kode_lokasi'] ?>">
																	<?php echo $lk['kode_lokasi'] ?>
																	 - 
																	<?php echo $lk['nama_lokasi'] ?>
																</option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group" style="display: none;" id="divMPRPresensiHarianKodeInduk">
												<label class="control-label col-lg-2">
													Kode Induk
												</label>
												<div class="col-lg-4">
													<select class="select2" id="slcMPRPresensiHarianKodeInduk" style="width: 100%" data-placeholder="Kode Induk" multiple="multiple">
														<?php 
														if (isset($kode_induk) && !empty($kode_induk)) {
															foreach ($kode_induk as $ki) {
																?>
																<option value="<?php echo $ki['noind'] ?>">
																	<?php echo $ki['noind'] ?>
																	 - 
																	<?php echo $ki['ket'] ?>
																</option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group" style="display: none;" id="divMPRPresensiHarianKodesie">
												<label class="control-label col-lg-2">
													Kodesie
												</label>
												<div class="col-lg-8">
													<table class="table table-bordered table-striped table-hover" id="tblMPRPresensiHarianKodesie">
														<thead>
															<tr>
																<th class="bg-primary text-center" style="width: 20%">Kodesie</th>
																<th class="bg-primary text-center" style="width: 20%">Dept</th>
																<th class="bg-primary text-center" style="width: 20%">Bidang</th>
																<th class="bg-primary text-center" style="width: 20%">Unit</th>
																<th class="bg-primary text-center" style="width: 20%">Seksi</th>
																<th class="bg-primary text-center" style="width: 20%">Pekerjaan</th>
															</tr>
														</thead>
														<tbody>
															
														</tbody>
													</table>
												</div>
												<div class="col-lg-2">
													<button type="button" class="btn btn-primary" id="btnMPRPresensiHarianAddKodesie">
														<span class="fa fa-plus"></span>
													</button>
												</div>
											</div>
											<div class="form-group" style="display: none;" id="divMPRPresensiHarianPekerja">
												<label class="control-label col-lg-2">
													Pekerja
												</label>
												<div class="col-lg-8">
													<table class="table table-bordered table-striped table-hover" id="tblMPRPresensiHarianPekerja">
														<thead>
															<tr>
																<th class="bg-primary text-center" style="width: 20%">No. Induk</th>
																<th class="bg-primary text-center" style="width: 60%">Nama</th>
															</tr>
														</thead>
														<tbody>
															
														</tbody>
													</table>
												</div>
												<div class="col-lg-2">
													<button type="button" class="btn btn-primary" id="btnMPRPresensiHarianAddPekerja">
														<span class="fa fa-plus"></span>
													</button>
												</div>
											</div>
											<div class="form-group text-center">
												<button type="button" class="btn btn-danger" id="btnMPRPresensiHarianPdf">PDF</button>
												<button type="button" class="btn btn-success" id="btnMPRPresensiHarianExcel">EXCEL</button>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12" style="color: red;">
										Note :<br>
										&nbsp;&nbsp;&nbsp;&nbsp;( * ) Hanya bisa menggunakan salah satu saja ( Pekerja / Kodesie ).
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
<div class="modal fade" id="mdlMPRPresensiHarianPekerja">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Pekerja</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped" id="tblMPRPresensiHarianModalPekerja" style="width: 100%">
								<thead>
									<tr>
										<th class="bg-warning text-center" style="width: 30%">No. Induk</th>
										<th class="bg-warning text-center" style="width: 50%">Pekerja</th>
										<th class="bg-warning text-center" style="width: 20%">Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2" class="text-center">
											<button type="button" class="btn btn-primary" id="btnMPRPresensiHarianModalAddPekerja">
												<span class="fa fa-plus"></span>
											</button>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<div class="modal fade" id="mdlMPRPresensiHarianKodesie">
	<div class="modal-dialog" style="width: 80%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Kodesie</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
						<h2>Unselected</h2>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="tblMPRPresensiHarianModalKodesie" style="width: 100%">
								<thead>
									<tr>
										<th class="bg-warning text-center">Action</th>
										<th class="bg-warning text-center">Kodesie</th>
										<th class="bg-warning text-center">Departemen</th>
										<th class="bg-warning text-center">Bidang</th>
										<th class="bg-warning text-center">Unit</th>
										<th class="bg-warning text-center">Seksi</th>
										<th class="bg-warning text-center">Pekerjaan</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
					<div class="col-lg-6">
						<h2>Selected</h2>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="tblMPRPresensiHarianModalKodesieSelected" style="width: 100%">
								<thead>
									<tr>
										<th class="bg-success text-center">Action</th>
										<th class="bg-success text-center">Kodesie</th>
										<th class="bg-success text-center">Departemen</th>
										<th class="bg-success text-center">Bidang</th>
										<th class="bg-success text-center">Unit</th>
										<th class="bg-success text-center">Seksi</th>
										<th class="bg-success text-center">Pekerjaan</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

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
<div class="loading" id="ldgMPRCetakPresensiHarianLoading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>