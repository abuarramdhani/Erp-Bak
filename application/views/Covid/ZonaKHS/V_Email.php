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
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-2">Area Isolasi</label>
												<div class="col-lg-8">
													<table class="table table-striped table-bordered table-hover" id="tbl-CVD-ZonaKHS-Email-Area">
														<thead style="background-color: #6c5ce7;color: white;">
															<tr>
																<th style="text-align: center;width: 20%">Area</th>
																<th style="text-align: center;width: 45%">Kasus</th>
																<th style="text-align: center;width: 30%">Periode Isolasi</th>
																<th style="text-align: center;width: 5%">Action</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>
																	<select class="slc-CVD-ZonaKHS-Email-Area" style="width: 100%;"></select>
																</td>
																<td>
																	<input type="text" class="form-control txt-CVD-ZonaKHS-Email-Kasus" disabled>
																</td>
																<td>
																	<input type="text" class="form-control txt-CVD-ZonaKHS-Email-Isolasi" disabled>
																</td>
																<td>
																	<button type="button" class="btn btn-danger btn-sm btn-CVD-ZonaKHS-Email-Area-Delete" title="Hapus"><span class="fa fa-trash"></span></button>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-lg-2">
													<button type="button" class="btn btn-primary" title="Tambah baris" id="btn-CVD-ZonaKHS-Email-Area-Add"><span class="fa fa-plus"></span></button>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<button type="button" class="btn btn-primary" id="btn-CVD-ZonaKHS-EMail-Preview">Preview</button>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 col-lg-offset-2">
													<textarea id="txa-CVD-ZonaKHS-Email-Preview"></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Penerima Email</label>
												<div class="col-lg-8">
													<table class="table table-striped table-bordered table-hover" id="tbl-CVD-ZonaKHS-Email-Penerima">
														<thead style="background-color: #fdcb6e;color: white;">
															<tr>
																<th style="text-align: center;width: 50%">Email</th>
																<th style="text-align: center;width: 45%">Nama</th>
																<th style="text-align: center;width: 5%">Action</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>
																	<input type="text" class="form-control txt-CVD-ZonaKHS-Email-Alamat">
																</td>
																<td>
																	<input type="text" class="form-control txt-CVD-ZonaKHS-Email-Nama">
																</td>
																<td>
																	<button type="button" class="btn btn-danger btn-sm btn-CVD-ZonaKHS-Penerima-Delete" title="Hapus"><span class="fa fa-trash"></span></button>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-lg-2">
													<button type="button" class="btn btn-primary" title="Tambah baris" id="btn-CVD-ZonaKHS-Email-Penerima-Add"><span class="fa fa-plus"></span></button>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<button type="button" class="btn btn-success" disabled id="btn-CVD-ZonaKHS-Email-Kirim">Kirim</button>
												</div>
											</div>
										</form>
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
    z-index: 9999;
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
<div class="loading" id="ldg-CVD-ZonaKHS-Email" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>