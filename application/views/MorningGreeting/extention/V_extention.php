<section class="content">
	<div class="inner" >
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h4 class="pull-left">Morning Greeting Branch Extention</h4>
			<a class="btn btn-default pull-right" href="<?php echo base_url('MorningGreeting/extention/new')?>">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> New
			</a>
		</div>
		<div class="box-body">
				<table style="max-width: 90%" id="branch" class="table table-striped table-bordered table-responsive table-hover text-center">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<th class="col-sm-1">No</th>
						<th>Branch</th>
						<th>Extention</th>
						<th class="col-md-2">Action</th>
					</thead>
					<tbody>
					<?php $no=1; foreach($branch as $branch_item){ ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $branch_item['org_name'];?></td>
							<td><?php echo $branch_item['ext_number']; ?></td>
							<td>
							<div class="btn-group-justified" role="group">
								<a class="btn btn-warning btn-sm" href="<?php echo base_url()?>MorningGreeting/extention/edit/<?php echo $branch_item['branch_extention_id'] ?>">
									<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
								</a>
								
								<!-- Button trigger modal -->
								<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>	Delete
								</a>
								
								<!-- Modal -->
								<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus</h4>
									</div>
									<div class="modal-body">
										Apakah anda yakin ingin menghapus data ini?
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<a class="btn btn-danger" href="<?php echo base_url()?>MorningGreeting/extention/delete/<?php echo $branch_item['branch_extention_id'] ?>">Delete</a>
									</div>
									</div>
								</div>
								</div>
							</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</center>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	</div>
</section>