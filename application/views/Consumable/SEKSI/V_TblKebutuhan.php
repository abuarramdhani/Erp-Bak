<table class="table table-bordered" id="daftar_kebutuhan" style="width: 100%">
	<thead class="bg-aqua">
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">Item</th>
			<th class="text-center">Desc</th>
			<th class="text-center">Qty</th>
			<th class="text-center">Created By</th>
			<th class="text-center">Creation Date</th>
			<th class="text-center">Status</th>

		</tr>
	</thead>
	<tbody>
		<?php $no = 1;
		foreach ($kebutuhan as $value) { ?>
			<tr>
				<input type="hidden" name="id_item[]" value="<?= $value['id'] ?>">
				<td class="text-center"><?= $no ?></td>
				<td class="text-center"><input type="hidden" name="itemcode[]" value="<?= $value['item_code'] ?>"><?= $value['item_code'] ?></td>
				<td class="text-center"><input type="hidden" name="itemdesc[]" value="<?= $value['desc'] ?>"><?= $value['desc'] ?></td>
				<td class="text-center"><input type="hidden" name="itemqty[]" value="<?= $value['quantity'] ?>"><?= $value['quantity'] ?></td>
				<td class="text-center"><input type="hidden" name="createdby[]" value="<?= $value['created_by'] ?>"><?= $value['created_by'] ?></td>
				<td class="text-center"><input type="hidden" name="creationdate[]" value="<?= $value['creation_date'] ?>"><?= $value['creation_date'] ?></td>
				<td class="text-center"><input type="hidden" name="statuss[]" value="<?= $value['status'] ?>"><?= $value['status'] ?></td>

			</tr>
		<?php $no++;
		} ?>
	</tbody>
</table>