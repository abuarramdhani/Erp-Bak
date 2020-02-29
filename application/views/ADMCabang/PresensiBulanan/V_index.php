<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?=$Title ?>
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
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
										<form class="form-horizontal" target="_blank" method="post" action="<?php echo site_url('AdmCabang/PresensiBulanan/ExportExcel') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Kodesie</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo $seksi['0']['kodesie'] ?>" class="form-control" name="txtKodesie" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo $seksi['0']['seksi'] ?>" class="form-control" name="txtKodesie" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<input type="text" class="date form-control" name="txtPeriodePresensiHarian" id="txtPeriodePresensiHarian" autocomplete="off" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button class="btn btn-success">Export Excel</button>
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