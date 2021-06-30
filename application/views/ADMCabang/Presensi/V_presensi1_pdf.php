<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>

<body>
	<div style="width: 100%">
		<div style="width: 100%">

		</div>
		<?php
		foreach ($pekerja as $key) {
			?>
			<div style="width: 100%">
				<table>
					<tr>
						<td width="10%">Noind</td>
						<td><?php echo $key['noind']; ?></td>
					</tr>
					<tr>
						<td width="10%">Nama</td>
						<td><?php echo $key['nama']; ?></td>
					</tr>
					<tr>
						<td width="10%">Seksi</td>
						<td><?php echo $key['seksi']; ?></td>
					</tr>
				</table>
			</div>
			<table width="100%" border="1" style="border: 1px solid black;border-collapse: collapse;">
				<tr>
					<td width="11%" style="text-align: center;">Tanggal</td>
					<td width="15%">Shift</td>
					<td width="6%">Point</td>
					<td style="text-align: center;" colspan="<?php echo $key['max'] ?>">Waktu</td>
					<td>Keterangan</td>
				</tr>
				<?php foreach ($key['data'] as $shi) : ?>
					<tr>
						<td style="text-align: center;">
							<?php echo $shi['tgl']; ?>
						</td>
						<td>
							<?php echo $shi['shift']; ?>
						</td>
						<td>
							<?php
									if (isset($shi['tim']) and !empty($shi['tim'])) {
										foreach ($shi['tim'] as $tims) {
											echo $tims;
										}
									}
									?>
						</td>
						<?php
								$angka = 0;
								if (isset($shi['wkt']) and !empty($shi['wkt'])) {
									foreach ($shi['wkt'] as $wkt) {
										echo "<td>$wkt</td>";
										$angka++;
									}
								}

								if ($angka < $key['max']) {
									for ($i = 0; $i < $key['max'] - $angka; $i++) {
										echo "<td></td>";
									}
								}

								if ($key['max'] == '0') {
									echo "<td></td>";
								}

								$ketket = '';
								if (isset($shi['ket']) and !empty($shi['ket'])) {
									foreach ($shi['ket'] as $ket) {
										$ketket .= $ket . '<br>';
									}
									echo "<td>" . $ketket . "</td>";
								} else if (empty($shi['ket'])) {
									echo "<td></td>";
								} ?>
					</tr>
				<?php endforeach; ?>
			</table>
			<br>
			<br>
		<?php
		}
		?>
	</div>
</body>

</html>