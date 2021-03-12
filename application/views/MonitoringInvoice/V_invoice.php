<style type="text/css">
	#filter tr td {
		padding: 5px
	}

	.text-left span {
		font-size: 36px
	}
</style>
<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/saveBatchNumber') ?>">
	<section class="content">
		<div class="inner">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-left ">
								<span><b>List Data Invoice</b></span>
								<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/addListInv'); ?>">
									<button type="button" class="btn btn-lg btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i></button>
								</a>
							</div>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-body">
									<div class="row" style="margin-bottom: 10px">
										<div class="col-md-6">
											<button type="button" class="btn btn-primary pull-left" id="btnSubmitChecking" data-target="#mdlChecking" data-toggle="modal">Submit for Checking</button>
											<?php
											$err = validation_errors();
											if (isset($err) && !empty($err)) :
												echo '<script> alert("' . str_replace(array('\r', '\n'), '\n', $err) . '"); </script>';
											endif;
											?>
										</div>
										<div class="col-md-6">
											<span class="btn btn-warning pull-right" style="cursor: none"><i class="fa fa-exclamation-triangle"></i> Submit hanya berdasarkan kategori invoice yang sama</span>
										</div>
									</div>
									<table id="tabel_invoice" class="text-center tblMI" style="width: 100%">
										<thead>
											<tr class="bg-primary">
												<th class="text-center">No</th>
												<th class="text-center"><input type="checkbox" id="submit_checking_all" class="submit_checking_all" onclick="chkSubmitChecking($(this));"></th>
												<th class="text-center">Action</th>
												<th class="text-center">Invoice Category</th>
												<th class="text-center">Jasa</th>
												<th class="text-center">Supplier</th>
												<th class="text-center">Invoice Number</th>
												<th class="text-center">Invoice Date</th>
												<th class="text-center">PPN</th>
												<th class="text-center">Tax Invoice Number</th>
												<th class="text-center">Invoice Amount</th>
												<th class="text-center">Po Amount</th>
												<th class="text-center" title="No PO - Line Number - LPPB Number - LPPB Status"> Po Detail</th>
												<th class="text-center">Status</th>
												<th class="text-center">PIC</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											if ($invoice) {
												foreach ($invoice as $inv) { ?>
													<tr id="<?php echo $no; ?>">
														<td style="width: 3%"><?php echo $no ?></td>
														<td style="width: 5%">
															<input type="checkbox" class="chckInvoice" name="mi-check-list[]" value="<?php echo $inv['INVOICE_ID'] ?>" inv-cat="<?php echo $inv['INVOICE_CATEGORY'] ?>">
														</td>
														<td style="width: 8%">
															<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/editListInv/' . $inv['INVOICE_ID']) ?>" title="Detail invoice ..." class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i>
															</a>
															<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/deleteInvoiceManual/' . $inv['INVOICE_ID']) ?>" title="Delete invoice ..." onclick="return confirm('Yakin untuk menghapusnya?')" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i>
															</a>
														</td>
														<td style="width: 7%"><?php echo $inv['INVOICE_CATEGORY'] ?></td>
														<td style="width: 7%">
															<?php echo $inv['JENIS_JASA'] ?>
														</td>
														<td style="width: 7%"><?php echo $inv['VENDOR_NAME'] ?></td>
														<td style="width: 5%"><?php echo  $inv['INVOICE_NUMBER'] ?></td>
														<td style="width: 5%"> <?php echo date('d-M-Y', strtotime($inv['INVOICE_DATE'])) ?></td>
														<td style="width: 5%"><?php echo  $inv['PPN'] ?></td>
														<td style="width: 8%"><?php echo $inv['TAX_INVOICE_NUMBER'] ?></td>
														<td style="width: 5%" class="inv_amount"><?php if ($inv['INVOICE_AMOUNT'] == NULL) {
																										echo 'Rp.' . ' ,-';
																									} else {
																										echo 'Rp. ' . number_format($inv['INVOICE_AMOUNT'], 0, '.', '.') . ',00-';
																									}; ?>
														</td>
														<td style="width: 5%" class="po_amount"><?php if ($inv['PO_AMOUNT'] == NULL) {
																									echo 'Rp.' . ' ,-';
																								} else {
																									echo 'Rp. ' . number_format(round($inv['PO_AMOUNT']), 0, '.', '.') . ',00-';
																								}; ?>
														</td>
														<td style="width: 60%"><?php if ($keputusan[$inv['INVOICE_ID']]) {
																					foreach ($keputusan[$inv['INVOICE_ID']] as $k) { ?>
																	<?php echo  $k . "<br>" ?>
															<?php }
																				} ?></td>
														<?php if ($inv['STATUS'] == 0) {
															$stat = 'New/Draft';
														} elseif ($inv['STATUS'] == 1) {
															$stat = 'Submited by Kasie Purc';
														} elseif ($inv['STATUS'] == 2) {
															$stat = 'Approved By Kasie Purc';
														} elseif ($inv['STATUS'] == 3) {
															$stat = 'Rejected by Kasie Purc';
														} ?>
														<td style="width: 10%"><?php echo $stat ?></td>
														<td style="width: 10%"><?php echo $inv['SOURCE'] ?></td>
													</tr>
											<?php $no++;
												}
											} ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>
	<!-- Modal Submit For Checking -->
	<div id="mdlChecking" class="modal fade" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content" id="content1">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title">Submit For Checking Confirmation</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">Apakah Anda yakin akan melakukan Submit For Checking untuk <b id="jmlChecked"></b> Invoices ?</div>
					</div>
					<input type="hidden" name="idYangDiPilih" value="">
					<input type="hidden" name="invoice_category" class="invoice_category" value="<?php echo $invoice[0]['INVOICE_CATEGORY'] ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
					<button type="submit" id="btnYes" class="btn btn-primary" name="status_purchase" value="1">Yes</button>
				</div>
			</div>
		</div>
	</div>
</form>