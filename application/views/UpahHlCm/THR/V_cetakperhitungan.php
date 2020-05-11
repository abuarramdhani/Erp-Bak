<h4 style="text-align: center">Perhitungan THR Idul Fitri </h4>
<h4> tanggal <?php echo date('d M Y',strtotime($tanggal))  ?></h4>
<table border="1" style="width: 100%;border: 1px solid black;border-collapse: collapse;font-size: 9pt;page-break-inside: all;">
<thead>
	<tr>
		<th style="text-align: center;vertical-align: middle;">NO.</th>
		<th style="text-align: center;vertical-align: middle;">NO. INDUK</th>
		<th style="text-align: center;vertical-align: middle;">NAMA</th>
		<th style="text-align: center;vertical-align: middle;">LOKASI KERJA</th>
		<th style="text-align: center;vertical-align: middle;">MASUK KERJA</th>
		<th style="text-align: center;vertical-align: middle;">MASA KERJA</th>
		<th style="text-align: center;vertical-align: middle;">NO REKENING</th>
		<th style="text-align: center;vertical-align: middle;">PEMILIK REKENING</th>
		<th style="text-align: center;vertical-align: middle;">BANK</th>
		<th style="text-align: center;vertical-align: middle;">NOMINAL THR</th>
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
				<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['no_rekening'] ?></td>
				<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['atas_nama'] ?></td>
				<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['nama_bank'] ?></td>
				<td style="text-align: right;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo number_format($dt['nominal_thr'],2,',','.')  ?></td>
			</tr>
			<?php 
			$nomor++;
		}
	}
	?>
</tbody>
</table>
<br>
<br>
<!-- <table style="width: 100%">
	<tr>
		<td></td>
		<td></td>
		<td style="text-align: right;">Yogyakarta, <?php echo date('d F Y',strtotime($waktu_dibuat)) ?></td>
	</tr>
	<tr>
		<td style="text-align: center">Mengetahui,</td>
		<td style="text-align: center">Menyetujui,</td>
		<td style="text-align: center">Dibuat,</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: center">Novita Sari</td>
		<td style="text-align: center">Yoga Andriawan</td>
		<td style="text-align: center">Subardi</td>
	</tr>
	<tr>
		<td style="text-align: center">Asisten Kepala Unit Akuntansi</td>
		<td style="text-align: center">Kepala Seksi Madya</td>
		<td style="text-align: center">Pekerja Staff Keuangan</td>
	</tr>
</table> -->