<!-- <form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/saveInvoicebyKasiePurchasing')?>"> -->
<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-body">
							<table id="modal_tabel_invoice">
								<tr>
									<td>
										<span><label>Invoice Number</label></span>
									</td>
									<td><input  class="form-control" style="margin-bottom: 10px;" size="40" type="text" name="invoice_number" id="invoice_number" value="<?php echo $invoice[0]['INVOICE_NUMBER']?>">
										<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice[0]['INVOICE_ID']?>">
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Invoice Date</label></span>
									</td>
									<td>
										<input  class="form-control" style="margin-bottom: 10px;" size="40" type="text" value="<?php echo $invoice[0]['INVOICE_DATE']?>" name="invoice_date" id="invoice_date">
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Invoice Amount</label></span>
									</td>
									<td >
										<input class="form-control" style="margin-bottom: 10px;" size="40" type="text" value="<?php echo 'Rp. '. number_format($invoice[0]['INVOICE_AMOUNT'],0,'.','.').',00-';?>" name="invoice_amount" id="invoice_amountt">
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Tax Invoice Number</label></span>
									</td>
									<td>
										<input  class="form-control" style="margin-bottom: 10px;"  size="40" type="text" value="<?php echo $invoice[0]['TAX_INVOICE_NUMBER']?>" name="tax_invoice_number" id="tax_invoice_number">
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Invoice Category</label></span>
									</td>
									<td>
										<select id="invoice_categorySlc" name="invoice_category" class="form-control select2 select2-hidden-accessible" style="width:320px;">
											<option><?php echo $invoice[0]['INVOICE_CATEGORY']?></option>
											<option value="BARANG">BARANG</option>
											<option value="JASA NON EKSPEDISI TRAKTOR">JASA NON EKSPEDISI TRAKTOR</option>
											<option value="JASA EKSPEDISI TRAKTOR">JASA EKSPEDISI TRAKTOR</option>
										</select>
									</td>
									<td>
										<select name="jenis_jasa" id="jenis_jasaSlc" class="form-control select2 select2-hidden-accessible" style="width:320px;">
											<option style="margin-left: 10px;"><?php echo $invoice[0]['JENIS_JASA']?></option>
											<option></option>
											<option>RECEIPT</option>
											<option>RECEIPT DAN PEMBAYARAN</option>
											<option>RECEIPT DAN REASLISASI PREPAYMENT</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Nominal DPP Faktur Pajak</label></span>
									</td>
									<td>
										<input  class="form-control" style="margin-bottom: 10px; margin-top: 10px"  size="40" type="text" value="<?php echo 'Rp. '. number_format($invoice[0]['NOMINAL_DPP'],0,'.','.').',00-';?>" name="nominal_dpp" id="nominal_dpp">
									</td>
								</tr>
								<tr>
									<td>
										<span><label>Info</label></span>
									</td>
									<td>
										<textarea class="form-control" size="40" name="info" id="info" type="text"><?php echo $invoice[0]['INFO']?></textarea>
									</td>
								</tr>
							</table>
							<span><b>Invoice PO Detail</b></span>
							<div style="overflow: auto">
							<table id="tabel_invoice_modal" class="table tblMI" style="width: 200%">
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
		<div class="pull-left" style="margin-top: 10px">
			<label>Po Amount : </label><span><?php echo 'Rp. '. number_format(round($po_amount),0,'.','.').',00-';?></span>
		</div>
		</div>
	</div>
</div>
</div>
<div class="pull-right" style="margin-top: 30px; margin-left: 10px;">
	<button type="button" class="btn btn-primary" value="2" batch-num="<?php echo $invoice[0]['BATCH_NUMBER']?>" onclick="approveInvoice($(this))">Approve</button>
</div>
<!-- </form> -->