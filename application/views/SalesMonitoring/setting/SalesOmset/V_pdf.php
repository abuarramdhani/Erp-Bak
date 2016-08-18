<center><h1>Sales Target</h1></center>
<hr/><br/><br/>

<table border="1" style="border-collapse: collapse;margin: 0 auto;">
	<thead>
		<tr>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">NO</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">ORGANIZATION</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">ORDER TYPE</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">ITEM CODE</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">ITEM DESCRIPTION</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">QTY FULFILLED</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">MONTH</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">YEAR</th>
		</tr>
	</thead>
									
	<tbody>
		<?php $no = 0; foreach($data as $dt) { $no++ ?>
		<?php 
				 if($dt['month'] == 1){$month = 'Januari';} 	else if($dt['month'] == 2){$month = 'Februari';}
			else if($dt['month'] == 3){$month = 'Maret';} 		else if($dt['month'] == 4){$month = 'April';}
			else if($dt['month'] == 5){$month = 'Mei';} 		else if($dt['month'] == 6){$month = 'Juni';}
			else if($dt['month'] == 7){$month = 'Juli';} 		else if($dt['month'] == 8){$month = 'Agustus';}
			else if($dt['month'] == 9){$month = 'September';}	else if($dt['month'] == 10){$month = 'Oktober';}
			else if($dt['month'] == 11){$month = 'November';} 	else if($dt['month'] == 12){$month = 'Desember';}
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $dt['org_name'] ?></td>
			<td><?php echo $dt['order_type'] ?></td>
			<td><?php echo $dt['item_code'] ?></td>
			<td><?php echo $dt['item_description'] ?></td>
			<td align="center"><?php echo $dt['qty_fulfilled'] ?></td>
			<td align="center"><?php echo $month ?></td>
			<td align="center"><?php echo $dt['year'] ?></td>
		</tr>
		<?php } ?>
	</tbody>																			
</table>