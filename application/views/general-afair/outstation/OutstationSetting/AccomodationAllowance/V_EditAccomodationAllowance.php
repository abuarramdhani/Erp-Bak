	<section class="content-header">
		<h1>
			Quick Outstation Accomodation Allowance
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary" style="margin: 0 auto;width: 60%">
							<div class="box-body with-border">
								<form method="post" action="<?php echo base_url('Outstation/accomodation-allowance/update') ?>">
									<?php foreach ($data_accomodation_allowance as $dac) { ?>
										<input type="hidden" name="txt_accomodation_id" value="<?php echo $dac['accomodation_allowance_id'] ?>">
										<table class="table">
											<tr>
												<td width="20%">Position</td>
												<td><select id="position" name="txt_position_id"  class="form-control select2" style="width: 100%" data-placeholder="position">
													<option value=""></option>
													<?php foreach($position_data as $pd){?>
														<?php $position_selected='';
														if ($dac['position_id'] ==$pd['position_id']){
															$position_selected ='selected';
														}
														?>
														<option <?php echo $position_selected?> value="<?php echo $pd['position_id'] ?>"><?php echo $pd['position_name'] ?></option>
													<?php } ?>
												</select></td>
											<tr>
												<td>Area</td>
												<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="area">
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
												<td><select id="citytype" name="txt_city_type_id"  class="form-control select2" style="width: 100%" data-placeholder="citytype">
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
												<td width="20%">Nominal</td>
												<td><input type="text" name="txt_nominal" class="form-control" value ="<?php echo $dac['nominal']?>" required></td>
											</tr>
											<tr>
												<td>Start Date</td>
												<td><input type="text" id="txt_start_date" name="txt_start_date" class="form-control" value="<?php echo $dac['start_date']?>"></td>
											</tr>
											<tr>
												<td>End Date</td>
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
								
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>