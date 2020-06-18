<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title; ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('CateringManagement/catering'); ?>" class="btn btn-default btn-lg">
									<span class="icon-wrench icon-2x"></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header"></div>
							<div class="box-body">
								<form class="form-horizontal" method="post" action="<?php echo base_url('CateringManagement/catering/Create') ?>">
									<div class="form-group">
										<label class="control-label col-lg-4">Kode</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" name="txtKodeCatering" placeholder="Kode Catering" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4">Nama</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" name="txtNamaCatering" placeholder="Nama Catering" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4">Alamat</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" name="txtAlamatCatering" placeholder="Alamat Catering" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4">Telepon</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" name="txtTeleponCatering" placeholder="Telepon Catering" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4">Status</label>
										<div class="col-lg-4">
											<select class="select select2" style="width: 100%" name="txtStatusCatering" data-placeholder="Status Catering" required>
												<option></option>
												<option value="t">Aktif</option>
												<option value="f">Tidak Aktif</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4">Lokasi</label>
										<div class="col-lg-4">
											<select class="select select2" style="width: 100%" name="txtLokasiCatering" data-placeholder="Lokasi Catering" required>
												<option></option>
												<option value="01">Pusat & Mlati</option>
												<option value="02">Tuksono</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-8 text-right">
											<a href="javascript:history.back(1);" class="btn btn-primary">Back</a>
											<button type="submit" class="btn btn-primary">Submit</button>
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
</section>