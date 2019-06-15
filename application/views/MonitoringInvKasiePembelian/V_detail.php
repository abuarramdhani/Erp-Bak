<style type="text/css">
#filter tr td{padding: 5px}
.text-left span {
	font-size: 36px
}
</style>
<!-- <form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/submittofinance') ?>"> -->
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
												<th class="text-center" width="10%;">Action</th>
												<th class="text-center">
													<!-- <input type="checkbox" class="checkbox submit_checking_all" name=""> -->
												</th>
												<th width="20%" class="text-center">Vendor Name</th>
												<th class="text-center">Invoice Number</th>
												<th class="text-center">Invoice Date</th>
												<th class="text-center">PPN</th>
												<th class="text-center">Tax Invoice Number</th>
												<th class="text-center">Invoice Amount</th>
												<th class="text-center">Po Amount</th>
												<th class="text-center">Created Date</th>
												<th class="text-center">Info Status</th>
											</tr>
										</thead>
										<tbody>
											<?php $no=1; foreach($batch as $b){ ?>
												<tr>
													<td><?php echo $no ?></td>
													<td>
														<button kedisable="0" inv="<?= $b['INVOICE_ID'] ?>" class="btn btn-xs btn-primary" type="button" name="checkbtndisable[]" onclick="bukaMOdal($(this))"><i class="fa fa-plus"></i></button>
														<button class="btn btn-xs btn-success" type="button" inv-id="<?php echo $b['INVOICE_ID']?>" onclick="btnApproveNew($(this))"><i class="fa fa-check"></i></button>
												</td>
												<td><input type="hidden" name="mi-check-list[]" class="chckInvoice" value="<?php echo $b['INVOICE_ID']?>"></td>
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
												<td class="inv_amount" >
												<?php if($b['INVOICE_AMOUNT']==NULL) {
									          	 echo 'Rp.'.' ,-';
									          	}else{
									          	 echo 'Rp. '. number_format($b['INVOICE_AMOUNT'],0,'.','.').',00-';
									          	};?>
									          	</td>
												<td class="po_amount">
												<?php if($b['PO_AMOUNT']==NULL) {
									          	 echo 'Rp.'.' ,-';
									          	}else{
									          	 echo 'Rp. '. number_format(round($b['PO_AMOUNT']),0,'.','.').',00-';
									          	};?>
									          	</td>
												<td><?php echo date('d-M-Y',strtotime($b['ACTION_DATE'])) ?></td>
												<td>
												<?php if($b['STATUS'] == 2){ ?>
													<button class="statusInvoice checked btn btn-xs btn-success" style="cursor: none" value="<?php echo $b['STATUS']?>" inv-id="<?php echo $b['INVOICE_ID']?>">Approve</button>
												<?php }elseif($b['STATUS'] == 3){ ?>
													<button class="statusInvoice checked btn btn-xs btn-danger" style="cursor: none" value="<?php echo $b['STATUS']?>" inv-id="<?php echo $b['INVOICE_ID']?>">Reject - <?php $b['REASON']?></button>
												<?php }elseif ($b['STATUS'] == 1) { ?>
													<button class="statusInvoice btn btn-xs btn-info" style="cursor: none" value="<?php echo $b['STATUS']?>" inv-id="<?php echo $b['INVOICE_ID']?>">Submit</button>
												<?php } ?>
												</td>
											</tr>
											<?php $no++; } ?>
										</tbody>
									</table>
									<div class="pull-right">
											<button type="submit" id="btnToFinance" name="submit_finance" class="btn btn-success pull-right" style="margin-top: 10px" value="1">Submit To Finance</button>
									</div>
									<div class="pull-right">
										<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie')?>">
											<button type="button" class="btn btn-primary pull-right" style="margin-top: 10px; margin-right: 10px;" >Back</button>
										</a>
									</div>
										<!-- <div class="pull-right">
											<button id="btnSubmitChecking" type="button" style="margin-top: 10px; margin-right: 5px;" class="btn btn-primary" data-toggle="modal" data-target="#uwuwuuwuwu">Approve</button>
										</div> -->
										<!-- <div class="pull-right">
											<button onclick="submitUlang($(this))" type="button" style="margin-top: 10px; margin-right: 5px;" class="btn btn-primary">Submit Ulang</button>
										</div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- </form> -->
<!-- Modal Submit For Edit/Reject Invoice -->
<!-- <form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/saveInvoicebyKasiePurchasing')?>"> -->
	<div class="modal fade bd-example-modal-lg" id="modal-invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Invoice Confirmation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body body_invoice">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<input type="hidden" name="nomor_batch" value="<?php echo $batch[0]['BATCH_NUMBER']?>">
					<!-- <button type="submit" class="btn btn-success">Save Edit</button> -->
					<!-- <button type="button" class="btn btn-primary" onclick="approveInvoice($(this))">Approve</button> -->
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#mdlreject">Reject</button>
				</div>
			</div>
		</div>
	</div>
<!-- </form> -->

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
						<div class="col-md-12">Alasan Reject </div>
					</div>
					<br>
					<input type="text" class="form-control" placeholder="Alasan Reject" name="alasan_reject" required="required">
					<input type="hidden" name="invoice_id" class="invoice_id">
					<input type="hidden" name="nomor_batch" value="<?php echo $batch[0]['BATCH_NUMBER']?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
					<button type="submit" class="btn btn-primary" name="prosesreject" value="3">Yes</button>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- Modal Submit For Approve Invoice -->
<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/approvedbykasiepurchasing')?>">
	<div id="uwuwuuwuwu" class="modal fade" role="dialog" >
		<div class="modal-dialog" role="document">
			<div class="modal-content"  id="content1" >
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title">Invoice Confirmation</h5>
				</div>
				<div class="modal-body">
					<span>Yakin untuk approve <b id="jmlChecked"></b> Invoice ?</span>
					<input type="hidden" name="idYangDiPilih">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="hidden" name="nomor_batch" value="<?php echo $batch[0]['BATCH_NUMBER']?>">
					<button type="submit" class="btn btn-success" name="prosesapprove" value="2">Approve</button>
				</div>
			</div>
		</div>
	</form>