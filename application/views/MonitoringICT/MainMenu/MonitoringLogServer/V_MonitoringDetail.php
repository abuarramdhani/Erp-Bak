<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> Monitoring Log Server</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringServer/Monitoring');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Detail Monitoring Server
							</div>
														<div class="box-body">
								<div class="row">
										
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Petugas</label>
												<div class="col-lg-1"> :</div>
												<div class="col-lg-4">
													<?php foreach ($DataMonitoring as $DM) {
															foreach ($DM['pekerja'] as $pkj) {
																echo ''.$pkj['petugas'].'<br>';
															}
													} ?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Ruang Server</label>
												<div class="col-lg-1"> :</div>
												<div class="col-lg-4">
													<?php echo $DataMonitoring[0]['ruang_server']; ?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Tanggal</label>
												<div class="col-lg-1"> :</div>
												<div class="col-lg-4">
													<?php echo date('d F Y',strtotime($DataMonitoring[0]['tanggal'])); ?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Jam Masuk</label>
												<div class="col-lg-1"> :</div>
												<div class="col-lg-4">
													<?php echo $DataMonitoring[0]['jam_masuk']; ?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Jam Keluar</label>
												<div class="col-lg-1"> :</div>
												<div class="col-lg-4">
													<?php echo $DataMonitoring[0]['jam_keluar']; ?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Keperluan</label>
												<div class="col-lg-1"> :</div>
												<div class="col-lg-8">
													<?php echo $DataMonitoring[0]['keperluan']; ?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<a href="<?php echo base_url('MonitoringServer/Monitoring') ?>">
										<button type="button" class="btn btn-default ">CANCEL</button>
										</a>
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