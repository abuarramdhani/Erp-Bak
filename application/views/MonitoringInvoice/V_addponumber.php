<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<form method="post" action="<?php echo base_url("AccountPayables/MonitoringInvoice/Invoice/addPoNumber2/".$invoice[0]['invoice_id']) ?>">
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
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" name="invoice_number" value="<?php echo $invoice[0]['invoice_number']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input type='text' class="form-control" size="40" value="<?php echo date('d-M-Y',strtotime($invoice[0]['invoice_date']))?>"  name="invoice_date" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
											<input class="form-control inv_amount" size="40" type="text" name="invoice_amount" value="<?php echo round($invoice[0]['invoice_amount'])?>" id="invoice_amount">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="tax_invoice_number" value="<?php echo $invoice[0]['tax_invoice_number']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Vendor Name</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text" name="vendor_name" value="<?php echo $invoice[0]['vendor_name']?>" readonly>
		                     			</td>
									</tr>
								</table>
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
							<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/editListInv/'.$invoice[0]['invoice_id'])?>">
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
