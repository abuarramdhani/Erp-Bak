<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Setting Approval Claim</b></h1>
						</div>
					</div>
					<div class="col-lg-1 ">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Setting/ApprovalClaim');?>">
								<i class="icon-wrench icon-2x"></i>
								<span ><br /></span>
							</a>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
						<a href="<?php echo site_url('CustomerRelationship/Setting/ApprovalClaim/Create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						Employee List
					</div>
					<div class="panel-body">
						<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
							<thead>
								<tr class="bg-primary">
									<th width="5%"><center>No</center></th>
									<th width="35%"><center>Employee Name</center></th>
									<th width="30%"><center>Branch</center></th>
									<th width="20%"><center>Status</center></th>
									<th width="10%"><center>Action</center></th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; foreach ($approval as $ac) { ?>
								<tr>
									<td align="center">
										<?php echo $no++; ?>
									</td>
									<td><?php echo $ac['employee_name']; ?></td>
									<td><?php echo $ac['location_name']; ?></td>
									<td><?php echo $ac['status']; ?></td>
									<td align="center">
										<div class="btn-group-justified" role="group">
											<a href="<?php echo site_url('CustomerRelationship/Setting/ApprovalClaim/Update').'/'. $ac['claim_approval_id'] ?>">
												<img src="<?php echo base_url('assets/img/edit.png');?>" title="Update">
											</a>
											<a href="#" data-toggle="modal" data-target="#delete<?php echo $ac['claim_approval_id']; ?>">
												<img src="<?php echo base_url('assets/img/hapus.png');?>" title="Delete">
											</a>
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>