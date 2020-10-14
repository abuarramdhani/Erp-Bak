<script src="<?php echo base_url('assets/js/ajaxSearch.js'); ?>"></script>

<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Catering List</b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/List'); ?>">
									<i class="icon-wrench icon-2x"></i>
									<span><br /></span>
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
								<b>Catering List</b>
							</div>
							<div class="box-body">
								<form method="post" action="<?php echo base_url('CateringManagement/List/Update') ?>">
									<?php foreach ($Catering as $ct) { ?>
										<input type="hidden" name="TxtId" class="form-control" value="<?php echo $ct['catering_id'] ?>" required>
										<!-- INPUT GROUP 1 ROW 1 -->
										<div class="row" style="margin: 10px 10px">
											<div class="form-group">
												<label class="col-lg-2 control-label">Catering Name</label>
												<div class="col-lg-5">
													<input name="TxtName" class="form-control toupper" placeholder="Catering Name" value="<?php echo $ct['catering_name'] ?>" required>
												</div>
												<label class="col-lg-1 control-label" align="right">Code</label>
												<div class="col-lg-3">
													<input name="TxtCode" class="form-control toupper" placeholder="Code" value="<?php echo $ct['catering_code'] ?>" required>
												</div>
											</div>
										</div>
										<!-- INPUT GROUP 1 ROW 3 -->
										<div class="row" style="margin: 10px 10px">
											<div class="form-group">
												<label class="col-lg-2 control-label">Address</label>
												<div class="col-lg-5">
													<input name="TxtAddress" class="form-control toupper" placeholder="Address" value="<?php echo $ct['catering_address'] ?>" required>
												</div>
												<label class="col-lg-1 control-label" align="right">Status</label>
												<div class="col-lg-3">
													<select class="form-control select4" name="txtStatus" placeholder="Status" required>
														<?php
															$a = '';
															if ($ct['catering_status'] == 0) {
																$a = 'selected';
															}
															$b = '';
															if ($ct['catering_status'] == 1) {
																$b = 'selected';
															}
															?>
														<option <?php echo $b ?> value="1">1</option>
														<option <?php echo $a ?> value="0">0</option>
													</select>
												</div>
											</div>
										</div>

										<!-- INPUT GROUP 2 ROW 1 -->
										<div class="row" style="margin: 10px 10px">
											<div class="form-group">
												<label class="col-lg-2 control-label">Phone Number</label>
												<div class="col-lg-5">
													<input name="TxtPhone" class="form-control toupper" onkeypress="return isNumberKey(event)" placeholder="Phone Number" value="<?php echo $ct['catering_phone'] ?>" maxlength="13" required>
												</div>
												<label class="col-lg-1 control-label" align="right">PPH</label>
												<div class="col-lg-1">
													<select class="form-control select4" name="TxtPph" placeholder="PPH" required>
														<?php
															$c = '';
															if ($ct['catering_pph'] == 0) {
																$c = 'selected';
															}
															$d = '';
															if ($ct['catering_pph'] == 1) {
																$d = 'selected';
															}
															?>
														<option <?php echo $d ?> value="1">YA</option>
														<option <?php echo $c ?> value="0">TIDAK</option>
													</select>
												</div>
												<div class="col-lg-2">
													<input type="number" step="any" class="form-control" name="TxtPphValue" value="<?php echo $ct['pph_value'] ?>" placeholder="PPH VALUE (%)" required>
												</div>
											</div>
										</div>
										<hr>

										<!-- submit -->
										<div class="form-group">
											<div class="col-lg-11 text-right">
												<a href="<?php echo site_url('CateringManagement/List'); ?>" class="btn btn-success btn-lg btn-rect">Back</a>
												&nbsp;&nbsp;
												<button type="submit" class="btn btn-success btn-lg btn-rect">Save Data</button>
											</div>
										</div>
									<?php } ?>
									<form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>