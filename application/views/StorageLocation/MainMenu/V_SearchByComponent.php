<table class="table table-striped table-bordered table-hover text-center" id="tableMonitor" style="font-size:12px;min-width:1500px;table-layout: fixed;">
	<thead>
		<tr class="bg-primary">
			<td width="4%">NO</td>
			<td width="10%">ITEM</td>
			<td width="15%">DESCRIPTION</td>
			<td width="10%">KODE ASSEMBLY</td>
			<td width="15%">NAMA ASSEMBLY</td>
			<td width="10%">TYPE ASSEMBLY</td>
			<td width="10%">SUBINVENTORY</td>
			<td width="10%">ALAMAT</td>
			<td width="10%">LPPB/MO/KIB</td>
			<td width="10%">PICKLIST</td>
		</tr>
	</thead>
	<tbody>
		<?php 
			$num = 0;
			foreach ($ByKomp as $komponen){
			$num++;

			if ($komponen ['LMK'] == "1"){ $centang ="checked";}
			else { $centang ="";}			
			if ($komponen ['PICKLIST'] == "1"){$centang2 ="checked";}
			else {$centang2 ="";}

		?>
		<tr>
			<td><?php echo $num?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $komponen ['ITEM']?>" type="hidden"/><?php echo $komponen ['ITEM']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $komponen ['DESCRIPTION']?>" type="hidden"/><?php echo $komponen ['DESCRIPTION']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $komponen ['KODE_ASSEMBLY']?>" type="hidden"/><?php echo $komponen ['KODE_ASSEMBLY']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $komponen ['NAMA_ASSEMBLY']?>" type="hidden"/><?php echo $komponen ['NAMA_ASSEMBLY']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $komponen ['TYPE_ASSEMBLY']?>" type="hidden"/><?php echo $komponen ['TYPE_ASSEMBLY']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $komponen ['SUB_INV']?>" type="hidden"/><?php echo $komponen ['SUB_INV']?></td>
			<td><input name="txtitem[]" id="txtitem" value="<?php echo $komponen ['ALAMAT']?>" type="hidden"/><?php echo $komponen ['ALAMAT']?></td>
			<td><input type="checkbox"  readonly onclick="return false;" onkeydown="return false;" <?php echo "$centang"; ?>  /></td>
			<td><input type="checkbox"  readonly  onclick="return false;" onkeydown="return false;" <?php echo "$centang2"; ?>  /></td>
		</tr> 
		<?php }
		?>
	</tbody>
</table>