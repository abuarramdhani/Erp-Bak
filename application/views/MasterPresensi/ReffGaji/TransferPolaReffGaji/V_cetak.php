<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h3>DATA POLA NON STAFF</h3>

	<table border="1" style="width: 100%;border-collapse: collapse;">
		<thead>
			<tr>
				<th>NO.</th>
				<th>NO. INDUK</th>
				<th>NAMA OPERATOR</th>
				<th>HARI IK</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if (isset($datajadi) && !empty($datajadi)) {
				$nomor =1;
				$noind = array_column($datajadi, 'noind');
				array_multisort($noind,SORT_ASC,$datajadi);
				foreach ($datajadi as $key) {
					?>
					<tr>
						<td style="text-align: center;"><?php echo $nomor; ?></td>
						<td style="text-align: center"><?php echo $key['noind']; ?></td>
						<td><?php echo $key['namaopr']; ?></td>
						<td style="text-align: right;padding-right: 10px;"><?php echo $key['hmp'] + $key['hms'] + $key['hmm'] + $key['hmu']; ?></td>
					</tr>
					<?php 
					$nomor++;
				}
			}
			?>
		</tbody>
	</table>
	<table>
		<tr>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 40%;text-align: center">Dicetak Oleh,</td>
		</tr>
		<tr>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 40%">&nbsp;</td>
		</tr>
		<tr>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 40%">&nbsp;</td>
		</tr>
		<tr>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 40%">&nbsp;</td>
		</tr>
		<tr>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 30%">&nbsp;</td>
			<td style="width: 40%;text-align: center"><?php echo $this->session->employee ?></td>
		</tr>
	</table>
</body>
</html>