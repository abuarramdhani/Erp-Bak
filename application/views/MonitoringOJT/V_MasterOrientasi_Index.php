<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/MasterOrientasi');?>">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-success box-solid">
							<form method="post" action="<?php echo base_url('OnJobTraining/MasterOrientasi/OrientasiBaru/Save');?>" enctype="multipart/form-data">
								<div class="box-header with-border">
									Pembuatan Orientasi Baru
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="row">
											
													<div class="form-group">
														<label for="numPeriodeBulan" class="control-label col-lg-4">Periode Bulan</label>
														<div class="col-lg-8">
															<input type="number" class="form-control" name="numPeriodeBulan" min="1" max="12" value="1" />
														</div>
													</div>

													<div class="form-group">
														<label for="numSequence" class="control-label col-lg-4">Sequence</label>
														<div class="col-lg-8">
															<input type="number" class="form-control" name="numSequence" min="1" max="99" value="1" />
														</div>
													</div>

													<div class="form-group">
														<label for="txtTahapan" class="control-label col-lg-4">Tahapan</label>
														<div class="col-lg-8">
															<input type="text" class="form-control" style="text-transform: uppercase;" name="txtTahapan" />
														</div>
													</div>

													<div class="form-group">
														<label for="radioTanggalOtomatis" class="control-label col-lg-4">Tanggal Otomatis</label>
														<div class="col-lg-2">
															<input type="radio" name="radioTanggalOtomatis" value="1">Ya</input>
														</div>
														<div class="col-lg-2">
															<input type="radio" name="radioTanggalOtomatis" value="0">Tidak</input>
														</div>
													</div>

													<div class="form-group">
														<label for="numLamaPelaksanaan" class="control-label col-lg-4">Pelaksanaan</label>
														<div class="col-lg-4">
															<input type="number" class="form-control" name="numLamaPelaksanaan" min="1" max="99" value="1" />
														</div>
													</div>

													<div class="form-group">
														<label for="radioCekEvaluasi" class="control-label col-lg-4">Cek Evaluasi</label>
														<div class="col-lg-4">
															<input type="radio" name="radioCekEvaluasi" value="1">Ya</input>
														</div>
														<div class="col-lg-4">
															<input type="radio" name="radioCekEvaluasi" value="0">Tidak</input>
														</div>
													</div>
											<div class="col-lg-6">
												<div class="row">
													<div class="form-group">
														<label for="radioPemberitahuan" class="control-label col-lg-4">Pemberitahuan</label>
														<div class="col-lg-4">
															<input type="radio" name="radioPemberitahuan" value="1">Ya</input>
														</div>
														<div class="col-lg-4">
															<input type="radio" name="radioPemberitahuan" value="0">Tidak</input>
														</div>
													</div>

													<div class="form-group">
														<label for="radioCetak" class="control-label col-lg-4">Cetak</label>
														<div class="col-lg-4">
															<input type="radio" name="radioCetak" value="1">Ya</input>
														</div>
														<div class="col-lg-4">
															<input type="radio" name="radioCetak" value="0">Tidak</input>
														</div>
													</div>

													<div class="form-group">
														<label for="cmbFormatCetak" class="control-label col-lg-4">Format Cetak</label>
														<div class="col-lg-8">
															<select class="select2" name="cmbFormatCetak">
																<option value=""></option>
															</select>
														</div>
													</div>

													<div class="form-group">
														<label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
														<div class="col-lg-8">
															<textarea name="txtKeterangan">
																
															</textarea>
														</div>
													</div>													
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
											<button type="reset" class="btn btn-warning btn-lg btn-rect">Reset Data</button>
											<button type="submit" class="btn btn-success btn-lg btn-rect">Simpan Data</button>
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