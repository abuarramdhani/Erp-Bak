<script src="<?php echo BASE_URL('assets/plugins/jQuery/jQuery-2.1.4.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js');?>"></script>
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
	<script type="text/javascript">
	
	</script>
<table class="table table-striped table-bordered table-hover text-center" id="myTables" style="font-size:12px;min-width:1500px;table-layout: fixed;">
	<thead>
		<tr class="bg-primary">
			<td width="4%">NO</td>
			<td width="10%">KODE ASSEMBLY</td>
			<td width="15%">NAMA ASSEMBLY</td>
			<td width="10%">TYPE ASSEMBLY</td>
			<td width="10%">ITEM</td>
			<td width="15%">DESCRIPTION</td>
			<td width="10%">SUBINVENTORY</td>
			<td width="10%">ALAMAT</td>
			<td width="10%">LPPB/MO/KIB</td>
			<td width="10%">PICKLIST</td>
		</tr>
	</thead>
	<tbody>
		<?php 
			$num = 0;
			foreach ($BySA as $assembly){
			$num++;
			if ($assembly ['LMK'] == "1"){ $centang ="checked";}
			else { $centang ="";}			
			if ($assembly ['PICKLIST'] == "1"){$centang2 ="checked";}
			else {$centang2 ="";}
		?>
		<tr>
			<td><?php echo $num?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $assembly ['KODE_ASSEMBLY']?>" type="hidden"/><?php echo $assembly ['KODE_ASSEMBLY']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $assembly ['NAMA_ASSEMBLY']?>" type="hidden"/><?php echo $assembly ['NAMA_ASSEMBLY']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $assembly ['TYPE_ASSEMBLY']?>" type="hidden"/><?php echo $assembly ['TYPE_ASSEMBLY']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $assembly ['ITEM']?>" type="hidden"/><?php echo $assembly ['ITEM']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $assembly ['DESCRIPTION']?>" type="hidden"/><?php echo $assembly ['DESCRIPTION']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $assembly ['SUB_INV']?>" type="hidden"/><?php echo $assembly ['SUB_INV']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $assembly ['ALAMAT']?>" type="hidden"/><?php echo $assembly ['ALAMAT']?></td>
			<td><input type="checkbox"  readonly onclick="return false;" onkeydown="return false;" <?php echo "$centang"; ?>  /></td>
			<td><input type="checkbox"  readonly  onclick="return false;" onkeydown="return false;" <?php echo "$centang2"; ?>  /></td>
		</tr> 
		<?php }
		?>
	</tbody>
</table>