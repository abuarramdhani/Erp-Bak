<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1 text-right">
							<a href="<?php echo site_url('WasteManagement/Simple/Read/'.$SimpleId) ?>" class="btn btn-default btn-lg">
								<span class="fa fa-wrench fa-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							
						</div>
						<div class="box-body">
							<form method="POST" action="<?php echo site_url('WasteManagement/Simple/Add_Detail/'.$SimpleId); ?>" class="form-horizontal">
								<div class="panel-body">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="control-label col-lg-4">Jenis Limbah</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="txtJenislimbah" value="<?php echo $LimbahJenis['0']['jenis_limbah']; ?>" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Kode Limbah</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="txtKodeLimbah" value="<?php echo $LimbahJenis['0']['kode_limbah']; ?>" disabled>
												<input type="hidden" name="txtJenisId" value="<?php echo $LimbahJenis['0']['id_jenis_limbah']; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Masa Simpan</label>
											<div class="col-lg-4">
												<div class="input-group">
													<input type="text" class="form-control" name="txtJumlah" value="90" disabled>
													<span class="input-group-addon">Hari</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">TPS</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="txtTPS" value="TPS Internal" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Sumber Limbah</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="txtSumberLimbah" value="Internal" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Tanggal Dihasilkan</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="txtTanggalDihasilkan" id="txtTanggalDihasilkan" class="date form-control" placeholder="<?php echo date('d M Y')?>" data-date-format="yyyy-mm-dd" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Kode Manifest</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="txtManifest" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Nama Pengirim</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="txtPengirim" value="CV. KARYA HIDUP SENTOSA" disabled>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Jumlah</label>
											<div class="col-lg-4">
												<div class="input-group">
													<input type="text" class="form-control" name="txtJumlah" required>
													<span class="input-group-addon">Ton</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Catatan</label>
											<div class="col-lg-4">
												<textarea class="form-control" name="txtCatatan" style="width:100%;"></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="col-lg-8 text-right">
												<button type="submit" class="btn btn-primary">Simpan</button>
												<a href="javascript:history.back(1);" class="btn btn-danger">Cancel</a>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>