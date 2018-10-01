<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/ListSubmitedChecking/showInvoiceInDetail/') ?>">
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
								<table id="tbInvoice" >
									<?php $no=1; foreach($invoice as $po_num) { ?>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" name="invoice_number" value="<?php echo $po_num['invoice_number']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input type='text' class="form-control" size="40" value="<?php echo date('d-M-Y',strtotime($po_num['invoice_date']))?>"  name="invoice_date" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
											<input class="form-control inv_amount" size="40" type="text" name="invoice_amount" value="<?php echo $po_num['invoice_amount']?>" id="invoice_amount" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="tax_invoice_number" value="<?php echo $po_num['tax_invoice_number']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Vendor Name</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text" name="vendor_name" value="<?php echo $po_num['vendor_name']?>" readonly>
		                     			</td>
									</tr>
									<?php $no++;} ?>
								</table>
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="col-md-12">
									<div style="overflow:auto;">
											<table id="poLinesTable" class="table table-striped table-bordered table-hover text-center dataTable" style="min-width:200%;">
												<thead style="vertical-align: middle;"> 
													<tr class="bg-primary">
														<th class="text-center">No</th>
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
													<?php $no=1; $po_amount=0; foreach($po_num['detail_invoice'] as $p) { ?>
													<tr id="<?php echo $no; ?>">
														<td>
															<?php echo $no ?>
														</td> 
														<td class="text-center">
															<input class="form-control" type="text" name="po_number" value="<?php echo $p['po_number']?>" readonly> 
														</td>
														<td class="text-center"> 
															<input class="form-control" type="text" name="lppb_number" value="<?php echo $p['lppb_number']?>" readonly> 
														</td>
														<td class="text-center"> 
															<input class="form-control" type="text" name="shipment_number" value="<?php echo $p['shipment_number']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="received_date" value="<?php echo $p['received_date']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="item_description" value="<?php echo $p['item_description']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="qty_receipt" value="<?php echo $p['qty_receipt']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="qty_reject" value="<?php echo $p['qty_reject']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="currency" value="<?php echo $p['currency']?>" readonly> 
														</td>
														<td class="text-center" id="unit_price"> <input class="form-control" type="text" name="unit_price" value="<?php echo $p['unit_price']?>" readonly> 
														 </td> 
														<td class="text-center"> <input class="form-control" type="text" name="qty_invoice" value="<?php echo $p['qty_invoice']?>" readonly> 
														</td> 
													</tr>
												<?php $no++; $po_amount=$po_amount+($p['unit_price'] * $p['qty_invoice'] );} ?>
											</tbody>
										</table>
									</div>
									<div class="col-md-4 pull-left">
										<label>Po Amount : </label><span class="po_amount"><?php echo $po_amount ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2 pull-right">
							<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/ListSubmitedChecking/batchDetail/'.$batch_number)?>">
							<button type="button" id="btnBack" class="btn btn-success" style="margin-top: 10px">Back</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>