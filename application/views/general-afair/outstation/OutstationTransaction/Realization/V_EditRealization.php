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
										<form method="post" id="realization-form" action="<?php echo base_url('Outstation/realization/update') ?>">
											<table class="table">
											<?php
												foreach($data_realization as $drel){
											?>
												<input type="hidden" name="txt_realization_id" value="<?php echo $drel['realization_id'] ?>" />
												<tr>
													<td width="15%">Employee</td>
													<td width="35%"><select id="txt_employee_id" name="txt_employee_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($Employee as $ed){?>
																<?php
																	$selected = '';
																	if ($drel['employee_id'] == $ed['employee_id']) {
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
													<td><p id="employee_code"><?php echo $drel['employee_code'] ?></p></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td>Employee Name</td>
													<td><p id="employee_name"><?php echo $drel['employee_name'] ?></p></td>
													<td>Destination</td>
													<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($Area as $ar){?>
																<?php
																	$selected = '';
																	if ($drel['area_id'] == $ar['area_id']) {
																		$selected = 'selected';
																	}
																?>
																<option <?php echo $selected ?> value="<?php echo $ar['area_id'] ?>"><?php echo $ar['area_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Section</td>
													<td><p id="section_name"><?php echo $drel['section_name'] ?></p></td>
													<td>City Type</td>
													<td><select id="citytype" name="txt_city_type_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($CityType as $ci){?>
																<?php
																	$selected = '';
																	if ($drel['city_type_id'] == $ci['city_type_id']) {
																		$selected = 'selected';
																	}
																?>
																<option <?php echo $selected ?> value="<?php echo $ci['city_type_id'] ?>"><?php echo $ci['city_type_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Unit</td>
													<td><p id="unit_name"><?php echo $drel['unit_name'] ?></p></td>
													<td>Depart</td>
													<td><input type="text" name="txt_depart" value="<?php echo $drel['depart_time'] ?> " class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Departemen</td>
													<td><p id="department_name"><?php echo $drel['department_name'] ?></p></td>
													<td>Return</td>
													<td><input type="text" name="txt_return" value="<?php echo $drel['return_time'] ?> " class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Outstation Position</td>
													<td><p id="outstation-position"><?php echo $drel['position_name'] ?><input type="hidden" name="txt_position_id" value="<?php echo $drel['position_id'] ?>"></p></td>
													<td>Bon</td>
													<td><input  id="txt_bon" type="text" name="txt_bon" value="<?php echo str_replace(',00', '', $drel['bon_nominal']); ?> " class="form-control input_money" required></td>
												</tr>
												<tr>
													<td colspan="4">
														<center>
															<a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
															<span id="submit-realization" style="margin: 10px; width: 100px;" class="btn btn-primary">Process</span>
														</center>
													</td>
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
											<?php
													}
											?>
											</table>
										<label>Estimate Allowance</label>
										<div class="row2" id="estimate-allowance">
											<div class="col-md-6">
												<div class="row" style="margin-bottom: 10px;">
													<div class="col-md-4">
														Meal
													</div>
													<div class="col-md-8">
														<div class="row">
															<table>
																<tr>
																	<td><?php echo $meal_pagi ?> Pagi</td>
																	<td>&emsp;X&emsp;</td>
																	<td>Rp.<?php if(!empty($nom_meal_pagi)){echo number_format($nom_meal_pagi, 2, ',', '.');}else{echo "0,00";} ?></td>
																	<td>&emsp;=&emsp;</td>
																	<td align="right">Rp.<?php if(!empty($nom_meal_pagi)){echo number_format($total_meal_pagi, 2, ',', '.');}else{echo "0,00";}  ?></td>
																</tr>
																<tr>
																	<td><?php echo $meal_siang ?> Siang</td>
																	<td>&emsp;X&emsp;</td>
																	<td>Rp.<?php if(!empty($nom_meal_siang)){echo number_format($nom_meal_siang, 2, ',', '.');}else{echo "0,00";}  ?></td>
																	<td>&emsp;=&emsp;</td>
																	<td align="right">Rp.<?php if(!empty($nom_meal_siang)){echo number_format($total_meal_siang, 2, ',', '.');}else{echo "0,00";}  ?></td>
																</tr>
																<tr>
																	<td><?php echo $meal_malam ?> Malam</td>
																	<td>&emsp;X&emsp;</td>
																	<td>Rp.<?php if(!empty($nom_meal_malam)){echo number_format($nom_meal_malam, 2, ',', '.');}else{echo "0,00";}  ?></td>
																	<td>&emsp;=&emsp;</td>
																	<td align="right">Rp.<?php if(!empty($nom_meal_malam)){echo number_format($total_meal_malam, 2, ',', '.');}else{echo "0,00";}  ?></td>
																</tr>
																<tr>
																	<td colspan="3">Total Meal Allowance</td>
																	<td>&emsp;=&emsp;</td>
																	<td align="right"><?php echo $total_meal  ?></td>
																</tr>
															</table>
														</div>
													</div>
												</div>
												<div class="row" style="margin-bottom: 10px;">
													<div class="col-md-4">
														Accomodation
													</div>
													<div class="col-md-8">
														<div class="row">
															<table>
																<tr>
																	<td><?php echo $meal_malam ?> Malam</td>
																	<td>&emsp;X&emsp;</td>
																	<td align="right">Rp.<?php if(!empty($nom_inn_malam)){echo number_format($nom_inn_malam, 2, ',', '.');}else{echo "0,00";}  ?></td>
																	<td>&emsp;=&emsp;</td>
																	<td align="right"><?php echo $total_acc  ?></td>
																</tr>
																<tr>
																	<td colspan="3">Total Accomodation Allowance</td>
																	<td>&emsp;=&emsp;</td>
																	<td align="right"><?php echo $total_acc  ?></td>
																</tr>
															</table>
														</div>
													</div>
												</div>
												<div class="row" style="margin-bottom: 10px;">
													<div class="col-md-4">
														 USH
													</div>
													<div class="col-md-8">
														<div class="row">
															<p id="ush-estimate"><?php echo $total_ush  ?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row" style="margin-bottom: 10px;">
													<div class="col-md-4">
														Total Estimated
													</div>
													<div class="col-md-8">
														<p id="total-estimate"><?php echo $total_all  ?></p>
													</div>
												</div>
											</div>
										</div>
										<div class="row2">
											<div class="col-md-12">
											<table id="realization_detail" class="table table-bordered table-striped table-hover">
												<thead>
													<tr class="bg-primary">
														<th width="30%"><center>Component</center></th>
														<th width="25%"><center>Info</center></th>
														<th width="10%"><center>Qty</center></th>
														<th width="15%"><center>Nominal</center></th>
														<th width="15%"><center>Total</center></th>
														<th width="5%"><center><span id="add-row" class="btn btn-primary btn-sm pull-right" style="margin-right: 10px;"><i class="fa fa-plus"></i></span></center></th>
													</tr>
												</thead>
												<tbody>
													<?php 
														foreach ($data_realization_detail as $real_det) {
													?>
														<tr class="multiRow">
															<td>
																<select name="txt_component[]" class="form-control select2-component" data-placeholder="Pilih Salah Satu!" style="width: 100%" required>
																	<option value=""></option>
																	<?php foreach($Component as $comp){ ?>
																		<?php
																			$selected = '';
																			if ($real_det['component_id'] == $comp['component_id']) {
																				$selected = 'selected';
																			}
																		?>
																		<option <?php echo $selected ?> value="<?php echo $comp['component_id'] ?>"><?php echo $comp['component_name'] ?></option>
																	<?php } ?>
																</select>
															</td>
															<td><input type="text" name="txt_info[]" class="form-control" value="<?php echo $real_det['info'] ?>" required/></td>
															<td><input type="number" onkeypress="return isNumberKeyAndComma(event)" name="txt_qty[]" class="form-control quantity" value="<?php echo $real_det['qty'] ?>" required/></td>
															<td>
															<input onkeypress="return isNumberKeyAndComma(event)" type="text" name="txt_component_nominal[]" class="form-control input_money nominal" value="Rp<?php echo number_format(str_replace(',00', '', $real_det['nominal']), 0,',','.')?>" required/>
															</td>
															<td><input style="text-align: right;" type="text" name="txt_total[]" class="form-control total-nominal" required readonly/></td>
															<td><span class="btn btn-primary btn-sm delete-row"><i class="fa fa-minus"></i></span></td>
														</tr>
													<?php
														} ?>
														<tr class="multiRow">
															<td>
																<select name="txt_component[]" class="form-control select2-component" data-placeholder="Pilih Salah Satu!" style="width: 100%" required>
																	<option value=""></option>
																	<?php foreach($Component as $comp){ ?>
																		<option value="<?php echo $comp['component_id'] ?>"><?php echo $comp['component_name'] ?></option>
																	<?php } ?>
																</select>
															</td>
															<td><input type="text" name="txt_info[]" class="form-control" value="" required/></td>
															<td><input type="number" onkeypress="return isNumberKeyAndComma(event)" name="txt_qty[]" class="form-control quantity" value="" required/></td>
															<td><input onkeypress="return isNumberKeyAndComma(event)" type="text" name="txt_component_nominal[]" class="form-control input_money nominal" value="" required/></td>
															<td><input style="text-align: right;" type="text" name="txt_total[]" class="form-control total-nominal" required readonly/></td>
															<td><span class="btn btn-primary btn-sm delete-row"><i class="fa fa-minus"></i></span></td>
														</tr>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="4" style="text-align: right">Total Estimate Allowance</td>
														<td style="text-align: right"><span id="total-final">Rp0,00</span></td>
														<td></td>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
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