<h2 style="margin-left: 33%">Report Response Time</h2>
<table>
		<tr>
			<td width="150"><b>Period</b></td>
			<td width="20">:</td>
			<td width="150"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
			<td width="20">-</td>
			<td width="150"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
		</tr>
</table>
<br />
<table border=1 style="border-collapse:collapse;table-layout:fixed;">
	<thead>
	<tr>
		<th width="80">Activity Num.</th>
		<th width="80">Call Date</th>
		<th width="120">Customer Name</th>
		<th width="120">City / Regency</th>
		<th width="95">Unit</th>
		<th width="80">Spare Part</th>
		<th width="100">Problem</th>
		<th width="100">Problem Description</th>
		<th width="150">Technician</th>
		<th width="60">Action Time</th>
		<th width="60">Close TIme</th>
	</tr>
	</thead>
	
	<tbody>
	<?php
	foreach($ResponseTime as $ResponseTime_item){
		
	?>
	<tr>
		<td width="85"><?php echo $ResponseTime_item['connect_number']." - ".$ResponseTime_item['service_number']; ?></td>
		<td><?php echo $ResponseTime_item['calling_date']; ?></td>
		<td><?php echo $ResponseTime_item['customer_name']; ?></td>
		<td><?php echo $ResponseTime_item['city_regency']; ?></td>
		<td width="160"><?php echo $ResponseTime_item['item_name']; ?></td>
		<td width="160"><?php echo $ResponseTime_item['spare_part_name']; ?></td>
		<td><?php echo $ResponseTime_item['service_problem_name']; ?></td>
		
		<td width="140"><?php echo $ResponseTime_item['problem_description']; ?></td>
		<td width="120"><?php echo $ResponseTime_item['technician_name']; ?></td>
		<td><?php echo $ResponseTime_item['action_time']; ?></td>
		<td><?php echo $ResponseTime_item['close_time']; ?></td>
	<?php
	}
	?>
	</tr>
	</tbody>
</table>
