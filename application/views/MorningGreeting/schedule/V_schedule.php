<section class="content">
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h4 class="pull-left">Morning Greeting Schedule</h4>
				<a class="btn btn-default pull-right" href="<?php echo base_url('MorningGreeting/schedule/new')?>">
					<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> New
				</a>
			</div>
			<div class="box-body">
				<table id="schedule" class="table table-striped table-bordered table-responsive table-hover text-center">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<tr>
							<th class="col-md-1">No</th>
							<th>Schedule Description</th>
							<th>Day</th>
							<th>Relasi</th>
							<th>Branch</th>
							<th class="col-md-2">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($schedule as $schedule_item){ 
							if($schedule_item['day'] == 1){
								$day = 'Senin';
							}
							else if($schedule_item['day'] == 2){
								$day = 'Selasa';
							}
							else if($schedule_item['day'] == 3){
								$day = 'Rabu';
							}
							else if($schedule_item['day'] == 4){
								$day = 'Kamis';
							}
							else if($schedule_item['day'] == 5){
								$day = 'Jumat';
							}
							else if($schedule_item['day'] == 6){
								$day = 'Sabtu';
							}
							else $day = 'Minggu';?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $schedule_item['schedule_description'];?></td>
							<td><?php echo $day; ?></td>
							<td><?php echo $schedule_item['relation_name']; ?></td>
							<td><?php echo $schedule_item['org_name']; ?></td>
							<td>
							<div class="btn-group-justified" role="group">
								<a class="btn btn-warning btn-sm" href="<?php echo base_url()?>MorningGreeting/schedule/edit/<?php echo $schedule_item['schedule_id'] ?>">
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
											<a class="btn btn-danger" href="<?php echo base_url()?>MorningGreeting/schedule/delete/<?php echo $schedule_item['schedule_id'] ?>">Delete</a>
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
		<div class="box box-info"></div>
	</div>
	</div>
</section>