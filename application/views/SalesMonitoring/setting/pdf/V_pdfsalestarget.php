<center><h1>Sales Target</h1></center>
<hr/><br/><br/>

<table border="1" style="border-collapse: collapse;margin: 0 auto;">
	<thead>
		<tr>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">NO</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">ORGANIZATION</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">ORDER TYPE</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">MONTH</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">YEAR</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">TARGET</th>
		</tr>
	</thead>
									
	<tbody>
		<?php $no = 0; foreach($data as $dt) { $no++ ?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $dt['org_name'] ?></td>
			<td><?php echo $dt['order_type'] ?></td>
			<td><?php echo $dt['month'] ?></td>
			<td><?php echo $dt['year'] ?></td>
			<td align="right"><?php echo number_format($dt['target'], 2 , ',' , '.' );  ?></td>
		</tr>
		<?php } ?>
	</tbody>																			
</table>