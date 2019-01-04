<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="co-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('SiteManagement/PembelianAsset') ?>" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
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
									<div class="col-lg-4"></div>
									<div class="col-lg-4">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-6">No BPPBA</label>
												<div class="col-lg-6">
													<input type="text" name="" value="<?php echo $noBPPBA ?>" class="form-control " disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-6">No PP</label>
												<div class="col-lg-6">
													<input type="text" name="" value="<?php echo $noPP ?>" class="form-control " disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-6">Tanggal Pembelian</label>
												<div class="col-lg-6">
													<input type="text" name="" value="<?php echo $tglBeli ?>" class="form-control " disabled>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4"></div>
									<div class="col-lg-4">
										<div class="panel panel-info">
											<div class="panel-heading">
												<div class="text-left">Tag Number</div>
											</div>
											<div class="panel-body">
												<div class="row">
													<div class="col-lg-12">
														<form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/PembelianAsset/SaveInput/'.$link) ?>">
															<?php 
															for ($i=1; $i <= $banyak; $i++) { ?>
																<div class="form-group">
																	<div class="col-lg-12">
																		
																			<input type="text" name="txtTagNumber[]" class="form-control" placeholder="Tag Number <?php echo $i ?>" required>
																		
																	</div>
																</div>
															<?php } ?>
															<div class="form-group">
																<div class="col-lg-8 text-right">
																	<button class="btn btn-info">Simpan</button>
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
				</div>
			</div>
		</div>
	</div>
</section>