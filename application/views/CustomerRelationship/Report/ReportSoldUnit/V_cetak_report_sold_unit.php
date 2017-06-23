<?php
$date = date('d-M-Y');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap_sold_unit_".$date.".xls");
//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------

?>
<center>
	<h3>REPORT DATA SOLD UNIT HARVERSTER CV. KARYA HIDUP SENTOSA</h3>
</center>
<br />
<b style="font-size:12px;">TANGGAL : <?php echo strtoupper($date);?></b><br />
<?php
if(($item_name == null) and ($body_number == null) and ($engine_number == null) and ($district == null) and ($city == null) and ($province == null) and ($buying_type_name == null) and ($customer_name == null) and ($rangesoldunit == null)){
?>
<b style="font-size:12px;">ALL DATA :</b><br /><br />
<?php
}else{  
	if($item_name == null){ $item_name = " -";}
	if($body_number == null){ $body_number = " -";}
	if($engine_number == null){ $engine_number = " -";}
	if($district == null){ $district = " -";}
	if($city == null){ $city = " -";}
	if($province == null){ $province = " -";}
	if($buying_type_name == null){ $buying_type_name = " -";}
	if($customer_name == null){ $customer_name = " -";}
	if($rangesoldunit == null){ $rangesoldunit = " -";}
	
?>
<b style="font-size:12px;">SEARCH BY : </b><br /><br />
<table>
	<tr>
		<td colspan=2>
			<table style="font-size:11px;">
				<tr>
					<td>UNIT</td>
					<td>: <?php echo $item_name;?></td>
					
				</tr>
				<tr>
					<td>BODY NUMBER</td>
					<td>: <?php echo $body_number;?></td>
				</tr>
				<tr>
					<td>ENGINE NUMBER</td>
					<td>: <?php echo $engine_number;?></td>
				</tr>
				
			</table>
		</td>
		<td colspan=4>
			<table style="font-size:11px;">
				
				<tr>
					<td>OWNER NAME</td>
					<td colspan=3>: <?php echo $customer_name;?></td>
				</tr>
				<tr>
					<td>BUYING TYPE</td>
					<td colspan=3>: <?php echo $buying_type_name;?></td>
				</tr>
				<tr>
					<td>RANGE DATE</td>
					<td colspan=3>: <?php echo $rangesoldunit;?></td>
				</tr>
			</table>
		</td>
		<td colspan=4>
			<table style="font-size:11px;">
				<tr>
					<td>DISTRICT</td>
					<td colspan=3>: <?php echo $district;?></td>
					
				</tr>
				<tr>
					<td>CITY</td>
					<td colspan=3>: <?php echo $city;?></td>
				</tr>
				<tr>
					<td>PROVINCE</td>
					<td colspan=3>: <?php echo $province;?></td>
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
			<th width="15%">ITEM NAME</th>
			<th width="10%">BODY NUMBER</th>
			<th width="10%">ENGINE NUMBER</th>
			<th width="10%">OWNERSHIP DATE</th>
			<th width="10%">DISTRICT</th>
			<th width="10%">CITY</th>
			<th width="10%">PROVINCE</th>
			<th width="10%">OWNER</th>
			<th width="10%">BUYING TYPE</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach($soldunit as $su){
		if($su['ownership_date'] == null){
			$date = "";
		}else{
			$date = date_format(date_create($su['ownership_date']), 'd-M-Y');
		}
	?>
		<tr>
			<td align="center"><?php echo $i;?></td>
			<td><?php echo $su['item_name'];?></td>
			<td><?php echo $su['no_body'];?></td>
			<td><?php echo $su['no_engine'];?></td>
			<td align="center"><?php echo $date;?></td>
			<td><?php echo $su['district'];?></td>
			<td><?php echo $su['city_regency'];?></td>
			<td><?php echo strtoupper($su['province']);?></td>
			<td><?php echo $su['customer_name'];?></td>
			<td align="center"><?php echo strtoupper($su['buying_type_name']);?></td>
		</tr>
	<?php
		$i++;
	}
	?>
	</tbody>
</table>