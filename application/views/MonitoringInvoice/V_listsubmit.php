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
							<span><b>List Submited For Checking</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbListSubmit" class="table table-striped table-bordered table-hover text-center dataTable">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Action</th>
											<th class="text-center">Batch Number</th>
											<th class="text-center">Submited Date</th>
											<th class="text-center">Invoices</th>
											<th class="text-center">Status Invoice</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($invoice) { foreach($invoice as $inv) { ?>
										<tr id="<?php echo $no; ?>">
											<td><?php echo $no ?> </td>
											<td>
												<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/ListSubmitedChecking/batchDetail/'.$inv['batch_num'])?>">
													<button type="button" class="btn btn-default">Detail</button>
												</a>
											</td>
											<td><?php echo  $inv['batch_num'] ?></td>
											<td><?php echo  $inv['submited_date'] ?></td>
											<td><?php echo $inv['jml_invoice']; ?></td>
											<?php if ($inv['last_purchasing_invoice_status'] == 0 ) {
												$stat = 'New/Draft';
												} elseif ($inv['last_purchasing_invoice_status'] == 1) {
													$stat = 'Submited by Kasie Purc';
												} elseif($inv['last_purchasing_invoice_status'] == 2){
													$stat = 'Approved By Kasie Purc';
												} elseif($inv['last_purchasing_invoice_status'] == 3){
													$stat = 'Rejected by Kasie Purc';
												}
											?>
											<td><?php echo $stat; ?></td>
										</tr>
										<?php $no++; } } ?>
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