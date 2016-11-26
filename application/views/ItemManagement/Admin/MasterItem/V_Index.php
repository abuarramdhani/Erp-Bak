<section class="content-header">
	<a class="btn btn-primary pull-right" href="<?php echo base_url('ItemManagement/MasterItem/create')?>">
		<span class="fa fa-plus" aria-hidden="true"></span> NEW ITEM
	</a>
	<h1>
		Master Item
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<table id="im-data-table-ignore-last" class="table table-hover table-bordered table-striped">
						<thead class="bg-primary">
							<tr>
								<th width="5%"><center>No</center></th>
								<th width="15%"><center>Kode Barang</center></th>
								<th width="30%"><center>Nama Barang</center></th>
								<th width="10%"><center>Stok</center></th>
								<th width="10%"><center>Umur</center></th>
								<th width="10%"><center>Satuan</center></th>
								<th width="10%"><center>Ukuran</center></th>
								<th width="10%"><center>Action</center></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no = 1;
								foreach ($MasterItem as $MI) {
							?>
							<tr>
								<td align="center"><?php echo $no; ?></td>
								<td><?php echo $MI['kode_barang'] ?></td>
								<td><?php echo $MI['detail'] ?></td>
								<td align="center"><?php echo $MI['stok'] ?></td>
								<td align="center"><?php echo $MI['umur'] ?></td>
								<td><?php echo $MI['satuan_lang'] ?></td>
								<td><?php echo $MI['ukuran_lang'] ?></td>
								<td align="center">
									<button type="button" data-toggle="modal" data-target="#update-modal" class="btn btn-warning btn-sm" onclick="update_item('<?php echo $MI['kode_barang'] ?>')">
										<i data-toggle="tooltip" title="Edit" class="fa fa-edit"></i>
									</button>

									<button type="button" data-toggle="modal" data-target="#delete-modal" class="btn btn-danger btn-sm" onclick="delete_item('<?php echo $MI['kode_barang'] ?>')">
										<i data-toggle="tooltip" title="Delete" class="fa fa-trash-o"></i>
									</button>
								</td>
							</tr>
							<?php 
								$no++;
							} ?>
						</tbody>
					</table>
					<div class="modal fade" id="update-modal">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<form method="post" action="<?php echo base_url('ItemManagement/MasterItem/update') ?>">
									<div class="modal-header bg-primary">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">UpdateIitem</h4>
									</div>
									<div class="modal-body">
										<div id="update-form">
											
										</div>
										<div id="loading" style="width: 10%;margin: 0 auto">
											
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button type="submit" class="btn btn-warning">Update</button>
									</div>
								</form>
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