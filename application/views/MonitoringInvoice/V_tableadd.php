</style>
		<?php if($invoice){foreach ($invoice as $po_num) { ?>
		<input type="hidden" value="<?= $po_num['LINE_NUM'] ?>" name="line_num">
		<input type="hidden" value="<?= $po_num['VENDOR_NAME'] ?>" name="vendor_name">
		<input type="hidden" value="<?= $po_num['NO_PO'] ?>" name="po_number">
		<input type="hidden" value="<?= $po_num['NO_LPPB'] ?>" name="lppb_number">
		<input type="hidden" value="<?= $po_num['STATUS'] ?>" name="status">
		<input type="hidden" value="<?= $po_num['SHIPMENT'] ?>" name="shipment_number">
		<input type="hidden" value="<?= $po_num['TRANSACTION'] ?>" name="received_date">
		<input type="hidden" value="<?= $po_num['DESCRIPTION'] ?>" name="item_description">
		<input type="hidden" value="<?= $po_num['ITEM_ID'] ?>" name="item_id">
		<input type="hidden" value="<?= $po_num['QTY_RECEIPT'] ?>" name="qty_receipt">
		<input type="hidden" value="<?= $po_num['QUANTITY_BILLED'] ?>" name="quantity_billed">
		<input type="hidden" value="<?= $po_num['REJECTED'] ?>" name="qty_reject">
		<input type="hidden" value="<?= $po_num['CURRENCY'] ?>" name="currency">
		<input type="hidden" value="<?= $po_num['UNIT_PRICE'] ?>" name="unit_price">
		<input type="hidden" value="<?= $po_num['QUANTITY'] ?>" name="quantity">
		<?php }} ?>

		<table id="poLinesTable" class="table table-striped table-bordered table-hover text-center dataTable">
			<thead style="vertical-align: middle;"> 
				<tr class="bg-primary">
					<th class="text-center"><input type="checkbox" class="chkAllAddMonitoringInvoice" onclick="chkAllAddMonitoringInvoice();"></th>
					<th class="text-center">Line Number</th>
					<th class="text-center">Nama Vendor</th>
					<th class="text-center">PO Number</th>
					<th class="text-center">LPPB Number</th>
					<th class="text-center">Status LPPB</th>
					<th class="text-center">Shipment Number</th>
					<th class="text-center">Receive Date</th>
					<th class="text-center">Item Description</th>
					<th class="text-center">Item Code</th>
					<th class="text-center">Qty Amount</th>
					<th class="text-center">Qty Billed</th>
					<th class="text-center">Qty Reject</th>
					<th class="text-center" style="display: none">Currency</th>
					<th class="text-center" style="display: none">Unit Price</th>
					<th class="text-center">Qty PO</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1; foreach($invoice as $po_num) { ?>
				<tr id="<?php echo $no; ?>">
					<td>
						<input class="checkbox addMonitoringInvoice" id="addMonitoringInvoice" value="<?php echo $no; ?>" type="checkbox" name="inputInvoice" data-id="<?php echo $po_num['LINE_ID']?>">
					</td> 
					<td class="text-center"> <?php echo $po_num['LINE_NUM']?> </td>
					<td class="text-center"> <?php echo $po_num['VENDOR_NAME']?> </td>
					<td class="text-center"> <?php echo $po_num['NO_PO']?> </td>
					<td class="text-center"> <?php echo $po_num['NO_LPPB']?> </td>
					<td class="text-center"> <?php echo $po_num['STATUS']?> </td>
					<td class="text-center"> <?php echo $po_num['SHIPMENT']?> </td>
					<td class="text-center"> <?php echo $po_num['TRANSACTION']?> </td>
					<td class="text-center"> <?php echo $po_num['DESCRIPTION']?> </td>
					<td class="text-center"> <?php echo $po_num['ITEM_ID']?> </td>
					<td class="text-center"> <?php echo $po_num['QTY_RECEIPT']?> </td>
					<td class="text-center"> <?php echo $po_num['QUANTITY_BILLED']?> </td>
					<td class="text-center"> <?php echo $po_num['REJECTED']?> </td>
					<td class="text-center" style="display: none"> <?php echo $po_num['CURRENCY']?> </td>
					<td class="text-center" id="unit_price" style="display: none"> <?php echo $po_num['UNIT_PRICE']?> </td> 
					<td class="text-center" id="quantity"> <?php echo $po_num['QUANTITY']?> </td> 
				</tr>
				<?php $no++;} ?>
			</tbody>
		</table>
		<div class="col-md-2 pull-left">
			<button type="button" id="btnAddPoNumber" class="btn btn-success" style="margin-top: 10px">Add</button>
		</div>
