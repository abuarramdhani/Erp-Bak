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
								<div class="row">
								<div class="col-md-6">
								<table id="tbInvoice" >
									<?php $no=1; foreach($invoice as $po_num) { ?>
									<tr>
										<td>
											<span><label>Vendor Name</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text" name="vendor_name" value="<?php echo $po_num['VENDOR_NAME']?>" readonly>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" name="invoice_number" value="<?php echo $po_num['INVOICE_NUMBER']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input type='text' class="form-control" size="40" value="<?php echo date('d-M-Y',strtotime($po_num['INVOICE_DATE']))?>"  name="invoice_date" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="invoice_amount" value="<?php echo $po_num['INVOICE_AMOUNT']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="tax_invoice_number" value="<?php echo $po_num['TAX_INVOICE_NUMBER']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Category</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="invoice_category" value="<?php echo $po_num['INVOICE_CATEGORY']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Nominal DPP</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="nominal_dpp" value="<?php echo $po_num['NOMINAL_DPP']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Info</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="info" value="<?php echo $po_num['INFO']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>PIC</label></span>
										</td>
										<td>
											<input class="form-control" size="40" type="text" name="info" value="<?php echo $po_num['SOURCE']?>" readonly>
										</td>
									</tr>
									<?php $no++; break;} ?>
								</table>
								</div><div class="col-md-6">
								<span><label>Invoice History</label></span><br>
								<table id="tbHistoryInvoice" class="table table-striped table-bordered table-hover text-center dataTable" >
								<thead style="vertical-align: middle;"> 
									<tr class="bg-primary">
										<th class="text-center">No</th>
										<th class="text-center">Action Date</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php $no=1; foreach($historyinvoice as $hi) { ?>
									<tr>
										<td><?php echo $no?></td>
										<td><?php echo $hi['ACTION_DATE']?></td>
										<td><?php echo $hi['STATUS']?></td>
									</tr>
									<?php $no++;}?>
								</tbody>												
								</table>
								</div>
								</div>
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="col-md-12">
									<div>
											<table id="table_tracking_invoice" class="table table-striped table-bordered table-hover text-center dataTable">
												<thead style="vertical-align: middle;"> 
													<tr class="bg-primary">
														<th class="text-center">No</th>
														<th class="text-center">PO Number</th>
														<th class="text-center">LPPB Number</th>
														<th class="text-center">Shipment Number</th>
														<th class="text-center">Receive Date</th>
														<th class="text-center">Item Code</th>
														<th class="text-center">Item Description</th>
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
														<td class="text-center"><?php echo $p['PO_NUMBER']?>
														</td>
														<td class="text-center"> 
															<?php echo $p['LPPB_NUMBER']?>
														</td>
														<td class="text-center"> 
															<?php echo $p['SHIPMENT_NUMBER']?>
														</td>
														<td class="text-center">
															<?php echo $p['RECEIVED_DATE']?>
														</td>
														<td class="text-center">
															<?php echo $p['ITEM_CODE']?>
														</td>
														<td class="text-center">
															<?php echo $p['ITEM_DESCRIPTION']?>
														</td>
														<td class="text-center">
															<?php echo $p['QTY_RECEIPT']?>
														</td>
														<td class="text-center">
															<?php echo $p['QTY_REJECT']?> 
														</td>
														<td class="text-center">
															<?php echo $p['CURRENCY']?> 
														</td>
														<td class="text-center" id="unit_price"> <?php echo $p['UNIT_PRICE']?> 
														 </td> 
														<td class="text-center"><?php echo $p['QTY_INVOICE']?> 
														</td> 
													</tr>
												<?php $no++; $po_amount=$po_amount+($p['UNIT_PRICE'] * $p['QTY_INVOICE'] );} ?>
											</tbody>
										</table>
									</div>
									<div class="col-md-4 pull-left">
										<label>Po Amount : </label><span><?php echo $po_amount ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>