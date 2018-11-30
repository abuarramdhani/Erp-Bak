<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>
<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/submittofinance') ?>">
	<input type="hidden" name="nomor_batch" value="<?= $batch_number; ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Batch Details : <?= $batch_number; ?> </b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tabel_detail_purchasing" class="table text-center" style="width: 100%">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Action</th>
											<th width="20%" class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">PPN</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Created</th>
											<th class="text-center">Info Status</th>
											<th class="text-center" style="display: none;">Invoice_id</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($batch as $b){ ?>
										<tr>
											<td><?php echo $no ?></td>
											<td><button inv="<?= $b['INVOICE_ID'] ?>" class="btn btn-primary" type="button" onclick="bukaMOdal($(this))"><i class="fa fa-plus"></i></button></td>
											<td>
												<?php echo $b['VENDOR_NAME']?>
											</td>
											<td>
												<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/invoiceDetail/'.$b['INVOICE_ID'].'/'.$batch_number)?>">
												<?php echo $b['INVOICE_NUMBER']?>
												</a>
											</td>
											<td><?php echo date('d-M-Y',strtotime($b['INVOICE_DATE']))?></td>
											<td><?php echo $b['PPN']?></td>
											<td><?php echo $b['TAX_INVOICE_NUMBER']?></td>
											<td class="inv_amount" id="invoice_amount"><?php echo $b['INVOICE_AMOUNT']?></td>
											<td class="po_amount"><?php echo $b['PO_AMOUNT']?></td>
											<td><?php echo date('d-M-Y',strtotime($b['ACTION_DATE'])) ?></td>
											<?php if($b['FINANCE_STATUS'] == 1 and $b['STATUS'] == 2){
												$status = 'Done';
											}elseif($b['STATUS'] == 2){
												$status = 'Approve';
											}elseif($b['STATUS'] == 3){
												$status = 'Reject'.' - '.$b['REASON'];
											}elseif ($b['STATUS'] == 1) {
												$status = 'Sumbit';
											} ?>
											<td><?php echo $status?></td>
											<td><input type="hidden" name="invoice_id[]" value="<?php echo $b['INVOICE_ID']?>"></td>
										</tr>
										<?php $no++; } ?>
									</tbody>
								</table>
								<div class="col-md-3 pull-right">
									<button type="submit" id="btnToFinance" name="submit_finance" class="btn btn-success pull-right" style="margin-top: 10px" value="1">Submit To Finance</button>
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
</form>
<!-- Modal Submit For Approve/Reject Invoice -->
<form method="post" action="<?php echo base_url('')?>">
<div id="modal-invoice" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Invoice Confirmation</h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td><input  class="form-control" style="margin-bottom: 10px;" size="40" type="text" name="invoice_number" value="" readonly>
											<input type="hidden" name="invoice_id" value="">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
											<input  class="form-control" style="margin-bottom: 10px;" size="40" type="text" name="invoice_number" value="" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td >
											<input class="form-control" style="margin-bottom: 10px;" size="40" type="text" name="invoice_number" value="" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" style="margin-bottom: 10px;"  size="40" type="text" name="invoice_number" value="" readonly>
										</td>
									</tr>
								</table>
						<span><b>Invoice PO Detail</b></span>
						<div style="overflow: auto">
						<table id="" class="table table-bordered table-hover table-striped text-center" style="width: 200%">
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
								
								<tr>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								
							</tbody>
						</table>
						</div>
						<div class="pull-left">
							<label>Po Amount : </label><span></span>
						</div>
					</div>
		    </div>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    <button type="submit" class="btn btn-success" name="prosesapprove" value="2">Approve</button>
		    <button type="button" class="btn btn-danger" name="prosesreject" value="3">Reject</button>
		  </div>
		</div>
 	</div>
</div>
</form>