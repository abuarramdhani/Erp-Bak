<h2 style="text-align: center">Perhitungan Bulan THR Idul Fitri <?php echo date('d M Y',strtotime($tanggal))  ?></h2>
<table border="1" style="width: 100%;border: 1px solid black;border-collapse: collapse;font-size: 9pt">
<thead>
	<tr>
		<th style="text-align: center;vertical-align: middle;">NO.</th>
		<th style="text-align: center;vertical-align: middle;">NO. INDUK</th>
		<th style="text-align: center;vertical-align: middle;">NAMA</th>
		<th style="text-align: center;vertical-align: middle;">LOKASI KERJA</th>
		<th style="text-align: center;vertical-align: middle;">MASUK KERJA</th>
		<th style="text-align: center;vertical-align: middle;">MASA KERJA</th>
		<th style="text-align: center;vertical-align: middle;">BULAN THR</th>
	</tr>
</thead>
<tbody>
	<?php 
	if (isset($data) && !empty($data)) {
		$nomor = 1;
		foreach ($data as $dt) {
			?>
			<tr>
				<td style="text-align: center;vertical-align: middle;"><?php echo $nomor ?></td>
				<td style="text-align: center;vertical-align: middle;"><?php echo $dt['noind'] ?></td>
				<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['employee_name'] ?></td>
				<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['location_name'] ?></td>
				<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo date('d M Y',strtotime($dt['tgl_masuk'])) ?></td>
				<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['masa_kerja'] ?></td>
				<td style="text-align: center;vertical-align: middle;"><?php echo $dt['bulan_thr'] ?></td>
			</tr>
			<?php 
			$nomor++;
		}
	}
	?>
</tbody>
</table>