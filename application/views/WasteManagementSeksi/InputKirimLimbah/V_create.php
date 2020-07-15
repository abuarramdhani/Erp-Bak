<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="POST" action="">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<h1 class="text-right"><b><?= $Title ?></b></h1>
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
														<input type="text" name="txtTanggalKirimLimbah" id="txtTanggalKirimLimbah" class="date form-control" value="<?php echo date('Y M d')?>" data-date-format="yyyy-mm-dd" required>
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
																$user = $this->session->user;
																if ($user !== 'B0791') {
																	foreach ($JenisLimbah as $key) {
																		$a = $key['id_jenis_limbah'];
																		$b = $key['jenis_limbah'];
																		$c = $key['kode_limbah'];
																		$d = $key['satuan'];
																		if ($a !== '26' and $a !== '27' and $a !== '28' and $a !== '30' and $a !== '37' and $a !== '43' and $a !== '47') {
																			echo "<option value='$a' data-satuan= '$d'>$c - $b</option>";
																		}
																	}
																}else{
																	foreach ($JenisLimbah as $key) {
																		echo "<option value='".$key['id_jenis_limbah']."' data-satuan='".$key['satuan']."'>".$key['kode_limbah']." - ".$key['jenis_limbah']."</option>";
																	}
																}

															?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtLokasi" class="control-label col-lg-4">Lokasi Kerja</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<select class="select select2" id="txtLokasi" name="txtLokasi" data-placeholder="Lokasi Kerja" style="width: 100%">
															<option></option>
															<?php foreach ($Lokasi as $key) { ?>
																<option value="<?php echo $key['location_code'] ?>"><?php echo $key['location_code']." - ".$key['location_name']  ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtSeksi" class="control-label col-lg-4">Seksi Pengirim</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<select class="select select2" id="txtSeksiPengirim" data-placeholder="Seksi Pengirim" style="width: 100%">
															<option></option>
															<?php foreach ($Seksi2 as $key): ?>
																<option value="<?php echo $key['section_code'] ?>"><?php echo $key['section_code']." - ".$key['section_name']  ?></option>
															<?php endforeach ?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtPengirimLimbah" class="control-label col-lg-4">Pengirim Limbah</label>
												<div class="col-lg-4">
													<div class="col-lg-5">
														<select class="select select2" name="txtPengirimLimbah" id="txtPengirimLimbah" data-placeholder="Noind" style="width:100%;" required>
															<option value=""></option>
														</select>
													</div>
													<div class="col-lg-7">
														<input type="text" name="txtNamaPengirim" id="txtNamaPengirim" class="form-control" disabled="" placeholder="Nama">
													</div>
												</div>
											</div>
											<div class="form-group hidden">
												<label for="txtSeksi" class="control-label col-lg-4">Seksi Asal Limbah</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<input type="text" name="txtSeksi" class="form-control" value="<?php echo $Seksi['0']['section_name']; ?>" disabled>
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
														<input type="number" autocomplete="off" class="form-control" name="txtJumlah" id="txtJumlah" placeholder="Jumlah" required>
													</div>
													<div class="col-lg-5">
														<select style="width: 100%;" class="select select2" name="txtSatuan" id="txtSatuan" data-placeholder="Satuan" required>
															<option></option>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<textarea class="form-control" name="txtKeterangan" id="txtKeterangan" placeholder="Keterangan" style="width:100%;height:100px;"></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-center">
										<button type="submit" class="btn btn-primary">Submit</button>
										<a href="javascript:history.back(1);" class="btn btn-warning">Back</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
