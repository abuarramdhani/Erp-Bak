<section class="content-header">
	<a class="btn btn-primary pull-right" href="<?php echo base_url('ItemManagement/User/InputPekerja/create')?>">
		<span class="fa fa-plus" aria-hidden="true"></span> NEW BON
	</a>
	<h1>
		Input Pekerja
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<div id="table-wrapper">
						<table id="im-data-table" class="table table-hover table-bordered table-striped">
							<thead class="bg-primary">
								<tr>
									<th width="30%"><center>Kode Pekerjaan</center></th>
									<th width="35%"><center>Pekerjaan</center></th>
									<th width="20%"><center>Jumlah Pekerja</center></th>
									<th width="15%"><center>Action</center></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($JumlahPekerja as $JP) {
								?>
								<tr>
									<td><?php echo $JP['kdpekerjaan'] ?></td>
									<td><?php echo $JP['pekerjaan'] ?></td>
									<td align="center"><?php echo $JP['jumlah_pkj'] ?></td>
									<td align="center">
										<a class="btn btn-warning btn-sm" href="<?php echo base_url('ItemManagement/User/InputPekerja/edit/'.$JP['id_jml_pkj']) ?>">
											<i data-toggle="tooltip" title="Edit" class="fa fa-edit"></i>
										</a>

										<button type="button" data-toggle="modal" data-target="#delete-modal" class="btn btn-danger btn-sm" onclick="delete_jumlah_pekerja('<?php echo $JP['id_jml_pkj'] ?>')">
										<i data-toggle="tooltip" title="Delete" class="fa fa-trash-o"></i>
									</button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
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
	</div>
</section>