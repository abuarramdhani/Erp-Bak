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
							<div class="text-right hidden-md hidden-sm hidden-xs">
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
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/Cetak/JadwalLayanan/Read') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<input type="text" name="txtPeriodeJadwalLayanan" id="txtPeriodeJadwalLayanan" class="date form-control" placeholder="Bulan Tahun" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Paket</label>
												<div class="col-lg-4">
													<input type="text" name="txtPaketJadwalLayanan" class="form-control" placeholder="Paket" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Dibuat Tanggal</label>
												<div class="col-lg-4">
													<input type="text" name="txtTanggalJadwalLayanan" id="txtTanggalJadwalLayanan" class="date form-control" placeholder="Tanggal" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Lokasi</label>
												<div class="col-lg-4">
													<select class="select2" style="width: 100%" name="slcLokasiJadwalLayanan" data-placeholder="Lokasi">
														<option></option>
														<option value="1">Yogyakarta & Mlati</option>
														<option value="2">Tuksono</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button class="btn btn-primary" type="submit">Lihat</button>
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