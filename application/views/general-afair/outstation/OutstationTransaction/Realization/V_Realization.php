
	<section class="content-header">
		<h1>
			Quick Outstation Realization
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<a href="<?php echo base_url('Outstation/realization/new') ?>" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> New</a>
				<div class="box box-primary" style="margin-top: 10px">
					<div class="table-responsive">
						<fieldset class="row2">
							<div class="box-body with-border">
								<div class="pull-right">
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" />
												Deleted Realization
											</label>
										</div>
									</div>
								</div>
								<table id="data_table" class="table table-bordered table-striped table-hover">
									<thead>
										<tr class="bg-primary" style="text-align: center">
											<th width="10%" style="text-align: center">No</th>
											<th style="text-align: center">Employee</th>
											<th style="text-align: center">Destination</th>
											<th style="text-align: center">City Type</th>
											<th style="text-align: center">Depart</th>
											<th style="text-align: center">Return</th>
											<th style="text-align: center">BON</th>
											<th width="20%" style="text-align: center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 1;
											foreach ($data_realization as $dre) {
										?>
										<tr>
											<td><?php echo $no++?></td>
											<td><?php echo $dre['area_name']?></td>
											<td><?php echo $dre['city_type_name']?></td>
											<td><?php echo $dre['bon_nominal']?></td>
											<td>
												<a class="btn btn-warning" href="<?php echo base_url('Outstation/realization/edit/'.$dre['realization_id'])?>"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_<?php echo $dre['realization_id']?>"><i class="fa fa-times"></i> Delete</button>
												<div class="modal fade" id="delete_<?php echo $dre['accomodation_allowance_id']?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header bg-primary">
																<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<h4 class="modal-title">Delete Realization Allowance?</h4>
															</div>
															<div class="modal-body">
																<p>Apakah Anda yakin akan menghapus data ini?</p>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																<a href="<?php echo base_url('Outstation/realization/delete/'.$dre['realization_id'])?>" id="delete_button"  class="btn btn-danger">Delete</a>
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
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</section>