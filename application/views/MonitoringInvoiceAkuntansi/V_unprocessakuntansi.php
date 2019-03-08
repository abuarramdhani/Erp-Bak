<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>
<form action="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/saveActionAkuntansi')?>" method="POST">
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
								<table id="unprocessTabel" class="table table-striped table-bordered table-hover text-center tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center" style="width: 15%">Action</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">PPN</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">PO Number</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center">Alasan</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($unprocess as $u){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $u['VENDOR_NAME']?></td>
											<td><strong><?php echo $u['INVOICE_NUMBER']?></strong></td>
											<td>
												<a title="Detail..." href="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/DetailUnprocess/'.$u['BATCH_NUMBER'].'/'.$u['INVOICE_ID']);?>" class="btn btn-info btn-sm"><i class="fa fa-file-text-o"></i>
												</a>
											<?php if($u['LAST_FINANCE_INVOICE_STATUS'] == 1){ ?>
												<a title="Terima" type="submit" data-id="<?= $u['INVOICE_ID'] ?>" onclick="prosesInvMI(this)" class="btn btn-primary btn-sm" value="2" name="proses"><i class="glyphicon glyphicon-ok"></i></a>
											<?php }else{ ?>
												<span data-id="<?= $u['INVOICE_ID'] ?>" class="btn btn-success" value="2" name="success">Success</span>
											<?php } ?>
												<a title="Tolak" type="sumbit" data-id="<?= $u['INVOICE_ID'] ?>" onclick="prosesInvMI(this)" class="btn btn-danger btn-sm" value="3" name="proses"> <i class="glyphicon glyphicon-remove"></i>
												</a>
											</td>
											<td><?php echo date('d-M-Y',strtotime($u['INVOICE_DATE']))?></td>
											<td><?php echo $u['PPN'] ?></td>
											<td><?php echo $u['TAX_INVOICE_NUMBER']?></td>
											<td class="inv_amount" id="invoice_amount"><?php echo $u['INVOICE_AMOUNT']?></td>
											<td class="po_amount"><?php echo $u['PO_AMOUNT']?></td>
											<td><?php echo $u['PO_NUMBER']?></td>
											<td><?php echo $u['LAST_STATUS_PURCHASING_DATE']?></td>
											<td>
												 <input type="text" style="display: none" name="reason_finance[]" class="reason_finance_class"> <input type="hidden" name="id_reason[]" value="<?php echo $u['INVOICE_ID']?>">
											</td>
											<td><?php echo $u['SOURCE']?></td>
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
</section>	
</form>
