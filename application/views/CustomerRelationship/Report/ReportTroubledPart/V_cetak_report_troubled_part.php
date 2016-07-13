<?php
$date = date('d-M-Y');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap_troubled_part_".$date.".xls");
//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------

?>
<center>
	<h3>REPORT DATA TROUBLED PART HARVERSTER CV. KARYA HIDUP SENTOSA</h3>
</center>
<br />
<b style="font-size:12px;">TANGGAL : <?php echo strtoupper($date);?></b><br />
<?php
if(($item == null) and ($spare_part == null) and ($body_number == null) and ($category == null)){
?>
<b style="font-size:12px;">ALL DATA :</b><br /><br />
<?php
}else{
	if($item == null){ $item = " -";}
	if($body_number == null){ $body_number = " -";}
	if($spare_part == null){ $spare_part = " -";}
	if($category == null){ $category = " -";}
	
?>
<b style="font-size:12px;">SEARCH BY : </b><br /><br />
<table>
	<tr>
		<td colspan=4>
			<table style="font-size:11px;">
				<tr>
					<td >SPARE PART</td>
					<td colspan=3>: <?php echo $spare_part;?></td>
					
				</tr>
				<tr>
					<td >ITEM / UNIT</td>
					<td colspan=3>: <?php echo $item;?></td>
				</tr>
				
			</table>
		</td>
		<td colspan=4>
			<table style="font-size:11px;">
				<tr>
					<td>BODY NUMBER</td>
					<td colspan=3>: <?php echo $body_number;?></td>
					
				</tr>
				<tr>
					<td>CATEGORY</td>
					<td colspan=3>: <?php echo $category;?></td>
				</tr>
				
			</table>
		</td>
	</tr>
</table>
<br />
<?php
}
?>
<table style="font-size:12px;" border=1>
	<thead>
		<tr>
			<th width="5%">NO</th>
			<th width="13%"> SPAREPART CODE</th>
			<th width="17%">SPAREPART NAME</th>
			<th width="25%">UNIT NAME</th>
			<th width="10%">BODY NUMBER</th>
			<th width="10%">PROBLEM CATEGORY</th>
			<th width="10%">ACTION DATE</th>
			<th width="10%">FINISH DATE</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach($troubledPart as $tp){
		if($tp['finish_date'] == null){
			$date = "";
		}else{
			$date = date_format(date_create($tp['finish_date']), 'd-M-Y');
		}
		if($tp['action_date'] == null){
			$date2 = "";
		}else{
			$date2 = date_format(date_create($tp['action_date']), 'd-M-Y');
		}
	?>
		<tr>
			<td align="center"><?php echo $i;?></td>
			<td><?php echo $tp['spare_part'];?></td>
			<td><?php echo $tp['spare_part_name'];?></td>
			<td><?php echo $tp['item_name'];?></td>
			<td><?php echo $tp['no_body'];?></td>
			<td></td>
			<td align="center"><?php echo $date2;?></td>
			<td align="center"><?php echo $date;?></td>
		</tr>
	<?php
		$i++;
	}
	?>
	</tbody>
</table>