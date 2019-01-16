<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="javascript:history.back(1)" class="btn btn-default btn-lg "><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class=" row">
									<div class="col-l-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/PembelianAsset/InputTag') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">No BPPBA</label>
												<div class="col-lg-4">
													<input type="text" name="txtNoBPPBA" placeholder="No BPPBA" class="form-control" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">No PP</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtNoPPAsset" id="txtNoPPAsset" style="width: 100%" data-palceholder="No PP" required>
														<option></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Pembelian</label>
												<div class="col-lg-4">
													<input type="text" name="txtTanggalPembelian" id="txtTanggalPembelian" placeholder="Tanggal Pembelian" class="date form-control" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Nama Barang</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtNamaBarang" data-placeholder="Nama Barang" id="txtNamaBarang" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kode Barang</label>
												<div class="col-lg-4">
													<input type="text" id="txtKodeBarang" placeholder="Kode Barang" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jumlah Kebutuhan</label>
												<div class="col-lg-4">
													<input type="text" id="txtJumlahKebutuhan" placeholder="Jumlah Kebutuhan" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi Pemakai</label>
												<div class="col-lg-4">
													<input type="text" id="txtSeksiPemakai" placeholder="Seksi Pemakai" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Cost Center</label>
												<div class="col-lg-4">
													<select class="select select2" data-placeholder="Cost Center" name="txtCostCenter" id="txtCostCenter" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jumlah Diterima</label>
												<div class="col-lg-4">
													<input type="number" name="txtJumlahDiterima" placeholder="Jumlah Diterima" class="form-control" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button class="btn btn-primary">Input Tag Number</button>
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