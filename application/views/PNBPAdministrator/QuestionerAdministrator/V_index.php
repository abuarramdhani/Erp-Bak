<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h3><b><?=$Title ?></b></h3>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="<?php echo base_url('PNBP') ?>" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('PNBP/QuestionerAdmin') ?>">
											<div class="form-group">
												<label class="control-label col-lg-3">Departemen</label>
												<div class="col-lg-6">
													<select class="select select2 selectPNBPDept" name="txtDepartmentUser" style="width: 100%">
														<?php 
															foreach ($dept as $dpt) { ?>
																<option value="<?php echo $dpt['kd_dept'] ?>"><?php echo $dpt['dept'] ?></option>
															<?php }
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Seksi / Unit</label>
												<div class="col-lg-6">
													<select class="selectPNBPSeksi" name="txtSeksiUser" style="width: 100%"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Masa Kerja</label>
												<div class="col-lg-6">
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="1" id="txtMasaKerjaOpt1"> < 1 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="2" id="txtMasaKerjaOpt2"> 1 - 3 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="3" id="txtMasaKerjaOpt3"> 4 - 6 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="4" id="txtMasaKerjaOpt4"> > 6 Tahun
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Jenis Kelamin</label>
												<div class="col-lg-6">
													<div class="col-lg-6">
														<input type="radio" name="txtJenKel" value="L" id="txtJenKelOpt1"> Laki - Laki
													</div>
													<div class="col-lg-6">
														<input type="radio" name="txtJenKel" value="P" id="txtJenKelOpt2"> Perempuan
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Usia</label>
												<div class="col-lg-6">
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="1" id="txtUsiaOpt1"> < 20 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="2" id="txtUsiaOpt2"> 20-29 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="3" id="txtUsiaOpt3"> 30-39 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="4" id="txtUsiaOpt4"> ≥ 40 Tahun
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Suku</label>
												<div class="col-lg-6">
													<select class="select select2" name="txtSuku" style="width: 100%">
														<option></option>
														<?php if (isset($suku) and !empty($suku)) {
															foreach ($suku as $val) { ?>
																<option value="<?php echo $val['id_suku'] ?>"><?php echo $val['nama_suku']." - ".$val['asal'] ?></option>
															<?php }
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Status Kerja</label>
												<div class="col-lg-6">
													<select class="selectStatusJabatan" name="txtJabatanUser" style="width: 100%"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Pendidikan Terakhir</label>
												<div class="col-lg-6">
													<select class="select select2" name="txtPendidikanAkhir" style="width: 100%">
														<option></option>
														<?php if (isset($pendidikan) and !empty($pendidikan)) {
															foreach ($pendidikan as $val) { ?>
																<option value="<?php echo $val['id_pendidikan'] ?>"><?php echo $val['pendidikan'] ?></option>
															<?php }
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-7 text-right">
													<i style="color: red">Lengkapi data yang kosong dan pastikan semua terisi</i>
												</div>
												<div class="col-lg-2 text-right">
													<button class="btn btn-success" type="submit">Lanjut</button>
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