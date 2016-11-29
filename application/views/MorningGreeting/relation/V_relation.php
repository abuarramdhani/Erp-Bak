<section class="content">
	<div class="inner">
	<div class="box box-info"> <!-- TAMBAHAN-->
	<div style="padding-top: 10px">
		<div class="box-header with-border"> <!-- TAMBAHAN-->
			<h4 class="pull-left">Morning Greeting Relation</h4>
			<a class="btn btn-default pull-right" href="<?php echo base_url('MorningGreeting/relation/new')?>">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> New
			</a>
		</div>
		<div class="box-body"> <!-- TAMBAHAN-->
				<table id="relation" class="table table-striped table-bordered table-responsive table-hover ">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<th style="width:5%; text-align:center;">No</th>
						<th style="text-align:center;">Relation Name</th>
						<th style="text-align:center;">City</th>
						<th style="text-align:center;">NPWP</th>
						<th style="text-align:center;">Oracle Cust ID</th>
						<th style="text-align:center;">Branch</th>
						<th style="text-align:center;">Phone</th>
						<th style="width:15%; text-align:center;">Action</th>
					</thead>
					<tbody>
					<?php $no=1; foreach($relation as $relation_item){ ?>
						<tr>
							<td style="text-align:center;"><?php echo $no++; ?></td>
							<td><?php echo $relation_item['relation_name'];?></td>
							<td><?php echo $relation_item['regency_name']; ?></td>
							<td style="text-align:center;"><?php echo $relation_item['npwp']; ?></td>
							<td style="text-align:center;"><?php echo $relation_item['oracle_cust_id']; ?></td>
							<td style="text-align:center;"><?php echo $relation_item['org_name']; ?></td>
							<td><?php echo $relation_item['contact_number']; ?></td>
							<td>
							<div class="btn-group-justified" role="group">
								<a class="btn btn-warning btn-sm" href="<?php echo base_url()?>MorningGreeting/relation/edit/<?php echo $relation_item['relation_id'] ?>">
									<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
								</a>
								
								<!-- Button trigger modal -->
								<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_<?php echo $relation_item['relation_id']; ?>">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>	Delete
								</a>
								
								<!-- Modal -->
								<div class="modal fade" id="delete_<?php echo $relation_item['relation_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus</h4>
									</div>
									<div class="modal-body">
										Apakah anda yakin ingin menghapus data ini?
										<p>
											<b>Relation Name</b> : <?php echo $relation_item['relation_name'];?> <br>
											<b>City         </b> : <?php echo $relation_item['regency_name']; ?>
										</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<a class="btn btn-danger" href="<?php echo base_url()?>MorningGreeting/relation/delete/<?php echo $relation_item['relation_id'] ?>">Delete</a>
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
		</div>
		<div class="box box-info"></div> <!-- TAMBAHAN-->
	</div>
	</div>
</section>