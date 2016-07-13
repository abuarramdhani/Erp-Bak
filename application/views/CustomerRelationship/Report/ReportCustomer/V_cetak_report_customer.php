<?php
$date = date('d-M-Y');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap_customer_"$date.".xls");
//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------

?>
<center>
	<h3>REPORT DATA CUSTOMER CV. KARYA HIDUP SENTOSA</h3>
</center>
<br />
<b style="font-size:12px;">TANGGAL : <?php echo strtoupper($date);?></b><br />
<?php
if(($name == null) and ($district == null) and ($city == null) and ($province == null) and ($job == "NULL") and ($category == null)){
?>
<b style="font-size:12px;">ALL DATA :</b><br /><br />
<?php
}else{
	if($name == null){ $name = " -";}
	if($district == null){ $district = " -";}
	if($city == null){ $city = " -";}
	if($province == null){ $province = " -";}
	if($job == "NULL"){ $job = " -";}
	if($category == null){ $category = " -";}
	
?>
<b style="font-size:12px;">SEARCH BY : </b><br /><br />
<table>
	<tr>
		<td colspan=5>
			<table style="font-size:11px;">
				<tr>
					<td>NAME</td>
					<td colspan=3>: <?php echo $name;?></td>
					
				</tr>
				<tr>
					<td>DISTRICT</td>
					<td colspan=3>: <?php echo $district;?></td>
				</tr>
				<tr>
					<td>CITY</td>
					<td colspan=3>: <?php echo $city;?></td>
				</tr>
			</table>
		</td>
		<td colspan=4>
			<table style="font-size:11px;">
				<tr>
					<td>PROVINCE</td>
					<td colspan=3>: <?php echo $province;?></td>
					
				</tr>
				<tr>
					<td>ADDITIONAL INFO</td>
					<td colspan=3>: <?php echo $job;?></td>
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

<table style="font-size:14px;" border=1>
	<thead>
		<tr>
			<th width="5%">NO</th>
			<th width="20%">CUSTOMER NAME</th>
			<th width="15%">ADDRESS</th>
			<th width="10%">DISTRICT</th>
			<th width="10%">CITY/REGENCY</th>
			<th width="10%">PROVINCE</th>
			<th width="10%">ADDITIONAL INFO</th>
			<th width="10%">CATEGORY</th>
			<th width="10%">CONTACT</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach($customer as $cs){
		$ct = $cs['contact'];
		if($ct == ""){
			$ct = "no contact info";
		}
		/*
		if(is_numeric($ct)){
			$ct = substr($ct,1);
			$ct = "+62 ".$ct;
		}
		*/
	?>
		<tr>
			<td align="center"><?php echo $i;?></td>
			<td><?php echo strtoupper($cs['customer_name']);?></td>
			<td><?php echo strtoupper($cs['address']);?></td>
			<td><?php echo strtoupper($cs['district']);?></td>
			<td><?php echo strtoupper($cs['city_regency']);?></td>
			<td><?php echo strtoupper($cs['province']);?></td>
			<td><?php echo strtoupper($cs['additional_info']);?></td>
			<td><?php echo strtoupper($cs['customer_category_name']);?></td>
			<td align="center"><?php echo "[ ".strtoupper($ct)." ]";?></td>
		</tr>
	<?php
		$i++;
	}
	?>
	</tbody>
</table>