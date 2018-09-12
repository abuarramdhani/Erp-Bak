<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="POST" action="<?php site_url('WasteManagementSeksi/InputKirimLimbah/EditKirim')?>">
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
												<label for="txtSeksi" class="control-label col-lg-4">Seksi Pengirim</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<select class="select select2" name="txtSeksi" id="txtSeksi" data-placeholder="Seksi Pengirim" style="width:100%;">
															<option value="<?php echo $KirimLimbah['0']['section_code'] ?>"><?php echo $KirimLimbah['0']['section_name'] ?></option>
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
														<input type="text" class="form-control" name="txtJumlah" id="txtJumlah" placeholder="Jumlah" value="<?php echo $KirimLimbah['0']['jumlah_kirim'];  ?>">
													</div>
													<div class="col-lg-5">
														<input type="text" class="form-control" name="txtSatuan" id="txtSatuan" placeholder="Satuan" disabled="" value="<?php echo $KirimLimbah['0']['limbah_satuan']; ?>" style="padding-right: 0px;">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<textarea name="txtKeterangan" id="txtKeterangan" placeholder="Keterangan" style="width:100%;height:100px;"><?php echo $KirimLimbah['0']['ket_kirim']; ?></textarea>
													</div>	
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="button" class="btn btn-primary" >Back</button>
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