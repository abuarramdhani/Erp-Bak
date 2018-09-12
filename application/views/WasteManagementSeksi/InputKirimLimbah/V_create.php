<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php site_url('WasteManagementSeksi/InputKirimLimbah/Insert')?>">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<h1 class="text-right"><b><?=$Title ?></b></h1>
							</div>
							<div class="col-lg-1">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a href="<?php echo site_url('WasteManagementSeksi/InputKirimLimbah') ?>" class="btn btn-default btn-lg">
										<span class="fa fa-wrench fa-2x"></span>
									</a>								
								</div>

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-header">
									
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="row">
											<div class="form-group">
												<label for="txtTanggalKirimLimbah" class="control-label col-lg-4">Tanggal Kirim</label>
												<div class="col-lg-4">
													<div class="col-lg-6">
														<input type="text" name="txtTanggalKirimLimbah" id="txtTanggalKirimLimbah" class="date form-control" placeholder="<?php echo date('d M Y')?>" data-date-format="yyyy-mm-dd" required>
													</div>
													<div class="col-lg-6">
														<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
															<input type="text" name="txtWaktuKirimLimbah" id="txtWaktuKirimLimbah" class="form-control" required>
															<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtJenisLimbah" class="control-label col-lg-4">Jenis Limbah</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<select class="select select2" name="txtJenisLimbah" id="txtJenisLimbah" data-placeholder="Jenis Limbah" style="width:100%;" required>
															<option value=""></option>
															<?php 
																foreach ($JenisLimbah as $key) {
																	echo "<option value='".$key['id_jenis_limbah']."' data-satuan='".$key['satuan']."'>".$key['kode_limbah']."-".$key['jenis_limbah']."</option>";
																}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtSeksi" class="control-label col-lg-4">Seksi Pengirim</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<select class="select select2" name="txtSeksi" id="txtSeksi" data-placeholder="Seksi Pengirim" style="width:100%;" required>
															<option value=""></option>
															<?php 
																foreach ($Seksi as $key) {
																	echo "<option value='".$key['section_code']."'>".$key['section_code']."-".$key['section_name']."</option>";
																}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtKondisi" class="control-label col-lg-4">Kondisi</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<select class="select select2" name="txtKondisi" id="txtKondisi" data-placeholder="Bocor/Tidak" style="width:100%;">
															<option></option>
															<option value="1">Bocor</option>
															<option value="0">Tidak Bocor</option>
														</select>	
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtJumlah" class="control-label col-lg-4">Jumlah</label>
												<div class="col-lg-4">
													<div class=" col-lg-7">
														<input type="text" class="form-control" name="txtJumlah" id="txtJumlah" placeholder="Jumlah" required>
													</div>
													<div class="col-lg-5">
														<input type="text" class="form-control" name="txtSatuan" id="txtSatuan" placeholder="Satuan" disabled="">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<textarea name="txtKeterangan" id="txtKeterangan" placeholder="Keterangan" style="width:100%;height:100px;"></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<a href="javascript:history.back(1);" class="btn btn-primary">Back</a>
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div>
								<div class="box-footer">
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>