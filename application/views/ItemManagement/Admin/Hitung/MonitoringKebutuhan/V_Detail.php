<?php
	foreach ($GetPekerjaan as $GP) {
?>
<h4 style="font-weight: bold"><?php echo $GP['kdpekerjaan_noind'].' - '.$GP['detail']; ?></h4>
<table class="table table-hover table-bordered table-striped im-data-table">
	<thead class="bg-primary">
		<tr>
			<th width="25%"><center>Kode Barang</center></th>
			<th width="70%"><center>Detail</center></th>
			<th width="15%"><center>Total Kebutuhan</center></th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach ($GetDetailBarang as $GB) {
			if ($GP['kdpekerjaan_noind'] == $GB['kdpekerjaan_noind']) {
	?>
		<tr>
			<td><?php echo $GB['kode_barang']; ?></td>
			<td><?php echo $GB['detail_barang']; ?></td>
			<td><?php echo $GB['total_kebutuhan']; ?></td>
		</tr>
	<?php
			}
		}
	?>
		
	</tbody>
</table>
<br>
<hr>
<?php
	}
?>