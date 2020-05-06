<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?php echo $Title  ?></h1>
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
										<form class="form-horizontal" method="POST" action="<?php echo base_url('AbsenPekerjaLaju/PekerjaLaju/update') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">No. Induk</label>
												<div class="col-lg-4">
													<select class="slcNoindPekerjalaju" name="slcNoindPekerjalaju" id="slcNoindPekerjalaju" style="width: 100%" required>	
														<option selected value="<?php echo $data->noind ?>"><?php echo $data->noind.' - '.$data->nama ?></option>
													</select>
													<input type="hidden" name="txtNamaPekerjalaju" id="txtNamaPekerjalaju" value="<?php echo $data->nama ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Alamat</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtAlamatPekerjalaju" id="txtAlamatPekerjalaju" placeholder="Alamat Pekerja" value="<?php echo $data->alamat ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Desa</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtDesaPekerjalaju" id="txtDesaPekerjalaju" placeholder="Desa Pekerja" value="<?php echo $data->desa ?>" required>	
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kecamatan</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtKecamatanPekerjalaju" id="txtKecamatanPekerjalaju" value="<?php echo $data->kecamatan ?>" placeholder="Kecamatan Pekerja" required>	
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kabupaten</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtKabupatenPekerjalaju" id="txtKabupatenPekerjalaju" value="<?php echo $data->kabupaten ?>" placeholder="Kabupaten Pekerja" required>	
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Provinsi</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtProvinsiPekerjalaju" id="txtProvinsiPekerjalaju" value="<?php echo $data->provinsi ?>" placeholder="Provinsi Pekerja" required>	
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis Transportasi</label>
												<div class="col-lg-4">
													<select class="select2" name="slcjenisTransportasiPekerjalaju[]" data-placeholder="Jenis Transportasi Pekerja" multiple="multiple" id="slcjenisTransportasiPekerjalaju" style="width: 100%" required>	
														<option></option>
														<?php 
														if (isset($transportasi) && !empty($transportasi)) {
															foreach ($transportasi as $ts) {
																$status_pilih = "";
																foreach (explode(",", $data->jenis_transportasi) as $dt) {
																	if ($ts['id_transportasi'] == $dt) {
																		$status_pilih = "selected";
																	}
																}
																?>
																<option value="<?php echo $ts['id_transportasi'] ?>" <?php echo $status_pilih ?>><?php echo $ts['jenis_transportasi'] ?></option>
																<?php 
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Mulai Laju</label>
												<div class="col-lg-4">
													<input class="form-control" name="txtMulaiLajuPekerjalaju" id="txtMulaiLajuPekerjalaju" value="<?php echo $data->mulai_laju ?>" placeholder="Pekerja Mulai Laju" value="<?php echo date('Y-m-d') ?>" required>	
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Status</label>
												<div class="col-lg-2">
													<input type="radio" class="form-control" name="radStatusPekerjaLaju" id="radStatusPekerjaLaju" value="1" <?php echo $data->status_active == 't' ? 'checked' : '' ?> required> Aktif
												</div>
												<div class="col-lg-2">
													<input type="radio" class="form-control" name="radStatusPekerjaLaju" id="radStatusPekerjaLaju" value="0" <?php echo $data->status_active == 'f' ? 'checked' : '' ?> required> Non Aktif
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Latitude</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtLatitudePekerjaLaju" id="txtLatitudePekerjaLaju" value="<?php echo $data->latitude ?>" placeholder="Koordinat Latitude Rumah Pekerja" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Longitude</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtLongitudePekerjaLaju" id="txtLongitudePekerjaLaju" value="<?php echo $data->longitude ?>" placeholder="Koordinat Longitude Pekerja" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button type="submit" class="btn btn-primary">Simpan</button>
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