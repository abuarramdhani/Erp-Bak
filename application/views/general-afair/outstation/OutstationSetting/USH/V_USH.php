
	<section class="content-header">
		<h1>
			Quick Outstation USH
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<a href="<?php echo base_url('Outstation/ush/new') ?>" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> New</a>
				<div class="box box-primary" style="margin-top: 10px">
					<div class="table-responsive">
						<fieldset class="row2">
							<div class="box-body with-border">
								<div class="pull-right">
									<div class="form-group">
										<div class="checkbox">
											<label id="show_deleted_data">
												<input id="toggle_button" name="txt_checkbox" type="checkbox" value="/ush/deleted-ush"/>
												Deleted USH
											</label>
										</div>
									</div>
								</div>
								<div id="div_data_tables">
									<table id="ush_table" class="table table-bordered table-striped table-hover" width="100%">
										<thead>
											<tr class="bg-primary">
												<th width="10%"><center>No</center></th>
												<th width="25%"><center>Position</center></th>
												<th width="15%"><center>Group</center></th>
												<th width="30%"><center>Nominal</center></th>
												<th width="20%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody id="table_content">
											
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