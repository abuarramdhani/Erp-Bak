<h2 style="margin-left: 33%">Data Keluhan dan Masukan</h2>
<div style="width:50%;">
	<table width="100%">
		<tr>
			<td width="15%"><b>City / Regency</b></td>
			<td width="3%">:</td>
			<td width="82%"><?php echo $city_chosen;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Activities</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $activities;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Category Response</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $faq_type;?></td>
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
	</table>
</div>
<table border=1 style="border-collapse:collapse;" width="100%">
	<tr>
		<th width="30">No</th>
		<th width="250">Customer Name</th>
		<th width="150">City / Regency</th>
		<th width="30">Activity</th>
		<th width="50">Category Response</th>
		<th width="50">Response Description</th>
		<th width="50">Open Date</th>
		<th width="50">Close Date</th>
		<th width="50">Response Time</th>
	</tr>
	<?php
	foreach($DataComplainFaQ as $key=>$DataComplainFaQ_item){
	?>
	<tr>
		<td><?php echo $key+1; ?></td>
		<td><?php echo $DataComplainFaQ_item['customer_name']; ?></td>
		<td><?php echo $DataComplainFaQ_item['city_regency']; ?></td>
		<td><?php echo $DataComplainFaQ_item['activity']?></td>
		<td><?php echo ucfirst($DataComplainFaQ_item['faq_type'])?></td>
		<td><?php echo $DataComplainFaQ_item['faq_description1']; ?></td>
		<td><?php echo date_format(date_create($DataComplainFaQ_item['open_date']),'d-M-Y'); ?></td>
		<td><?php echo date_format(date_create($DataComplainFaQ_item['close_date']),'d-M-Y'); ?></td>
		<td><?php echo $DataComplainFaQ_item['response_time']; ?></td>
	</tr>
	<?php
	}
	?>
</table>