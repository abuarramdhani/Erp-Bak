
	<section class="content-header">
		<h1>
			Quick Outstation Position
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-primary" style="margin-top: 10px">
					<div class="table-responsive">
						<fieldset class="row2">
							<div class="box-body with-border">
								<table id="employee_position_table" class="table table-bordered table-striped table-hover" width="100%">
									<thead style="background-color: #3c8dbc; color: #fff;">
										<tr class="bg-primary">
											<th width="10%"><center>No</center></th>
											<th width="15%"><center>Employee Code</center></th>
											<th><center>Name</center></th>
											<th><center>Outstation Position</center></th>
											<th width="15%"><center>Marketing Status</center></th>
											<th width="10%"><center>Action</center></th>
										</tr>
									</thead>
									<!--
									<tbody>
										<?php
											$no = 1;
											foreach ($data_employee_position as $dp) {
												if ($dp['outstation_position'] > 0) {
													$position = $dp['position_name'];
														$marketing = $dp['marketing_status'];
												}
												else{
													$position = '-';
													$marketing = '-';
												}
										?>
										<tr>
											<td style="text-align: center"><?php echo $no++?></td>
											<td><?php echo $dp['employee_code']?></td>
											<td><?php echo $dp['employee_name']?></td>
											<td><?php echo $position?></td>
											<td style="text-align: center"><?php echo $marketing?></td>
											<td style="text-align: center">
												<a class="btn btn-warning" href="<?php echo base_url('Outstation/employee-position/edit/'.$dp['employee_id'])?>"><i class="fa fa-edit"></i> Edit</a>
											</td>
										</tr>
										<?php }?>
									</tbody>
									-->
									<tbody>
										
									</tbody>
								</table>
								<div class="modal fade text-center" id="delete_data">
									<div class="modal-dialog">
										<div class="modal-content" id="delete_type">
									
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</section>