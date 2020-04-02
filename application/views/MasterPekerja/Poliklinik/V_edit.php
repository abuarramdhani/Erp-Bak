<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
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
										<form class="form-horizontal" method="POST" action="<?php echo base_url('MasterPekerja/Poliklinik/UpdateData/'.$enkripsi) ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Kunjungan</label>
												<div class="col-lg-4">
													<input type="text" name="txtPoliklinikTanggal" id="txtPoliklinikTanggal" class="form-control" value="<?php echo $data->waktu_kunjungan ?>" placeholder="Pilih Tanggal" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select style="width: 100%" class="form-control" name="slcPoliklinikPekerja" id="slcPoliklinikPekerja" required>
														<option value="<?php echo $data->noind ?>"><?php echo $data->noind.' - '.$data->employee_name ?></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Keterangan</label>
												<div class="col-lg-4">
													<select style="width: 100%" class="form-control" name="slcPoliklinikKeterangan[]" id="slcPoliklinikKeterangan" multiple required>
														<?php 
														$keterangan = explode(', ', $data->keterangan);
														foreach ($keterangan as $ket) {
															?>
															<option value="<?php echo $ket ?>" selected><?php echo $ket ?></option>
															<?php
														}
														?>
													</select>
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