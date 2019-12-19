</style>
		<?php foreach ($lppb as $lp) 
		{ ?>
		<input type="hidden" value="<?php echo $lp['PO_HEADER_ID']?>" name="po_header_id">
		<input type="hidden" value="<?php echo $lp['PO_NUMBER']?>" name="po_number">
		<input type="hidden" value="<?php echo $lp['ORGANIZATION_ID']?>" name="organization_id">
		<input type="hidden" value="<?php echo $lp['ORGANIZATION_CODE']?>" name="organization_code">
		<input type="hidden" value="<?php echo $lp['LPPB_NUMBER']?>" name="lppb_number">
		<input type="hidden" value="<?php echo $lp['VENDOR_NAME']?>" name="vendor_name">
		<input type="hidden" value="<?php echo $lp['TANGGAL_LPPB']?>" name="tanggal_lppb">
		<input type="hidden" value="<?php echo $lp['STATUS_LPPB']?>" name="status_lppb">
		<?php } ?>

		<table id="showTableLppb" class="table table-striped table-bordered table-hover text-center">
			<thead style="vertical-align: middle;"> 
				<tr class="bg-primary">
					<th class="text-center"><input type="checkbox" class="chkAllLppb" onclick="chkAllLppb();"></th>
					<th class="text-center" style="display: none">Po Header Id</th>
					<th class="text-center" style="display: none">Organization Id</th>
					<th class="text-center">Organization Code</th>
					<th class="text-center">Lppb Number</th>
					<th class="text-center">Vendor Name</th>
					<th class="text-center">Tanggal Lppb</th>
					<th class="text-center">PO Number</th>
					<th class="text-center">Status Lppb</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1; foreach($lppb as $lp) { ?>
				<tr id="<?php echo $no; ?>">
					<td>
						<input class="checkbox chkAllLppbNumber" value="<?php echo $no; ?>" type="checkbox" name="inputInvoice" data-id="<?php $lp['PO_HEADER_ID']?>">
					</td> 
					<td class="text-center" style="display: none"> <?php echo $lp['PO_HEADER_ID']?> </td>
					<td class="text-center" style="display: none"> <?php echo $lp['ORGANIZATION_ID']?> </td>
					<td class="text-center"> <?php echo $lp['ORGANIZATION_CODE']?> </td>
					<td class="text-center"> <?php echo $lp['LPPB_NUMBER']?> </td>
					<td class="text-center"> <?php echo $lp['VENDOR_NAME']?> </td>
					<td class="text-center"> <?php echo $lp['TANGGAL_LPPB']?> </td>
					<td class="text-center"> <?php echo $lp['PO_NUMBER']?> </td>
					<td class="text-center"> <?php echo $lp['STATUS_LPPB']?> </td>
				</tr>
				<?php $no++;} ?>
			</tbody>
		</table>
		<div class="pull-right">
			<button type="button" id="addLppbNumber" class="btn btn-primary zoom" style="margin-top: 10px">Add</button>
		</div>
<script type="text/javascript">
	var id_gd;
</script>

