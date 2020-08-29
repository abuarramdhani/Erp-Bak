<style type="text/css">
	.upp {
		font-weight: bold;
	}
</style>
<table class="table table-striped table-bordered table-hover text-center">
	<thead class="bg-primary">
		<tr>
			<td width="5%">No</td>
			<td width="10%">ID</td>
			<td><?= $kolom ?></td>
			<?php if (!empty($kolom2)): ?>
				<td><?= $kolom2 ?></td>
			<?php endif ?>
			<td>ACTION</td>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach ($list as $key): ?>
		<tr>
			<td><?= $i; ?></td>
			<td><?= $key['id']; ?></td>
			<td class="upp"><?= $key['txt']; ?></td>
			<?php if (!empty($kolom2)): ?>
				<td class="so_satuan" satuan="<?= $key['satuan'] ?>"><?= $key['satuan'] ?></td>
			<?php endif ?>
			<td>
				<button textnya="<?= $key['txt'] ?>" idnya="<?= $key['id'] ?>" class="btn btn-primary os_edTB" style="margin-right: 10px;"><i class="fa fa-pencil"></i> Edit</button>
				<button textnya="<?= $key['txt'] ?>" idnya="<?= $key['id'] ?>" class="btn btn-danger os_delTB"><i class="fa fa-trash"></i> Delete</button>
			</td>
		</tr>
		<?php $i++; endforeach ?>
	</tbody>
</table>