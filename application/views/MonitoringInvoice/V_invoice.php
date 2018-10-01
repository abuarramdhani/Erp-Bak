<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}

</style>
<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/saveBatchNumber') ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>List Data Invoice</b></span>
							<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/addListInv');?>">
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
										<button type="button" class="btn btn-primary pull-left" id="btnSubmitChecking" data-toggle="modal" data-target="#mdlChecking">Submit for Checking</button>
									</div>
									<div class="col-md-6"><button type="button" class="btn btn-success pull-right" id="clickExcel" onclick="clickExcel()" data-toggle="modal" data-target="#modaltariktanggal" >Export Excel</button></div>
								</div>
								<table id="tbListInvoice" class="table text-center dataTable">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Submit Checking</th>
											<th class="text-center">Action</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Po Detail</th>
											<th class="text-center">Status</th>
											<th class="text-center">Reason</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=1; foreach($invoice as $inv){ ?>
									
									<tr id="<?php echo $no; ?>">
										<td><?php echo $no ?></td>
										<td>
											<div class="checkbox">
											<input  type="checkbox" name="mi-check-list[]" value="<?php echo $inv['invoice_id']?>">
											</div>
										</td>
										<td>
											<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/editListInv/'.$inv['invoice_id'])?>">
											<button type="button" class="btn btn-success">Edit</button>
											</a>
											<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/deleteInvoice/'.$inv['invoice_id'])?>">
											<button type="button" onclick="return confirm('Yakin untuk menghapusnya?')" class="btn btn-danger">Delete</button>
											</a>
										</td>
										<td><?php echo  $inv['invoice_number'] ?></td>
										<td> <?php echo date('d-M-Y',strtotime($inv['invoice_date'])) ?></td>
										<td><?php echo  $inv['tax_invoice_number']?></td>
										<td id="inv_amount" class="inv_amount"><?php echo $inv['invoice_amount'] ?></td>
										<td id="po_amount" class="po_amount"><?php echo  $inv['po_amount']?></td>
										<td><?php echo  $inv['status_lppb']?></td>
										<td><?php echo  $inv['status']?></td>
										<td><?php echo  $inv['reason']?></td>
									</tr>
									<?php $no++; }?>
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
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Submit For Checking Confirmation</h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">Apakah Anda yakin akan melakukan Submit For Checking untuk <b id="jmlChecked"></b> Invoices ?</div>
		    </div>
		    <input type="hidden" name="idYangDiPilih" value="">
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    <button type="submit" class="btn btn-primary">Yes</button>
		  </div>
		</div>
 	</div>
</div>
</form>

<!-- Modal Tarikan Tanggal -->
<form action="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/exportExcelMonitoringInvoice') ?>" method="post">
	
<div id="modaltariktanggal" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="tarik_data" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Periode Tanggal Tarikan Data</h5>
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

