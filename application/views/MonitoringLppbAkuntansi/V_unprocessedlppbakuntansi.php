<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}

</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>List Data Batch LPPB</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tabel_list_batch" class="table text-center datatable">
									<thead>
										<tr class="bg-primary">
											<th width="5%" class="text-center">No</th>
											<th width="10%" class="text-center">Action</th>
											<th class="text-center">Batch LPPB Number</th>
											<th class="text-center">Create Date</th>
											<th class="text-center">Jumlah LPPB</th>
											<th class="text-center">Status Detail</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=1; if ($lppb) { foreach($lppb as $lb){ ?>
									<tr>
										<td><?php echo $no?></td>
										<td>
											<a title="Detail Lppb" href="<?php echo base_url('MonitoringLppbAkuntansi/Unprocess/detailLppbAkuntansi/'.$lb['BATCH_NUMBER'])?>" class="btn btn-default btn-xs"><i class="fa fa-file-text-o"></i></a>
										</td>
										<td><?php echo $lb['BATCH_NUMBER']?></td>
										<td><?php echo $lb['CREATE_DATE']?></td>
										<td><?php echo $lb['JUMLAH_LPPB']?></td>
										<td>
											<?php
											if ($lb['CHECKING_AKUNTANSI']>0) {
												echo $lb['CHECKING_AKUNTANSI']." Checking Akuntansi"."<br>";
											}
											if ($lb['AKUNTANSI_APPROVED']>0) {
												echo $lb['AKUNTANSI_APPROVED']." Akuntansi Approve"."<br>";
											}
											if ($lb['AKUNTANSI_REJECT']>0) {
												echo $lb['AKUNTANSI_REJECT']." Akuntansi Reject"."<br>";
											}
											?>
										</td>
									</tr>
									<?php $no++; }}?>
								</tbody>
								</table>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

