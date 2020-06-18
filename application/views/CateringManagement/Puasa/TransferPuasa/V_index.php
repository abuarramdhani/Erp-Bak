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
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode Puasa</label>
												<div class="col-lg-4">
													<input type="text" class="date form-control cmpuasadaterange" id="txtPeriodeTranferPuasa" required>
												</div>
											</div>
											<div class="form-group" id="TransferProgress1" >
												<div class="col-lg-2"></div>
												<div class="col-lg-8">
													<div class="progress">
														<div id="progressTransferPuasa" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
											</div>
											<div class="form-group" id="TransferProgress2" style="display: none;">
												<div class="col-lg-2"></div>
												<div class="col-lg-8">
													<div class="progress">
														<div id="progressTransferPuasa1" class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Mohon Tunggu....</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button type="button" class="btn btn-primary" onclick="transferPuasa(0,0)">Proses Puasa</button>
													<button type="button" class="btn btn-danger" onclick="batalTransferPuasa()">Batalkan Puasa</button>
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