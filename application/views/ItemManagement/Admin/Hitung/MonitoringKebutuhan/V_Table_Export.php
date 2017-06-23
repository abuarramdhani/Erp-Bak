<div style="width: 100%; text-align: center"><h4 style="font-weight: bold">MONITORING KEBUTUHAN</h4></div>
<table id="im-data-table-group" class="table table-hover table-bordered table-striped">
	<thead class="bg-primary">
		<tr>
			<th width="25%"><center>Periode</center></th>
			<th width="70%"><center>Kodesie</center></th>
			<th width="15%"><center>Total</center></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($BarangKebutuhan as $BK) {
				$no = 1;
		?>
		<tr>
			<td colspan="3">
				&emsp;<b><?php echo $BK['kode_barang'].' - '.$BK['detail'] ?></b>
			</td>
		</tr>
		<?php
			foreach ($MonitoringKebutuhan as $MK) {
				if ($MK['periode'] == $BK['periode'] && $MK['kode_barang'] == $BK['kode_barang']) {
		?>
		<tr>
			<td>&emsp;<?php echo strtoupper(date('F Y', strtotime($MK['periode']))); ?></td>
			<td>&emsp;<?php echo $MK['seksi'] ?></td>
			<td>&emsp;<?php echo $MK['total_kebutuhan'] ?></td>
		</tr>
		<?php $no++; } } }?>
	
	</tbody>
</table>