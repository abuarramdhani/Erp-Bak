<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table class="table table-bordered">
	<thead>
		<tr>
			<th style="width: 3%;text-align: center">No</th>
			<th style="width: 10%;text-align: center">Periode</th>
			<th style="width: 35%;text-align: center">Nama</th>
			<th style="width: 30%;text-align: center">Seksi</th>
			<th style="width: 7%;text-align: center">Total Jam Kerja</th>
			<th style="width: 7%;text-align: center">Total Hari Kerja</th>
			<th style="width: 5%;text-align: center">Overtime</th>
			<th style="width: 5%;text-align: center">Net</th>
			<th style="width: 5%;text-align: center">Rerata Net/hari</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($dataovertime) and !empty($dataovertime)) {
			$angka = 1;
			foreach ($dataovertime as $key) { ?>
				<tr>
					<td style="text-align: center"><?php echo $angka ?></td>
					<td style="text-align: center"><?php echo $key['periode'] ?></td>
					<td><?php echo $key['noind']." - ".$key['nama'] ?></td>
					<td><?php echo $key['seksi'] ?></td>
					<td style="text-align: center"><?php echo number_format($key['jam_kerja'],'2',',','.') ?></td>
					<td style="text-align: center"><?php echo number_format($key['hari_kerja'],'0',',','.') ?></td>
					<td style="text-align: center"><?php echo number_format($key['overtime'],'2',',','.') ?></td>
					<td style="text-align: center"><?php echo number_format($key['net'],'2',',','.') ?></td>
					<td style="text-align: center"><?php echo number_format($key['rerata_net'],'2',',','.') ?></td>
				</tr>
		<?php $angka++; }
		} ?>
	</tbody>
</table>
</body>
</html>