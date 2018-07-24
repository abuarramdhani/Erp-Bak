	<div class="table-responsive">
		<?php if($itemCombine){foreach ($itemCombine as $ci) { ?>
		<input type="hidden" value="<?= $ci['item'] ?>" name="hdnItem[]">
		<input type="hidden" value="<?= $ci['description'] ?>" name="hdnDsc[]">
		<input type="hidden" value="<?= $ci['qty_available'] ?>" name="hdnQty[]">
		<?php }} ?>
		
		<table id="tbItemTokoquick" class="table table-striped table-bordered table-hover text-center">
			<thead>
				<tr class="bg-primary">
					<th>NO</th>
					<th>ITEM</th>
					<th>DESCRIPTION</th>
					<!-- <th>ID TOKO QUICK</th> -->
					<th>QTY AVAILABLE TO TRANSACT</th>
					<th>QTY TOKO QUICK</th>
				</tr>
			</thead>
			<tbody>
				<?php $num=1; if($itemCombine){foreach ($itemCombine as $ci) { ?>
				<tr>
					<td>
						<?= $num ?>
					</td>
					<td><?= $ci['item'] ?></td>
					<td><?= $ci['description'] ?></td>
					<td><?= $ci['qty'] ?></td>
					<td><?= $ci['qty_available'] ?></td>
				</tr>
				<?php $num++; }} ?>
			</tbody>
		</table>
	</div>