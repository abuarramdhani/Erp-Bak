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
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Simpan') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Kepada</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerja" data-placeholder="Ditujukan Kepada" name="slcMPSuratIsolasiMandiriTo" id="slcMPSuratIsolasiMandiriTo" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerja" data-placeholder="Pekerja" name="slcMPSuratIsolasiMandiriPekerja" id="slcMPSuratIsolasiMandiriPekerja" style="width: 100%" required></select>
												</div>
											</div>
											<input type="hidden" name="txtMPSuratIsolasiMandiriSurat" id="txtMPSuratIsolasiMandiriSurat">
											<div class="form-group">
												<label class="control-label col-lg-4">Wawancara</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriWawancaraTanggal" id="txtMPSuratIsolasiMandiriWawancaraTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" placeholder="Tanggal Wawancara" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Mulai Isolasi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriMulaiIsolasiTanggal" id="txtMPSuratIsolasiMandiriMulaiIsolasiTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" placeholder="Tanggal Mulai Isolasi Mandiri" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Selesai Isolasi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal" id="txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" placeholder="Tanggal Selesai Isolasi Mandiri" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jumlah Hari</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriJumlahHari" id="txtMPSuratIsolasiMandiriJumlahHari" class="form-control" placeholder="Jumlah Hari" readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Status</label>
												<div class="col-lg-4">
													<select class="select2" data-placeholder="Status Isolasi Mandiri" name="slcMPSuratIsolasiMandiriStatus" id="slcMPSuratIsolasiMandiriStatus" style="width: 100%" required>
														<option>PRM</option>
														<option>PSK</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Cetak</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriCetakTanggal" id="txtMPSuratIsolasiMandiriCetakTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" placeholder="Tanggal Cetak Surat" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Dibuat Oleh</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerja" data-placeholder="Dibuat Oleh" name="slcMPSuratIsolasiMandiriDibuat" id="slcMPSuratIsolasiMandiriDibuat" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Menyetujui</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerja" data-placeholder="Menyetujui" name="slcMPSuratIsolasiMandirimenyetujui" id="slcMPSuratIsolasiMandirimenyetujui" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Mengetahui</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerja" data-placeholder="Mengetahui" name="slcMPSuratIsolasiMandiriMengetahui" id="slcMPSuratIsolasiMandiriMengetahui" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary" id="btnMPSuratIsolasiMandiriPreview" type="button" disabled><span class="fa fa-print"></span>&nbsp;Preview</button>
												</div>
											</div>
											<div class="form-group">
                                                <label class="col-lg-2 control-label">Format Surat</label>
                                                <div class="col-lg-8">
                                                    <textarea name="txaMPSuratIsolasiMandiriRedactor" class="form-control" id="txaMPSuratIsolasiMandiriRedactor" disabled required></textarea>
                                                </div>
                                            </div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary" id="btnMPSuratIsolasiMandiriSubmit" type="submit" disabled><span class="fa fa-save"></span>&nbsp;Simpan</button>
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