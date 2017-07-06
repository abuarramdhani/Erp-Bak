<table class="table table-striped table-bordered table-hover text-center" id="tableMonitor" style="font-size:12px;min-width:1500px;table-layout: fixed;">
	<thead>
		<tr class="bg-primary">
			<td width="4%">NO</td>
			<td width="10%">ASSEMBLY CODE</td>
			<td width="15%">ASSEMBLY NAME</td>
			<td width="10%">ASSEMBLY TYPE</td>
			<td width="10%">COMPONENT</td>
			<td width="15%">DESCRIPTION</td>
			<td width="10%">SUBINVENTORY</td>
			<td width="10%">STORAGE LOCATION</td>
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