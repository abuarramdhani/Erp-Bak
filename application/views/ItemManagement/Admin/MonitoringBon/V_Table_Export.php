<div style="width: 100%; text-align: center"><h4 style="font-weight: bold">MONITORING BON</h4></div>
<table id="data_table" class="table table-hover table-bordered table-striped">
	<thead class="bg-primary">
		<tr>
			<th width="5%" style="padding: 3px 3px;"><center>No</center></th>
			<th width="35%" style="padding: 3px 3px;"><center>Seksi</center></th>
			<th width="30%" style="padding: 3px 3px;"><center>Detail</center></th>
			<th width="10%" style="padding: 3px 3px;"><center>Jumlah Batas</center></th>
			<th width="10%" style="padding: 3px 3px;"><center>Jumlah Bon</center></th>
			<th width="10%" style="padding: 3px 3px;"><center>Sisa Stok</center></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			foreach ($MonitoringBon as $HK) {
		?>
		<tr>
			<td align="center" style="padding: 3px 3px;"><?php echo $no; ?></td>
			<td style="padding: 3px 3px;"><?php echo $HK['seksi'] ?></td>
			<td style="padding: 3px 3px;"><?php echo $HK['detail'] ?></td>
			<td align="center" style="padding: 3px 3px;"><?php echo $HK['jumlah_batas'] ?></td>
			<td align="center" style="padding: 3px 3px;"><?php echo $HK['jumlah'] ?></td>
			<td align="center" style="padding: 3px 3px;"><?php echo $HK['sisa_stok'] ?></td>
		</tr>
		<?php 
			$no++;
		} ?>
	</tbody>
</table>