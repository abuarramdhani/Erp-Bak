<table class="table table-bordered table-striped" id="mcc_tbl_seksi">
	<thead class="bg-primary">
		<th width="5%">No</th>
		<th>Kodesie</th>
		<th>Unit</th>
		<th>Seksi</th>
	</thead>
	<tbody>
		<?php $akun = array('Non Produksi', 'Produksi');
		$x=1; foreach ($cek as $key): ?>
		<tr>
			<td><?= $x ?></td>
			<td><?= $key['kodesie']?></td>
			<td><?= $key['unit']?></td>
			<td><?= $key['seksi']?></td>
		</tr>
		<?php $x++; endforeach ?>
	</tbody>
</table>