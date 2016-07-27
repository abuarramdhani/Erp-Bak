	<section class="content-header">
		<h1>
			Quick Outstation Realization
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
										<form method="post" action="<?php echo base_url('Outstation/realization/new/save') ?>">
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
													<td>Destination</td>
													<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($Area as $ar){?>
																<option value="<?php echo $ar['area_id'] ?>"><?php echo $ar['area_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Employee Name</td>
													<td><p id="employee_name">-</p></td>
													<td>City Type</td>
													<td><select id="citytype" name="txt_city_type_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($CityType as $ci){?>
																<option value="<?php echo $ci['city_type_id'] ?>"><?php echo $ci['city_type_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Section</td>
													<td><p id="section_name">-</p></td>
													<td>Depart</td>
													<td><input type="text" name="txt_depart" class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Unit</td>
													<td><p id="unit_name">-</p></td>
													<td>Return</td>
													<td><input type="text" name="txt_return" class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Departemen</td>
													<td><p id="department_name">-</p></td>
													<td>Bon</td>
													<td><input id="txt_bon" type="text" name="txt_bon" class="form-control input_money" required></td>
												</tr>
												<tr>
													<td colspan="4">
														<center>
															<a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
															<a style="margin: 10px; width: 100px;" onclick="location.reload()" class="btn btn-primary">Reset</a>
															<span id="submit-realization" style="margin: 10px; width: 100px;" class="btn btn-primary">Process</span>
														</center>
													</td>
												</tr>
											</table>
										<label>Estimate Allowance</label>
										<div class="row2">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-7">
														Meal Allowance
													</div>
													<div class="col-md-5">
														<p id="meal-estimate">Rp0,00</p>
													</div>
												</div>
												<div class="row">
													<div class="col-md-7">
														Accomodation Allowance
													</div>
													<div class="col-md-5">
														<p id="accomodation-estimate">Rp0,00</p>
													</div>
												</div>
												<div class="row">
													<div class="col-md-7">
														 USH
													</div>
													<div class="col-md-5">
														<p id="ush-estimate">Rp0,00</p>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-5">
														Total Estimated
													</div>
													<div class="col-md-5">
														<p id="total-estimate">Rp0,00</p>
													</div>
												</div>
											</div>
										</div>
										<div class="row2">
											<div class="col-md-12">
												<span id="add-row" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i></span>
											</div>
										</div>
										<table id="realization_detail" class="table table-bordered table-striped table-hover">
											<thead>
												<tr class="bg-primary">
													<th width="5%">No</th>
													<th>Component</th>
													<th>Info</th>
													<th>Qty</th>
													<th>Nominal</th>
													<th>Total</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td></td>
													<td>
														<select name="txt_component_id[]"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($Component as $comp){?>
																<option value="<?php echo $comp['component_id'] ?>"><?php echo $comp['component_name'] ?></option>
															<?php } ?>
														</select>
													</td>
													<td><input type="text" name="txt_info[]" /></td>
													<td><input type="text" name="txt_qty[]" /></td>
													<td><input type="text" name="txt_nominal[]" /></td>
													<td><input type="text" name="txt_total[]" /></td>
													<td><span class="btn btn-primary btn-sm delete-row"><i class="fa fa-minus"></i></span></td>
												</tr>
												<tr>
													<td></td>
													<td><input type="text" name="txt_component[]" /></td>
													<td><input type="text" name="txt_info[]" /></td>
													<td><input type="text" name="txt_qty[]" /></td>
													<td><input type="text" name="txt_nominal[]" /></td>
													<td><input type="text" name="txt_total[]" /></td>
													<td><span class="btn btn-primary btn-sm delete-row"><i class="fa fa-minus"></i></span></td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="5" style="text-align: right">Total Estimate Allowance</td>
													<td>xxxxx</td>
													<td></td>
												</tr>
											</tfoot>
										</table>
										<table width="100%">
											<tr>
												<td colspan="8">
													<center>
														<a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
														<a style="margin: 10px; width: 100px;" onclick="location.reload()" class="btn btn-primary">Reset</a>
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