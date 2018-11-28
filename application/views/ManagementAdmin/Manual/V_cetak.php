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
							<div class="text-right hidden-xs hidden-sm hidden-md">
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
									<form class="form-horizontal" method="post" target="_blank" action="<?php echo site_url('ManagementAdmin/Cetak/Cetak') ?>">
										<div class="form-group">
											<label class="control-label col-lg-4">Pekerja</label>
											<div class="col-lg-4">
												<select class="selectPekerjaProses" name="txtPekerjaCetak[]" style="width: 100%" multiple="multiple"></select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4"></label>
											<div class="col-lg-4">
												<input type="checkbox" name="txtSemuaPekerjaCetak" value="1"> Semua Pekerja
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Periode</label>
											<div class="col-lg-4">
												<input type="text" class="date form-control" name="txtPeriodeCetak" id="txtPeriodeCetak">
											</div>
										</div>
										<div class="form-group">
											<div class="col-lg-8 text-right">
												<button type="submit" class="btn btn-primary">Cetak</button>
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
</section>