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
							<span><b>Batch Detail</b></span>
						</div>
					</div>
					<div class="col-lg-12">
						<button type="button" class="btn btn-success pull-right clickExcel" id="clickExcel" onclick="clickExcel()" data-toggle="modal" data-target="#modaltariktanggal" >Export Excel</button>
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
								<table id="tbListInvoice" class="table table-striped table-bordered table-hover text-center dataTable">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Action</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Status</th>
											<th class="text-center">Reason</th>
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
											<td><?php echo $inv['TAX_INVOICE_NUMBER'] ?></td>
											<td class="inv_amount" ><?php echo round($inv['INVOICE_AMOUNT']) ?></td>
											<td class="po_amount"><?php echo round($inv['PO_AMOUNT']) ?></td>
											<?php if ( $inv['STATUS'] == 0) {
												$stat = 'New/Draft';
												}elseif ($inv['STATUS'] == 1) {
													$stat = 'Submited by Kasie Purc';
												}elseif ($inv['STATUS'] == 2) {
													$stat = 'Approved By Kasie Purc';
												}elseif ($inv['STATUS'] == 3) {
													$stat = 'Rejected by Kasie Purc';
												} ?>
											<td><?php echo  $stat ?></td>
											<td><?php echo $inv['REASON'] ?></td>
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
	<!-- Modal Tarikan Tanggal -->
<form action="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/exportExcelMonitoringInvoice') ?>" method="post">
<div id="modaltariktanggal" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="tarik_data" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Periode Tanggal Tarikan Data</h5><input type="hidden" style="width: 10%" name="batch_num" class="form-control" value="<?php echo $batch_number; ?>" readonly>
		  </div>
		  <div class="modal-body">
		    <table id="filter">
				<tr>
					<td>
						<div class="input-group date" data-provide="datepicker">
	    					<input size="30" type="text" class="form-control" name="dateTarikFrom" id="dateTarikFrom" placeholder="From">
	    					<div class="input-group-addon">
	        					<span class="glyphicon glyphicon-calendar"></span>
	    					</div>
						</div>
					</td>
					<td>
						<span class="align-middle">s/d</span>
					</td>
					<td>
						<div class="input-group date" data-provide="datepicker">
	    					<input size="30" type="text" class="form-control" name="dateTarikTo" id="dateTarikTo" placeholder="To">
	    					<div class="input-group-addon">
	        					<span class="glyphicon glyphicon-calendar"></span>
	    					</div>
						</div>
					</td>
				</tr>
			</table>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    <button type="submit" class="btn btn-primary">Yes</button>
		  </div>
		</div>
 	</div>
</div>
</form>
</section>


	