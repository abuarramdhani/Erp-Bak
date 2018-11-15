<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>
<form action="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/saveReasonAkuntansi')?>" method="POST">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Unprocessed Invoice</b></span>
							<input type="hidden" name="batch_num" value="<?php echo $batch_num ?>">
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<!-- <div style="overflow: auto;"> -->
								<table id="unprocessTabel" class="table table-striped table-bordered table-hover text-center datatable">
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
											<th class="text-center" width="20%" title="No PO - Line Number - LPPB Number - Status LPPB">Po Detail</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center" width="15%">Action</th>
											<th class="text-center">Alasan Ditolak</th>
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
											<td><?php echo $u['PPN']?></td>
											<td><?php echo $u['TAX_INVOICE_NUMBER']?></td>
											<td class="inv_amount" id="invoice_amount"><?php echo $u['INVOICE_AMOUNT']?></td>
											<td class="po_amount"><?php echo $u['PO_AMOUNT']?></td>
											<td><?php if($keputusan[$u['INVOICE_ID']]){foreach ($keputusan[$u['INVOICE_ID']] as $k) { ?>
												<?php echo  $k ."<br>" ?>
											<?php }} ?></td>
											<td><?php echo $u['LAST_STATUS_PURCHASING_DATE']?></td>
											<td><?php if($u['LAST_FINANCE_INVOICE_STATUS'] == 1){ ?>
												<button type="submit" data-id="<?= $u['INVOICE_ID'] ?>" onclick="prosesInvMI(this)" class="btn btn-primary" value="2" name="proses">Terima</button>
											<?php }else{ ?>
												<span data-id="<?= $u['INVOICE_ID'] ?>" class="btn btn-success" value="2" name="success">Success</span>
											<?php } ?>
												<button type="sumbit" data-id="<?= $u['INVOICE_ID'] ?>" onclick="prosesInvMI(this)" class="btn btn-danger" value="3" name="proses" >
												 Tolak
												</button>
											</td>
											<td>
												 <input type="text" name="reason_finance[]" class="reason_finance_class" value="<?php echo $u['REASON_FINANCE']?>" > <input type="hidden" name="id_reason[]" class="reason_invoice_id" value="<?php echo $u['INVOICE_ID']?>">
											</td>
										</tr>
										<?php $no++; } ?>
									</tbody>
								</table>
								<div class="col-md-2 pull-right">
									<button type="submit" class="btn btn-primary pull-right" style="margin-top: 10px" >Submit</button>
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
