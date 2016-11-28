	<section class="content-header">
		<h1>
			uick Outstation City Type
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary" style="margin: 0 auto;width: 60%">
							<div class="box-body with-border">
								<form method="post" action="<?php echo base_url('Outstation/city-type/update') ?>">
									<?php foreach ($data_city_type as $dc) {?>
										<input type="hidden" name="txt_city_type_id" value="<?php echo $dc['city_type_id']?>" />
										<table class="table">
											<tr>
												<td width="25%">City Type</td>
												<td><input type="text" name="txt_city_type_name" maxlength="50" class="form-control" value ="<?php echo $dc['city_type_name']?>" required></td>
											</tr>
											<tr>
												<td>Start Date</td>
												<td><input type="text" id="txt_start_date" name="txt_start_date" class="form-control" value="<?php echo $dc['start_date']?>"></td>
											</tr>
											<tr>
												<td>End Date</td>
												<td><input type="text" id="txt_end_date" name="txt_end_date" class="form-control" value="<?php echo $dc['end_date']?>"></td>
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