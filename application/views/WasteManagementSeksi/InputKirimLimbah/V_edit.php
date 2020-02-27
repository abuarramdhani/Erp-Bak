<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="POST" action="">
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
														<input type="text" class="form-control" name="txtTanggalKirimLimbah" id="txtTanggalKirimLimbah" class="date form-control" value="<?php echo $KirimLimbah['0']['tanggal'] ?>" data-date-format="yyyy-mm-dd" >
													</div>
													<div class="col-lg-6">
														<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
															<input type="text" class="form-control" name="txtWaktuKirimLimbah" id="txtWaktuKirimLimbah" class="form-control" value="<?php echo $KirimLimbah['0']['waktu'] ?>">
															<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtJenisLimbah" class="control-label col-lg-4">Jenis Limbah</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<select class="select select2" name="txtJenisLimbah" id="txtJenisLimbah" data-placeholder="Jenis Limbah" style="width:100%;">
															<option value="<?php echo $KirimLimbah['0']['id_jenis_limbah'] ?>"><?php echo $KirimLimbah['0']['jenis_limbah'] ?></option>
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
												<label for="txtLokasi" class="control-label col-lg-4">Lokasi Kerja</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<select class="select select2" id="txtLokasi" name="txtLokasi" style="width: 100%" required>
															<option value="<?php echo $KirimLimbah['0']['lokasi_kerja'] ?>"><?php echo $KirimLimbah['0']['noind_location'] ?></option>
															<option></option>
															<?php foreach ($Lokasi as $key) { ?>
																<option value="<?php echo $key['location_code'] ?>"><?php echo $key['location_code']." - ".$key['location_name']  ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtPengirimLimbah" class="control-label col-lg-4">Pengirim Limbah</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<input type="text" name="txtPengirimLimbah" value="<?php echo $KirimLimbah['0']['noind_pengirim'] ?>" class="form-control" disabled>
													</div>
												</div>
											</div>
											<div class="form-group hidden">
												<label for="txtSeksi" class="control-label col-lg-4">Seksi Pengirim</label>
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
														<select class="select select2" name="txtKondisi" id="txtKondisi" value='.$bocor.' style="width:100%;">
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
														<input type="number" class="form-control" name="txtJumlah" id="txtJumlah" placeholder="Jumlah" value="<?php echo $KirimLimbah['0']['jumlah_kirim'];  ?>">
													</div>
													<div class="col-lg-5">
														<select style="width: 100%;" class="select select2" name="txtSatuan" id="txtSatuan" data-placeholder="Satuan">
															<option></option>
															<?php foreach ($SatuanLimbah as $key) { ?>
																<option value="<?=$key['id_satuan_all']?>" <?php if($LimbahSatuan['0']['satuan'] == $key['satuan']){echo 'selected';} ?>><?=$key['satuan']?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<textarea class="form-control" name="txtKeterangan" id="txtKeterangan" placeholder="Keterangan" style="width:100%;height:100px;"><?php echo $KirimLimbah['0']['ket_kirim']; ?></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-center">
										<button type="submit" class="btn btn-primary">Submit</button>
										<a href="javascript:history.back(1);" class="btn btn-warning" >Back</a>
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
