<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('SiteManagement') ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/InputAsset/InputData') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">No PP</label>
												<div class="col-lg-4">
													<input type="text" placeholder="No PP" class="form-control" name="txtNomorPP" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal PP</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Tanggal PP" class="date form-control" name="txtTanggalPP" id="txtTanggalPPAsset" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">No PPA</label>
												<div class="col-lg-4">
													<input type="text" placeholder="No PPA" class="form-control" name="txtNomorPPA" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kategori Asset</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtKategoriAsset" data-placeholder="Kategori Asset" required style="width: 100%">
														<option></option>
														<?php if (isset($kategori)) {
															foreach ($kategori as $val) { ?>
																<option value="<?php echo $val['id_kat'] ?>"><?php echo $val['kategori'] ?></option>
														<?php	}
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis Asset</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtJenisAsset" data-placeholder="Jenis Asset" required style="width: 100%">
														<option></option>
														<?php if (isset($jenis)) {
															foreach ($jenis as $val) { ?>
																<option value="<?php echo $val['id_jenis'] ?>"><?php echo $val['jenis_asset'] ?></option>
														<?php	}
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Perolehan Asset</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtPerolehanAsset" data-placeholder="Perolehan Asset" required style="width: 100%">
														<option></option>
														<?php if (isset($perolehan)) {
															foreach ($perolehan as $val) { ?>
																<option value="<?php echo $val['id_perolehan'] ?>"><?php echo $val['perolehan'] ?></option>
														<?php	}
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi Pemakai</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtSeksiPemakaiAsset" id="txtSeksiPemakaiAsset" data-placeholder="Seksi Pemakai" required style="width: 100%">
														<option value="<?php echo $seksi['0']['kodesie'] ?>"><?php echo $seksi['0']['seksi'] ?></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Requester</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtRequesterAsset" id="txtRequesterAsset" data-placeholder="Requester" required style="width: 100%">
														<option></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<a href="javascript:history.back(1);" class="btn btn-danger">Cancel</a>
													<button type="submit" class="btn btn-success">Input Barang</button>
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