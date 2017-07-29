<table class="table table-hover table-bordered table-striped">
	<thead class="bg-primary">
		<tr>
			<th width="10%"><center>Kode Barang</center></th>
			<th width="40%"><center>Detail</center></th>
			<th width="10%"><center>QTY</center></th>
			<th width="20%"><center>Tanggal</center></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($KodeBon as $KB) {
		?>
		<tr>
			<td colspan="4" align="center"><b>Kode Blanko (<?php echo $KB['kode_blanko'] ?>)</b></td>
		</tr>
		<?php
			foreach ($MonitoringBon as $MB) {
				if ($MB['kode_blanko'] == $KB['kode_blanko']) {
		?>
		<tr>
			<td><?php echo $MB['kode_barang'] ?></td>
			<td><?php echo $MB['detail'] ?></td>
			<td align="center"><?php echo $MB['jumlah'] ?></td>
			<td><?php echo $MB['periode'] ?></td>
		</tr>
		<?php }} ?>
		<tr>
			<td colspan="4"></td>
		</tr>
		<?php } ?>
	</tbody>
</table>