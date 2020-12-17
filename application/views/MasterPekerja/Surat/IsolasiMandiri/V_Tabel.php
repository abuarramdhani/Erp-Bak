<!-- <p>Lama Isolasi <?= $qq ?> Hari :</p> -->
<table style="width: 100%; border-collapse: collapse;" border="1">
	<tr>
		<td>Tanggal</td>
		<td>Jumlah hari</td>
		<td>Status</td>
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
			<?php
				if ($key['sta'] == 'PSK') {
					echo 'Isolasi Rumah';
				}elseif ($key['sta'] == 'PKJ') {
					echo "Tidak Isolasi";
				}elseif (strpos($key['st'], 'WFO') !== false || $key['st'] == 'TERHITUNG PKJ'){
					echo 'Isolasi Perusahaan';
				}else{
					echo 'Isolasi Rumah';
				}
			?>
			</td>
		</tr>
	<?php endforeach ?>
</table>