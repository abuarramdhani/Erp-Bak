<table style="min-width:1600px;" id="table_SA" class="table table-responsive table-striped table-hover table-bordered">
	<thead class="bg-primary">
		<tr>
			<th style="vertical-align: middle; text-align:center; width: 3%">No</th>
			<th style="vertical-align: middle; text-align:center">Action</th>
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
			<td>
				<a class="btn btn-danger" href="javascript:void(0)" data-toggle="modal" data-target="#mdlStrgLoc">
					<i aria-hidden="true" class="fa fa-trash"></i>
				</a>
			</td>
			<td> <?php echo $SA['KODE_ASSEMBLY']; ?> </td>
			<td> <?php echo $SA['NAMA_ASSEMBLY']; ?> </td>
			<td> <?php echo $SA['TYPE_ASSEMBLY']; ?> </td>
			<td>
				<select class="form-control jsComponent item" style="width: 150px;" name="compCode" onchange="updateCompCode(this)" data-toggle="tooltip" data-placement="top" title="Automatically save when you change the value!">
					<option value="<?php echo $SA['ITEM']; ?>" selected><?php echo $SA['ITEM']; ?></option>
				</select>
				<input type="hidden" class="ID" value="<?php echo $SA['ID']; ?>">
				<input type="hidden" class="org_id" value="<?php echo $SA['ORGANIZATION_ID']; ?>">
			</td>
			<td> <?php echo $SA['DESCRIPTION']; ?> </td>
			<td>
				<select class="form-control select-2 sub_inv" style="max-width: 100px;" name="subInv" onchange="updateSubInv(this)" data-toggle="tooltip" data-placement="top" title="Automatically save when you change the value!">
					<?php foreach ($SubInv as $si) { 
						if ($si['SECONDARY_INVENTORY_NAME'] == $SA['SUB_INV']) {
					?>
						<option value="<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>" selected>
							<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>
						</option>
					<?php }elseif ($si['ORGANIZATION_ID'] == $SA['ORGANIZATION_ID']) { ?>
						<option value="<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>">
							<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>
						</option>
					<?php }
					} ?>
				</select>
			</td>
			<td align="center">
				<input type="text" class="alamat form-control" onkeypress="updateStorage(event, this)" value="<?php echo $SA['ALAMAT'];?>" data-toggle="tooltip" data-placement="top" title="Press Enter to save!">
			</td>
			<td>
				<select class="lmk form-control select-2" name="txtLmk[]" onchange="updateLMK(this)" style="width: auto;">
					<option></option>
					<option value="1" <?php if ($SA['LMK'] == "1") {echo "selected";} ?>>YES</option>
					<option value="0" <?php if ($SA['LMK'] == "0") {echo "selected";} ?>>NO</option>
				</select>
			</td>
			<td>
				<select class="form-control select-2 picklist" name="txtPicklist[]" onchange="updatePicklist(this)" style="width: auto;">
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
				<div id="mdlStrgLoc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Modal title</h4>
							</div>
							<div class="modal-body">
								<form method="post" action="<?php echo base_url('StorageLocation/Correction/Delete/'.$SA['ID']); ?>">
									<table class="table table-striped table-hover">
										<thead class="bg-primary">
		<tr>
			<th style="vertical-align: middle; text-align:center; width: 3%">No</th>
			<th style="vertical-align: middle; text-align:center">Action</th>
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
									</table>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary">Save changes</button>
							</div>
						</div>
					</div>
				</div>