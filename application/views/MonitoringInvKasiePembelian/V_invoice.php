<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
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
								<table id="tbInvoice" >
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td><?php echo $invoice_detail[0]['invoice_number']?></td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
											<?php echo date('d-M-Y',strtotime($invoice_detail[0]['invoice_date']))?>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
											<?php echo $invoice_detail[0]['invoice_amount']?>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<?php echo $invoice_detail[0]['tax_invoice_number']?>
										</td>
									</tr>
								</table>
							</form>
						<span><b>Invoice PO Detail</b></span>
						<div style="overflow: auto">
						<table class="table table-bordered table-hover table-striped text-center" style="width: 200%">
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
								<tr id="<?php echo $no;?>">
									<td class="text-center"><?php echo $no ?></td>
									<td class="text-center"><?php echo $b['vendor_name']?></td>
									<td class="text-center"><?php echo $b['po_number']?></td>
									<td class="text-center"><?php echo $b['lppb_number']?></td>
									<td class="text-center"><?php echo $b['shipment_number']?></td>
									<td class="text-center"><?php echo $b['received_date']?></td>
									<td class="text-center"><?php echo $b['item_description']?></td>
									<td class="text-center"><?php echo $b['qty_receipt']?></td>
									<td class="text-center"><?php echo $b['qty_reject']?></td>
									<td class="text-center"><?php echo $b['currency']?></td>
									<td class="text-center"><?php echo $b['unit_price']?></td>
									<td class="text-center"><?php echo $b['qty_invoice']?></td>
								</tr>
								<?php $no++; $po_amount=$po_amount+($b['unit_price'] * $b['qty_invoice']); }?>
							</tbody>
						</table>
						</div>
						<div class="col-md-4 pull-left">
							<label>Po Amount : </label><span><?php echo $po_amount ?></span>
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