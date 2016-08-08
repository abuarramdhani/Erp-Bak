	<section class="content-header">
		<h1>
			Quick Outstation Area
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary" style="margin: 0 auto;width: 60%">
							<div class="box-body with-border">
								<form method="post" action="<?php echo base_url('Outstation/employee-position/update') ?>">
									<?php foreach ($data_employee_position as $dp) {?>
										<input type="hidden" name="txt_employee_id" value="<?php echo $dp['employee_id']?>" />
										<table class="table">
											<tr>
												<td width="25%">Employee Code</td>
												<td><?php echo $dp['employee_code'] ?></td>
											</tr>
											<tr>
												<td>Name</td>
												<td><?php echo $dp['employee_name'] ?></td>
											</tr>
											<tr>
												<td>Outstation Position</td>
												<td>
													<select id="position" name="txt_position_id"  class="form-control select2" style="width: 100%" data-placeholder="Pilih Salah Satu">
													<option value=""></option>
													<?php foreach($Position as $pos){?>
														<?php
															$selected = '';
															if ($dp['outstation_position'] == $pos['position_id']) {
																$selected = 'selected';
															}
														?>
														<option <?php echo $selected?> value="<?php echo $pos['position_id'] ?>"><?php echo $pos['position_name'] ?></option>
													<?php } ?>
												</select>
												</td>
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