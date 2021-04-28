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
														<label for="chkMPRPresensiHarianKodesie">Kodesie</label>
													</div>
													<div class="col-lg-3">
														<input type="checkbox" id="chkMPRPresensiHarianPekerja">&nbsp;
														<label for="chkMPRPresensiHarianPekerja">Pekerja</label>
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
													<table class="table table-bordered table-striped table-hover">
														<thead>
															<tr>
																<th class="bg-primary text-center" style="width: 20%">Kodesie</th>
																<th class="bg-primary text-center" style="width: 70%">Ket</th>
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
													<table class="table table-bordered table-striped table-hover">
														<thead>
															<tr>
																<th class="bg-primary text-center" style="width: 20%">No. Induk</th>
																<th class="bg-primary text-center" style="width: 60%">Nama</th>
																<th class="bg-primary text-center" style="width: 20%">Status</th>
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
												<button type="button" class="btn btn-warning" id="btnMPRPresensiHarianReset">RESET</button>
												<button type="button" class="btn btn-primary" id="btnMPRPresensiHarianShow">SHOW</button>
												<button type="button" class="btn btn-danger" id="btnMPRPresensiHarianPdf">PDF</button>
												<button type="button" class="btn btn-success" id="btnMPRPresensiHarianExcel">EXCEL</button>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered table-hover table-striped">
											<thead>
												<tr>
													<th class="bg-primary">No</th>
													<th class="bg-primary">Nama</th>
													<th class="bg-primary">Tanggal</th>
													<th class="bg-primary">Absen</th>
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
<div class="modal fade" id="mdlMPRPresensiHarian">
	<div class="modal-dialog">
		<div class="modal-content" id="divMPRPresensiHarianKodesieModal">
			<div class="modal-header">
				<h4 class="modal-title">Add Pekerja</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<form class="form-horizontal">
							<div class="col-lg-6">
								<select class="select2">
									<option>No. Induk</option>
									<option>No. Induk</option>
								</select>
							</div>
							<div class="col-lg-6"></div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>