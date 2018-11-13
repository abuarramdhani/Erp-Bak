<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Unprocessed Invoice</b></span>
							<input type="hidden" value="<?php echo $batch_num ?>">
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<!-- <div style="overflow: auto;"> -->
								<table id="tbListBatchPembelian" class="table table-striped table-bordered table-hover text-center dataTable">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($unprocess as $u){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $u['VENDOR_NAME']?></td>
											<td><a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/DetailUnprocess/'.$u['FINANCE_BATCH_NUMBER'].'/'.$u['INVOICE_ID']);?>">
												<?php echo $u['INVOICE_NUMBER']?>
											</a></td>
											<td><?php echo date('d-M-Y',strtotime($u['INVOICE_DATE']))?></td>
											<td><?php echo $u['TAX_INVOICE_NUMBER']?></td>
											<td class="inv_amount" id="invoice_amount"><?php echo $u['INVOICE_AMOUNT']?></td>
											<td class="po_amount"><?php echo round($u['PO_AMOUNT'])?></td>
											<td><?php echo $u['LAST_STATUS_PURCHASING_DATE']?></td>
											<td><?php if($u['LAST_FINANCE_INVOICE_STATUS'] == 1){ ?>
												<button type="submit" data-id="<?= $u['INVOICE_ID'] ?>" onclick="prosesInvMI(this)" class="btn btn-primary" value="2" name="proses">Process</button>
											<?php }else{ ?>
												<span data-id="<?= $u['INVOICE_ID'] ?>" class="btn btn-success" value="2" name="success">Success</span>
											<?php } ?>
											</td>
										</tr>
										<?php $no++; } ?>
									</tbody>
								</table>
								<!-- </div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
