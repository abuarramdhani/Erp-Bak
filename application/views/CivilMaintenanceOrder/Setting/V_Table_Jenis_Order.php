<table class="table table-bordered table-hover table-striped" id="CMOtblJorder">
	<thead class="bg-primary">
		<th width="10%" style="text-align: center;">No</th>
		<th style="text-align: center;">Jenis Order</th>
		<th width="20%" style="text-align: center;">Action</th>
	</thead>
	<tbody class="text-center">
		<?php $x = 1; foreach ($list as $key): ?>
			<tr>
				<td data="<?= $key['jenis_order_id'] ?>"><?= $x ?></td>
				<td style="text-align: left;"><?= $key['jenis_order'] ?></td>
				<td>
					<button value="<?= $key['jenis_order_id'] ?>" data-target="#cmoupjenisorder" data-toggle="modal" class="btn btn-primary cmo_upJnsOrder" nama="<?= $key['jenis_order'] ?>"><i class="fa fa-edit"></i></button>
					<button class="btn btn-danger cmo_delJnsOrder" value="<?= $key['jenis_order_id'] ?>" nama="<?= $key['jenis_order'] ?>"><i class="fa fa-trash"></i></button>
				</td>
			</tr>
		<?php $x++; endforeach ?>
	</tbody>
</table>