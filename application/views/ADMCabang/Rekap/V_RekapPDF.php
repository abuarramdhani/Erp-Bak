<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<div style="width: 100%;height: 100%;">
		<table class="table table-bordered" style="font-size: 12px;">
			<thead>
				<tr>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">No</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Nomor Induk</th>
					<th style="padding: 5px;border: 1px solid black;">Nama</th>
					<th style="padding: 5px;border: 1px solid black;">Seksi</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Jumlah Terlambat</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Jumlah Izin Pribadi</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Jumlah Mangkir</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Jumlah Sakit</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Jumlah Izin Pamit (Cuti)</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Jumlah Izin Perusahaan</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Jumlah Kehadiran</th>
					<th style="padding: 5px;border: 1px solid black;" class="text-center">Persentase Kehadiran</th>
				</tr>
			</thead>
			<tbody>
				<?php
				 $nomor = 1;
				 foreach ($data as $key => $value): ?>
					<tr>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= $nomor++ ?></td>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= $value['noind'] ?></td>
						<td style="padding: 3px;border: 1px solid black;"><?= $value['nama'] ?></td>
						<td style="padding: 3px;border: 1px solid black;"><?= $value['seksi'] ?></td>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= $value['terlambat'] ?></td>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= $value['izin_pribadi'] ?></td>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= $value['mangkir'] ?></td>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= $value['sakit'] ?></td>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= $value['izin_pamit'] ?></td>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= $value['izin_perusahaan'] ?></td>
						<td style="padding: 3px;padding: 3px;border: 1px solid black;" class="text-center"><?= $value['bekerja'] ?></td>
						<td style="padding: 3px;border: 1px solid black;" class="text-center"><?= round(((intval($value['bekerja']) - intval($value['izin_pribadi']) ) / $days * 100),2)." %" ?></td>
					</tr>
				<?php endforeach; ?>	
			</tbody>	
		</table>
	</div>
</body>
</html>