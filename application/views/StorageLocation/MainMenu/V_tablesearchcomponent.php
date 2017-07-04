<table id="table_comp" class="table table-responsive table-striped table-hover table-bordered" style="min-width: 1600px;">
	<thead class="bg-primary">
		<tr>
			<th style="vertical-align: middle; text-align:center; width: 3%;">No</th>
			<th style="vertical-align: middle; text-align:center">Item</th>
			<th style="vertical-align: middle; text-align:center">Description</th>
			<th style="vertical-align: middle; text-align:center">Kode Assembly</th>
			<th style="vertical-align: middle; text-align:center">Nama Assembly</th>
			<th style="vertical-align: middle; text-align:center">Type Assembly</th>
			<th style="vertical-align: middle; text-align:center">Subinventory</th>
			<th style="vertical-align: middle; text-align:center">Alamat</th>
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
			<td> <?php echo $num; ?> </td>
			<td> <?php echo $comp['ITEM']; ?> </td>
			<td> <?php echo $comp['DESCRIPTION']; ?> </td>
			<td> <?php echo $comp['KODE_ASSEMBLY']; ?> </td>
			<td> <?php echo $comp['NAMA_ASSEMBLY']; ?> </td>
			<td> <?php echo $comp['TYPE_ASSEMBLY']; ?> </td>
			<td> <?php echo $comp['SUB_INV']; ?> </td>
			<td align="center">
				<input type="text" class="alamat form-control" onkeypress="entir(event, this)"  value="<?php echo $comp['ALAMAT']; ?>"> 
				<input style="display: none" type="text" hiden class="item form-control" value="<?php echo $comp['ITEM']; ?>" > 
				<input style="display: none" type="text" hiden class="kode_assy form-control" value="<?php echo $comp['KODE_ASSEMBLY']; ?>">
				<input style="display: none" type="text" hiden class="type_assy form-control" value="<?php echo $comp['TYPE_ASSEMBLY']; ?>">
				<input style="display: none" type="text" hiden class="sub_inv form-control" value="<?php echo $comp['SUB_INV']; ?>"> 
			</td>
			<td>
				<select class="lmk form-control select-2" name="txtLmk[]" onchange="enter(event,this)" style="width: auto;">
					<option></option>
					<option value="1" <?php if ($comp['LMK'] == "1") {echo "selected";} ?>>YES</option>
					<option value="0" <?php if ($comp['LMK'] == "0") {echo "selected";} ?>>NO</option>
				</select>
				<!-- <input type="checkbox" class="lmk" onchange="enter(event,this)" <?php echo $centang;?>/> -->
			</td>
			<td>
				<select class="form-control select-2 picklist" name="txtPicklist[]" onchange="enter2(event,this)" style="width: auto;">
					<option></option>
					<option value="1" <?php if ($comp['PICKLIST'] == "1") {echo "selected";} ?>>YES</option>
					<option value="0" <?php if ($comp['PICKLIST'] == "0") {echo "selected";} ?>>NO</option>
				</select>
				<!-- <input type="checkbox" class="picklist" onchange="enter2(event,this)" <?php echo $centang2;?>/> -->
			</td>
		</tr>
		<?php
			$num++;
			}
		?>
	</tbody>
</table>