<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table style="width: 100%;border-collapse: collapse;font-size: 9pt" border="1">
		<thead>
			<tr style="background-color: #00ccff;">
				<th style="text-align: center; vertical-align: middle;width: 5%" rowspan="2">No</th>
				<th style="text-align: center; vertical-align: middle;width: 18%" rowspan="2">Nama</th>
				<th style="text-align: center; vertical-align: middle;width: 13%" rowspan="2">Status</th>
				<th style="text-align: center;" colspan="4">Komponen</th>
				<th style="text-align: center;" colspan="4">Nominal</th>
				<th style="text-align: center; vertical-align: middle;width: 13%" rowspan="2">Total Gaji</th>
			</tr>
			<tr style="background-color: #00ccff;">
				<th style="text-align: center;width: 8%">Gaji Pokok</th>
				<th style="text-align: center;width: 8%">Uang Makan</th>
				<th style="text-align: center;width: 8%">Uang Makan Puasa</th>
				<th style="text-align: center;width: 8%">Lembur</th>
				<th style="text-align: center;width: 9%">Gaji Pokok</th>
				<th style="text-align: center;width: 9%">Uang Makan</th>
				<th style="text-align: center;width: 9%">Uang Makan Puasa</th>
				<th style="text-align: center;width: 9%">Lembur</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no=1;
			foreach ($data as $key) {
				?>
				<tr>
					<td style="text-align: center;"><?php echo $no;?></td>
					<td><?php echo $key['nama'];?></td>
					<td style="text-align: center;"><?php echo $key['pekerjaan'];?></td>
					<td style="text-align: center;"><?php echo number_format($key['jml_gp'],'2',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['jml_um'],'2',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['jml_ump'],'2',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['jml_lbr'],'2',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['gp'],'0',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['um'],'0',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['ump'],'0',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['lmbr'],'0',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['total_bayar'],'0',',','.');?></td>
				</tr>
				<?php
				$no++;
			}
			?>
		</tbody>
	</table>
	<br>
	<div>
		<label><?php echo "Periode : ".$periode; ?></label>
	</div>
</body>
</html>