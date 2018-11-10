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
							<span><b>Reject Invoice</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="rejectinvoice" class="table table-striped table-bordered table-hover text-center dataTable">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center">Status</th>
											<th class="text-center">Reason</th>
											<th class="text-center">Batch Number</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($invoice){foreach($invoice as $f){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/Rejected/Detail/'.$f['INVOICE_ID']);?>">
												<?php echo $f['INVOICE_NUMBER']?>
												</a>
											</td>
											<td><?php echo date('d-M-Y',strtotime($f['INVOICE_DATE']))?></td>
											<td><?php echo $f['TAX_INVOICE_NUMBER']?></td>
											<td class="inv_amount"><?php echo round($f['INVOICE_AMOUNT'])?></td>
											<td class="po_amount"><?php echo round($f['PO_AMOUNT'])?></td>
											<td><?php echo $f['LAST_STATUS_PURCHASING_DATE']?></td>
											<?php if($f['LAST_PURCHASING_INVOICE_STATUS'] == 3){
												$status = 'Rejected by Kasie Purchasing'; 
												?> <td><?php echo $status?></td> <?php
											} else{ ?> <td><?php echo 'Invoice Tidak Reject'?></td> <?php }?>
											<td><?php echo $f['REASON']?></td>
											<td><?php echo $f['PURCHASING_BATCH_NUMBER']?></td>
										</tr>
										<?php $no++; }} ?>
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