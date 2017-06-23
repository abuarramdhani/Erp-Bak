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
											<table class="table">
												<form method="post" action="<?php echo base_url('Outstation/simulation/new/save') ?>">
												<tr>
													<td width="15%">Employee</td>
													<td width="35%"><select id="txt_employee_id" name="txt_employee_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
															<option value=""></option>
															<?php foreach($Employee as $ed){?>
																<option value="<?php echo $ed['employee_id'] ?>"><?php echo $ed['employee_code'] ?></option>
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
													<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
															<option value=""></option>
															<?php foreach($Area as $ar){?>
																<option value="<?php echo $ar['area_id'] ?>"><?php echo $ar['area_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
												<td>Section</td>
													<td><p id="section_name">-</p></td>
													<td>City Type</td>
													<td><select id="citytype" name="txt_city_type_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
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
													<td><input id="txt_start_date"type="text" name="txt_depart" class="form-control" required></td>
												</tr>
												<tr>
												<td>Departemen</td>
													<td><p id="department_name">-</p></td>
													<td>Return</td>
													<td><input id="txt_end_date"type="text" name="txt_return" class="form-control" required></td>
												</tr>
												</form>
												<tr>
												<td colspan="4"><center><button style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</button><button style="margin: 10px; width: 100px;" onclick="location.reload()" class="btn btn-primary">Reset</button><button style="margin: 10px; width: 100px;" class="btn btn-primary">Process</button></center></td>
												</tr>
											</table>
										<label>Simulation Table</label>
										<table id="simulation_detail" class="table table-bordered table-striped table-hover">
											<thead>
												<tr class="bg-primary">
													<th width="5%">No</th>
													<th>Date</th>
													<th>Time</th>
													<th>Meal Allowance</th>
													<th>Accomodation Allowance</th>
													<th>Group</th>
													<th>USH</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
											<tfoot>
												<tr>
													<td colspan="3">Total</td>
													<td>-</td>
													<td>-</td>
													<td></td>
													<td>-</td>
													<td>-</td>
												</tr>
												<tr>
													<td colspan="8"><center><button style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</button><button style="margin: 10px; width: 100px;" onclick="location.reload()" class="btn btn-primary">Reset</button><button style="margin: 10px; width: 100px;" class="btn btn-primary">Save</button></center></td>
												
												</tr>
											</tfoot>
										</table>
									</div>
								</fieldset>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>