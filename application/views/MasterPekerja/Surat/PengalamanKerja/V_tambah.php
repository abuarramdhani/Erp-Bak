<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<br><h1><?=$Title ?></h1></div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/Simpan') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slcMPSuratPengalamanKerjaPekerja" data-placeholder="Pekerja" name="slcMPSuratPengalamanKerjaPekerja" id="slcMPSuratPengalamanKerjaPekerja" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaSeksi" id="txtMPSuratPengalamanKerjaSeksi" class="form-control " placeholder="Seksi"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Bidang</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaBidang" id="txtMPSuratPengalamanKerjaBidang" class="form-control " placeholder="Bidang"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Unit</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaUnit" id="txtMPSuratPengalamanKerjaUnit" class="form-control " placeholder="Unit"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Departemen</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaDept" id="txtMPSuratPengalamanKerjaDept" class="form-control " placeholder="Departemen"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Masuk</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaMasuk" id="txtMPSuratPengalamanKerjaMasuk" class="form-control " placeholder="Masuk Kerja"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Sampai</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaSampai" id="txtMPSuratPengalamanKerjaSampai" class="form-control " placeholder="Sampai"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Alamat</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaAlamat" id="txtMPSuratPengalamanKerjaAlamat" class="form-control " placeholder="Alamat"   required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Desa</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaDesa" id="txtMPSuratPengalamanKerjaDesa" class="form-control " placeholder="Desa"  readonly required>
												</div>
											</div>
                                            <div class="form-group">
												<label class="control-label col-lg-4">Kabupaten</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaKab" id="txtMPSuratPengalamanKerjaKab" class="form-control " placeholder="Kabupaten" readonly   required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kecamatan</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaKec" id="txtMPSuratPengalamanKerjaKec" class="form-control " placeholder="Kecamatan"  readonly  required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">NIK</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaNIK" id="txtMPSuratPengalamanKerjaNIK" class="form-control " placeholder="NIK"  readonly  required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Template Isi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaTemplate" id="" class="form-control " placeholder="" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanda Tangan</label>
												<div class="col-lg-4">
													<select class="slcMPSuratPengalamanKerjaPekerja" data-placeholder="Tanda Tangan" name="slcMPSuratPengalamanKerjaPekerja" id="slcMPSuratPengalamanKerjaPekerja" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary" id="btnMPSuratPengalamanKerjaSubmit" type="submit" disabled><span class="fa fa-save"></span>&nbsp;Simpan</button>
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