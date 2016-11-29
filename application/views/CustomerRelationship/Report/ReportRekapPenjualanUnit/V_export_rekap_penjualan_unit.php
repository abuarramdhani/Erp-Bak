<h2 style="margin-left: 33%">Report Rekap Jumlah Unit</h2>
<table>
		<tr>
			<td width="150"><b>Period</b></td>
			<td width="20">:</td>
			<td width="150"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
			<td width="20">-</td>
			<td width="150"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
		</tr>
</table>
<table>
		<tr>
			<td width="150"><b>Area</b></td>
			<td width="20">:</td>
			<td width="320"><?php echo $province_chosen;?></td>
		</tr>
		<tr>
			<td width="80"><b>Buying Type</b></td>
			<td width="20">:</td>
			<td width="320"><?php echo $buying_type;?></td>
		</tr>
</table>
<br />
<table border=1 style="border-collapse:collapse;">
	<thead>
		<tr>
			<th width="150">Area</th>
			<?php
			foreach($MonthYear as $MonthYear_item){
			?>
				<th  width="30" ><?php echo $MonthYear_item['month']; ?></th>
			<?php
			}
			?>
			<th width="50">Total</th>
			<th width="50">Average</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($ProvinceTotal as $ProvinceTotal_item){
		?>
		<tr>
			<td><?php echo ($ProvinceTotal_item['province']=='Total')?"<b>".$ProvinceTotal_item['province']."</b>":$ProvinceTotal_item['province']; ?></td>
			<?php
			foreach($MonthYear as $MonthYear_item){
				$x=0;
				foreach($ProvincePerMonth as $ProvincePerMonth_item){
					if($ProvincePerMonth_item['province']==$ProvinceTotal_item['province'] and
					$ProvincePerMonth_item['month_own']== $MonthYear_item['month']){
			?>
				<td><?php echo $ProvincePerMonth_item['month_total']; ?></td>
			<?php
					}elseif($ProvincePerMonth_item['province']==$ProvinceTotal_item['province'] and
					$ProvincePerMonth_item['month_own']!= $MonthYear_item['month']){
						$x++;
					
						if($ProvincePerMonth_item['total']== $x){
			?>
				<td>0</td>
			<?php
						}
					}
				}
				
			}
			?>
			<td width="50"><?=$ProvinceTotal_item['total']?></td>
			<td width="50"><?=round($ProvinceTotal_item['total']/count($MonthYear),2)?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php
foreach($ProvinceTotal as $ProvinceTotal_item){
	if ($ProvinceTotal_item['province'] != 'Total'){
?>
<br />
<b><?=$ProvinceTotal_item['province']?></b>
<table border=1 style="border-collapse:collapse;">
	<thead>
		<tr>
			<th width="150">Area</th>
			<?php
			foreach($MonthYear as $MonthYear_item){
			?>
				<th width="30" ><?php echo $MonthYear_item['month']; ?></th>
			<?php
			}
			?>
			<th width="50">Total</th>
			<th width="50">Average</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($CityTotal as $CityTotal_item){
			if($CityTotal_item['province']==$ProvinceTotal_item['province']){
		?>
		<tr>
			<td><?=$CityTotal_item['city_regency']?></td>
			<?php
			foreach($MonthYear as $MonthYear_item){
				$x=0;
				foreach($CityPerMonth as $CityPerMonth_item){
					if($CityPerMonth_item['city_regency']==$CityTotal_item['city_regency'] and
					$CityPerMonth_item['month_own']== $MonthYear_item['month']){
			?>
				<td><?php echo $CityPerMonth_item['month_total']; ?></td>
			<?php
					}elseif($CityPerMonth_item['city_regency']==$CityTotal_item['city_regency'] and
					$CityPerMonth_item['month_own']!= $MonthYear_item['month']){
						$x++;
					//}
						if($CityPerMonth_item['total']== $x){
			?>
				<td>0</td>
			<?php
						}
					}
				}
				
			}
			?>
			<td width="50"><?=$CityTotal_item['total']?></td>
			<td width="50"><?=round($CityTotal_item['total']/count($MonthYear),2)?></td>
		</tr>
		<?php
			}
		}
		?>
	</tbody>
</table>
<?php
	}
}
?>