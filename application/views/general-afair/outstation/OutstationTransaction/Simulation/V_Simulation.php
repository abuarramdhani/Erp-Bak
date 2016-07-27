
	<section class="content-header">
		<h1>
			Quick Outstation Simulation
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<a href="<?php echo base_url('Outstation/simulation/new') ?>" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> New</a>
				<div class="box box-primary" style="margin-top: 10px">
					<div class="table-responsive">
						<fieldset class="row2">
							<div class="box-body with-border">
								<div class="pull-right">
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" />
												Deleted Simulation
											</label>
										</div>
									</div>
								</div>
								<table id="data_table" class="table table-bordered table-striped table-hover">
									<thead style="background-color: #3c8dbc; color: #fff;">
										<tr class="bg-primary">
											<th width="5%" style="text-align: center">No</th>
											<th style="text-align: center">Employee</th>
											<th style="text-align: center">Destination</th>
											<th style="text-align: center">City Type</th>
											<th style="text-align: center">Depart</th>
											<th style="text-align: center">Return</th>
											<th style="text-align: center">Total</th>
											<th width="25%" style="text-align: center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 1;
											foreach ($data_simulation as $dsim) {
												$meal_nominal = $dsim['meal_nominal'];
												$acc_nominal = $dsim['accomodation_nominal'];
												$ush_nominal = $dsim['ush_nominal'];

												$meal_rep = str_replace('Rp', '', $meal_nominal);
												$meal_rep1 = str_replace(',00', '', $meal_rep);
												$meal_rep2 = str_replace('.', '', $meal_rep1);

												$acc_rep = str_replace('Rp', '', $acc_nominal);
												$acc_rep1 = str_replace(',00', '', $acc_rep);
												$acc_rep2 = str_replace('.', '', $acc_rep1);

												$ush_rep = str_replace('Rp', '', $ush_nominal);
												$ush_rep1 = str_replace(',00', '', $ush_rep);
												$ush_rep2 = str_replace('.', '', $ush_rep1);

												$total = $meal_rep2+$acc_rep2+$ush_rep2;
										?>
										<tr>
											<td><?php echo $no++?></td>
											<td><?php echo $dsim['employee_name']?></td>
											<td><?php echo $dsim['area_name']?></td>
											<td><?php echo $dsim['city_type_name']?></td>
											<td><?php echo $dsim['depart_time']?></td>
											<td><?php echo $dsim['return_time']?></td>
											<td>Rp<?php echo number_format($total , 2, ',', '.') ?></td>
											<td style="text-align: center">
												<a class="btn btn-warning" href="<?php echo base_url('Outstation/simulation/edit/'.$dsim['simulation_id'])?>"><i class="fa fa-edit"></i> Edit</a>
												<button class="btn btn-danger" data-toggle="modal" data-target="#delete_<?php echo $dsim['simulation_id']?>"><i class="fa fa-times"></i> Delete</button>
													<div class="modal fade" id="delete_<?php echo $dsim['simulation_id']?>">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header bg-primary">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title">Delete Simulation Allowance?</h4>
																</div>
																<div class="modal-body">
																	<p>Apakah Anda yakin akan menghapus data ini?</p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																	<a href="<?php echo base_url('Outstation/simulation/delete/'.$dsim['simulation_id'])?>" id="delete_button"  class="btn btn-danger">Delete</a>
																</div>
															</div>
														</div>
													</div>
												<a class="btn btn-primary" href="<?php echo base_url('Outstation/simulation/print/'.$dsim['simulation_id'])?>"><i class="fa fa-print"></i> Print</a>
											</td>
										</tr>
										<?php
											}
										?>
									</tbody>
								</table>
								
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</section>