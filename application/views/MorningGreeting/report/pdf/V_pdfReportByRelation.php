<h1 style="text-align:center;">Laporan Realisasi Morning Greeting</h1>
<?php foreach($branch as $branch_item){ ?>
	<h5 style="text-align:center;">Relasi <?php echo $branch_item['org_name']; ?></h5>
<?php } ?>
<h3 style="text-align:center;">01 - 31 Januari 2016</h3>
<hr/><br/><br/>

<table border="1" style="border-collapse: collapse;margin: 0 auto; width:100%;">
	<thead>
		<tr>
			<th rowspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">No</th>
			<th rowspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Cust. ID</th>
			<th rowspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Relasi</th>
			<th rowspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Kota</th>
			<th colspan="5" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Minggu</th>
			<th rowspan="2" align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">Presentase ( 100% jika 4x )</th>
		</tr>
		<tr>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">1</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">2</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">3</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">4</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">5</th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; foreach($data as $data_item){ ?>
			<tr>
				<td style="text-align:center;"><?php echo $no++; ?></td>
				<td style="text-align:center;"><?php echo $data_item['oracle_cust_id'];?></td>
				<td><?php echo $data_item['relation_name'];?></td>
				<td style="text-align:center;"><?php echo $data_item['regency_name'];?></td>
				<td>1</td>
				<td>1</td>
				<td>1</td>
				<td>1</td>
				<td>1</td>
				<td>100%</td>
			</tr>
		<?php } ?>
	</tbody>
	<thead>
		<tr>
			<th colspan="9">RATA - RATA PELAKSANAAN</th>
			<th>100%</th>
		</tr>
	</thead>
</table>