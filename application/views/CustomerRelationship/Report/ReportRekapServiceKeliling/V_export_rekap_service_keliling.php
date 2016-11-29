<h2 style="margin-left:35%">Report Rekap Service Keliling</h2>
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
			<td width="320"><?php echo $city_chosen;?></td>
		</tr>
	</table>
<br />

<table border=1 style="border:1px solid #333;border-collapse:collapse;">
	<tr>	
		<th width="5%">No</th>
		<th width="55%">Kabupaten / Kota</th>
		<th width="10%">Unit</th>
		<th width="10%">Spare Part</th>
	</tr>
	<?php
	$num=0;
	$sumsp=0;
	$sumun=0;
	foreach($RekapServiceKeliling as $rsk){
		$num++;
		?>
		<tr>
			<td align="center"><?php echo $num;?></td>
			<td style="padding: 3px;"><?php echo $rsk['regency_name'];?></td>
			<td style="padding: 3px;" align="right"><?php echo $rsk['unit'];?></td>
			<td style="padding: 3px;" align="right"><?php echo $rsk['spare_part'];?></td>
		</tr>
		<?php
		$sumun =$sumun + $rsk['unit'];
		$sumsp =$sumsp + $rsk['spare_part'];
	}
	?>
	<tr>
		<td style="padding: 3px;" colspan=2><b>Total</b></td>
		<td style="padding: 3px;" align="right"><?php echo $sumun;?></td>
		<td style="padding: 3px;" align="right"><?php echo $sumsp;?></td>
	</tr>
</table>
