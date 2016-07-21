	<section class="content-header">
		<h1>
			Quick Outstation Simulation
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary" style="margin: 0 auto;width: 60%">
							<div class="table-responsive">
								<fieldset class="row2">
									<div class="box-body with-border">
										<form method="post" action="<?php echo base_url('Outstation/simulation/update') ?>">
											<?php foreach ($data_simulation as $dsim) { ?>
												<input type="hidden" name="txt_simulation_id" value="<?php echo $dsim['simulation_id'] ?>">
												<table class="table">
													<tr>
														<td width="20%">Employee</td>
														<td><select id="txt_employee_id" name="txt_employee_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
															<option value=""></option>
															<?php foreach($Employee as $ed){?>
																<?php $employee_selected='';
																if ($dsim['employee_id'] ==$ed['employee_id']){
																	$employee_selected ='selected';
																}
																?>
																<option <?php echo $employee_selected?> value="<?php echo $ed['employee_id'] ?>"><?php echo $ed['employee_code'] ?></option>
															<?php } ?>
														</select></td>
													</tr>
													<tr>
														<td>Destination</td>
														<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
															<option value=""></option>
															<?php foreach($area_data as $ad){?>
																<?php $area_selected='';
																if ($dac['area_id'] ==$ad['area_id']){
																	$area_selected ='selected';
																}
																?>
																<option <?php echo $area_selected?> value="<?php echo $ad['area_id'] ?>"><?php echo $ad['area_name'] ?></option>
															<?php } ?>
														</select></td>
													</tr>
													<tr>
														<td width="20%">City Type</td>
														<td><select id="citytype" name="txt_city_type_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
															<option value=""></option>
															<?php foreach($city_type_data as $ct){?>
																<?php $area_selected='';
																if ($dac['city_type_id'] ==$ct['city_type_id']){
																	$area_selected ='selected';
																}
																?>
																<option <?php echo $area_selected?> value="<?php echo $ct['city_type_id'] ?>"><?php echo $ct['city_type_name'] ?></option>
															<?php } ?>
														</select></td>
													</tr>
													<tr>
														<td width="20%">Depart</td>
														<td><input type="text" name="txt_depart" class="form-control" value ="<?php echo $dsim['depart_time']?>" required></td>
													</tr>
													<tr>
														<td>Return</td>
														<td><input type="text" id="txt_return" name="txt_return" class="form-control" value="<?php echo $dsim['return_time']?>"></td>
													</tr>
													<tr>
														<td>Total</td>
														<td><input type="text" id="txt_end_date" name="txt_end_date" class="form-control" value="<?php echo $dac['end_date']?>"></td>
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
											<?php }?>
										</form>
									</div>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>