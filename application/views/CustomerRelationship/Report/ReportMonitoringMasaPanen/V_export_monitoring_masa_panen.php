<h2 style="margin-left: 33%">Monitoring Masa Panen</h2>
<div style="width:50%;">
	<table width="100%">
		<tr>
			<td width="15%"><b>City / Regency</b></td>
			<td width="3%">:</td>
			<td width="82%"><?php echo $city_chosen;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Buying Type</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $buying_type;?></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="15%"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
			<td width="3%">-</td>
			<td><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
		</tr>
		<tr>
			<td width="15%"><b>Sort By</b></td>
			<td width="3%">:</td>
			<td width="30%"><?php echo $filter;?></td>
		</tr>
	</table>
</div>
<table border=1 style="border-collapse:collapse;" width="100%">
	<tr>
		<th width="30">No</th>
		<th width="200">Customer Name</th>
		<th width="100">City / Regency</th>
		<th width="50">Contact</th>
		<th width="50">Ownership Date</th>
		<th width="50">Buying Type</th>
		<?php
		foreach($MonthYear as $MonthYear_item){
		?>
			<th width="50"><?php echo $MonthYear_item['month']; ?></th>
		<?php
		}
		?>
	</tr>
	<?php
	foreach($MasaPanen as $key=>$MasaPanen_item){
	?>
	<tr>
		<td><?php echo $key+1; ?></td>
		<td><?php echo $MasaPanen_item['customer_name']; ?></td>
		<td><?php echo $MasaPanen_item['city_regency']; ?></td>
		<td><?php echo $MasaPanen_item['contact']; ?></td>
		<td><?php echo date_format(date_create($MasaPanen_item['ownership_date']),'d-M-y'); ?></td>
		<td><?php echo $MasaPanen_item['buying_type_name']; ?></td>
		<?php
		foreach($MonthYear as $MonthYear_item){
			if($MonthYear_item['month']==strtoupper(date_format(date_create($MasaPanen_item['harvest_time']),'M-y')))
			{	//E67437
		?>	
			<td bgcolor="#F57AB4"></td>
		<?php
			}
			else{
		?>
			<td></td>
		<?php
			}
		}
		?>
	</tr>
	<?php
	}
	?>
</table>