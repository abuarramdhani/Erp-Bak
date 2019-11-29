<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1 style="text-align: center">Pekerja CutOff</h1>
<table style="border-collapse: collapse;border: 1px solid black;width: 100%">
	<thead>
		<tr>
			<th style="border: 1px solid black;">NO</th>
			<th style="border: 1px solid black;">NO INDUK</th>
			<th style="border: 1px solid black;">NAMA</th>
			<th style="border: 1px solid black;">KODESIE</th>
			<th style="border: 1px solid black;">SEKSI</th>
			<th style="border: 1px solid black;">ABS</th>
			<th style="border: 1px solid black;">IF</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if (isset($data) and !empty($data)) {
			$nomor = 1;
			foreach ($data as $key) { ?>
				<tr>
					<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$nomor ?></td>
					<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['noind'] ?></td>
					<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;"><?=$key['nama'] ?></td>
					<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['kodesie'] ?></td>
					<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;"><?=$key['seksi'] ?></td>
					<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['htm'] ?></td>
					<td style="border: 1px solid black;padding-left: 10px;padding-right: 10px;text-align: center"><?=$key['ief'] ?></td>
				</tr>
				<?php 
				$nomor++;
			}
		}
		?>
	</tbody>
</table>
</body>
</html>