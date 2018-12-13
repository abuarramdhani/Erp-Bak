<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-xs hidden-md">
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div> 
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('ManagementAdmin/Input/Simpan') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="selectPekerjaProses" name="selectPekerjaProses" style="width: 100%" required=""></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerjaan</label>
												<div class="col-lg-4">
													<select class="selectPekerjaanProses" name="selectPekerjaanProses" style="width: 100%" required=""></select>
													<input type="hidden" name="selectPekerjaanProses">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jumlah Dokumen</label>
												<div class="col-lg-4">
													<input type="number" name="txtJumlahDocument" class="form-control" placeholder="Jumlah Dokumen" required="">
												</div>
											</div>
											<div class="form-group">	
												<label class="control-label col-lg-4">Target Total</label>
												<div class="col-lg-4">
													<input type="number" name="txtTargetTotal" class="form-control" placeholder="Target Total" required="">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Mulai</label>
												<div class="col-lg-2">
													<div class="input-group">
														<input type="text" name="txtTanggalMulai" class="date form-control tanggalPelaksanaan" required="">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
												</div>
												<div class="col-lg-2">
													<div class="input-group bootstrap-timepicker timepicker">
														<input type="text" name="txtWaktuMulai" class="form-control waktuPelaksanaan" required>
														<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Selesai</label>
												<div class="col-lg-2">
													<div class="input-group">
														<input type="text" name="txtTanggalSelesai" class="date form-control tanggalPelaksanaan" required="">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
												</div>
												<div class="col-lg-2">
													<div class="input-group bootstrap-timepicker timepicker">
														<input type="text" name="txtWaktuSelesai" class="form-control waktuPelaksanaan" required>
														<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<a href="javascript:history.back(1)" class="btn btn-danger">batal</a>
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