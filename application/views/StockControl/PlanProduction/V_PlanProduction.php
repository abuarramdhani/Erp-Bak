<section class="content-header">
	<a class="btn btn-default pull-right" href="<?php echo base_url('StockControl/plan-production/insert')?>">
		<span class="fa fa-plus" aria-hidden="true"></span> NEW
	</a>
	<h1>
		Plan Production
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<table id="data_table" class="table table-hover table-bordered table-striped">
						<thead class="bg-primary">
							<tr>
								<th width="10%"><center>No</center></th>
								<th width="30%"><center>Plan Date</center></th>
								<th width="30%"><center>Plan QTY</center></th>
								<th width="30%"><center>Action</center></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no = 1;
								foreach ($plan_production as $pp) {
							?>
							<tr>
								<td style="text-align: center"><?php echo $no ?></td>
								<td><?php echo $pp['plan_date'] ?></td>
								<td style="text-align: center"><?php echo $pp['qty_plan'] ?></td>
								<td style="text-align: center">
									<a data-toggle="tooltip" data-placement="top" title="Edit" href="<?php echo base_url('StockControl/plan-production/edit/'.$pp['plan_id'])?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
									<button data-toggle="modal" data-target="#delete-<?php echo $no ?>" class="btn btn-default"><i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash-o"></i></button>
									<div class="modal fade" id="delete-<?php echo $no ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-primary">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title">Delete Area?</h4>
												</div>
												<div class="modal-body">
													<p>Apakah Anda yakin akan menghapus data ini?</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<a href="<?php echo base_url('StockControl/plan-production/delete/'.$pp['plan_id'])?>" class="btn btn-default">Delete</a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<?php 
								$no++;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>