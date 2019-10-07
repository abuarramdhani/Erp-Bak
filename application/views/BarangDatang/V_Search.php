<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable({
			  "bSort" : false
			});
			
			$('#dataTables-table').dataTable({
			   "bSort" : false,
			   "searching": false,
			   "bLengthChange": false
			});
         });
    </script>
	<table class="table table-striped table-bordered table-hover text-left" id="dataTables-table" style="font-size:12px;">
		<thead>
			<tr class="bg-primary">
				<td width="8%"><b>No</b></td>
				<td width="1%"><b></td>
				<td width="20%"><b>Item </b></td>
				<td width="55%"><b>Item Description</b></td>
				<td width="15%"><b>Sub inv</b></td>
				<td width="5%"><b>QTY PO</b></td>
				<td width="5%"><b>QTY Simpan</b></td>
				<td width="5%"><b><center>QTY Datang</center></b></td>
			</tr>
		</thead>
		<tbody>
            <?php 
            // echo "<pre>"; print_r($data); exit();
			$num = 1;
			foreach ($Activity as $Activity_item): 
			if ($Activity_item ['QUANTITY'] == 0) {
				
			} else {
			?>
			<tr>
				<td><?php echo $num?></td>
				<td><input name="txtCheck[<?php echo $num-1; ?>]" id="txtCheck" value="add" type="checkbox"/></td>
				<td><input name="txtitem[]" id="txtitem" value="<?php echo $Activity_item ['ITEM']?>" type="hidden"/><?php echo $Activity_item ['ITEM']?></td>
				<td><input name="txtitem_description[]" id="txtitem_description" value="<?php echo $Activity_item ['ITEM_DESCRIPTION']?>" type="hidden"/><?php echo $Activity_item ['ITEM_DESCRIPTION']?></td>
				<td><input name="txtsubinv[]" id="txtsubinv" value="<?php echo $Activity_item ['SUBINV']?>" type="hidden"/><?php echo $Activity_item ['SUBINV']?></td>
				<td><?php echo $Activity_item ['QTY']?></td>
				<td><?php echo $Activity_item ['QTY2']?></td>
				<td><input name="txtqty[]" id="txtqty" value="<?php echo $Activity_item ['QUANTITY']?>"/>
				<input type="hidden" name="txtitemid[]" id="txtitemid" value="<?php echo $Activity_item ['ITEM_ID']?>"/></td>
			</tr>
			<?php $num++;} endforeach?>
		</tbody>
	</table>