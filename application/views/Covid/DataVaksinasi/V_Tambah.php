<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<b><h1><?=$Title ?></h1></b>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" id="frm-CVD-DataVaksinasi-Tambah">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select id="slc-CVD-DataVaksinasi-Pekerja" name="slc-CVD-DataVaksinasi-Pekerja" style="width: 100%;"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Peserta Vaksin</label>
												<div class="col-lg-4">
													<select id="slc-CVD-DataVaksinasi-Peserta" style="width: 100%;" disabled></select>
													<input type="hidden" name="txt-CVD-DataVaksinasi-Peserta-NIK">
													<input type="hidden" name="txt-CVD-DataVaksinasi-Peserta-Nama">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kelompok Vaksin</label>
												<div class="col-lg-4">
													<select id="slc-CVD-DataVaksinasi-Kelompok" name="slc-CVD-DataVaksinasi-Kelompok" style="width: 100%;" disabled>
														<option></option>
														<?php 
														if (isset($kelompok) && !empty($kelompok)) {
															foreach ($kelompok as $k) {
																?>
																	<option 
																		value="<?=$k['kelompok_vaksin'] ?>"
																		data-id="<?=$k['id'] ?>"
																	>
																		<?=$k['kelompok_vaksin'] ?>
																	</option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Vaksin</label>
												<div class="col-lg-2">
													<input type="text" id="txt-CVD-DataVaksinasi-Tanggal" class="form-control" placeholder="Tanggal Vaksin" disabled>
													<input type="hidden" name="txt-CVD-DataVaksinasi-Tanggal">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis Vaksin</label>
												<div class="col-lg-4">
													<select id="slc-CVD-DataVaksinasi-Jenis" style="width: 100%;" disabled>
														<option></option>
														<?php 
														if (isset($jenis) && !empty($jenis)) {
															foreach ($jenis as $j) {
																?>
																	<option 
																		value="<?=$j['nama_vaksin'] ?>"
																	>
																		<?=$j['nama_vaksin'] ?>
																	</option>
																<?php
															}
														}
														?>
													</select>
													<input type="hidden" name="txt-CVD-DataVaksinasi-Jenis">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Lokasi Vaksin</label>
												<div class="col-lg-4">
													<textarea id="txa-CVD-DataVaksinasi-Lokasi" class="form-control" placeholder="Lokasi Vaksin" disabled></textarea>
													<input type="hidden" name="txt-CVD-DataVaksinasi-Lokasi">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Vaksin Ke</label>
												<div class="col-lg-1">
													<select id="slc-CVD-DataVaksinasi-Ke" name="slc-CVD-DataVaksinasi-Ke" style="width: 100%;" disabled>
														<option></option>
														<?php 
														for ($i=1; $i <= 5; $i++) { 
															?>
															<option><?=$i ?></option>
															<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Foto Kartu Vaksin</label>
												<div class="col-lg-4">
													<img src="<?=base_url('assets/img/TimCovid/kartu_vaksin.svg') ?>" style="width: 100%;">
													<input type="file" name="fl-CVD-DataVaksinasi-Kartu" id="fl-CVD-DataVaksinasi-Kartu" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Foto Sertifikat Vaksin</label>
												<div class="col-lg-4">
													<img src="<?=base_url('assets/img/TimCovid/sertifikat_vaksin.svg') ?>" style="width: 100%;">
													<input type="file" name="fl-CVD-DataVaksinasi-Sertifikat" id="fl-CVD-DataVaksinasi-Sertifikat" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center" id="div-CVD-DataVaksinasi-Warning" style="color: red;">
													
												</div>
											</div>
											<hr>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<button type="button" class="btn btn-primary" id="btn-CVD-DataVaksinasi-Simpan" disabled>
														<span class="fa fa-save"></span> Simpan
													</button>
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