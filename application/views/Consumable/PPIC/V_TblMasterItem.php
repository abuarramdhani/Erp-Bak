<table class="table table-bordered" id="master_item" style="width: 100%">
	<thead class="bg-green">
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">Item</th>
			<th class="text-center">Description</th>
			<th class="text-center">UoM</th>
			<th class="text-center">Created By</th>
			<th class="text-center">Creation Date</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;
		foreach ($master as $value) { ?>
			<tr>
				<input type="hidden" name="id_item[]" value="<?= $value['id'] ?>">
				<td class="text-center"><?= $no ?></td>
				<td class="text-center"><input type="hidden" name="itemcode[]" value="<?= $value['item_code'] ?>"><?= $value['item_code'] ?></td>
				<td class="text-center"><input type="hidden" name="itemdesc[]" value="<?= $value['item_desc'] ?>"><?= $value['item_desc'] ?></td>
				<td class="text-center"><input type="hidden" name="itemuom[]" value="<?= $value['uom'] ?>"><?= $value['uom'] ?></td>
				<td class="text-center"><input type="hidden" name="createdby[]" value="<?= $value['created_by'] ?>"><?= $value['created_by'] ?></td>
				<td class="text-center"><input type="hidden" name="creationdate[]" value="<?= $value['creation_date'] ?>"><?= $value['creation_date'] ?></td>
			</tr>
		<?php $no++;
		} ?>
	</tbody>
</table>