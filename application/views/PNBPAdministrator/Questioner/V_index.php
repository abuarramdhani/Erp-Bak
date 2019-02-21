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
										<?php if (!isset($periode) or empty($periode)) { ?>
											<div class="col-lg-12 text-center">
												<?php if(isset($ada) and $ada == '1'){ ?>
														<p style="font-size: 20pt;color: red">Anda Sudah Mengisi Questioner Periode Sekarang.</p>
												<?php }else{ ?>
														<p style="font-size: 20pt;color: red">Bukan Periode Pengisian Questioner</p>
												<?php } ?>
												
											</div>
										<?php }else{ ?> 
										<form class="form-horizontal" method="POST" action="<?php echo site_url('PNBP/Questioner') ?>">
											<?php if (isset($data) and !empty($data)) { 
												foreach ($data as $key) { ?>
											<div class="form-group">
												<label class="control-label col-lg-3">No. Induk</label>
												<div class="col-lg-6">
													<input type="text" name="txtNoindUser" class="form-control" value="<?php echo $key['noind'] ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Nama</label>
												<div class="col-lg-6">
													<input type="text" name="txtNamaUser" class="form-control" value="<?php echo $key['nama'] ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Seksi / Unit</label>
												<div class="col-lg-6">
													<input type="text" name="txtSeksiUser" class="form-control" value="<?php echo $key['seksi'] ?>" required>
													<input type="hidden" name="txtKodesie" value="<?php echo $key['kodesie'] ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Departemen</label>
												<div class="col-lg-6">
													<input type="text" name="txtDepartmentUser" class="form-control" value="<?php echo $key['dept'] ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Masa Kerja</label>
												<div class="col-lg-6">
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="1" <?php if (intval($key['masa_kerja']) < 1) { echo "checked";} ?>> < 1 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="2" <?php if (intval($key['masa_kerja']) >= 1 and intval($key['masa_kerja']) <= 3 ) { echo "checked";} ?>> 1 - 3 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="3" <?php if (intval($key['masa_kerja']) >=4 and intval($key['masa_kerja']) <= 6) { echo "checked";} ?>> 4 - 6 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="4" <?php if (intval($key['masa_kerja']) > 6) { echo "checked";} ?>> > 6 Tahun
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Jenis Kelamin</label>
												<div class="col-lg-6">
													<div class="col-lg-6">
														<input type="radio" name="txtJenKel" value="L" <?php if ($key['jenkel'] == 'L') { echo "checked"; }  ?>> Laki - Laki
													</div>
													<div class="col-lg-6">
														<input type="radio" name="txtJenKel" value="P" <?php if ($key['jenkel'] == 'P') { echo "checked"; }  ?>> Perempuan
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Usia</label>
												<div class="col-lg-6">
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="1" <?php if (intval($key['umur']) < 20) { echo "checked";} ?>> < 20 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="2" <?php if (intval($key['umur']) > 20 and intval($key['umur']) < 29) { echo "checked";} ?>> 20-29 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="3" <?php if (intval($key['umur']) > 30 and intval($key['umur']) < 39) { echo "checked";} ?>> 30-39 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="4" <?php if (intval($key['umur']) >= 20) { echo "checked";} ?>> ≥ 40 Tahun
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
													<input type="text" name="txtJabatanUser" class="form-control" value="<?php echo $key['nama_jabatan'] ?>" required>
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
													<?php if (!empty($key['nama_jabatan']) or $key['noind'] == 'F2228') { ?>
														<button class="btn btn-success" type="submit">Lanjut</button>
													<?php }else{ ?>
														<button class="btn btn-danger" type="button" disabled>Data Tidak Lengkap</button>
													<?php } ?>
													
												</div>
											</div>
											<?php } } ?>
										</form>
										<?php } ?>
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