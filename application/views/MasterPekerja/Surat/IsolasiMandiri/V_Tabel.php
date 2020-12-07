<p>Lama Isolasi <?= $qq ?> Hari :</p>
<table style="width: 100%; border-collapse: collapse;" border="1">
	<tr>
		<td>Tanggal</td>
		<td>Jumlah hari</td>
		<td>Isolasi di</td>
	</tr>
	<?php foreach ($arr2 as $key): ?>
		<tr>
			<?php if ($key['awal'] == $key['akhir']): ?>
				<td>
					<?= $key['awal'] ?>
				</td>
			<?php else: ?>
				<td>
					<?= $key['awal'].' s.d '.$key['akhir'] ?>
				</td>
			<?php endif ?>
			<td>
				<?= $key['jml'] ?> Hari
			</td>
			<td>
			<?php if ($key['st'] == 'PKJ'): ?>
				Rumah
			<?php else: ?>
				Perusahaan
			<?php endif ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>