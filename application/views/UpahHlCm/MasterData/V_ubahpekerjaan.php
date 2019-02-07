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
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo base_url('HitungHlcm/UbahPekerjaan/Simpan') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Noind</label>
												<div class="col-lg-4">
													<select class="cmbNoindHlcm" name="cmbNoindHlcm" style="width: 100%"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Nama</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" id="txtNamaPekerjaHlcm2" disabled="disabled" placeholder="Nama">
													<input type="hidden" name="txtNamaPekerjaHlcm" id="txtNamaPekerjaHlcm">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerjaan Lama</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" id="txtPekerjaanLamaHlcm2" disabled="disabled" placeholder="Pekerjaan Lama">
													<input type="hidden" name="txtPekerjaanLamaHlcm" id="txtPekerjaanLamaHlcm">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerjaan Baru</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" id="txtPekerjaanBaruHlcm2" disabled="disabled" placeholder="Pekerjaan Baru">
													<input type="hidden" name="txtPekerjaanBaruHlcm" id="txtPekerjaanBaruHlcm">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Mulai Berlaku</label>
												<div class="col-lg-4">
													<input type="text" name="txtMulaiBerlaku" id="txtMulaiBerlakuPekerjaanHlcm" class="date form-control" placeholder="Mulai Berlaku">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<a href="javascript:history.back(1)" class="btn btn-danger">Batal</a>
													<button type="submit" class="btn btn-primary">Simpan</button>
												</div>
											</div>
											<?php if (isset($noind_sukses) and !empty($noind_sukses)) { ?>
												<script type="text/javascript">
													alert('Perubahan Pekerjaan <?php echo $noind_sukses ?> Sukses !!!');
												</script>
											<?php } ?>
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