<h2 style="margin-left: 33%">Report Data Troubled Part</h2>
<br />
<?php
	if($activity == ""){
		$activity ="-";
	}
	if($sparepart == ""){
		$sparepart ="-";
	}
	if($technician == ""){
		$technician ="-";
	}
	if($status == ""){
		$status ="-";
	}
?>
<div style="width:50%;float:right;">
	<table width="100%">
		<tr>
			<td width="30%"><b>Activity</b></td>
			<td width="3%">:</td>
			<td><?php echo $activity;?></td>
		</tr>
		<tr>
			<td><b>Spare Part</b></td>
			<td>:</td>
			<td><?php echo $sparepart;?></td>
		</tr>
		<tr>
			<td><b>Technician</b></td>
			<td>:</td>
			<td><?php echo $technician;?></td>
		</tr>
		<tr>
			<td><b>Status</b></td>
			<td>:</td>
			<td><?php echo $status;?></td>
		</tr>
	</table>
</div>
<div style="width:50%;">
	<?php
	if($period == ""){
		$period = "-";
	}else{
		$ex_per = explode(" - ",$period);
		$start = $ex_per[0]; 
		$ex_st = explode("/",$start);
		$start = $ex_st[2]."-".$ex_st[1]."-".$ex_st[0];
		$end = $ex_per[1]; 
		$ex_ed = explode("/",$end);
		$end = $ex_ed[2]."-".$ex_ed[1]."-".$ex_ed[0];
		$start = date_format(date_create($start), "d M Y");
		$end = date_format(date_create($end), "d M Y");
		$period = $start." - ".$end;
	}
	if($customername == ""){
		$customername ="-";
	}
	if($bodynumber == ""){
		$bodynumber ="-";
	}
	if($unit == ""){
		$unit ="-";
	}
	
	?>
	<table width="100%">
		<tr>
			<td width="30%"><b>Period</b></td>
			<td width="3%">:</td>
			<td><?php echo $period;?></td>
		</tr>
		<tr>
			<td><b>Customer Name</b></td>
			<td>:</td>
			<td><?php echo $customername;?></td>
		</tr>
		<tr>
			<td><b>Province</b></td>
			<td>:</td>
			<td><?php echo $province;?></td>
		</tr>
		<tr>
			<td><b>Body Number</b></td>
			<td>:</td>
			<td><?php echo $bodynumber;?></td>
		</tr>
		<tr>
			<td style="vertical-align:top;"><b>Unit</b></td>
			<td style="vertical-align:top;">:</td>
			<td><?php echo $unit;?></td>
		</tr>
	</table>
</div>
<br />
<table width="100%" border=1 style="font-size:10px;border: 1px solid #333;border-collapse:collapse;">
	<tr>
		<th width="2%">No</th>
		<th width="8%">Customer Name</th>
		<th width="8%">City</th>
		<th width="8%">Activity Number</th>
		<th width="6%">Complain Date</th>
		<th width="8%">Unit</th>
		<th width="6%">Body Number</th>
		<th width="6%">BKE Number</th>
		<th width="8%">Spare Part</th>
		<th width="5%">Problem</th>
		<th width="9%">Problem Description</th>
		<th width="8%">Action</th>
		<th width="6%">Technician</th>
		<th width="6%">Action Date</th>
		<th width="6%">Finish Date</th>
	</tr>
	<?php
	$num = 0;
	foreach($DataTroubledPart as $dtp){
		$num++;
		?>
		<tr>
			<td style="padding:3px;" align="center"><?php echo $num;?></td>
			<td style="padding:3px;"><?php echo $dtp['customer_name'];?></td>
			<td style="padding:3px;"><?php echo $dtp['regency_name'];?></td>
			<td style="padding:3px;"><?php echo $dtp['service_number'];?></td>
			<td style="padding:3px;" align="center"><?php echo date_format(date_create($dtp['service_date']), "d/m/Y");?></td>
			<td style="padding:3px;"><?php echo $dtp['item_name'];?></td>
			<td style="padding:3px;"><?php echo $dtp['no_body'];?></td>
			<td style="padding:3px;"><?php echo $dtp['claim_number'];?></td>
			<td style="padding:3px;"><?php echo $dtp['spare_part_name'];?></td>
			<td style="padding:3px;"><?php echo $dtp['service_problem_name'];?></td>
			<td style="padding:3px;"><?php echo $dtp['problem_description'];?></td>
			<td style="padding:3px;"><?php echo $dtp['action'];?></td>
			<td style="padding:3px;"><?php echo $dtp['technician_name'];?></td>
			<td style="padding:3px;" align="center"><?php echo date_format(date_create($dtp['action_date']), "d/m/Y");?></td>
			<td style="padding:3px;" align="center"><?php echo $dtp['finish_date']==""?"":date_format(date_create($dtp['finish_date']), "d/m/Y");?></td>
		</tr>
		<?php
	}
	?>
</table>