<section class="content-header">
	<h1>
		Monitoring Kebutuhan
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<div class="pull-right">
						<a href="<?php echo base_url('ItemManagement/Hitung/MonitoringKebutuhan/export'); ?>" class="btn btn-primary">EXPORT</a>
					</div>
					<table id="im-data-table" class="table table-hover table-bordered table-striped">
						<thead class="bg-primary">
							<tr>
								<th width="5%"><center>No</center></th>
								<th width="30%"><center>Periode</center></th>
								<th width="50%"><center>Kodesie</center></th>
								<th width="15%"><center>Action</center></th>
							</tr>
						</thead>
						<tbody>
							<?php /* foreach ($PeriodeKebutuhan as $PK) { ?>
							<tr>
								<td colspan="3">
									<center><b><?php echo strtoupper(date('F Y', strtotime($PK['periode']))); ?></b></center>
								</td>
							</tr>
							<?php
								foreach ($BarangKebutuhan as $BK) {
									if ($BK['periode'] == $PK['periode']) {
									$no = 1;
							?>
							<tr>
								<td colspan="3">
									<b><?php echo $BK['kode_barang'].' - '.$BK['detail'] ?></b>
								</td>
							</tr>
							<?php
								foreach ($MonitoringKebutuhan as $MK) {
									if ($MK['periode'] == $BK['periode'] && $MK['kode_barang'] == $BK['kode_barang']) {
							?>
							<tr>
								<td align="center"><?php echo $no; ?></td>
								<td><?php echo $MK['seksi'] ?></td>
								<td><?php echo $MK['total_kebutuhan'] ?></td>
							</tr>
							<?php $no++; } } } } } */ ?>
							<!--! _____________________ !-->
							<?php
								$no = 1;
								foreach ($MonitoringKebutuhan as $MK) {
							?>
									<tr>
										<td align="center"><?php echo $no;?></td>
										<td><?php echo '('.$MK['periode'].') '.strtoupper(date('F Y', strtotime($MK['periode'])));?></td>
										<td><?php echo $MK['seksi'];?></td>
										<td align="center">
											<button type="button" data-toggle="modal" data-target="#detail-kebutuhan" class="btn btn-primary btn-sm" onclick="detail_monitoring_kebutuhan('<?php echo $MK['periode'] ?>','<?php echo $MK['kodesie'] ?>')">
												<i data-toggle="tooltip" title="Detail" class="fa fa-search-plus"></i>
											</button>
										</td>
									</tr>
							<?php
								$no++;
								} 
							?>
						</tbody>
					</table>
					<div class="modal fade" id="detail-kebutuhan">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Change Status</h4>
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
				</div>
			</div>
		</div>
	</div>
</section>