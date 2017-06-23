<h4><b>Laporan Realisasi Morning Greeting</b></h4>
<h5>KSH GROUP</h5>
<h5><?php echo $range; ?> ( Otomatis Hilangkan Hari Libur )</h5>
<hr/><br/><br/>

<table border="1" style="border-collapse: collapse;margin: 0 auto;">
	<thead>
		<tr>
			<th rowspan="3" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">No</th>
			<th rowspan="3" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Hari, Tanggal</th>
		<?php foreach($data_branch as $branch){ ?> 
			<th colspan="3" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;"><?php echo $branch['org_name'] ?></th>
		<?php } ?>
		</tr>
		<tr>
		<?php foreach($data_branch as $branch){ ?>
			<th colspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Tingkat Pelaksanaan (Realisasi / Jadwal)</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Prosentase</th>
		<?php } ?>
		</tr>
		<tr>
		<?php foreach($data_branch as $branch){ ?>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">R</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">P</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">%</th>
		<?php } ?>
		</tr>
	</thead>
									
	<tbody>
		<?php $no=1; foreach($data as $data_item){ ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $data_item['calldate'];?></td>
				<?php foreach($data_branch as $branch){ ?>
					<td style="text-align:center;"><?php echo $data_item['r'];?></td>
					<td style="text-align:center;"><?php echo $data_item['p'];?></td>
					<td style="text-align:center;">100%</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
	<thead>
		<tr>
			<th colspan="2" style="height:40px;background:#22aadd;color:#FFFFFF;">RATA - RATA PELAKSANAAN</th>
			<?php foreach($data_branch as $branch){ ?>
				<th style="height:40px;background:#22aadd;color:#FFFFFF;"></th>
				<th style="height:40px;background:#22aadd;color:#FFFFFF;"></th>
				<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">80.92%</th>
			<?php } ?>
		</tr>
	</thead>
</table>