<table id="#" class="table table-hover table-bordered table-striped">
	<thead class="bg-primary">
		<tr>
			<th width="25%"><center>Kode Item</center></th>
			<th width="25%"><center>Detail</center></th>
			<th width="25%"><center>QTY</center></th>
			<th width="25%"><center>Tanggal</center></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($MonitoringBon as $MB) {
		?>
		<tr>
			<td><?php echo $MB['kode_standar'] ?></td>
			<td><?php echo $MB['kode_standar'] ?></td>
			<td><?php echo $MB['kode_standar'] ?></td>
			<td><?php echo $MB['kode_standar'] ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>