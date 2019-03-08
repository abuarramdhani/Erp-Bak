<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>
<form action="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/exportExcelMonitoringInvoice') ?>" method="post">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Batch Detail</b></span><input type="hidden" style="width: 10%" name="batch_num" class="form-control" value="<?php echo $batch_number; ?>">
						</div>
					</div>
					<div class="col-lg-12">
						<button type="sumbit" class="btn btn-success pull-right" id="clickExcel">Export Excel</button>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="row" style="margin-bottom: 10px">
									<div class="col-md-6">
										<h3><label>Batch Detail : <?=  $batch_number; ?></label></h3>
									</div>
								</div>
								<table id="tbListInvoice" class="table table-striped table-bordered table-hover text-center tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Action</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">PPN</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Status</th>
											<th class="text-center">Reason</th>
											<th class="text-center">Supplier</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($invoice as $inv){?>
										<tr id="<?php echo $no; ?>">
											<td><?php echo $no ?></td>
											<td>
												<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/ListSubmitedChecking/showInvoiceInDetail/'.$inv['INVOICE_ID'].'/'.$batch_number)?>">
												<button type="button" class="btn btn-default">Detail</button>
												</a>
											</td>
											<td><?php echo $inv['INVOICE_NUMBER'] ?></td>
											<td><?php echo date('d-M-Y',strtotime($inv['INVOICE_DATE'])) ?></td>
											<td><?php echo $inv['PPN']?></td>
											<td><?php echo $inv['TAX_INVOICE_NUMBER'] ?></td>
											<td class="inv_amount" ><?php echo $inv['INVOICE_AMOUNT'] ?></td>
											<td class="po_amount"><?php echo $inv['PO_AMOUNT'] ?></td>
											<?php if ($inv['LAST_FINANCE_INVOICE_STATUS'] == 2 && $inv['STATUS'] = 2) {
												$stat = 'Approved by Kasie Finance';
												}elseif ($inv['STATUS'] == 1) {
													$stat = 'Submited by Kasie Purc';
												}elseif ($inv['STATUS'] == 2) {
													$stat = 'Approved By Kasie Purc';
												}elseif ($inv['STATUS'] == 3) {
													$stat = 'Rejected by Kasie Purc';
												}elseif ($inv['STATUS'] == 0) {
													$Stat = 'New/Draft';
												} ?>
											<td><?php echo  $stat ?></td>
											<td><?php echo $inv['REASON'] ?></td>
											<td><?php echo $inv['VENDOR_NAME']?></td>
											<td><?php echo $inv['SOURCE']?></td>
										</tr>
										<?php $no++; } ?>
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
</form>


	