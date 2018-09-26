<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('CateringManagement/JamDatangShift') ?>" class="btn btn-default btn-lg">
									<span class="icon-wrench icon-2x"></span>
								</a>
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
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/JamPesananDatang/Edit/'.$linkdata) ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Shift</label>
												<div class="col-lg-4">
													<input type="text" name="txtshift" class="form-control" value="<?php
													 echo $JamPesananDatang['0']['shift']; 
													 ?>" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Hari</label>
												<div class="col-lg-4">
													<input type="text" name="txthari" class="form-control" value="<?php
													$hari = array(
															'1' => "Minggu", 
															'2' => "Senin", 
															'3' => "Selasa", 
															'4' => "Rabu", 
															'5' => "Kamis", 
															'6' => "Jumat", 
															'7' => "Sabtu"
														);
													 echo $hari[$JamPesananDatang['0']['fs_hari']]; 
													 ?>" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jam Pesan</label>
												<div class="col-lg-4">
													<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
														<input type="text" name="txtJamPesan" id="txtJamPesan" class="form-control"  value="<?php echo $JamPesananDatang['0']['fs_jam_pesan'] ?>" required>
														<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jam Datang</label>
												<div class="col-lg-4">
													<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
														<input type="text" name="txtJamDatang" id="txtJamDatang" class="form-control" value="<?php echo $JamPesananDatang['0']['fs_jam_datang'] ?>" required>
														<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
													</div>
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
	</div>
</section>