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
								<div class="box-body">
      								<button type="button" class="btn btn-danger btn-m pull-left" onclick="deleteRejectedInv(this)" style="margin-bottom:10px;width:150px" ><i class="fa fa-trash"></i> Delete Invoice</button>
     							</div>   
								<div style="overflow-x: auto;">
								<table id="rejectinvoice" class="table-striped table-bordered table-hover text-center tblMI" style="width: 150%;">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center"><input type="checkbox" class="submit_checking_all_rejected"></th>
											<th class="text-center">Action</th>
											<th class="text-center">Supplier</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center" width="15%" title="No PO - Line Number - LPPB Number - LPPB Status">Po Detail</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center">Status</th>
											<th class="text-center">Reject Date</th>
											<th class="text-center">Reason</th>
											<th class="text-center">Batch Number</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($invoice){foreach($invoice as $f){?>
										<tr class="<?php echo $f['INVOICE_ID']?>">
											<td style="width:3%;"><?php echo $no ?></td>
											<td style="width: 5%">
											<input  type="checkbox" class="chckInvoice_rejected" value="<?php echo $f['INVOICE_ID']?>" name="rejectedChckBox[]">
											</td>
											<td style="width:8%;">
												
											<a title="Detail ..." href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/Rejected/Detail/'.$f['INVOICE_ID']);?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o" ></i>
											</a>

											<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice/viewEditReject/'.$f['INVOICE_ID'])?>" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i>
											</a>

											</td>
											<td style="width:7%;"><?php echo $f['VENDOR_NAME']?></td>
											<td style="width:6%;">
												<?php echo $f['INVOICE_NUMBER']?>
												
											</td>
											<td style="width:6%;"><?php echo date('d-M-Y',strtotime($f['INVOICE_DATE']))?></td>
											<td style="width:7%;"><?php echo $f['TAX_INVOICE_NUMBER']?></td>
											<td style="width:6%;" class="inv_amount"><?php if($f['INVOICE_AMOUNT']==NULL) {
								          	 echo 'Rp.'.' ,-';
								          	}else{
								          	 echo 'Rp. '. number_format($f['INVOICE_AMOUNT'],0,'.','.').',00-';
								          	};?>
								          	</td>
											<td class="po_amount"><?php if($f['PO_AMOUNT']==NULL) {
								          	 echo 'Rp.'.' ,-';
								          	}else{
								          	 echo 'Rp. '. number_format(round($f['PO_AMOUNT']),0,'.','.').',00-';
								          	};?>
								          	</td>
											<td style="width:30%;" ><?php if($keputusan[$f['INVOICE_ID']]){foreach ($keputusan[$f['INVOICE_ID']] as $k) { ?>
												<?php echo  $k ."<br>" ?>
											<?php }} ?></td>
											<td style="width:10%;"><?php echo $f['LAST_STATUS_PURCHASING_DATE']?></td>
											<?php if($f['LAST_PURCHASING_INVOICE_STATUS'] == 3){
												$status = 'Rejected by Kasie Purchasing'; 
											} elseif($f['LAST_FINANCE_INVOICE_STATUS'] == 3){ 
												$status = 'Rejected by Kasie Finance';
											}?>
											<td style="width:7%;" ><?php echo $status; ?></td>
											<td style="width:8%;"><?php echo $f['REJECT_DATE']?></td>
											<td style="width:15%;"><?php echo $f['REASON']?></td>
											<td style="width:15%;"><?php echo $f['BATCH_NUMBER']?></td>
											<td style="width:10%;"><?php echo $f['SOURCE']?></td>
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
	</div>
</section>