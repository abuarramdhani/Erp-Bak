<h1><b>Laporan Realisasi Morning Greeting</b></h1>
<?php foreach($branch as $branch_item){ ?>
	<h3><?php echo $branch_item['org_name']; ?></h3>
<?php } ?>
<h3><?php echo $range; ?> ( Otomatis Hilangkan Hari Libur )</h3>
<hr/><br/><br/>

<table border="1" style="width:100%; border-collapse: collapse;margin: 0 auto;">
	<thead>
		<tr>
			<th rowspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">No</th>
			<th rowspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Hari, Tanggal</th>
			<th colspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Tingkat Pelaksanaan (Realisasi / Jadwal)</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Prosentase</th>
		</tr>
		<tr>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">R</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">P</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">%</th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; foreach($data as $data_item){ ?>
		<tr>
			<td align="center" ><?php echo $no++; ?></td>
			<td><?php echo $data_item['calldate'];?></td>
			<td align="center" ><?php echo $data_item['r'];?></td>
			<td align="center" ><?php echo $data_item['p'];?></td>
			<td align="center" ><?php echo $prsn=($data_item['r']/$data_item['p'])*100; ?>%</td>
		</tr>
	<?php } ?>
	</tbody>
	<thead>
	<tr>
		<th colspan="4" style="height:40px;background:#22aadd;color:#FFFFFF;">RATA - RATA PELAKSANAAN</th>
		<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">100%</th>
	</tr>
	</thead>
</table>