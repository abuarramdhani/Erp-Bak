<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?php echo $Title ?></b></h1>
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
										<form class="form-horizontal" method="POST" action="">
											<div class="form-group">
												<label class="control-label col-lg-4">Gol. Kerja</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtgk" value="<?php echo $nominal['0']['gol_kerja'] ?>" disabled> 
												</div>
												
												
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Gol. Nilai</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtgn" value="<?php echo $nominal['0']['gol_nilai'] ?>" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kenaikan</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtPengurangNominal" value="<?php echo $nominal['0']['nominal_kenaikan'] ?>" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button type="submit" class="btn btn-primary">Simpan</button>
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