<!DOCTYPE html>
<!DOCTYPE html>
<html>
<body>
	<div>
		<h2 style="text-align: center">Rekap Presensi</h2>
		<?php if (isset($periode) and !empty($periode)) {
			$bulan = array (
				1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
			$prd = explode(' - ', $periode);
			$prd['0'] = explode('-', $prd['0']);
			$prd['1'] = explode('-', $prd['1']);
			echo "Periode : ".$prd['0']['2'].'/'.$prd['0']['1'].'/'.$prd['0']['0'].' - '.$prd['1']['2'].'/'.$prd['1']['1'].'/'.$prd['1']['0'];
		} ?>
	</div>
	<br>
	<div>
		<table style="width: 100%;border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">Noind</th>
					<th rowspan="2">Nama</th>
					<th rowspan="2">Status</th>
					<th colspan="4">Gaji</th>
					<th colspan="3">Tambahan</th>
					<th colspan="3">Potongan</th>
				</tr>
				<tr>
					<th>Gaji Pokok</th>
					<th>Lembur</th>
					<th>Uang Makan</th>
					<th>Uang Makan Puasa</th>
					<th>Gaji Pokok</th>
					<th>Lembur</th>
					<th>Uang Makan</th>
					<th>Gaji Pokok</th>
					<th>Lembur</th>
					<th>Uang Makan</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($RekapPresensi) && !empty($RekapPresensi)) {
					$nomor = 1;
					foreach ($RekapPresensi as $key) {
						?>
						<tr>
							<td style="text-align: center"><?php echo $nomor; ?></td>
							<td style="text-align: center"><?php echo $key['noind'] ?></td>
							<td><?php echo $key['nama'] ?></td>
							<td><?php echo $key['pekerjaan'] ?></td>
							<td style="text-align: center"><?php echo number_format($key['gp_gaji'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['lembur_gaji'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['um_gaji'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['ump_gaji'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['gp_tambahan'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['lembur_tambahan'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['um_tambahan'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['gp_potongan'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['lembur_potongan'],'2','.','') ?></td>
							<td style="text-align: center"><?php echo number_format($key['um_potongan'],'2','.','') ?></td>
						</tr>
						<?php
						$nomor++;
					}
				} ?>
			</tbody>
		</table>
	</div>
</body>
</html>