<h2 style="margin-left:35%">Report Rekap Troubled Part</h2>
<br>
<div style="width:50%;">
	<table width="100%">
		<tr>
			<td width="100"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $month_from;?></td>
			<td width="3%">-</td>
			<td><?php echo $month_to;?></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="100"><b>Unit</b></td>
			<td width="3%">:</td>
			<td width="82%"><?php echo $unit;?></td>
		</tr>
		<tr>
			<td width="100"><b>Area</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $city_chosen;?></td>
		</tr>
		<tr>
			<td width="100"><b>Spare Part</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $spare_part;?></td>
		</tr>
	</table>
	
</div>
<table width="100%" border=1 style="font-size:11px;border:1px solid #333;border-collapse:collapse;">
	<tr>
		<th width="3%">No</th>
		<th width="15%">Spare Part</th>
		<th width="15%">Unit</th>
		<?php
		while($nstart <= $tt){
			$bulan = ${"bulan" . $nstart};
			?>
			<th>
				<?php echo $bulan;?>
			</th>
			<?php
			$nstart++;
		}
		?>
		<th width="3%">Avg</th>
		<th width="4%">Total</th>
	</tr>
	<?php
	$num =0;
	$awal = $waw;
	foreach($RekapTroubledPart as $rtp){
	//echo $rtp['a1'];
	$num++;
	?>
	<tr>
		<td style="padding:3px;" align="center"><?php echo $num;?></td>
		<td style="padding:3px;"><?php echo $rtp['spare_part_name'];?></td>
		<td style="padding:3px;"><?php echo $rtp['item_name'];?></td>
		<?php
		//echo $waw;
		$ii = 1;
		while($awal <= $tt){
			$aa = $rtp['a'.$ii];
		?>
		<td style="padding:3px;" align="right" ><?php echo $aa;?></td>
		<?php
			$awal++;
			$ii++;
		}
		$awal = $waw;
		$ii = 1;
		?>
		<td style="padding:3px;" align="right"><?php echo round($rtp['total']/$tt, 3);?></td>
		<td style="padding:3px;" align="right"><?php echo $rtp['total'];?></td>
	</tr>
	<?php
	}
	?>
</table>