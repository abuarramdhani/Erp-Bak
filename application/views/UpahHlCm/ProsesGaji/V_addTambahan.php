<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
								<br>
								<h4>Input Tambahan / Potongan</h4>
								<a class="btn btn-primary pull-right" href="<?php echo base_url("HitungHlcm/TambahanPotongan/History") ?>">History Potongan Tambahan</a>
								<br>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" action="<?php echo site_url("HitungHlcm/TambahanPotongan/Simpan") ?>" method="POST">
											<div class="form-group">
												<label class="form-label col-lg-2">Periode Penggajian</label>
												<div class="col-lg-4">
													<select class="select2" name="slc-hlcm-tampot-periode" data-placeholder="Pilih Periode Penggajian" style="width: 100%" required>
														<option></option>
														<?php
															if (isset($periodeGaji) and !empty($periodeGaji)){
																foreach ($periodeGaji as $key) {
																	echo "<option value ='".$key['rangetanggal']."'>".$key['bulan']." ".$key['tahun']."</option>";
																}
															}
														 ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="form-label col-lg-2">No. Induk</label>
												<div class="col-lg-4">
													<select id="slc-hlcm-tampot-noind" name="slc-hlcm-tampot-noind" style="width: 100%"></select>
												</div>
												<div class="col-lg-2">
													<i style="color: grey; font-size: 8pt">*kosongi untuk memproses semua pekerja</i>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-center">
													<span id="hlcm-label-pot-tam" style="color: red;display: none;font-weight: bold;">No. Induk sudah Memiliki data Potongan atau Tambahan</span>
												</div>
											</div>
											<div class="form-group">
												<label class="form-label col-lg-2">Tambahan</label>
												<div class="col-lg-6" style="border-radius: 10px;background-color: #72bdf7">
													<div class="row" style="margin-bottom: 5px;margin-top: 5px;">
														<div class="col-lg-12">
															<label class="form-label col-lg-3">Gaji Pokok</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Jumlah Gaji Pokok" name="txt-hlcm-tam-gp" class="form-control">
															</div>
															<label class="form-label col-lg-2">Hari</label>
														</div>
													</div>
													<div class="row" style="margin-bottom: 5px;margin-top: 5px;">
														<div class="col-lg-12">
															<label class="form-label col-lg-3">Lembur</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Jumlah Lembur" name="txt-hlcm-tam-lembur" class="form-control">
															</div>
															<label class="form-label col-lg-2">Jam</label>
														</div>
													</div>
													<div class="row" style="margin-bottom: 5px;margin-top: 5px;">
														<div class="col-lg-12">
															<label class="form-label col-lg-3">Uang Makan</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Jumlah Uang Makan" name="txt-hlcm-tam-um" class="form-control">
															</div>
															<label class="form-label col-lg-2">Hari</label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="form-label col-lg-2">Potongan</label>
												<div class="col-lg-6" style="border-radius: 10px;background-color: #fc9e7e">
													<div class="row" style="margin-bottom: 5px;margin-top: 5px;">
														<div class="col-lg-12">
															<label class="form-label col-lg-3">Gaji Pokok</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Jumlah Gaji Pokok" name="txt-hlcm-pot-gp" class="form-control">
															</div>
															<label class="form-label col-lg-2">Hari</label>
														</div>
													</div>
													<div class="row" style="margin-bottom: 5px;margin-top: 5px;">
														<div class="col-lg-12">
															<label class="form-label col-lg-3">Lembur</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Jumlah Lembur" name="txt-hlcm-pot-lembur" class="form-control">
															</div>
															<label class="form-label col-lg-2">Jam</label>
														</div>
													</div>
													<div class="row" style="margin-bottom: 5px;margin-top: 5px;">
														<div class="col-lg-12">
															<label class="form-label col-lg-3">Uang Makan</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Jumlah Uang Makan" name="txt-hlcm-pot-um" class="form-control">
															</div>
															<label class="form-label col-lg-2">Hari</label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button class="btn btn-primary">Proses</button>
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