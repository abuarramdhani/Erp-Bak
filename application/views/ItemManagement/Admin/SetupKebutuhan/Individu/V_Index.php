<section class="content-header">
	<a class="btn btn-primary pull-right" href="<?php echo base_url('ItemManagement/SetupKebutuhan/Individu/create')?>">
		<span class="fa fa-plus" aria-hidden="true"></span> NEW
	</a>
	<h1>
		Setup Kebutuhan Standar Individu
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<div class="pull-right">
						<a href="<?php echo base_url('ItemManagement/SetupKebutuhan/Individu/export'); ?>" class="btn btn-primary">EXPORT</a>
					</div>
					<table id="im-data-table-ignore-last" class="table table-hover table-bordered table-striped">
						<thead class="bg-primary">
							<tr>
								<th width="5%"><center>No</center></th>
								<th width="25%"><center>Seksi</center></th>
								<th width="30%"><center>No Induk</center></th>
								<th width="25%"><center>Kode Standar</center></th>
								<th width="15%"><center>Action</center></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no = 1;
								foreach ($SetupKebutuhan as $SetupKebutuhan) {
							?>
							<tr>
								<td align="center"><?php echo $no; ?></td>
								<td><?php echo $SetupKebutuhan['seksi'] ?></td>
								<td><?php echo $SetupKebutuhan['noind'].' - '.$SetupKebutuhan['employee_name'] ?></td>
								<td><?php echo $SetupKebutuhan['kode_standar_ind'] ?></td>
								<td align="center">
									<button type="button" data-toggle="modal" data-target="#detail-modal" class="btn btn-primary btn-sm" onclick="detail_kebutuhan_indv('<?php echo $SetupKebutuhan['kode_standar_ind'] ?>','<?php echo $SetupKebutuhan['kodesie'] ?>','<?php echo $SetupKebutuhan['noind'] ?>')">
										<i data-toggle="tooltip" title="Detail" class="fa fa-search-plus"></i>
									</button>

									<a class="btn btn-warning btn-sm" href="<?php echo base_url('ItemManagement/SetupKebutuhan/Individu/edit/'.$SetupKebutuhan['kode_standar_ind'].'/'.$SetupKebutuhan['kodesie'].'/'.$SetupKebutuhan['noind']) ?>">
										<i data-toggle="tooltip" title="Edit" class="fa fa-edit"></i>
									</a>

									<button type="button" data-toggle="modal" data-target="#delete-modal" class="btn btn-danger btn-sm" onclick="delete_kebutuhan_indv('<?php echo $SetupKebutuhan['kode_standar_ind'] ?>','<?php echo $SetupKebutuhan['kodesie'] ?>','<?php echo $SetupKebutuhan['noind'] ?>')">
										<i data-toggle="tooltip" title="Delete" class="fa fa-trash-o"></i>
									</button>
								</td>
							</tr>
							<?php 
								$no++;
							} ?>
						</tbody>
					</table>
					<div class="modal fade" id="detail-modal">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Detail Kebutuhan</h4>
								</div>
								<div class="modal-body">
									<div id="update-form">
										
									</div>
									<div id="loading" style="width: 10%;margin: 0 auto">
										
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="delete-modal">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Delete Item</h4>
								</div>
								<div class="modal-body">
									Are You sure to delete this item?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<a id="delete_btn" href="#" class="btn btn-danger">Delete</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>