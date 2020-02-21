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
										<form class="form-horizontal" id="form_presensiH" target="_blank" method="post">
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
												<div class="col-lg-10 text-right">
													<button id="presensiH-btnExcel_v1" class="btn btn-success"><span style="font-size: 16px;" class="fa fa-file-excel-o"></span> - Template 1 </button>
													<button id="presensiH-btnExcel_v2" class="btn btn-success"><span style="font-size: 16px;" class="fa fa-file-excel-o"></span> - Template 2</button>
													<button id="presensiH-btnPDF_v1" class="btn btn-info"><span style="font-size: 16px;" class="fa fa-file-pdf-o"></span> - Template 1 </button>
													<button id="presensiH-btnPDF_v2" class="btn btn-info"><span style="font-size: 16px;" class="fa fa-file-pdf-o"></span> - Template 2</button>
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