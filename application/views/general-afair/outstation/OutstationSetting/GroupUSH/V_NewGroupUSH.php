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
								<form method="post" action="<?php echo base_url('Outstation/group-ush/new/save') ?>">
									<table class="table">
										<tr>
											<td width="20%">Group Name</td>
											<td><input type="text" name="txt_group_name" maxlength="1" class="form-control" required></td>
										</tr>
										<tr>
											<td>Holiday</td>
											<td><input type="checkbox" name="checkbox_holiday"></td>
										</tr>
										<tr>
											<td>Foreign</td>
											<td><input type="checkbox" name="checkbox_foreign"></td>
										</tr>
										<tr>
											<td>From</td>
											<td>
												<div class="bootstrap-timepicker timepicker">
													<input name="txt_time_from" type="text" class="form-control input-small time-pickers" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<td>To</td>
											<td>
												<div class="bootstrap-timepicker timepicker">
													<input name="txt_time_to" type="text" class="form-control input-small time-pickers" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<td>Start Date</td>
											<td><input type="text" id="txt_start_date" name="txt_start_date" class="form-control" required></td>
										</tr>
										<tr>
											<td>End Date</td>
											<td><input type="text" id="txt_end_date" name="txt_end_date" class="form-control" required></td>
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
								</form>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>