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
							<span><b>Finish Invoice</b></span>
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
											<th class="text-center">Laporkan Invoice</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">PPN</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Nominal DPP Faktur Pajak</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center">Finance Process Date</th>
											<th class="text-center">Batch Number</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($finish){foreach($finish as $f){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><a target="_blank" title="Laporkan sebagai Inv bermasalah..." class="btn btn-warning btn-sm" href="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/invBermasalah/'.$f['INVOICE_ID']);?>" ><i class="fa fa-bullhorn"></i>
												</a></td>
											<td><?php echo $f['VENDOR_NAME']?></td>
											<td><a target="_blank" href="<?php echo base_url('AccountPayables/MonitoringInvoice/Finish/DetailProcessed/'.$f['INVOICE_ID']);?>">
												<?php echo $f['INVOICE_NUMBER']?>
												</a>
											</td>
											<td><?php echo date('d-M-Y',strtotime($f['INVOICE_DATE']))?></td>
											<td><?php echo $f['PPN']?></td>
											<td><?php echo $f['TAX_INVOICE_NUMBER']?></td>
											<td><?php echo $f['NOMINAL_DPP']?></td>
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
											<td><?php echo $f['LAST_STATUS_FINANCE_DATE']?></td>
											<td><?php echo $f['BATCH_NUMBER']?></td>
											<td><?php echo $f['SOURCE']?></td>
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