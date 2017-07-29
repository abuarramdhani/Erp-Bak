<section class="content-header">
	<h1>
		Monitoring Bon
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<div class="pull-right">
						<a href="<?php echo base_url('ItemManagement/MonitoringBon/export'); ?>" class="btn btn-primary">EXPORT</a>
					</div>
					<table id="im-data-table" class="table table-hover table-bordered table-striped">
						<thead class="bg-primary">
							<tr>
								<th width="5%"><center>No</center></th>
								<th width="30%"><center>Seksi</center></th>
								<th width="25%"><center>Detail</center></th>
								<th width="10%"><center>Jumlah Batas</center></th>
								<th width="10%"><center>Jumlah Bon</center></th>
								<th width="10%"><center>Sisa Stok</center></th>
								<th width="10%"><center>Tanggal</center></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no = 1;
								foreach ($MonitoringBon as $HK) {
							?>
							<tr>
								<td align="center"><?php echo $no; ?></td>
								<td><?php echo $HK['seksi'] ?></td>
								<td><?php echo $HK['detail'] ?></td>
								<td align="center"><?php echo $HK['jumlah_batas'] ?></td>
								<td align="center"><?php echo $HK['jumlah'] ?></td>
								<td align="center"><?php echo $HK['sisa_stok'] ?></td>
								<td><?php echo $HK['tgl_bon'] ?></td>
							</tr>
							<?php 
								$no++;
							} ?>
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
</section>