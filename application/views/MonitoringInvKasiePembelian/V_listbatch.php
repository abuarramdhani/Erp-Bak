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
							<span><b>List Batch Invoice Checking</b></span>
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
											<th class="text-center">Purchasing Batch Number</th>
											<th class="text-center">Submited Date</th>
											<th class="text-center">Invoices</th>
											<th class="text-center">Status Invoice</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($batch) { foreach($batch as $b) { ?>
										<tr>
											<td><?php echo $no ?></td>
											<td>
												<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$b['BATCH_NUMBER'])?>">
													<button type="button" class="btn btn-default">Detail</button>
												</a>
											</td>
											<td><?php echo $b['BATCH_NUMBER']?></td>
											<td><?php echo date('d-M-Y',strtotime($b['SUBMITED_DATE']))?></td>
											<td><?php echo $b['JML_INVOICE']?></td>
											<?php if ($b['LAST_PURCHASING_INVOICE_STATUS'] == 2 and  $b['LAST_FINANCE_INVOICE_STATUS'] == 2) {
												$stat = 'Approved by Kasie Finance';
												} elseif($b['LAST_PURCHASING_INVOICE_STATUS'] == 2){
													$stat = 'Approved By Kasie Purc';
												} elseif($b['LAST_PURCHASING_INVOICE_STATUS'] == 0 or $b['LAST_PURCHASING_INVOICE_STATUS'] == null ){
													$stat = 'New/Draf';
												} elseif($b['LAST_PURCHASING_INVOICE_STATUS'] == 1 ){
													$stat = 'Submit to Kasie Purchasing';
												} ?>
											<td><?php echo $stat; ?></td>
											<td><?php echo $b['SOURCE'] ?></td>
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