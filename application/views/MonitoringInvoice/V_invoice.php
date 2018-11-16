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
								</div>
								<table id="tabel_invoice" class="table text-center datatable">
									<thead>
										<tr class="bg-primary">
											<th width="5%" class="text-center">No</th>
											<th width="5%" class="text-center">Submit Checking</th>
											<th width="10%" class="text-center">Action</th>
											<th width="5%"class="text-center">Supplier</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th width="5%"class="text-center">PPN</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th width="20%" class="text-center" title="No PO - Line Number - LPPB Number - LPPB Status">Po Detail</th>
											<th width="5%"class="text-center">Status</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=1; if ($invoice) { foreach($invoice as $inv){ ?>
									<tr id="<?php echo $no; ?>">
										<td><?php echo $no ?></td>
										<td>
											<div class="checkbox">
											<input  type="checkbox" name="mi-check-list[]" value="<?php echo $inv['INVOICE_ID']?>">
											</div>
										</td>
										<td>
											<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/editListInv/'.$inv['INVOICE_ID'])?>">
											<button type="button" class="btn btn-success"><i class="fa fa-pencil-square-o" style="width: 12px; height: 12px" ></i></button>
											</a>
											<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/deleteInvoice/'.$inv['INVOICE_ID'])?>">
											<button type="button" onclick="return confirm('Yakin untuk menghapusnya?')" class="btn btn-danger"><i class='fa fa-trash' style="width: 12px; height: 12px"></i></button>
											</a>
										</td>
										<td><?php echo $inv['VENDOR_NAME']?></td>
										<td><?php echo  $inv['INVOICE_NUMBER'] ?></td>
										<td> <?php echo date('d-M-Y',strtotime($inv['INVOICE_DATE'])) ?></td>
										<td><?php echo  $inv['PPN']?></td>
										<td> <input type="hidden" name="id" class="text_invoice_id" value="<?php echo $inv['INVOICE_ID']?>"> <input type="text" name="tax_input" class="tax_id" value="<?php echo $inv['TAX_INVOICE_NUMBER']?>" > 
											<button type="button" class=" btn btn-sm btn-primary saveTaxInvoice" id="saveTaxInvoice"><i class="fa fa-check-square"></i>
											</button></td>
										<td class="inv_amount"><?php echo $inv['INVOICE_AMOUNT']?></td>
										<td class="po_amount"><?php echo $inv['PO_AMOUNT']?></td>
										<td><?php if($keputusan[$inv['INVOICE_ID']]){foreach ($keputusan[$inv['INVOICE_ID']] as $k) { ?>
											<?php echo  $k ."<br>" ?>
										<?php }} ?></td>
										<?php if ( $inv['STATUS'] == 0) {
											$stat = 'New/Draft';
										}elseif ($inv['status'] == 1) {
											$stat = 'Submited by Kasie Purc';
										}elseif ($inv['status'] == 2) {
											$stat = 'Approved By Kasie Purc';
										}elseif ($inv['status'] == 3) {
											$stat = 'Rejected by Kasie Purc';
										} 

										if ($inv['PURCHASING_BATCH_NUMBER'] != 0) { 
										 	$batchnumber = 'SUBMITTED';
										}else{
										 	$batchnumber = 'NO SUMBIT';
										} ?>
										<td><?php echo $stat.'<br>'?>
										<span class="btn-sm  <?php if ($inv['PURCHASING_BATCH_NUMBER'] != 0): ?>
											btn-success
										<?php else: ?>
											btn-warning
										<?php endif ?>"  ><?php echo $batchnumber?></span></td>
									</tr>
									<?php $no++; }}?>
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

