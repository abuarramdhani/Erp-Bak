<table id="tabel_search_tracking_invoice" class="table table-striped table-bordered table-hover text-center dataTable">
	<thead style="vertical-align: middle;"> 
		<tr class="bg-primary">
			<td class="text-center">No</td>
			<td class="text-center">Action</td>
			<td class="text-center">Vendor name</td>
			<td class="text-center">Invoice Number</td>
			<td class="text-center">Invoice Date</td>
			<td class="text-center">Tax Invoice Number</td>
			<td class="text-center">Invoice Amount</td>
			<td class="text-center" title="Nomor PO - Line Num - LPPB Num - Status LPPB">PO Detail</td>
			<!-- <td class="text-center">Status</td> -->
		</tr>
	</thead>
	<tbody>
		<?php $no=1; if ($invoice) {
			foreach($invoice as $i) { ?>
		<tr>
			<td><?php echo $no?></td>
			<td><a class="btn btn-success" href="<?php echo base_url('Monitoring/TrackingInvoice/DetailInvoice/'.$i['INVOICE_ID'])?>">
				 Detail
				</a>
			</td>
			<td><?php echo $i['VENDOR_NAME']?></td>
			<td><?php echo $i['INVOICE_NUMBER']?></td>
			<td><?php echo $i['INVOICE_DATE']?></td>
			<td><?php echo $i['TAX_INVOICE_NUMBER']?></td>
			<td><?php echo $i['INVOICE_AMOUNT']?></td>
			<td><?php if($status[$i['INVOICE_ID']]){foreach ($status[$i['INVOICE_ID']] as $k) { ?>
											<?php echo  $k ."<br>" ?>
										<?php }} ?></td>
			<!-- <td><?php echo $i['']?></td> -->
		</tr>
		<?php $no++;}} ?>
	</tbody>
</table>
