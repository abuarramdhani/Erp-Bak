<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-body">
							<table id="modal_tabel_invoice">
								<tr>
									<td>
										<span><label>Invoice Number</label></span>
									</td>
									<td><input  class="form-control" style="margin-bottom: 10px;" size="40" type="text" name="invoice_number" value="<?php echo $invoice[0]['INVOICE_NUMBER']?>" readonly>
										<input type="hidden" name="invoice_id" value="<?php echo $invoice[0]['INVOICE_ID']?>">
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Invoice Date</label></span>
									</td>
									<td>
										<input  class="form-control" style="margin-bottom: 10px;" size="40" type="text" value="<?php echo $invoice[0]['INVOICE_DATE']?>" readonly>
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Invoice Amount</label></span>
									</td>
									<td >
										<input class="form-control" style="margin-bottom: 10px;" size="40" type="text" value="<?php echo $invoice[0]['INVOICE_AMOUNT']?>" readonly>
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Tax Invoice Number</label></span>
									</td>
									<td>
										<input  class="form-control" style="margin-bottom: 10px;"  size="40" type="text" value="<?php echo $invoice[0]['TAX_INVOICE_NUMBER']?>" readonly>
									</td>
								</tr>
							</table>
							<span><b>Invoice PO Detail</b></span>
							<div style="overflow: auto">
							<table id="tabel_invoice_modal" class="table" style="width: 200%">
							<thead>
							<tr class="bg-primary">
								<th class="text-center">No</th>
								<th class="text-center">Vendor</th>
								<th class="text-center">PO Number</th>
								<th class="text-center">LPPB Number</th>
								<th class="text-center">Shipment Number</th>
								<th class="text-center">Receive Date</th>
								<th class="text-center">Item Description</th>
								<th class="text-center">Item Code</th>
								<th class="text-center">Qty Receipt</th>
								<th class="text-center">Qty Reject</th>
								<th class="text-center">Currency</th>
								<th class="text-center">Unit Price</th>
								<th class="text-center">Qty Invoice</th>
							</tr>
							</thead>
							<tbody>
							<?php $no=1; $po_amount=0; foreach($invoice as $b){?>
							<tr>
								<td class="text-center"><?php echo $no ?></td>
								<td class="text-center"><?php echo $b['VENDOR_NAME']?></td>
								<td class="text-center"><?php echo $b['PO_NUMBER']?></td>
								<td class="text-center"><?php echo $b['LPPB_NUMBER']?></td>
								<td class="text-center"><?php echo $b['SHIPMENT_NUMBER']?></td>
								<td class="text-center"><?php echo $b['RECEIVED_DATE']?></td>
								<td class="text-center"><?php echo $b['ITEM_CODE']?></td>
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
		<div class="pull-left">
			<label>Po Amount : </label><span><?php echo $po_amount ?></span>
		</div>
		</div>
	</div>
</div>