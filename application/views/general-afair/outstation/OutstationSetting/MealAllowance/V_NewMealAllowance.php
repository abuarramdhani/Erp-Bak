	<section class="content-header">
		<h1>
			Quick Outstation Meal Allowance
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary" style="margin: 0 auto;width: 60%">
							<div class="box-body with-border">
								<form method="post" action="<?php echo base_url('Outstation/meal-allowance/new/save') ?>">
									<table class="table">
										<tr>
											<td width="20%">Position</td>
											<td><select id="position" name="txt_position_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
													<option value=""></option>
													<?php foreach($Position as $pos){?>
														<option value="<?php echo $pos['position_id'] ?>"><?php echo $pos['position_name'] ?></option>
													<?php } ?>
												</select></td>
										</tr>
										<tr>
											<td>Area</td>
											<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
													<option value=""></option>
													<?php foreach($Area as $ar){?>
														<option value="<?php echo $ar['area_id'] ?>"><?php echo $ar['area_name'] ?></option>
													<?php } ?>
												</select></td>
										</tr>
										<tr>
											<td>Time</td>
											<td><select id="time" name="txt_time_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
													<option value=""></option>
													<?php foreach($Time as $ti){?>
														<option value="<?php echo $ti['time_id'] ?>"><?php echo $ti['time_name'] ?></option>
													<?php } ?>
												</select></td>
										</tr>
										<tr>
											<td width="20%">Nominal</td>
											<td><input type="text" name="txt_nominal" class="form-control input_money" required></td>
										</tr>
										<tr>
											<td>Start Date</td>
											<td><input type="text" id="txt_start_date" name="txt_start_date" class="form-control"></td>
										</tr>
										<tr>
											<td>End Date</td>
											<td><input type="text" id="txt_end_date" name="txt_end_date" class="form-control"></td>
										</tr>
										<tr>
											<td></td>
											<td>
												<input type="submit" class="btn btn-primary pull-right" style="margin:5px;width: 25%" value="Save" />
												<a onclick="window.history.back()" class="btn btn-primary pull-right" style="margin:5px;width: 25%">
													<i class="fa fa-arrow-left"></i>
													Back
												</a>
											</td>
										</tr>
									</table>
								</form>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>