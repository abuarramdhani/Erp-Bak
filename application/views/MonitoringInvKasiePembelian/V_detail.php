<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>
<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/addReasonModifikasi/') ?>">
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
								<table id="tbListBatchPembelian" class="table table-striped table-bordered table-hover text-center dataTable" style="width: 100%">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th width="20%" class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th width="40%" class="text-center ">Action</th>
											<th class="text-center ">Reason</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($batch as $b){ ?>
										<tr>
											<td><?php echo $no ?></td>
											<td>
												<?php echo $b['VENDOR_NAME']?>
											</td>
											<td>
												<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/invoiceDetail/'.$b['INVOICE_ID'].'/'.$batch_number)?>">
												<?php echo $b['INVOICE_NUMBER']?>
												</a>
											</td>
											<td><?php echo date('d-M-Y',strtotime($b['INVOICE_DATE']))?></td>
											<td><?php echo $b['TAX_INVOICE_NUMBER']?></td>
											<td class="inv_amount" id="invoice_amount"><?php echo $b['INVOICE_AMOUNT']?></td>
											<td class="po_amount"><?php echo round($b['PO_AMOUNT'])?></td>
											<td style="background-color: <?php if ($b['FINANCE_STATUS'] == '1' or $b['FINANCE_STATUS'] == '2') { ?>
												grey
											<?php }else if($b['STATUS'] == '2' ){ ?>
												green
											<?php }else if($b['STATUS'] == '3'){ ?>
												red
											<?php } ?>">
												<label  class="radio-inline">
													<input type="radio" id="approvedByKasiePurc" <?php if ($b['STATUS'] == '2'): ?>
													checked
												<?php endif ?>  name="radioForReason[][<?php echo $b['INVOICE_ID'] ?>]" value="2"> Ok</label>
												<label class="radio-inline RejectByKasiePurc">
													<input  type="radio" id="RejectByKasiePurc" <?php if ($b['STATUS'] == '3'): ?>
														checked
													<?php endif ?> name="radioForReason[][<?php echo $b['INVOICE_ID'] ?>]" value="3">Not OK</label>
											</td>
											<td>
												<input style="width: 200px" type="text" id="alasan" name="inputReason[][<?php echo $b['INVOICE_ID']?>]" class="form-control" value="<?php echo $b['REASON'] ?>">
											</td>
										</tr>
										<?php $no++; } ?>
									</tbody>
								</table>
								<div class="col-md-3 pull-right">
									<button type="submit" id="btnSaveBatch" name="submitButton" class="btn btn-success" style="margin-top: 10px" value="2">Save</button>
									<button type="submit" id="btnToFinance" name="submitButton" class="btn btn-success pull-right" style="margin-top: 10px" value="1">Submit To Finance</button>
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