<h1>Tunjangan Hari Raya</h1>
<?php 
	if (isset($data) && !empty($data)) {
		$nomor = 1;
		$kode = "X";
		foreach ($data as $dt) {
			if ($kode !== substr($dt['noind'], 0,1)) {
				if ($kode !== "X") {
					$nomor = 1;
					?>
	</tbody>
</table>
<br>
<br>
<br>
<table style="width: 100%">
	<tr>
		<td></td>
		<td style="text-align: right;">Yogyakarta, <?php echo date('d M Y',strtotime($mengetahui['0']['tgl_dibuat'])) ?></td>
	</tr>
	<tr>
		<td style="text-align: center;">Mengetahui,</td>
		<td style="text-align: center;">Dibuat,</td>
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
		<td style="text-align: center;"><?php echo $mengetahui['0']['mengetahui_nama'] ?></td>
		<td style="text-align: center;"><?php echo $mengetahui['0']['created_by_nama'] ?></td>
	</tr>
	<tr>
		<td style="text-align: center;"><?php echo $mengetahui['0']['mengetahui_jab'] ?></td>
		<td style="text-align: center;"><?php echo $mengetahui['0']['created_by_jab'] ?></td>
	</tr>
</table>
<div style="page-break-after: always;"></div>
					<?php 
				}
				?>
<table border="1" style="width: 100%;border: 1px solid black;border-collapse: collapse;">
	<thead>
		<tr>
			<th style="text-align: center;vertical-align: middle;">No.</th>
			<th style="text-align: center;vertical-align: middle;">No. Induk</th>
			<th style="text-align: center;vertical-align: middle;">Nama</th>
			<th style="text-align: center;vertical-align: middle;">Seksi</th>
			<th style="text-align: center;vertical-align: middle;">Diangkat</th>
			<th style="text-align: center;vertical-align: middle;">Masa Kerja</th>
			<th style="text-align: center;vertical-align: middle;">Bulan THR</th>
			<th style="text-align: center;vertical-align: middle;">Proporsi</th>
		</tr>
	</thead>
	<tbody>
				<?php
			}
			?>
			<tr>
				<td style="text-align: center;"><?php echo $nomor; ?></td>
				<td style="text-align: center;"><?php echo $dt['noind']; ?></td>
				<td><?php echo $dt['nama']; ?></td>
				<td><?php echo $dt['seksi']; ?></td>
				<td style="text-align: center;"><?php echo date('d M Y',strtotime($dt['diangkat'])); ?></td>
				<td><?php echo $dt['masa_kerja']; ?></td>
				<td style="text-align: center;"><?php echo $dt['bulan_thr']; ?></td>
				<td style="text-align: center;"><?php echo $dt['proporsi']; ?></td>
			</tr>
			<?php
			$nomor++;
			$kode = substr($dt['noind'], 0,1);
		}
	} 
?>
	</tbody>
</table>
<br>
<br>
<br>
<table style="width: 100%">
	<tr>
		<td></td>
		<td style="text-align: right;">Yogyakarta, <?php echo date('d M Y',strtotime($mengetahui['0']['tgl_dibuat'])) ?></td>
	</tr>
	<tr>
		<td style="text-align: center;">Mengetahui,</td>
		<td style="text-align: center;">Dibuat,</td>
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
		<td style="text-align: center;"><?php echo $mengetahui['0']['mengetahui_nama'] ?></td>
		<td style="text-align: center;"><?php echo $mengetahui['0']['created_by_nama'] ?></td>
	</tr>
	<tr>
		<td style="text-align: center;"><?php echo $mengetahui['0']['mengetahui_jab'] ?></td>
		<td style="text-align: center;"><?php echo $mengetahui['0']['created_by_jab'] ?></td>
	</tr>
</table>