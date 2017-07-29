<div style="width: 100%; text-align: center"><h4 style="font-weight: bold">KEBUTUHAN STANDAR KODESIE</h4></div>
<table class="table table-hover table-bordered table-striped">
	<thead class="bg-primary">
		<tr>
			<th width="5%" style="padding: 3px 3px;"><center>No</center></th>
			<th width="40%" style="padding: 3px 3px;"><center>Seksi</center></th>
			<th width="40%" style="padding: 3px 3px;"><center>No Induk</center></th>
			<th width="15%" style="padding: 3px 3px;"><center>Kode Standar</center></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			foreach ($SetupKebutuhan as $SetupKebutuhan) {
		?>
		<tr>
			<td align="center" style="padding: 3px 3px;"><?php echo $no; ?></td>
			<td style="padding: 3px 3px;"><?php echo $SetupKebutuhan['seksi'] ?></td>
			<td style="padding: 3px 3px;"><?php echo $SetupKebutuhan['noind'].' - '.$SetupKebutuhan['employee_name'] ?></td>
			<td style="padding: 3px 3px;"><?php echo $SetupKebutuhan['kode_standar_ind'] ?></td>
		</tr>
		<?php 
			$no++;
		} ?>
	</tbody>
</table>