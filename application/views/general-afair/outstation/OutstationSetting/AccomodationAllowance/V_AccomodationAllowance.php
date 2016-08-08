
	<section class="content-header">
		<h1>
			Quick Outstation Accomodation Allowance
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<a href="<?php echo base_url('Outstation/accomodation-allowance/new') ?>" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> New</a>
				<div class="box box-primary" style="margin-top: 10px">
					<div class="table-responsive">
						<fieldset class="row2">
							<div class="box-body with-border">
								<div class="pull-right">
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" />
												Deleted Accomodation Allowance
											</label>
										</div>
									</div>
								</div>
								<div id="div_data_tables">
									<table id="data_table" class="table table-bordered table-striped table-hover">
										<thead>
											<tr class="bg-primary">
												<th width="10%"><center>No</center></th>
												<th><center>Position</center></th>
												<th><center>Area</center></th>
												<th><center>City Type</center></th>
												<th><center>Nominal</center></th>
												<th width="20%">Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php
												$no = 1;
												foreach ($data_accomodation_allowance as $dac) {
											?>
											<tr>
												<td style="text-align: center"><?php echo $no++?></td>
												<td><?php echo $dac['position_name']?></td>
												<td><?php echo $dac['area_name']?></td>
												<td><?php echo $dac['city_type_name']?></td>
												<td>Rp<?php echo number_format($dac['nominal'],2,',','.')?></td>
												<td style="text-align: center">
													<a class="btn btn-warning" href="<?php echo base_url('Outstation/accomodation-allowance/edit/'.$dac['accomodation_allowance_id'])?>"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_<?php echo $dac['accomodation_allowance_id']?>"><i class="fa fa-times"></i> Delete</button>
													<div class="modal fade" id="delete_<?php echo $dac['accomodation_allowance_id']?>">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header bg-primary">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title">Delete Accomodation Allowance?</h4>
																</div>
																<div class="modal-body">
																	<p>Apakah Anda yakin akan menghapus data ini?</p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																	<a href="<?php echo base_url('Outstation/accomodation-allowance/delete/'.$dac['accomodation_allowance_id'])?>" id="delete_button"  class="btn btn-danger">Delete</a>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
										<?php }?>
										</tbody>
									</table>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</section>