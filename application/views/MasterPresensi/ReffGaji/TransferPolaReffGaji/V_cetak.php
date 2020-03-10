<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h3>DATA POLA NON STAFF</h3>

	<?php 
	if (isset($datajadi) && !empty($datajadi)) {
		$noind = array_column($datajadi, 'noind');
		array_multisort($noind,SORT_ASC,$datajadi);
		$jumlah_orang = count($datajadi);
		$jumlah_halaman = ceil($jumlah_orang/120);
		$jumlah_sisa = $jumlah_orang%120;
		for ($i= 0; $i < $jumlah_halaman; $i++) { 
			?>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>NO.</th>
						<th>NO. INDUK</th>
						<th>NAMA OPERATOR</th>
						<th>HARI IK</th>
						<th style="border-top: 0px;border-bottom: 0px">   </th>
						<th>NO.</th>
						<th>NO. INDUK</th>
						<th>NAMA OPERATOR</th>
						<th>HARI IK</th>
					</tr>
				</thead>
				<tbody>
			<?php 
			if (($i + 1) != $jumlah_halaman) {
				for ($j= ($i * 120) + 0; $j < ($i * 120) + 60; $j++) { 
					$index1 = $j;
					$nomor1 = $index1 + 1;
					$index2 = $j + 60;
					$nomor2 = $index2 + 1;
					?>
						<tr>
							<td style="text-align: center;width: 6%;"><?php echo $nomor1; ?></td>
							<td style="text-align: center;width: 10%;"><?php echo $datajadi[$index1]['noind']; ?></td>
							<td style="width: 22%;"><?php echo substr($datajadi[$index1]['namaopr'], 0, 20); ?></td>
							<td style="text-align: right;padding-right: 10px;width: 10%;"><?php echo $datajadi[$index1]['hmp'] + $datajadi[$index1]['hms'] + $datajadi[$index1]['hmm'] + $datajadi[$index1]['hmu']; ?></td>

							<td style="text-align: center;border-top: 0px;border-bottom: 0px;width: 4%;"><?php echo "   "; ?></td>

							<td style="text-align: center;width: 6%;"><?php echo $nomor2; ?></td>
							<td style="text-align: center;width: 10%;"><?php echo $datajadi[$index2]['noind']; ?></td>
							<td style="width: 22%;"><?php echo substr($datajadi[$index2]['namaopr'], 0, 20); ?></td>
							<td style="text-align: right;padding-right: 10px;width: 10%;"><?php echo $datajadi[$index2]['hmp'] + $datajadi[$index2]['hms'] + $datajadi[$index2]['hmm'] + $datajadi[$index2]['hmu']; ?></td>
						</tr>
					<?php 
				}		
			?>
					</tbody>
				</table>
				<div style="page-break-before: always;"></div>
			<?php 	
			}else{
				for ($j= ($i * 120) + 0; $j < ($i * 120) + ceil($jumlah_sisa/2); $j++) { 
					$index1 = $j;
					$nomor1 = $index1 + 1;
					$index2 = $j + ceil($jumlah_sisa/2);
					$nomor2 = $index2 + 1;
					?>
						<tr>
							<td style="text-align: center;width: 6%;"><?php echo $nomor1; ?></td>
							<td style="text-align: center;width: 10%;"><?php echo $datajadi[$index1]['noind']; ?></td>
							<td style="width: 22%;"><?php echo substr($datajadi[$index1]['namaopr'], 0, 20); ?></td>
							<td style="text-align: right;padding-right: 10px;width: 10%;"><?php echo $datajadi[$index1]['hmp'] + $datajadi[$index1]['hms'] + $datajadi[$index1]['hmm'] + $datajadi[$index1]['hmu']; ?></td>

							<td style="text-align: center;border-top: 0px;border-bottom: 0px;width: 4%;"><?php echo "   "; ?></td>

							<td style="text-align: center;width: 6%;"><?php echo $nomor2; ?></td>
							<td style="text-align: center;width: 10%;"><?php echo $datajadi[$index2]['noind']; ?></td>
							<td style="width: 22%;"><?php echo substr($datajadi[$index2]['namaopr'], 0, 20); ?></td>
							<td style="text-align: right;padding-right: 10px;width: 10%;"><?php echo $datajadi[$index2]['hmp'] + $datajadi[$index2]['hms'] + $datajadi[$index2]['hmm'] + $datajadi[$index2]['hmu']; ?></td>
						</tr>
					<?php 
				}			
			}
			?>
					</tbody>
				</table>
			<?php 
		}
	}
	?>
	<table style="width: 100%">
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