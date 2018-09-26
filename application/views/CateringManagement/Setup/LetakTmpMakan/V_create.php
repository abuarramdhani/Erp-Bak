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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/LetakTmpMakan'); ?>"><span class="icon-wrench icon-2x"></span></a>
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
									<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/LetakTmpMakan/Create'); ?>">
										<div class="form-group">
											<label class="control-label col-lg-4">Kode</label>
											<div class="col-lg-4">
												<input type="text" name="txtKodeLetakTmpMakan" class="form-control" placeholder="Kode Letak Tempat Makan" value="<?php echo $kode['0']['kode'] ?>" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Letak</label>
											<div class="col-lg-4">
												<input type="text" name="txtLetakTmpMakan" class="form-control" placeholder="Letak Tempat Makan" required>
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