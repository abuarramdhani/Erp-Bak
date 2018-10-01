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
							<span><b>Batch Detail</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="row" style="margin-bottom: 10px">
									<div class="col-md-6">
										<h3><label>Batch Detail : <?=  $batch_number; ?></label></h3>
									</div>
								</div>
								<table id="tbListInvoice" class="table table-striped table-bordered table-hover text-center dataTable">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Action</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Status</th>
											<th class="text-center">Reason</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($invoice as $inv){?>
										<tr id="<?php echo $no; ?>">
											<td><?php echo $no ?></td>
											<td>
												<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/ListSubmitedChecking/showInvoiceInDetail/'.$inv['invoice_id'].'/'.$batch_number)?>">
												<button type="button" class="btn btn-default">Detail</button>
												</a>
											</td>
											<td><?php echo $inv['invoice_number'] ?></td>
											<td><?php echo date('d-M-Y',strtotime($inv['invoice_date'])) ?></td>
											<td><?php echo $inv['tax_invoice_number'] ?></td>
											<td class="inv_amount" ><?php echo $inv['invoice_amount'] ?></td>
											<td class="po_amount"><?php echo $inv['po_amount'] ?></td>
											<td><?php echo $inv['status'] ?></td>
											<td><?php echo $inv['reason'] ?></td>
										</tr>
										<?php $no++; } ?>
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