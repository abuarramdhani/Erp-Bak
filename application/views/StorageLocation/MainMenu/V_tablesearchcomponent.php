<table id="table_comp" class="table table-responsive table-striped table-hover table-bordered" style="min-width: 1600px;">
	<thead class="bg-primary">
		<tr>
			<th style="vertical-align: middle; text-align:center; width: 3%;">No</th>
			<th style="vertical-align: middle; text-align:center; width: 10%;">Component Code</th>
			<th style="vertical-align: middle; text-align:center">Description</th>
			<th style="vertical-align: middle; text-align:center">Assembly Code</th>
			<th style="vertical-align: middle; text-align:center">Assembly Name</th>
			<th style="vertical-align: middle; text-align:center">Assembly Type</th>
			<th style="vertical-align: middle; text-align:center;">Subinventory</th>
			<th style="vertical-align: middle; text-align:center; width: 12%;">Storage Location</th>
			<th style="vertical-align: middle; text-align:center; width: 5%;">LPPB / MO / KIB</th>
			<th style="vertical-align: middle; text-align:center; width: 5%;">Picklist</th>
		</tr>
	</thead>
	<tbody id="loading">
		<?php
			$num = 1;
			foreach ($Component as $comp) {
		?>
		<tr>
			<td><?php echo $num++; ?></td>
			<td>
				<select class="form-control jsComponent item" style="width: 150px;" name="compCode" onchange="updateCompCode(this)" data-toggle="tooltip" data-placement="top" title="Automatically save when you change the value!">
					<option value="<?php echo $comp['ITEM']; ?>" selected><?php echo $comp['ITEM']; ?></option>
				</select>
				<input type="hidden" class="ID" value="<?php echo $comp['ID']; ?>">
				<input type="hidden" class="org_id" value="<?php echo $comp['ORGANIZATION_ID']; ?>">
			</td>
			<td class="compDescArea"><?php echo $comp['DESCRIPTION']; ?></td>
			<td><?php echo $comp['KODE_ASSEMBLY']; ?></td>
			<td><?php echo $comp['NAMA_ASSEMBLY']; ?></td>
			<td><?php echo $comp['TYPE_ASSEMBLY']; ?></td>
			<td>
				<select class="form-control select-2 sub_inv" style="max-width: 100px;" name="subInv" onchange="updateSubInv(this)" data-toggle="tooltip" data-placement="top" title="Automatically save when you change the value!">
					<?php foreach ($SubInv as $si) { 
						if ($si['SECONDARY_INVENTORY_NAME'] == $comp['SUB_INV']) {
					?>
						<option value="<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>" selected>
							<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>
						</option>
					<?php }elseif ($si['ORGANIZATION_ID'] == $comp['ORGANIZATION_ID']) { ?>
						<option value="<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>">
							<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>
						</option>
					<?php }
					} ?>
				</select>
			</td>
			<td align="center">
				<input type="text" class="form-control" onkeypress="updateStorage(event,this)" value="<?php echo $comp['ALAMAT']; ?>" data-toggle="tooltip" data-placement="top" title="Press Enter to save!" style="width: 150px;"> 
			</td>
			<td>
				<select class="lmk form-control select-2" name="txtLmk[]" onchange="updateLMK(this)" style="width: auto;">
					<option></option>
					<option value="1" <?php if ($comp['LMK'] == "1") {echo "selected";} ?>>YES</option>
					<option value="0" <?php if ($comp['LMK'] == "0") {echo "selected";} ?>>NO</option>
				</select>
			</td>
			<td>
				<select class="form-control select-2 picklist" name="txtPicklist[]" onchange="updatePicklist(this)" style="width: auto;">
					<option></option>
					<option value="1" <?php if ($comp['PICKLIST'] == "1") {echo "selected";} ?>>YES</option>
					<option value="0" <?php if ($comp['PICKLIST'] == "0") {echo "selected";} ?>>NO</option>
				</select>
			</td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>