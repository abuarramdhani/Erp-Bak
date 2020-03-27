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
							<div class="box-header with-border text-right">
								<a href="btn btn-primary"><i class="fa fa-plush"></i></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="">
											<div class="form-group">
												<label class="control-label col-lg-4">Batas Bawah</label>
												<div class="col-lg-4">
													<input type="number" value="0" min="0" name="txtBatasBawahPrestasi" class="form-control" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Batas Atas</label>
												<div class="col-lg-4">
													<input type="number" value="0" min="0" name="txtBatasAtasPrestasi" class="form-control" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pengurang</label>
												<div class="col-lg-4">
													<input type="number" value="0" min="0" name="txtPengurangPrestasi" class="form-control" required>
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