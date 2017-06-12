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
													<td width="20%">Employee</td>
													<td><select id="txt_employee_id" name="txt_employee_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
															<option value=""></option>
															<?php foreach($Employee as $ed){?>
																<option value="<?php echo $ed['employee_id'] ?>"><?php echo $ed['employee_code'] ?></option>
															<?php } ?>
														</select></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td>ID Employee</td>
													<td>J1161</td>
													<td>Destination</td>
													<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
															<option value=""></option>
															<?php foreach($Area as $ar){?>
																<option value="<?php echo $ar['area_id'] ?>"><?php echo $ar['area_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Employee Name</td>
													<td>KHOERUL AMRI</td>
													<td>City Type</td>
													<td><select id="citytype" name="txt_city_type_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
															<option value=""></option>
															<?php foreach($CityType as $ci){?>
																<option value="<?php echo $ci['city_type_id'] ?>"><?php echo $ci['city_type_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Section</td>
													<td>ICT</td>
													<td>Depart</td>
													<td><input id="txt_start_date"type="text" name="txt_depart" class="form-control" required></td>
												</tr>
												<tr>
													<td>Unit</td>
													<td>ICT</td>
													<td>Return</td>
													<td><input id="txt_end_date"type="text" name="txt_return" class="form-control" required></td>
												</tr>
												<tr>
													<td>Departemen</td>
													<td>Keuangan</td>
													<td>Bon</td>
													<td><input id="txt_bon"type="text" name="txt_bon" class="form-control" required></td>
												</tr>
												<tr>
													<td colspan="4"><center><button onclick="window.history.back()" class="btn btn-primary">back</button>&nbsp;&nbsp;&nbsp;<button onclick="location.reload()" class="btn btn-primary">reset</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-primary">process</button></center></td>
												</tr>
											</table>
										</form>
										<label>Estimate Allowance</label>
										<table>
											<tr>
												<td width="200px">Meal Allowance</td>
												<td>xxxxx</td><td width="30px"></td>
												<td width="200px">Total Estimate Allowance</td>
												<td>xxxxx</td>
											</tr>
											<tr>
												<td>Accomodation Allowance</td>
												<td>xxxxx</td>
											</tr>
											<tr>
												<td>USH</td>
												<td>xxxxx</td>
											</tr>
										</table>
										<br>
										<br>
										<table id="data-realization" class="table table-bordered table-striped table-hover">
											<thead>
												<tr class="bg-primary">
													<th width="10%">No</th>
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
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="5" style="text-align: right">Total Estimate Allowance</td>
													<td>xxxxx</td>
													<td></td>
												</tr>
												<tr>
													<td colspan="8"><center><button onclick="window.history.back()" class="btn btn-primary">back</button>&nbsp;&nbsp;&nbsp;<button onclick="location.reload()" class="btn btn-primary">reset</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-primary">save</button></center></td>
												
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