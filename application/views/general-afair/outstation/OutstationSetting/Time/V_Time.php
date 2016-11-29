
	<section class="content-header">
		<h1>
			Quick Outstation Time
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<a href="<?php echo base_url('Outstation/time/new') ?>" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> New</a>
				<div class="box box-primary" style="margin-top: 10px">
					<div class="table-responsive">
						<fieldset class="row2">
							<div class="box-body with-border">
								<div class="pull-right">
									<div class="form-group">
										<div class="checkbox">
											<label id="show_deleted_data">
												<input id="toggle_button" name="txt_checkbox" type="checkbox" value="/time/deleted-time"/>
												Deleted Time
											</label>
										</div>
									</div>
								</div>
								<div id="div_data_tables">
									<table id="data_table" class="table table-bordered table-striped table-hover">
										<thead>
											<tr class="bg-primary">
												<th width="10%"><center>No</center></th>
												<th><center>Time Name</center></th>
												<th width="20%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody id="table_content">
											<?php
												$no = 1;
												foreach ($data_time as $dt) {
											?>
											<tr>
												<td style="text-align: center"><?php echo $no++?></td>
												<td><?php echo $dt['time_name']?></td>
												<td style="text-align: center">
													<a class="btn btn-warning" href="<?php echo base_url('Outstation/time/edit/'.$dt['time_id'])?>"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_<?php echo $dt['time_id']?>"><i class="fa fa-times"></i> Delete</button>
													<div class="modal fade" id="delete_<?php echo $dt['time_id']?>">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header bg-primary">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title">Delete Time?</h4>
																</div>
																<div class="modal-body">
																	<p>Apakah Anda yakin akan menghapus data ini?</p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																	<button id="delete_button" type="button" data-dismiss="modal" data-toggle="modal" data-target="#delete_data" class="btn btn-danger" onClick="checkDelete('<?php echo base_url('Outstation/time/delete')?>','<?php echo $dt['time_id'] ?>')">Delete</button>
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