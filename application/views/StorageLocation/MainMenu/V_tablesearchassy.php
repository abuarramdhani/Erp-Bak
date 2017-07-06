<table style="min-width:1600px;" id="table_SA" class="table table-responsive table-striped table-hover table-bordered">
	<thead class="bg-primary">
		<tr>
			<th style="vertical-align: middle; text-align:center; width: 3%">No</th>
			<th style="vertical-align: middle; text-align:center">Assembly Code</th>
			<th style="vertical-align: middle; text-align:center">Assembly Name</th>
			<th style="vertical-align: middle; text-align:center">Assembly Type</th>
			<th style="vertical-align: middle; text-align:center">Component Code</th>
			<th style="vertical-align: middle; text-align:center">Description</th>
			<th style="vertical-align: middle; text-align:center">Subinventory</th>
			<th style="vertical-align: middle; text-align:center">Storage Location</th>
			<th style="vertical-align: middle; text-align:center; width: 5%;">LPPB / MO / KIB</th>
			<th style="vertical-align: middle; text-align:center; width: 5%;">Picklist</th>
		</tr>
	</thead>
	<tbody style="background-color: white; color: black" >
		<?php 
			$num = 1;
			foreach ($Assy as $SA) {
		?>
		<tr>
			<td> <?php echo $num; ?> </td>
			<td> <?php echo $SA['KODE_ASSEMBLY']; ?> </td>
			<td> <?php echo $SA['NAMA_ASSEMBLY']; ?> </td>
			<td> <?php echo $SA['TYPE_ASSEMBLY']; ?> </td>
			<td> <?php echo $SA['ITEM']; ?> </td>
			<td> <?php echo $SA['DESCRIPTION']; ?> </td>
			<td> <?php echo $SA['SUB_INV']; ?> </td>
			<td align="center">
				<input type="text" class="alamat form-control" onkeypress="entir(event, this)"  value="<?php echo $SA['ALAMAT'];?>"  data-toggle="tooltip" data-placement="top" title="Press Enter to save!"> 
				<input type="hidden" class="item form-control" value="<?php echo $SA['ITEM']; ?>" > 
				<input type="hidden" class="kode_assy form-control" value="<?php echo $SA['KODE_ASSEMBLY']; ?>"> 
				<input type="hidden" class="type_assy form-control" value="<?php echo $SA['TYPE_ASSEMBLY']; ?>"> 
				<input type="hidden" class="sub_inv form-control" value="<?php echo $SA['SUB_INV']; ?>"> 
			</td>
			<td>
				<select class="lmk form-control select-2" name="txtLmk[]" onchange="enter(event,this)" style="width: auto;">
					<option></option>
					<option value="1" <?php if ($SA['LMK'] == "1") {echo "selected";} ?>>YES</option>
					<option value="0" <?php if ($SA['LMK'] == "0") {echo "selected";} ?>>NO</option>
				</select>
			</td>
			<td>
				<select class="form-control select-2 picklist" name="txtPicklist[]" onchange="enter2(event,this)" style="width: auto;">
					<option></option>
					<option value="1" <?php if ($SA['PICKLIST'] == "1") {echo "selected";} ?>>YES</option>
					<option value="0" <?php if ($SA['PICKLIST'] == "0") {echo "selected";} ?>>NO</option>
				</select>
			</td>
		</tr>
		<?php
			$num++;
			}
		?>
	</tbody>
</table>