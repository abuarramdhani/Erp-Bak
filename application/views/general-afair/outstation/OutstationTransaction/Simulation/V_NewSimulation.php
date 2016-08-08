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
										<form method="post" id="simulation-form" action="<?php echo base_url('Outstation/simulation/new/save') ?>">
											<table class="table">
												<tr>
													<td width="15%">Employee</td>
													<td width="35%"><select id="txt_employee_id" name="txt_employee_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($Employee as $ed){?>
																<option value="<?php echo $ed['employee_id'] ?>"><?php echo $ed['employee_code'] ?> - <?php echo $ed['employee_name'] ?></option>
															<?php } ?>
														</select></td>
													<td width="15%"></td>
													<td width="35%"></td>
												</tr>
												<tr>
													<td>ID Employee</td>
													<td><p id="employee_code">-</p></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td>Employee Name</td>
													<td><p id="employee_name">-</p></td>
													<td>Destination</td>
													<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($Area as $ar){?>
																<option value="<?php echo $ar['area_id'] ?>"><?php echo $ar['area_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Section</td>
													<td><p id="section_name">-</p>
													</td>
													<td>City Type</td>
													<td><select id="citytype" name="txt_city_type_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($CityType as $ci){?>
																<option value="<?php echo $ci['city_type_id'] ?>"><?php echo $ci['city_type_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Unit</td>
													<td><p id="unit_name">-</p></td>
													<td>Depart</td>
													<td><input type="text" name="txt_depart" class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Departemen</td>
													<td><p id="department_name">-</p></td>
													<td>Return</td>
													<td><input type="text" name="txt_return" class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Outstation Position</td>
													<td><p id="outstation-position">-</p></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td colspan="4"><center><a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a><a style="margin: 10px; width: 100px;" onclick="location.reload()" class="btn btn-primary">Reset</a><span id="submit-simulation" style="margin: 10px; width: 100px;" class="btn btn-primary">Process</span></center></td>
												</tr>
												<tr>
													<td colspan="4" style="text-align: center">
														<p id="errordiv">
														</p>
														<div id="loadAjax" class="progress" style="width:50%;margin: 0 auto;display:none">
															<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
																<span class="sr-only">Processing</span>
															</div>
														</div>
													</td>
												</tr>
											</table>
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
													<td colspan="8"><center><a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a><a style="margin: 10px; width: 100px;" onclick="location.reload()" class="btn btn-primary">Reset</a><button style="margin: 10px; width: 100px;" class="btn btn-primary">Save</button></center></td>
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