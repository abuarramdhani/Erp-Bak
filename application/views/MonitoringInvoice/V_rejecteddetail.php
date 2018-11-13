<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#rejectdetail tr td{padding: 5px}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Reject Invoice Details</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="rejectdetail"  >
									<?php $no=1; ?>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" name="invoice_number" value="<?php echo $invoice[0]['INVOICE_NUMBER']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input type='text' class="form-control" size="40" value="<?php echo date('d-M-Y',strtotime($invoice[0]['INVOICE_DATE']))?>"  name="invoice_date" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
											<input class="form-control inv_amount" size="40" type="text" name="invoice_amount" value="<?php echo $invoice[0]['INVOICE_AMOUNT']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="tax_invoice_number" value="<?php echo $invoice[0]['TAX_INVOICE_NUMBER']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Vendor Name</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text" name="vendor_name" value="<?php echo $invoice[0]['VENDOR_NAME']?>" readonly>
		                     			</td>
									</tr>
									<?php $no++; ?>
								</table>
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="col-md-12">
									<div style="overflow:auto;">
											<table id="rejectpo" class="table table-striped table-bordered table-hover text-center dataTable" style="min-width:200%;">
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
													<?php $no=1; $po_amount=0; foreach($invoice as $p) { ?>
													<tr>
														<td>
															<?php echo $no ?>
														</td> 
														<td class="text-center">
															<input class="form-control" type="text" name="po_number" value="<?php echo $p['PO_NUMBER']?>" readonly> 
														</td>
														<td class="text-center"> 
															<input class="form-control" type="text" name="lppb_number" value="<?php echo $p['LPPB_NUMBER']?>" readonly> 
														</td>
														<td class="text-center"> 
															<input class="form-control" type="text" name="shipment_number" value="<?php echo $p['SHIPMENT_NUMBER']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="received_date" value="<?php echo $p['RECEIVED_DATE']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="item_description" value="<?php echo $p['ITEM_DESCRIPTION']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="qty_receipt" value="<?php echo $p['QTY_RECEIPT']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="qty_reject" value="<?php echo $p['QTY_REJECT']?>" readonly> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="currency" value="<?php echo $p['CURRENCY']?>" readonly> 
														</td>
														<td class="text-center" id="unit_price"> <input class="form-control" type="text" name="unit_price" value="<?php echo $p['UNIT_PRICE']?>" readonly> 
														 </td> 
														<td class="text-center"> <input class="form-control" type="text" name="qty_invoice" value="<?php echo $p['QTY_INVOICE']?>" readonly> 
														</td> 
													</tr>
												<?php $no++; $po_amount=$po_amount+($p['UNIT_PRICE'] * $p['QTY_INVOICE'] );} ?>
											</tbody>
										</table>
									</div>
									<div class="col-md-4 pull-left">
										<label>Po Amount : </label><span class="po_amount"><?php echo round($po_amount) ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2 pull-right">
							<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/Rejected')?>">
							<button type="button" id="btnBack" class="btn btn-success" style="margin-top: 10px">Back</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>