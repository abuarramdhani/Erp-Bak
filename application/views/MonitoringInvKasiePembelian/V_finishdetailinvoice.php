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
							<span><b>Finish Invoice Detail Purchasing</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="finishInvoice" class="table table-striped table-bordered table-hover text-center tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">PPN</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center">Batch Number</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($batch){foreach($batch as $f){?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $f['VENDOR_NAME']?></td>
												<td><a href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/finishinvoice/'.$f['INVOICE_ID']);?>">
													<?php echo $f['INVOICE_NUMBER']?>
												</a>
											</td>
											<td><?php echo date('d-M-Y',strtotime($f['INVOICE_DATE']))?></td>
											<td><?php echo $f['PPN']?></td>
											<td><?php echo $f['TAX_INVOICE_NUMBER']?></td>
											<td class="inv_amount" >
											<?php if($f['INVOICE_AMOUNT']==NULL) {
								          	 echo 'Rp.'.' ,-';
								          	}else{
								          	 echo 'Rp. '. number_format($f['INVOICE_AMOUNT'],0,'.','.').',00-';
								          	};?>
								          	</td>
											<td class="po_amount">
											<?php if($f['PO_AMOUNT']==NULL) {
								          	 echo 'Rp.'.' ,-';
								          	}else{
								          	 echo 'Rp. '. number_format(round($f['PO_AMOUNT']),0,'.','.').',00-';
								          	};?>
								          	</td>
											<td><?php echo $f['LAST_STATUS_PURCHASING_DATE']?></td>
											<td><?php echo $f['BATCH_NUMBER']?></td>
										</tr>
										<?php $no++; }} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-8 pull-right">
						<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceKasie/finishBatch')?>">
							<button type="button" class="btn btn-primary pull-right" style="margin-top: 10px" >Back</button>
						</a>
						<!-- <button type="button" class="btn btn-primary pull-right" onclick="submitUlangKasieGudang($(this))" value="<?php echo $batch[0]['BATCH_NUMBER']?>" style="margin-top: 10px; margin-right: 10px;" >Submit Ulang</button> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>