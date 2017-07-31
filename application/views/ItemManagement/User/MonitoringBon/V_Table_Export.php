<div style="width: 100%; text-align: center"><h4 style="font-weight: bold">MONITORING BON</h4></div>
<table class="table table-hover table-bordered table-striped">
	<thead class="bg-primary">
		<tr>
			<th width="20%" style="padding: 3px 3px;"><center>Kode Barang</center></th>
			<th width="50%" style="padding: 3px 3px;"><center>Detail</center></th>
			<th width="10%" style="padding: 3px 3px;"><center>QTY</center></th>
			<th width="20%" style="padding: 3px 3px;"><center>Tanggal</center></th>
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
			<td style="padding: 3px 3px;"><?php echo $MB['kode_barang'] ?></td>
			<td style="padding: 3px 3px;"><?php echo $MB['detail'] ?></td>
			<td style="padding: 3px 3px;" align="center"><?php echo $MB['jumlah'] ?></td>
			<td style="padding: 3px 3px;"><?php echo $MB['periode'] ?></td>
		</tr>
		<?php }} ?>
		<tr>
			<td colspan="4"></td>
		</tr>
		<?php } ?>
	</tbody>
</table>