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
								<a href="<?php echo site_url('SiteManagement/RetirementAsset') ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/RetirementAsset/SaveRetirement') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Tag Number</label>
												<div class="col-lg-4">
													<select class="tagRetirement" name="txtTagNum" style="width: 100%" required></select>
												</div>
												<input type="hidden" name="txtTagNumberRetirementAsset">
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">No Retirement Asset</label>
												<div class="col-lg-4">
													<input type="text" placeholder="No Retirement Asset" class="form-control" name="txtNoRetirementAsset" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Nama barang</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Nama Barang" name="txtNamaBarangRetirementAsset" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Merk</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="merk" name="txtMerkBarangRetirementAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Model</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Model" name="txtModelBarangRetirementAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Negara Pembuat</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Negara Pembuat" class="form-control" name="txtNegaraPembuatbarangRetirementAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Serial Numb./No Mesin</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Serial Number / Nomor Mesin" class="form-control" name="txtSerialNumberBarangRetirementAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Seksi" name="txtSeksiRetirementAsset" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kota</label>
												<div class="col-lg-4">
													<select class="kotaRetirementAsset" name="txtKota" style="width: 100%"></select>
													<input type="hidden" class="form-control" placeholder="Seksi" name="txtKotaRetirementAsset" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Gedung</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Gedung" name="txtGedungRetirementAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Lantai</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Lantai" name="txtLantaiRetirementAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Ruang</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Ruang" name="txtRuangRetirementAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Rencana Penghentian</label>
												<div class="col-lg-4">
													<div class="col-lg-6">
														<input type="radio" value="Sementara" name="txtRencanaRetirementAsset"> Sementara
													</div>
													<div class="col-lg-6">
														<input type="radio" value="Permanent" name="txtRencanaRetirementAsset"> Permanent
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Usulan Seksi</label>
												<div class="col-lg-4">
													<select class="select select2" data-placeholder="Usulan Seksi" name="txtUsulanSeksiRetirementAsset" id="txtUsulanSeksiRetirementAsset" style="width: 100%">
														<option></option>
														<?php
															foreach ($usulan as $key) { ?>
																<option><?php echo $key['usulan'] ?></option>
														<?php	}
														 ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4"></label>
												<div class="col-lg-4">
													<input type="text" placeholder="Keterangan" class="form-control" name="txtUsulanLainnyaRetirementAsset" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Alasan Penghentian</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Alasan Penghentian" class="form-control" name="txtAlasanRetirementAsset">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<a href="javascript:history.back(1)" class="btn btn-danger">Batal</a>
													<button class="btn btn-success">Simpan</button>
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