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
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/JamPesananDatang/Create') ?>">
											<?php if(isset($alert)){ ?>
											<div class="form-group">
												<div class="text-center">
													<label class="label label-danger" style="font-size: 15pt;">Data Hari dan Shift Tersebut Sudah Ada</label>
												</div>
											</div>
											<?php } ?>
											<div class="form-group">
												<label class="control-label col-lg-4">Shift</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtShiftPesananDatang" data-placeholder="Pilih Shift" style="width: 100%" required>
														<option></option>
														<?php foreach ($Shift as $key) {?>
															<option value="<?php echo $key['kd_shift'] ?>"><?php echo $key['shift'] ?></option>
														<?php } ?>
														<option value="1">Shift 1 dan Shift Umum</option>
														<option value="2">Shift 2</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Hari</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtHariPesananDatang" data-placeholder="Pilih Hari" style="width: 100%" required>
														<option></option>
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
												<label class="control-label col-lg-4">Jam Pesan</label>
												<div class="col-lg-4">
													<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
														<input type="text" name="txtJamPesan" id="txtJamPesan" class="form-control" required>
														<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jam Datang</label>
												<div class="col-lg-4">
													<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
														<input type="text" name="txtJamDatang" id="txtJamDatang" class="form-control" required>
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