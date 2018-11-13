<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoiceKasie tr td{padding: 5px}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Invoice Details</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
							<form id="filInvoice" >
								<table id="tbInvoiceKasie" >
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td><?php echo $invoice_detail[0]['INVOICE_NUMBER']?></td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
											<?php echo date('d-M-Y',strtotime($invoice_detail[0]['INVOICE_DATE']))?>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td id="invoice_amount">
											<?php echo $invoice_detail[0]['INVOICE_AMOUNT']?>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<?php echo $invoice_detail[0]['TAX_INVOICE_NUMBER']?>
										</td>
									</tr>
								</table>
							</form>
						<span><b>Invoice PO Detail</b></span>
						<div style="overflow: auto">
						<table id="invoiceKasiePembelian" class="table table-bordered table-hover table-striped text-center" style="width: 200%">
							<thead>
								<tr class="bg-primary">
									<th class="text-center">No</th>
									<th class="text-center">Vendor</th>
									<th class="text-center">PO Number</th>
									<th class="text-center">LPPB Number</th>
									<th class="text-center">Shipment Number</th>
									<th class="text-center">Receive Date</th>
									<th class="text-center">Item Desc</th>
									<th class="text-center">Qty Receipt</th>
									<th class="text-center">Qty Reject</th>
									<th class="text-center">Currency</th>
									<th class="text-center">Unit Price</th>
									<th class="text-center">Qty Invoice</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; $po_amount=0; foreach($invoice_detail as $b){?>
								<tr>
									<td class="text-center"><?php echo $no ?></td>
									<td class="text-center"><?php echo $b['VENDOR_NAME']?></td>
									<td class="text-center"><?php echo $b['PO_NUMBER']?></td>
									<td class="text-center"><?php echo $b['LPPB_NUMBER']?></td>
									<td class="text-center"><?php echo $b['SHIPMENT_NUMBER']?></td>
									<td class="text-center"><?php echo $b['RECEIVED_DATE']?></td>
									<td class="text-center"><?php echo $b['ITEM_DESCRIPTION']?></td>
									<td class="text-center"><?php echo $b['QTY_RECEIPT']?></td>
									<td class="text-center"><?php echo $b['QTY_REJECT']?></td>
									<td class="text-center"><?php echo $b['CURRENCY']?></td>
									<td class="text-center"><?php echo $b['UNIT_PRICE']?></td>
									<td class="text-center"><?php echo $b['QTY_INVOICE']?></td>
								</tr>
								<?php $no++; $po_amount=$po_amount+($b['UNIT_PRICE'] * $b['QTY_INVOICE']); }?>
							</tbody>
						</table>
						</div>
						<div class="col-md-4 pull-left">
							<label>Po Amount : </label><span class="po_amount"><?php echo round($po_amount) ?></span>
						</div>
						<div class="col-md-2 pull-right">
						<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$batch_number)?>">
							<button type="button" class="btn btn-success pull-right" style="margin-top: 10px" >Back</button>
						</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>