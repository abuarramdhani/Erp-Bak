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
													<td><select id="area" name="txt_city_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu" required>
															<option value=""></option>
															<?php foreach($City as $ct){?>
																<?php
																	$selected = '';
																	if ($dsim['city_id'] == $ct['city_id']) {
																		$selected = 'selected';
																	}
																?>
																<option <?php echo $selected ?> value="<?php echo $ct['city_id'].'-'.$ct['area_id'].'-'.$ct['city_type_id'] ?>"><?php echo $ct['city_province'].' - '.$ct['city_name'] ?></option>
															<?php } ?>
														</select></td>
												</tr>
												<tr>
													<td>Section</td>
													<td><p id="section_name"><?php echo $dsim['section_name'] ?></p></td>
													<td>Depart</td>
													<td><input type="text" name="txt_depart" value="<?php echo $dsim['depart_time'] ?> " class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Unit</td>
													<td><p id="unit_name"><?php echo $dsim['unit_name'] ?></p></td>
													<td>Return</td>
													<td><input type="text" name="txt_return" value="<?php echo $dsim['return_time'] ?> " class="form-control date-picker" required></td>
												</tr>
												<tr>
													<td>Departemen</td>
													<td><p id="department_name"><?php echo $dsim['department_name'] ?></p></td>
													<td colspan="2"><input type="checkbox" name="acc_check" class="" value="1" <?php if($dsim['accomodation_option'] == 1){echo "checked";} ?> >&nbsp;&nbsp;  Include Accomodation Allowance</td>
												</tr>
												<tr>
													<td>Outstation Position</td>
													<td><p id="outstation-position"><?php echo $dsim['position_name'] ?><input type="hidden" name="txt_position_id" value="<?php echo $dsim['position_id'] ?>"></p></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td colspan="4">
														<center>
															<a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
															<span id="submit-simulation" style="margin: 10px; width: 100px;" class="btn btn-primary">Process</span>
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
											</table>
											<?php
													}
											?>
											<label>Simulation Table</label>
											<!--
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
											-->
													<?php
														$meal_pagi = 0;
														$meal_siang = 0;
														$meal_malam = 0;
														$nom_meal_pagi = 0;
														$nom_meal_siang = 0;
														$nom_meal_malam = 0;
														$acc_malam = 0;
														$nom_accomodation = 0;
														$total_ush = 0;

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

															$string = array('Rp',',00','.');
															//Meal
															if (strtolower($sdet['time_name']) == strtolower("Pagi")) {
																$meal_pagi++;
																$nom_meal_pagi = str_replace($string,'',$sdet['meal_allowance_nominal']);
															}
															if (strtolower($sdet['time_name']) == strtolower("Siang")) {
																$meal_siang++;
																$nom_meal_siang = str_replace($string,'',$sdet['meal_allowance_nominal']);
															}
															if (strtolower($sdet['time_name']) == strtolower("Malam")) {
																$meal_malam++;
																$nom_meal_malam = str_replace($string,'',$sdet['meal_allowance_nominal']);
															}
															//Accomodation
															if (strtolower($sdet['time_name']) == strtolower("Malam")) {
																$acc_malam++;
																$nom_accomodation = str_replace($string,'',$sdet['acomodation_allowance_nominal']);
															}
															//USH
															if ($sdet['group_id'] != NULL) {
																$total_ush = $total_ush+$sdet['ush_nominal'];
															}
														}
														$total_meal_pagi = $meal_pagi*$nom_meal_pagi;
														$total_meal_siang = $meal_siang*$nom_meal_siang;
														$total_meal_malam = $meal_malam*$nom_meal_malam;
														$total_meal = $total_meal_pagi+$total_meal_siang+$total_meal_malam;

														$total_acc = $acc_malam*$nom_accomodation;
														$total_all = $total_meal+$total_acc+$total_ush;
													?>
											<!--
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
											-->
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
																		<td align="right">Rp.<?php echo number_format($total_meal, 2, ',', '.');  ?></td>
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
																		<td><?php echo $acc_malam ?> Malam</td>
																		<td>&emsp;X&emsp;</td>
																		<td align="right">Rp.<?php if(!empty($nom_accomodation)){echo number_format($nom_accomodation, 2, ',', '.');}else{echo "0,00";}  ?></td>
																		<td>&emsp;=&emsp;</td>
																		<td align="right">Rp.<?php echo number_format($total_acc, 2, ',', '.');  ?></td>
																	</tr>
																	<tr>
																		<td colspan="3">Total Accomodation Allowance</td>
																		<td>&emsp;=&emsp;</td>
																		<td align="right">Rp.<?php echo number_format($total_acc, 2, ',', '.');  ?></td>
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
																<table>
									
																	<?php
																	$ush_id="";
																	$ush_count = 0;
																	foreach ($Simulation_detail as $sdet) {
																		if ($sdet['group_id'] != NULL) {
																			$group_name ='-';
																			foreach ($GroupUSH as $grp) {
																				if ($sdet['group_id'] == $grp['group_id']) {
																					$group_name = $grp['group_name'];
																				}
																			}
																			/*
																			$ush_nom = $sdet['ush_nominal'];
																			$ush_tot = $sdet['ush_nominal']*$ush_count;
																			echo'
																			<tr>
																				<td>'.$ush_count.' '.$group_name.'</td>
																				<td>&emsp;X&emsp;</td>
																				<td align="right">Rp.'.number_format($ush_nom , 2, ',', '.').'</td>
																				<td>&emsp;=&emsp;</td>
																				<td align="right">Rp.'.number_format($ush_tot , 2, ',', '.').'</td>
																			</tr>';
																			*/

																			if($group_name == $ush_id || $ush_id == ""){
																				$ush_count++;
																				$ush_name = $group_name;
																				$ush_nom = $sdet['ush_nominal'];
																				$ush_tot = $ush_count*$ush_nom;
																			}else{
																				echo'
																				<tr>
																					<td>'.$ush_count.' '.$ush_name.'</td>
																					<td>&emsp;X&emsp;</td>
																					<td align="right">Rp.'.number_format($ush_nom , 2, ',', '.').'</td>
																					<td>&emsp;=&emsp;</td>
																					<td align="right">Rp.'.number_format($ush_tot , 2, ',', '.').'</td>
																				</tr>';

																				$ush_count = 1;
																				$ush_name = $group_name;
																				$ush_nom = $sdet['ush_nominal'];
																				$ush_tot = $ush_count*$ush_nom;
																			}
																			$ush_id = $group_name;

																		}
																		$total_ush = $total_ush+$ush_tot;
																	}
																				echo'
																				<tr>
																					<td>'.$ush_count.' '.$ush_name.'</td>
																					<td>&emsp;X&emsp;</td>
																					<td align="right">Rp.'.number_format($ush_nom , 2, ',', '.').'</td>
																					<td>&emsp;=&emsp;</td>
																					<td align="right">Rp.'.number_format($ush_tot , 2, ',', '.').'</td>
																				</tr>';
																	?>

																	<tr>
																		<td colspan="3">Total USH Allowance</td>
																		<td>&emsp;=&emsp;</td>
																		<td>Rp. <?php echo number_format($total_ush, 2, ',', '.');  ?></td>
																	</tr>
																</table>
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
															<p id="total-estimate">Rp.<?php echo number_format($total_all, 2, ',', '.');  ?></p>
														</div>
													</div>
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