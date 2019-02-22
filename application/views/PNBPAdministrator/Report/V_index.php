<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h3><b><?=$Title ?></b></h3>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="<?php echo base_url('PNBP') ?>" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<select class="select2" data-placeholder="Periode" style="width: 100%">
														<option></option>
														<?php if (isset($periode) and !empty($periode)) { 
															foreach($periode as $prd){?>
															<option value="<?php echo $prd['id_periode'] ?>"><?php echo $prd['periode_awal']." - ".$prd['periode_akhir'] ?></option>
														<?php } } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="selectPekerjaReportPNBP" style="width: 100%">
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button type="button" class="btn btn-primary" id="btnSubmitChartPNBP">Proses</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-primary">
											<div class="panel-heading text-right">
												<button class="btn btn-danger"><i class="fa fa-file-pdf-o fa-2x"></i></button>
											</div>
											<div class="panel-body">
												<canvas id="canvasReportPNBP"></canvas>
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