<h2 style="margin-left: 33%">Report Rekap Complain</h2>
<div style="width:50%;">
	<table width="100%">
		<tr>
			<td width="30%"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
			<td width="3%">-</td>
			<td><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="30%"><b>City / Regency</b></td>
			<td width="3%">:</td>
			<td width="67%"><?php echo $city_chosen;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Category Service</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $category_service;?></td>
		</tr>
	</table>
	
</div>
<table border=1 style="border-collapse:collapse;" width="100%">
	<tr>
		<th rowspan="2" width="30">No</th>
		<th rowspan="2" width="250">Customer Name</th>
		<th rowspan="2" width="150">City / Regency</th>
		<?php
		foreach($MonthYear as $MonthYear_item){
		?>
			<th colspan="2" width="30" colspan="2"><?php echo $MonthYear_item['month']; ?></th>
		<?php
		}
		?>
		<th rowspan="2" width="50">Total Complain</th>
		<th rowspan="2" width="50">Total Troubled Part</th>
	</tr>
	<tr>
		<?php
		foreach($MonthYear as $MonthYear_item){
		?>
			<th width="30">C</th>
			<th width="30">TP</th>
		<?php
		}
		?>
	</tr>
	<?php
	foreach($RekapComplain as $key=>$RekapComplain_item){
	?>
	<tr>
		<td><?php echo $key+1; ?></td>
		<td><?php echo $RekapComplain_item['customer_name']; ?></td>
		<td><?php echo $RekapComplain_item['city_regency']; ?></td>
		<?php
		foreach($MonthYear as $MonthYear_item){
			$x=0;
			foreach($DataTpComplain as $key=>$DataTpComplain_item){
				if($RekapComplain_item['customer_id'] == $DataTpComplain_item['customer_id']){
					if($MonthYear_item['month']==strtoupper($DataTpComplain_item['group_date'])){	
					
		?>	
			<td><?php echo $DataTpComplain_item['complain']?></td>
			<td><?php echo $DataTpComplain_item['tp']?></td>
		<?php
					}
					else{
						$x+=1;
					
						if($DataTpComplain_item['total']==$x){
		?>
			<td>0</td>
			<td>0</td>
		<?php
						}
					}
				}
			}
		}
		?>
		<td><?php echo $RekapComplain_item['complain']; ?></td>
		<td><?php echo $RekapComplain_item['tp']; ?></td>
	</tr>
	<?php
	}
	?>
</table>