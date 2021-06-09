<table class="table table-bordered table-striped table-hover" id="mpk_tblajxamp2">
	<thead class="bg-primary">
		<tr>
			<th>No</th>
			<th>Noind</th>
			<th>Nama</th>
			<th>Alamat</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1; foreach ($pkj as $key): ?>
			<tr>
				<td><?= $x++ ?></td>
				<td>
					<?= $key['noind'] ?>
				</td>
				<td>
					<?= trim($key['nama']) ?>
					<input hidden="" name="nama_pkj[]" value="<?= trim($key['nama']) ?>" />
				</td>
				<td>
					<input class="form-control" name="alamat_pkj[]" value="<?= trim($key['alamat']) ?>" />
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>