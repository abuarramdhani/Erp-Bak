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
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/Cetak/JadwalPengiriman/Read') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<input type="text" name="txtPeriodeJadwalPengiriman" id="txtPeriodeJadwalPengiriman" placeholder="Periode Lihat" class="date form-control" required autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Catering</label>
												<div class="col-lg-4">
													<select class="select select2" data-placeholder="Catering" name="txtKdCateringJadwalPengiriman" style="width: 100%;" required autocomplete="off">
														<option></option>
														<?php
														foreach ($catering as $key) { ?>
															<option value="<?php echo $key['kode'] ?>"><?php echo $key['kode']." - ".$key['nama'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Menu Paket</label>
												<div class="col-lg-4">
													<input type="text" name="txtMenuPaketJadwalPengiriman" placeholder="Menu Paket" class="form-control" required autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Pembuatan</label>
												<div class="col-lg-4">
													<input type="text" name="txtTanggalPembuatanJadwalPengiriman" id="txtTanggalPembuatanJadwalPengiriman" placeholder="Tanggal Pembuatan" class="date form-control" required autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Yang Bertandatangan :</label>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Personalia</label>
												<div class="col-lg-4">
													<select class="select select2" data-placeholder="Personalia" name="txtPersonaliaJadwalPengiriman" style="width: 100%" required autocomplete="off">
														<option></option>
														<option>................</option>
														<?php
														foreach ($personalia as $key) { ?>
															<option value="<?php echo $key['nama'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Catering</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Catering" name="txtCateringJadwalPengiriman" required autocomplete="off">
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