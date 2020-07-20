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
			<th style="width: 5%;text-align: center">Noind</th>
			<th style="width: 10%;text-align: center">Nama</th>
			<th style="width: 7%;text-align: center">Dept</th>
			<th style="width: 15%;text-align: center">Unit</th>
			<th style="width: 15%;text-align: center">Bidang</th>
			<th style="width: 15%;text-align: center">Seksi</th>
			<th style="width: 15%;text-align: center">Jabatan</th>
			<th style="width: 10%;text-align: center">Lokasi Kerja</th>
			<th style="width: 9%;text-align: center">Tgl.Diangkat</th>
			<th style="width: 9%;text-align: center">Akh.Kontrak</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($tarikdatapekerja) and !empty($tarikdatapekerja)) {
			$angka = 1;
			foreach ($tarikdatapekerja as $key) {
				?>
				<tr>
					<td style="text-align: center"><?php echo $angka ?>
					<td style="padding-left: 5px" ><?php echo $key['noind'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['nama'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['dept'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['bidang'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['unit'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['seksi'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['jabatan'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['lokasi_kerja'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['diangkat'] ?></td>
					<td style="padding-left: 5px" ><?php echo $key['akhkontrak'] ?></td>
		<?php $angka++; }
		} ?>
	</tbody>
</table>
</body>
</html>


