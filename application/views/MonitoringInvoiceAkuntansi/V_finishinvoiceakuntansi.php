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
							<span><b>Finish Invoice</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="finishInvoice" class="table table-striped table-bordered table-hover text-center dataTable">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center">Finance Process Date</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($finish){foreach($finish as $f){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $f['vendor_name']?></td>
											<td><a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Finish/DetailProcessed/'.$f['invoice_id']);?>">
												<?php echo $f['invoice_number']?>
												</a>
											</td>
											<td><?php echo date('d-M-Y',strtotime($f['invoice_date']))?></td>
											<td><?php echo $f['tax_invoice_number']?></td>
											<td class="inv_amount"><?php echo $f['invoice_amount']?></td>
											<td class="po_amount"><?php echo $f['po_amount']?></td>
											<td><?php echo $f['last_status_purchasing_date']?></td>
											<td><?php echo $f['last_status_finance_date']?></td>
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
	</div>
</section>