<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<form method="post" action="<?php echo base_url("AccountPayables/MonitoringInvoice/Invoice/addPoNumber2/".$invoice[0]['INVOICE_ID']) ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Add Po Number</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbInvoice" >
									<tr>
										<td>
											<span><label>Vendor Name</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text" name="vendor_name" value="<?php echo $invoice[0]['VENDOR_NAME']?>" readonly>
		                     			</td>
									</tr>
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
											<input readonly="readonly" class="form-control inv_amount" size="40" type="text" name="invoice_amount" value="<?php echo $invoice[0]['INVOICE_AMOUNT']?>" id="invoice_amount">
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
											<span><label>Invoice Category</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text" name="invoice_category" value="<?php echo $invoice[0]['INVOICE_CATEGORY']?>" readonly>
		                     			</td>
		                     			<td>
											<span><label>Jenis Jasa</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text" name="jenis_jasa" value="<?php echo $invoice[0]['JENIS_JASA']?>" readonly>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Nominal DPP Faktur Pajak</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text" name="nominal_dpp" value="<?php echo $invoice[0]['NOMINAL_DPP']?>" readonly>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Info</label></span>
										</td>
										<td>
		                     				<textarea readonly class="form-control" size="40" type="text" name="note_admin"><?php echo $invoice[0]['INFO'] ?></textarea> 
		                     			</td>
									</tr>
								</table>
								<div>
							<table class="table table-bordered table-hover table-striped text-center">
								<thead style="width: 100%">
									<tr class="bg-primary">
										<th class="text-center" width= "1%">No</th>
										<th class="text-center" width= "1%">Line Number</th>
										<th class="text-center" width= "20%">Vendor Name</th>
										<th class="text-center" width= "10%">PO Number</th>
										<th class="text-center" width= "10%">LPPB Number</th>
										<th class="text-center" width= "15%">Shipment Number</th>
										<th class="text-center" width= "10%">Receive Date</th>
										<th class="text-center" width= "15%">Item Code</th>
										<th class="text-center" width= "40%">Item Description</th>
										<th class="text-center" width= "5%">Qty Amount</th>
										<th class="text-center" width= "3%">Qty Reject</th>
										<th class="text-center" width= "10%">Currency</th>
										<th class="text-center" width= "10%">Unit Price</th>
										<th class="text-center" width= "5%">Qty Invoice</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=1; $po_amount=0; foreach($invoice as $po_num) { ?>
										<tr>
											<td>
												<?php echo $no ?>
											</td> 
											<td class="text-center"><?php echo $po_num['LINE_NUMBER']?>
											<input type="hidden" name="line_number" class="line_number" value="<?php echo $po_num['LINE_NUMBER']?>"> 
											</td>
											<td class="text-center"><?php echo $po_num['VENDOR_NAME']?></td>
											<td class="text-center"><?php echo $po_num['PO_NUMBER']?>
											</td>
											<td class="text-center"><?php echo $po_num['LPPB_NUMBER']?>
											</td>
											<td class="text-center"><?php echo $po_num['SHIPMENT_NUMBER']?>
											</td>
											<td class="text-center"><?php echo $po_num['RECEIVED_DATE']?>
											</td>
											<td class="text-center"><?php echo $po_num['ITEM_CODE']?>
											</td>
											<td class="text-center"><?php echo $po_num['ITEM_DESCRIPTION']?>
											</td>
											<td class="text-center"><?php echo $po_num['QTY_RECEIPT']?>
											</td>
											<td class="text-center"><?php echo $po_num['QTY_REJECT']?>
											</td>
											<td class="text-center"><?php echo $po_num['CURRENCY']?>
											</td>
											<td class="text-center"><?php echo $po_num['UNIT_PRICE']?>
											 </td> 
											<td class="text-center"><?php echo $po_num['QTY_INVOICE']?>
											</td> 
										</tr>
									<?php $no++; } ?>
								</tbody>
							</table>
						</div>
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="box-header with-border">
										PO Data
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<div class="col-md-6">
													<table id="filter" class="col-md-12" style="margin-bottom: 20px">
														<tr>
															<td>
																<span class="text-center"><label>Po Number</label></span>
															</td>
														<td>
																<div class="col-md-12" id="divPoNumber">
																	<div class="col-md-12">
																		<input name="slcPoNumberInv" id="slcPoNumberMonitoring" class="form-control" style="width:100%;">
																		</input>
																	</div>
																</div>
															</td>
															<td>
																<div><button class="btn btn-md btn-success pull-left" type="button" id="btnSearchPoNumber">Search</button>
																</div>
															</td>
														</tr>
													</table>
												</div>
											</div>
											<div id="tablePoLines">
												
											</div>
										</div>
									</div>
								</div>
						<span><b>Invoice PO Detail</b></span>
						<div style="overflow:auto;">
							<table class="table table-bordered table-hover table-striped text-center" style="min-width:200%;">
								<thead>
									<tr class="bg-primary">
										<th class="text-center">No</th>
										<th class="text-center">Line Number</th>
										<th class="text-center">Vendor Name</th>
										<th class="text-center">PO Number</th>
										<th class="text-center">LPPB Number</th>
										<th class="text-center">Status LPPB</th>
										<th class="text-center">Shipment Number</th>
										<th class="text-center">Receive Date</th>
										<th class="text-center">Item Code</th>
										<th class="text-center">Item Desc</th>
										<th class="text-center">Qty Amount</th>
										<th class="text-center">Qty Billed</th>
										<th class="text-center">Qty Reject</th>
										<th class="text-center">Currency</th>
										<th class="text-center">Unit Price</th>
										<th class="text-center">Qty Po</th>
										<th class="text-center">Qty Invoice</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody id="tbodyPoDetailAll">
									
								</tbody>
							</table>
						</div>
						<div class="col-md-4 pull-left">
							<label>Po Amount : </label><span id="AmountOtomatis"></span>
						</div>
						<div class="col-md-2 pull-right">
							<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/editListInv/'.$invoice[0]['INVOICE_ID'])?>">
							<button type="button" id="btnMICancel" class="btn btn-danger" style="margin-top: 10px">Cancel</button>
							</a>
							<a href="">
							<button id="btnMISave" class="btn btn-success pull-right" style="margin-top: 10px" >Save</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>
