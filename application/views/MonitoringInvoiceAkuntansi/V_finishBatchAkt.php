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
							<span><b>List Batch Invoice Finish -Kasie Akuntansi-</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbListSubmit" class="table table-striped table-bordered table-hover text-center tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Action</th>
											<th class="text-center">Batch Number</th>
											<th class="text-center">Submited Date</th>
											<th class="text-center">Total Invoice</th>
											<th class="text-center">Detail</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($batch) { foreach($batch as $b) { ?>
										<tr>
											<td><?php echo $no ?></td>
											<td>
												<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Finish/finishInvoice/'.$b['BATCH_NUMBER'])?>">
													<button type="button" class="btn btn-default">Detail</button>
												</a>
											</td>
											<td><?php echo $b['BATCH_NUMBER']?></td>
											<?php if ($b['SUBMITED_DATE']) {
												$tanggal = date('d-M-Y',strtotime($b['SUBMITED_DATE']));
												}else{
												$tanggal = '';
												}?>
											<td><?php echo $tanggal; ?></td>
											<td><?php echo $b['JML_INVOICE']?></td>
											<td><?php echo $b['approved']; ?>
											<td><?php echo $b['SOURCE']; ?>
											</td>
										</tr>
										<?php $no++; }} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>