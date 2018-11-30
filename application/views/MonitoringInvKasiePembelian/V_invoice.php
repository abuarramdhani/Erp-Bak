<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoiceKasie tr td{padding: 5px}
</style>
<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/approvedbykasiepurchasing')?>" >
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Invoice Details</b></span>
							<input type="hidden" name="nomor_batch"  value="<?php echo $invoice_detail[0]['PURCHASING_BATCH_NUMBER']?>">
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
							<form id="filInvoice" >
								<table id="tbInvoiceKasie" >
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td><input  class="form-control" size="40" type="text" name="invoice_number" value="<?php echo $invoice_detail[0]['INVOICE_NUMBER']?>" readonly>
											<input type="hidden" name="invoice_id" value="<?php echo $invoice_detail[0]['INVOICE_ID']?>">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" name="invoice_number" value="<?php echo date('d-M-Y',strtotime($invoice_detail[0]['INVOICE_DATE']))?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td >
											<input class="form-control" size="40" type="text" name="invoice_number" value="<?php echo $invoice_detail[0]['INVOICE_AMOUNT']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" name="invoice_number" value="<?php echo $invoice_detail[0]['TAX_INVOICE_NUMBER']?>" readonly>
										</td>
									</tr>
								</table>
							</form>
						<span><b>Invoice PO Detail</b></span>
						<div style="overflow: auto">
						<table id="invoiceKasiePembelian" class="table table-bordered table-hover table-striped text-center" style="width: 200%">
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
								<?php $no=1; $po_amount=0; foreach($invoice_detail as $b){?>
								<tr>
									<td class="text-center"><?php echo $no ?></td>
									<td class="text-center"><?php echo $b['VENDOR_NAME']?></td>
									<td class="text-center"><?php echo $b['PO_NUMBER']?></td>
									<td class="text-center"><?php echo $b['LPPB_NUMBER']?></td>
									<td class="text-center"><?php echo $b['SHIPMENT_NUMBER']?></td>
									<td class="text-center"><?php echo $b['RECEIVED_DATE']?></td>
									<td class="text-center"><?php echo $b['ITEM_DESCRIPTION']?></td>
									<td class="text-center"><?php echo $b['ITEM_CODE']?></td>
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
						<div class="col-md-12">
						<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$batch_number)?>">
							<button type="button" class="btn btn-primary pull-right" style="margin-top: 10px; margin-left: 10px" >Back</button>
						</a>
							<button class="btn btn-danger pull-right" type="button" style="margin-top: 10px; margin-left: 10px" data-toggle="modal" data-target="#mdlreject">Reject</button>
							<button class="btn btn-success pull-right" type="submit" value="2" name="prosesapproved" style="margin-top: 10px">Approved</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>
<!-- Modal Submit For Reject Invoice -->
<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/rejectbykasiepurchasing')?>">
<div id="mdlreject" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Reject Invoice Confirmation</h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">Reject Nomor Invoice </div>
		    </div>
		    <br>
		    <input type="text" class="form-control" placeholder="Alasan Reject" name="alasan_reject" required="required">
		    <input type="hidden" name="invoice_id" value="<?php echo $invoice_detail[0]['INVOICE_ID']?>">
		    <input type="hidden" name="nomor_batch" value="<?php echo $invoice_detail[0]['PURCHASING_BATCH_NUMBER']?>">
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    <button type="submit" class="btn btn-primary" name="prosesreject" value="3">Yes</button>
		  </div>
		</div>
 	</div>
</div>
</form>