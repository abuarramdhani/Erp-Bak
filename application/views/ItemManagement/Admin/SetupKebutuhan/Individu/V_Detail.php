<?php
	foreach ($DetailKebutuhan as $group) {}
?>
<table width="100%">
	<tr>
		<td width="20%">Kode Standar</td>
		<td width="5%">:</td>
		<td width="75%" style="font-weight: bold;"><?php echo $group['kode_standar_ind'];?></td>
	</tr>
	<tr>
		<td>Kodesie</td>
		<td>:</td>
		<td style="font-weight: bold;"><?php echo $group['seksi'];?></td>
	</tr>
	<tr>
		<td>Pekerja</td>
		<td>:</td>
		<td style="font-weight: bold;"><?php echo $group['noind'].' - '.$group['employee_name'];?></td>
	</tr>
</table>
<br>
<table class="table table-bordered table-striped im-data-table" style="width: 100%">
	<thead class="bg-primary">
		<tr>
			<td width="55%" align="center"><b>KODE BARANG</b></td>
			<td width="15%" align="center"><b>PERIODE MULAI</b></td>
			<td width="15%" align="center"><b>PERIODE SELESAI</b></td>
			<td width="15%" align="center"><b>JUMLAH</b></td>
		</tr>
	</thead>
	<tbody class="preview-body">
	<?php
		foreach ($DetailKebutuhan as $DK) {
	?>
		<tr>
			<td><?php echo $DK['kode_barang'].' - '.$DK['detail'];?></td>
			<td><?php echo $DK['periode_mulai'];?></td>
			<td><?php echo $DK['periode_selesai'];?></td>
			<td><?php echo $DK['jumlah'];?></td>
		</tr>
	<?php
		}
	?>
	</tbody>
</table>
<br>
<br>