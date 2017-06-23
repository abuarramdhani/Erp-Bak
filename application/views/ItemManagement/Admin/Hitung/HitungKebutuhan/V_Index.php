<section class="content-header">
	<a class="btn btn-primary pull-right" href="<?php echo base_url('ItemManagement/Hitung/HitungKebutuhan/create')?>">
		<span class="fa fa-plus" aria-hidden="true"></span> NEW
	</a>
	<h1>
		Hitung Kebutuhan
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<form id="form-status" method="post" action="<?php echo base_url('ItemManagement/Hitung/HitungKebutuhan/changeStatus')?>">
						<div class="pull-right">
							<button id="update-status-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#update-status" disabled><i class="fa fa-edit"></i> CHANGE STATUS</button>
						</div>
						<table id="im-data-table-ignore-last" class="table table-hover table-bordered table-striped">
							<thead class="bg-primary">
								<tr>
									<th width="5%"><center>No</center></th>
									<th width="15%"><center>Periode</center></th>
									<th width="15%"><center>Kode Barang</center></th>
									<th width="35%"><center>Detail</center></th>
									<th width="15%"><center>Total</center></th>
									<th width="10%"><center>Status</center></th>
									<th width="5%"><center><input type="checkbox" name="check_all"></center></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$no = 1;
									foreach ($HitungKebutuhan as $HK) {
								?>
								<tr>
									<td align="center"><?php echo $no; ?></td>
									<td><?php echo date('F Y', strtotime($HK['periode'])); ?></td>
									<td><?php echo $HK['kode_barang'] ?></td>
									<td><?php echo $HK['detail'] ?></td>
									<td><?php echo $HK['total_kebutuhan'] ?></td>
									<td align="center"><span class="label <?php if ($HK['status'] =='READY') { echo "label-success";}elseif ($HK['status'] =='ORDER') { echo "label-info";}else{ echo "label-primary";}?>"><?php echo $HK['status'] ?></span></td>
									<td align="center">
										<?php
											if ($HK['status'] != 'READY') {
										?>
										<input type="checkbox" name="txt_data_status[]" value="<?php echo $HK['periode'].'//'.$HK['kode_barang']?>">
										<?php
											}
										?>
									</td>
								</tr>
								<?php 
									$no++;
								} ?>
							</tbody>
						</table>
						<div class="modal fade" id="update-status">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header bg-primary">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Change Status</h4>
									</div>
									<div class="modal-body">
										<select name="txt_status" class="form-control select2" data-placeholder="STATUS" style="width: 100%;" required>
											<option></option>
											<option value="NEW">NEW</option>
											<option value="ORDER">ON ORDER PROCESS</option>
											<option value="READY">READY AND ADD TO MASTER ITEM</option>
										</select>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button type="submit" class="btn btn-primary">Update Status</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>