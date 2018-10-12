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
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/JamDatangShift/Edit/'.$kd."/".$hari) ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Shift</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtShiftJamDatang" data-placeholder="Pilih Shift" style="width: 100%" disabled>
														<?php if ($JamDatangShift['0']['fs_kd_shift'] == '1') { ?>
														<option value="1">Shift 1 dan Shift Umum</option>
														<?php }else{ ?>
														<option value="2">Shift 2</option>
													<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Hari</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtHariJamDatang" data-placeholder="Pilih Hari" style="width: 100%" required>
														<option value="<?php echo $JamDatangShift['0']['fs_hari'] ?>">
															<?php 
																$hari = array("","Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
																echo $hari[$JamDatangShift['0']['fs_hari']];
															?>
														</option>
														<option value="1">Minggu</option>
														<option value="2">Senin</option>
														<option value="3">Selasa</option>
														<option value="4">Rabu</option>
														<option value="5">Kamis</option>
														<option value="6">Jumat</option>
														<option value="7">Sabtu</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jam Awal Absen</label>
												<div class="col-lg-4">
													<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
														<input type="text" name="txtAwalJamDatang" id="txtAwalJamDatang" class="form-control" value="<?php echo $JamDatangShift['0']['fs_jam_awal'] ?>" placeholder="Jam Awal Absen" required>
														<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jam Akhir Absen</label>
												<div class="col-lg-4">
													<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
														<input type="text" name="txtAkhirJamDatang" id="txtAkhirJamDatang" class="form-control" value="<?php echo $JamDatangShift['0']['fs_jam_akhir'] ?>" placeholder="Jam Akhir Absen" required>
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