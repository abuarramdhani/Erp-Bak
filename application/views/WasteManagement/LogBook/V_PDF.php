<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table class="table table-bordered">
	<thead>
		<tr>
			<th colspan="11" style="width: 3%;text-align: center; font-size: 20px; height:40px;">Logbook Harian Limbah Bahan Berbahaya Dan Beracun</th>
		</tr>
		<tr>
			<td colspan="11">Lokasi Kerja : <?php echo $lokasi ?></td>
		</tr>
		<tr>
			<td colspan="6">Bulan : <?php echo $allBulanIn ?></td>
			<td colspan="5">Bulan : <?php echo $allBulanOut ?></td>
		</tr>
		<tr>
			<th colspan="11"></th>
		</tr>
		<tr>
			<td colspan="6" style="text-align: center; font-weight: bold;">Masuknya Limbah B3 ke TPS</td>
			<td colspan="5" style="text-align: center; font-weight: bold;">Keluarnya Limbah B3 ke TPS</td>
		</tr>
		<tr>
			<td style="width: 3%;text-align: center">No</td>
			<td style="width: 3%;text-align: center">Jenis Limbah B3 Masuk</td>
			<td style="width: 3%;text-align: center">Tanggal Limbah B3 Masuk</td>
			<td style="width: 3%;text-align: center">Sumber Limbah B3</td>
			<td style="width: 3%;text-align: center">Jumlah Limbah B3</td>
			<td style="width: 3%;text-align: center">Maksimal Penyimpanan s/d Tanggal</td>
			<td style="width: 3%;text-align: center">Tanggal Keluar Limbah B3</td>
			<td style="width: 3%;text-align: center">Jumlah Limbah B3 Keluar</td>
			<td style="width: 3%;text-align: center">Tujuan Penyerahan</td>
			<td style="width: 3%;text-align: center">Bukti Nomer Dokumen</td>
			<td style="width: 3%;text-align: center">Sisa Limbah B3 yang ada di TPS</td>
		</tr>
	</thead>
	<tbody>
			<?php
			if (count($filterMasuk) > count($filterKeluar)) {
				$ulang1 = $filterMasuk;
			}else {
				$ulang1 = $filterKeluar;
			}
			  for ($i=0; $i < count($ulang1) ; $i++) { ?>
				<tr>
					<td style="text-align: center;"><?php echo $i+1 ?></td>
					<td style="text-align: center;"><?php echo $filterMasuk[$i]['jenis_limbah']; ?></td>
					<td style="text-align: center;"><?php echo $filterMasuk[$i]['tanggal']; ?></td>
					<td style="text-align: center;"><?php echo $filterMasuk[$i]['sumber']; ?></td>
					<td style="text-align: center;"><?php echo $filterMasuk[$i]['jumlah']; ?></td>
					<td style="text-align: center;"><?php echo $filterMasuk[$i]['tanggalmax']; ?></td>
					<td style="text-align: center;"><?php echo $filterKeluar[$i]['tanggal']; ?></td>
					<td style="text-align: center;"><?php echo $filterKeluar[$i]['jumlah']; ?></td>
					<td></td>
					<td></td>
					<td style="text-align: center;">0</td>
					</tr>
				<?php } ?>
	</tbody>
</table>
<table align="right" position="absolute">
<tr>
	<td style="text-align:center;"><b>Kepala Seksi Waste Management</b></td>
</tr>
<tr>
	<td style="height: 80px;"></td>
</tr>
<tr>
	<td colspan="5" style="text-align:center;"><?php echo $user_name; ?></td>
</tr>
</table>
</body>
</html>
