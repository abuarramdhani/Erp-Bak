<center><h1>Pricelist Index</h1></center>
<hr/><br/><br/>

<table border="1" style="border-collapse: collapse;margin: 0 auto;">
	<thead>
		<tr>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">NO</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">ITEM CODE
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">PRODUCT NAME</th>
			<th align="center" style="height:40px;background:#22aadd;color:#FFFFFF;">PRICE</th>
		</tr>
	</thead>
									
	<tbody>
		<?php $no = 0; foreach($data as $dt) { $no++ ?>
		
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $dt['item_code'] ?></td>
			<td><?php echo $dt['item_name'] ?></td>
			<td align="right"><?php echo number_format($dt['price'], 2 , ',' , '.' ); ?></td>
		</tr>
		<?php } ?>
	</tbody>																			
</table>
    