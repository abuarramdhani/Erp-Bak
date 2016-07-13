<h2 style="margin-left: 33%">Report Rekap Call Out</h2>
<div style="width:50%;">
	<table width="100%">
		<tr>
			<td width="15%"><b>Province</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $province_chosen;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
			<td width="3%">-</td>
			<td><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
		</tr>
	</table>
</div>
<div style="width:100%;">
	<div style="width:26%;float:left;" >
		<table width="100%"  border="1" style="border: 1px solid #333;border-collapse:collapse;">
			<tr>
				<th colspan="3"><b>By City / Regency</b></th>
			</tr>
			<tr>
				<th width="15%">Num</th>
				<th>City / Regency</th>
				<th>Frequency</th>
			</tr>
			<?php
				$num = 0;
				$total = 0;
				foreach($CityRegency as $CityRegency_item){
				$num++;
				$total += $CityRegency_item['freq'];
			?>
			<tr>
				<td><?php echo $num;?></td>
				<td><?php echo $CityRegency_item['city_regency'];?></td>
				<td><?php echo $CityRegency_item['freq'];?></td>
			</tr>
			
			<?php
				}
			?>
			<tr>
				<td></td>
				<td><b>Total</b></td>
				<td><?php echo $total;?></td>
			</tr>
		</table>
	</div>
	<div style="width:27%;float:left;margin-left:1%;">
		<table width="100%"  border="1" style="border: 1px solid #333;border-collapse:collapse;">
			<tr>
				<th colspan="3"><b>By Province</b></th>
			</tr>
			<tr>
				<th width="15%">Num</th>
				<th width="60%">Province</th>
				<th width="25%">Frequency</th>
			</tr>
			<?php
				$num = 0;
				$total = 0;
				foreach($Province as $Province_item){
				$num++;
				$total += $Province_item['freq'];
			?>
			<tr>
				<td><?php echo $num;?></td>
				<td><?php echo $Province_item['province'];?></td>
				<td><?php echo $Province_item['freq'];?></td>
			</tr>
			<?php
				}
			?>
			<tr>
				<td></td>
				<td><b>Total</b></td>
				<td><?php echo $total;?></td>
			</tr>
		</table>
	</div>
	
</div>