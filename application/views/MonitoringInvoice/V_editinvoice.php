<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoiceEdit tr td{padding: 5px}
</style>

<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/saveEditInvoice/'.$invoice[0]['INVOICE_ID']) ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Edit Invoice</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbInvoiceEdit" >
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" name="invoice_number" value="<?php echo $invoice[0]['INVOICE_NUMBER']?>">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input type='text' class="form-control idDateInvoice" size="40" value="<?php echo date('d-M-Y',strtotime($invoice[0]['INVOICE_DATE'])) ?>" name="invoice_date">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="invoice_amount" id="invoice_amount" value="<?php echo $invoice[0]['INVOICE_AMOUNT']?>">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="tax_invoice_number" value="<?php echo $invoice[0]['TAX_INVOICE_NUMBER']?>">
										</td>
									</tr>
									<tr>
										<td>
											<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/addListPo/'.$invoice[0]['INVOICE_ID']);?>">
											<button type="button" class="btn btn-sm btn-primary">Tambah PO  <i class="glyphicon glyphicon-plus" style="width: 12px; height: 12px;"></i></button>
											</a>
										</td>
									</tr>
								</table>
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="col-md-12">
									<div style="overflow:auto;">
											<table id="editlinespo" class="table table-striped table-bordered table-hover text-center dataTable" style="min-width:200%;">
												<thead style="vertical-align: middle;"> 
													<tr class="bg-primary">
														<th class="text-center">No</th>
														<th class="text-center">Line Number</th>
														<th class="text-center">Vendor Name</th>
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
													<?php $no=1; $po_amount=0; foreach($invoice as $po_num) { ?>
													<tr id="<?php echo $no; ?>">
														<td>
															<?php echo $no ?>
														</td> 
														<td class="text-center">
															<input class="form-control" type="text" value="<?php echo $po_num['LINE_NUMBER']?>"> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" value="<?php echo $po_num['VENDOR_NAME']?>"> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="po_number[]" value="<?php echo $po_num['PO_NUMBER']?>"> 
														</td>
														<td class="text-center"> 
															<input class="form-control" type="text" name="lppb_number[]" value="<?php echo $po_num['LPPB_NUMBER']?>"> 
														</td>
														<td class="text-center"> 
															<input class="form-control" type="text" name="shipment_number[]" value="<?php echo $po_num['SHIPMENT_NUMBER']?>"> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="received_date[]" value="<?php echo $po_num['RECEIVED_DATE']?>"> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="item_description[]" value="<?php echo $po_num['ITEM_DESCRIPTION']?>"> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="qty_receipt[]" value="<?php echo $po_num['QTY_RECEIPT']?>"> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="qty_reject[]" value="<?php echo $po_num['QTY_REJECT']?>"> 
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="currency[]" value="<?php echo $po_num['CURRENCY']?>"> 
														</td>
														<td class="text-center" id="unit_price"> <input class="form-control" type="text" name="unit_price[]" value="<?php echo $po_num['UNIT_PRICE']?>"> 
														 </td> 
														<td class="text-center" id="qty_invoice"> <input class="form-control " type="text" name="qty_invoice[]" value="<?php echo $po_num['QTY_INVOICE']?>"> 
														</td> 
													</tr>
												<?php $no++; $po_amount=$po_amount+($po_num['UNIT_PRICE']*$po_num['QTY_INVOICE']); } ?>
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
							<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice')?>">
							<button type="button" id="btnMICancel" class="btn btn-danger" style="margin-top: 10px">Cancel</button>
							</a>
							<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/saveEditInvoice')?>">
							<button type="submit" id="btnMISave" class="btn btn-success pull-right" style="margin-top: 10px" >Save</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>