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
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" target="_blank">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<select class="select select2" data-placeholder="Periode" name="txtPeriodeRekap" style="width: 100%" required>
														<option></option>
														<?php if (isset($periode) and !empty($periode)) { 
															foreach ($periode as $key) { ?>
															<option><?php echo $key['tanggal_awal_rekap']." - ".$key['tanggal_akhir_rekap'] ?></option>
														<?php } } ?>
													</select>
												</div>
												<button type="submit" class="btn btn-primary">Export</button>
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