	<section class="content-header">
		<h1>
			Quick Outstation Group USH
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary" style="margin: 0 auto;width: 60%">
							<div class="box-body with-border">
								<form method="post" action="<?php echo base_url('Outstation/group-ush/update') ?>">
									<?php foreach ($data_group_ush as $dgu) {?>
										<input type="hidden" name="txt_group_id" value="<?php echo $dgu['group_id']?>" />
										<table class="table">
											<tr>
												<td width="20%">Group Name</td>
												<td><input type="text" name="txt_group_name" maxlength="50" class="form-control" value ="<?php echo $dgu['group_name']?>" required></td>
											</tr>
											<tr>
												<td>Holiday</td>
												<td>
													<?php
														if($dgu['holiday'] == '1'){
															$checkbox = 'checked';
														}
														else{
															$checkbox = '';
														}
													?>
													<input type="checkbox" name="checkbox_holiday" <?php echo $checkbox; ?>>
												</td>
											</tr>
											<tr>
												<td>Foreign</td>
												<td>
													<?php
														if($dgu['foreign'] == '1'){
															$checkbox = 'checked';
														}
														else{
															$checkbox = '';
														}
													?>
													<input type="checkbox" name="checkbox_foreign" <?php echo $checkbox; ?>>
												</td>
											</tr>
											<tr>
											<td>From</td>
												<td>
													<div class="bootstrap-timepicker timepicker">
														<input name="txt_time_from" type="text" class="form-control input-small time-pickers" value ="<?php echo $dgu['time_1']?>" readonly>
													</div>
												</td>
											</tr>
											<tr>
												<td>To</td>
												<td>
													<div class="bootstrap-timepicker timepicker">
														<input name="txt_time_to" type="text" class="form-control input-small time-pickers" value ="<?php echo $dgu['time_2']?>" readonly>
													</div>
												</td>
											</tr>
											<tr>
												<td>Start Date</td>
												<td><input type="text" id="txt_start_date" name="txt_start_date" class="form-control" value="<?php echo $dgu['start_date']?>"></td>
											</tr>
											<tr>
												<td>End Date</td>
												<td><input type="text" id="txt_end_date" name="txt_end_date" class="form-control" value="<?php echo $dgu['end_date']?>"></td>
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