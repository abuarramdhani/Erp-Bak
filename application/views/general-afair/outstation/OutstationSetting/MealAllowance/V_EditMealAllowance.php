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
								<form method="post" action="<?php echo base_url('Outstation/meal-allowance/update') ?>">
									<?php foreach ($data_meal_allowance as $dma) {?>
										<input type="hidden" name="txt_meal_id" value="<?php echo $dma['meal_allowance_id']?>">
										<table class="table">
											<tr>
												<td width="20%">Position</td>
												<td><select id="position" name="txt_position_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
													<option value=""></option>
													<?php foreach($position_data as $pd){?>
														<?php $position_selected='';
														if ($dma['position_id'] ==$pd['position_id']){
															$position_selected ='selected';
														}
														?>
														<option <?php echo $position_selected?> value="<?php echo $pd['position_id'] ?>"><?php echo $pd['position_name'] ?></option>
													<?php } ?>
												</select></td>
											<tr>
												<td>Area</td>
												<td><select id="area" name="txt_area_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
													<option value=""></option>
													<?php foreach($area_data as $ad){?>
														<?php $area_selected='';
														if ($dma['area_id'] ==$ad['area_id']){
															$area_selected ='selected';
														}
														?>
														<option <?php echo $area_selected?> value="<?php echo $ad['area_id'] ?>"><?php echo $ad['area_name'] ?></option>
													<?php } ?>
												</select></td>
											</tr>
											<tr>
												<td width="20%">Time</td>
												<td><select id="time" name="txt_time_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
													<option value=""></option>
													<?php foreach($time_data as $ct){?>
														<?php $area_selected='';
														if ($dma['time_id'] ==$ct['time_id']){
															$area_selected ='selected';
														}
														?>
														<option <?php echo $area_selected?> value="<?php echo $ct['time_id'] ?>"><?php echo $ct['time_name'] ?></option>
													<?php } ?>
												</select></td>
											</tr>
											<tr>
												<td width="20%">Nominal</td>
												<td><input type="text" name="txt_nominal" class="form-control" value ="<?php echo $dma['nominal']?>" required></td>
											</tr>
											<tr>
												<td>Start Date</td>
												<td><input type="text" id="txt_start_date" name="txt_start_date" class="form-control" value="<?php echo $dma['start_date']?>"></td>
											</tr>
											<tr>
												<td>End Date</td>
												<td><input type="text" id="txt_end_date" name="txt_end_date" class="form-control" value="<?php echo $dma['end_date']?>"></td>
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