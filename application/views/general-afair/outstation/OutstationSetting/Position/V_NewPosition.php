	<section class="content-header">
		<h1>
			Quick Outstation Position
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary" style="margin: 0 auto;width: 60%">
							<div class="box-body with-border">
								<form method="post" action="<?php echo base_url('Outstation/position/new/save') ?>">
									<table class="table">
										<tr>
											<td width="20%">Position Name</td>
											<td><input type="text" name="txt_position_name" class="form-control" required></td>
										</tr>
										<tr>
											<td width="20%">Marketing Status</td>
											<td><input type="checkbox" name="checkbox_marketing_status"></td>
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