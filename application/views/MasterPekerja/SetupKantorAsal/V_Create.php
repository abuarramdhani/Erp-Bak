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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/SetupKantorAsal'); ?>"><span class="icon-wrench icon-2x"></span></a>
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
									<form class="form-horizontal" method="post" action="<?php echo site_url('MasterPekerja/SetupKantorAsal/create'); ?>">
										<div class="form-group">
											<label class="control-label col-lg-4">Kode</label>
											<div class="col-lg-4">
												<input type="text" name="txtIdKantor" class="form-control" id="kodeKantor" placeholder="Kode Kantor Asal" value="<?php echo $kode['0']['kode'] ?>" readonly="" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4">Kantor Asal</label>
											<div class="col-lg-4">
												<input type="text" name="txtMasterKantor" class="form-control" id="masterKantor" placeholder="Kantor Asal" required>
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
