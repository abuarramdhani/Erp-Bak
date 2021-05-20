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
									<div class="col-lg-12 text-right">
										<button type="button" class="btn btn-primary" id="btnMPKSebabKeluarAdd">
											<span class="fa fa-plus"></span>
										</button>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover" style="width: 100%" id="tblMPKSebabKeluarList">
											<thead class="bg-primary">
												<tr>
													<th style="width: 5%">No.</th>
													<th style="width: 10%">Action</th>
													<th style="width: 10%">Kode</th>
													<th style="width: 30%">Sebab Keluar</th>
													<th style="width: 20%">Dasar Hukum</th>
													<th style="width: 10%">Pengali U. Pesangon</th>
													<th style="width: 10%">Pengali U. PMK</th>
													<th style="width: 5%">Urutan</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td>
																<button 
																	type="button" 
																	data-id="<?php echo str_replace(['+','/','='], ['-','_','~'], base64_encode($dt['id'])) ?>" 
																	class="btn btn-primary btnMPKSebabKeluarEdit"
																	>
																	<span class="fa fa-edit"></span>
																</button>
															</td>
															<td><?php echo $dt['kode'] ?></td>
															<td><?php echo $dt['sebab_keluar'] ?></td>
															<td><?php echo $dt['dasar_hukum'] ?></td>
															<td><?php echo $dt['pengali_u_pesangon'] ?></td>
															<td><?php echo $dt['pengali_u_pmk'] ?></td>
															<td><?php echo $dt['urutan'] ?></td>
														</tr>
														<?php 
														$nomor++;
													}
												}
												?>
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
<div class="modal fade" tabindex="-1" role="dialog" id="mdlMPKSebabKeluar">
	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Sebab Keluar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-4">Kode</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="txtMPKSebabKeluarKode" autocomplete="off">
								</div>
								<div class="col-sm-4" id="divMPKSebabKeluarKodeKet" style="color: red;font-style: italic;">
									Kode masih digunakan (<b></b>).
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Sebab Keluar</label>
								<div class="col-sm-8">
									<textarea class="form-control" id="txtMPKSebabKeluaSebabKeluar" autocomplete="off"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Dasar Hukum</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="txtMPKSebabKeluarDasarhukum" autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pengali U. Pesangon</label>
								<div class="col-sm-2">
									<input type="number" class="form-control" id="txtMPKSebabKeluarUpesangon" autocomplete="off" min="0">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pengali U. PMK</label>
								<div class="col-sm-2">
									<input type="number" class="form-control" id="txtMPKSebabKeluarUmpk" autocomplete="off" min="0">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Urutan</label>
								<div class="col-sm-2">
									<input type="number" class="form-control" id="txtMPKSebabKeluarUrutan" autocomplete="off" min="1">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-sm-12 text-center">
						<input type="hidden" id="txtMPKSebabKeluarID">
						<button type="button" class="btn btn-primary" id="btnMPKSebabKeluarSimpan">
							<span class="fa fa-save"></span>
							&nbsp;Simpan
						</button>
					</div>
				</div>
			</div>
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
<div class="loading" id="ldgMPKSebabKeluarLoading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>