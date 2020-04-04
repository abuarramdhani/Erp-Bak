<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/TmpMakan'); ?>"><span class="icon-wrench icon-2x"></span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<div class="col-lg-12">
									<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/TmpMakan/Create'); ?>">
										<div class="form-group">
											<label class="control-label col-lg-4">Tempat Makan</label>
											<div class="col-lg-4">
												<input type="text" name="txtTmpMakan" class="form-control" placeholder="Tempat Makan" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Letak</label>
											<div class="col-lg-4">
												<select class="select select2" name="txtLetakTmpMakan" class="form-control" data-placeholder="Letak Tempat Makan" required style="width: 100%">
													<option></option>
													<?php 
													foreach ($letak as $key) { ?>
														<option value="<?php echo $key['fn_kd_letak'] ?>"><?php echo $key['fs_letak'] ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Lokasi</label>
											<div class="col-lg-4">
												<select class="select select2" style="width: 100%" name="txtLokasiTempatMakan" data-placeholder="Lokasi Tempat Makan" required>
													<option></option>
													<option value="1">Pusat & Mlati</option>
													<option value="2">Tuksono</option>
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
	</div>
</section>