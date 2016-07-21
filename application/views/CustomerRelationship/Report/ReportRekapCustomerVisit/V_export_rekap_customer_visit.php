<h2 style="margin-left: 33%">Report Rekap Customer Visit</h2>
<div style="width:50%;">
	<table width="100%">
		<tr>
			<td width="15%"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo date_format(date_create($start_date),'d-M-Y');?></td>
			<td width="3%">-</td>
			<td><?php echo date_format(date_create($end_date),'d-M-Y');?></td>
		</tr>
	</table>
</div>
<div style="width:100%;">
	<div style="width:27%;float:left;" >
		<table width="100%"  border="1" style="border: 1px solid #333;border-collapse:collapse;">
			<tr>
				<th colspan="3"><b>By Activity</b></th>
			</tr>
			<tr>
				<th width="15%">Num</th>
				<th>Activity</th>
				<th>Frequency</th>
			</tr>
			<?php
				$num = 0;
				$total = 0;
				foreach($Activity as $Activity_item){
				$num++;
				$total += $Activity_item['freq'];
			?>
			<tr>
				<td><?php echo $num;?></td>
				<td><?php echo $Activity_item['activity'];?></td>
				<td><?php echo $Activity_item['freq'];?></td>
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
	<div style="width:23%;float:left;margin-left:1%;">
		<table width="100%"  border="1" style="border: 1px solid #333;border-collapse:collapse;">
			<tr>
				<th colspan="3"><b>By Regency / City</b></th>
			</tr>
			<tr>
				<th width="15%">Num</th>
				<th width="60%">Regency / City</th>
				<th width="25%">Frequency</th>
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
				<td><?php echo $CityRegency_item['regency_name'];?></td>
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
	<div style="width:23%;float:left;margin-left:1%;">
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
				<td><?php echo $Province_item['province_name'];?></td>
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
	<div style="width:23%;float:left;margin-left:1%;">
		<table width="100%"  border="1" style="border: 1px solid #333;border-collapse:collapse;">
			<tr>
				<th colspan="3"><b>By Month</b></th>
			</tr>
			<tr>
				<th width="15%">Num</th>
				<th width="60%">Month</th>
				<th width="25%">Frequency</th>
			</tr>
			<?php
				$num = 0;
				$total = 0;
				foreach($Month as $Month_item){
				$num++;
				$total += $Month_item['freq'];
			?>
			<tr>
				<td><?php echo $num;?></td>
				<td><?php echo $Month_item['month'];?></td>
				<td><?php echo $Month_item['freq'];?></td>
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