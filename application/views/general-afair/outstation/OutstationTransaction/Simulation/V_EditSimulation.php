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
						<div class="box box-primary" style="margin: 0 auto">
							<div class="table-responsive">
								<fieldset class="row2">
									<div class="box-body with-border">
										<form method="post" id="simulation-form" action="<?php echo base_url('Outstation/simulation/update') ?>">
											<table class="table">
											<?php
												foreach($data_simulation as $dsim){
											?>
												<input type="hidden" name="txt_simulation_id" value="<?php echo $dsim['simulation_id'] ?>" />
												<tr>
													<td width="15%">Employee</td>
													<td width="35%"><select id="txt_employee_id" name="txt_employee_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($Employee as $ed){?>
																<?php
																	$selected = '';
																	if ($dsim['employee_id'] == $ed['employee_id']) {
																		$selected = 'selected';
																	}
																?>
																<option <?php echo $selected ?> value="<?php echo $ed['employee_id'] ?>"><?php echo $ed['employee_code'] ?> - <?php echo $ed['employee_name'] ?></option>
															<?php } ?>
														</select></td>
													<td width="15%"></td>
													<td width="35%"></td>
												</tr>
												<tr>
													<td>ID Employee</td>
													<td><p id="employee_code"><?php echo $dsim['employee_code'] ?></p></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td>Employee Name</td>
													<td><p id="employee_name"><?php echo $dsim['employee_name'] ?></p></td>
													<td>Destination</td>
													<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($Area as $ar){?>
																<?php
																	$selected = '';
																	if ($dsim['area_id'] == $ar['area_id']) {
																		$selected = 'selected';
																	}
																?>
																<option <?php echo $selected ?> value="<?php echo $ar['area_id'] ?>"><?php echo $ar['area_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Section</td>
													<td><p id="section_name"><?php echo $dsim['section_name'] ?></p>
													</td>
													<td>City Type</td>
													<td><select id="citytype" name="txt_city_type_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($CityType as $ci){?>
																<?php
																	$selected = '';
																	if ($dsim['city_type_id'] == $ci['city_type_id']) {
																		$selected = 'selected';
																	}
																?>
																<option <?php echo $selected ?> value="<?php echo $ci['city_type_id'] ?>"><?php echo $ci['city_type_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Unit</td>
													<td><p id="unit_name"><?php echo $dsim['unit_name'] ?></p></td>
													<td>Depart</td>
													<td><input type="text" name="txt_depart" value="<?php echo $dsim['depart_time'] ?> " class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Departemen</td>
													<td><p id="department_name"><?php echo $dsim['department_name'] ?></p></td>
													<td>Return</td>
													<td><input type="text" name="txt_return" value="<?php echo $dsim['return_time'] ?> " class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td colspan="4">
														<center>
															<a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
															<span id="submit-simulation" style="margin: 10px; width: 100px;" class="btn btn-primary">Process</span>
														</center>
													</td>
												</tr>
											</table>
											<?php
													}
											?>
											<label>Simulation Table</label>
											<table id="simulation_detail" class="table table-bordered table-striped table-hover">
												<thead>
													<tr class="bg-primary">
														<th width="5%"><center>No</center></th>
														<th width="10%"><center>Date</center></th>
														<th><center>Time</center></th>
														<th><center>Meal Allowance</center></th>
														<th><center>Accomodation Allowance</center></th>
														<th><center>Group</center></th>
														<th><center>USH</center></th>
														<th><center>Total</center></th>
													</tr>
												</thead>
												<tbody id="simulation_body">
													<?php
														foreach ($Simulation_detail as $sdet) {
															$inn_date = explode(' ', $sdet['inn_date']);
															$meal_rep = str_replace('Rp', '', $sdet['meal_allowance_nominal']);
															$meal_rep1 = str_replace(',00', '', $meal_rep);
															$meal_rep2 = str_replace('.', '', $meal_rep1);

															$acc_rep = str_replace('Rp', '', $sdet['acomodation_allowance_nominal']);
															$acc_rep1 = str_replace(',00', '', $acc_rep);
															$acc_rep2 = str_replace('.', '', $acc_rep1);

															$ush_rep = str_replace('Rp', '', $sdet['ush_nominal']);
															$ush_rep1 = str_replace(',00', '', $ush_rep);
															$ush_rep2 = str_replace('.', '', $ush_rep1);

															$total = $meal_rep2+$acc_rep2+$ush_rep2;
																$group_name ='-';
															foreach ($GroupUSH as $grp) {
																if ($sdet['group_id'] == $grp['group_id']) {
																	$group_name = $grp['group_name'];
																}
															}
													?>
													<tr>
														<td></td>
														<td><?php echo $inn_date[0] ?></td>
														<td><?php echo $sdet['time_name'] ?></td>
														<td style="text-align: right">Rp<?php echo number_format($meal_rep2 , 2, '.', ',') ?></td>
														<td style="text-align: right">Rp<?php echo number_format($acc_rep2 , 2, '.', ',') ?></td>
														<td><?php echo $group_name ?></td>
														<td style="text-align: right">Rp<?php echo number_format($ush_rep2 , 2, '.', ',') ?></td>
														<td style="text-align: right">Rp<?php echo number_format($total , 2, '.', ',') ?></td>
													</tr>
													<?php
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="3">Total</td>
														<td style="text-align: right">-</td>
														<td style="text-align: right">-</td>
														<td></td>
														<td style="text-align: right">-</td>
														<td style="text-align: right">-</td>
													</tr>
												</tfoot>
											</table>
											<table width="100%">
												<tr>
													<td colspan="8">
														<center>
															<a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
															<button style="margin: 10px; width: 100px;" class="btn btn-primary">Save</button>
														</center>
													</td>
												</tr>
											</table>
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