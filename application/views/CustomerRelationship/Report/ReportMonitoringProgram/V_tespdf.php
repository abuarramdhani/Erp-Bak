<table border=1 style="border-collapse:collapse;border:1px solid #333;text-align:center;" width="100%">
	<tr>
		<td width="5%" rowspan=2>No</td>
		<td width="12%" rowspan=2>Nama Customer</td>
		<td width="12%" rowspan=2>Kabupaten</td>
		<td width="7%" rowspan=2>Contact</td>
		<td width="7%" rowspan=2>Ownership Date</td>
		<td width="7%" rowspan=2>Buying Type</td>
		<?php
		$awal = $nstart;
		$awal2 = $nstart;
		while($nstart <= $tt){
			$bulan = ${"bulan" . $nstart};
		?>
		<td colspan=4>
			<?php echo $bulan;?>
		</td>
		<?php
			$nstart++;
		}
		?>
	</tr>
	<tr>
		<?php
		while($awal <= $tt){
		?>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<?php
			$awal++;
		}
		?>
	</tr>
	<?php
	$k=1;
	foreach($tes as $ts){
	?>
	<tr>
		<td><?php echo $k;?></td>
		<td align="left"><?php echo $ts['customer_name'];?></td>
		<td align="left"><?php echo $ts['city_regency'];?></td>
		<td align="left"><?php echo $ts['no_engine'];?></td>
		<td align="left"><?php echo date_format(date_create($ts['ownership_date']), 'd-M-Y');?></td>
		<td align="left"><?php echo $ts['buying_type_name'];?></td>
		<?php
		$all = ($tt - $awal2 + 1) * 4;
		//echo $all;
		$m = 1;
		while($m <= $all){
			$date1 = new DateTime($ts['ownership_date']);
			$date2 = new DateTime($ts[$m]);
			$interval = $date1->diff($date2);
			$hasil = $interval->format("%r");
			$bedahari = $interval->format("%r%a");
			
			$od1 = new DateTime($ts['ownership_date']);
			$od2 = new DateTime($ts[$all]);
			$lama = $od1->diff($od2);
			$hasil2 = $lama->format("%r");
			$totalpunya = $lama->format("%r%a");
			
			$cd1 = new DateTime($ts['callout_date']);
			$cd2 = new DateTime($ts[$m]);
			$interval2 = $cd1->diff($cd2);
			$bedacd = $interval2->format("%r%a");
			
			$vd1 = new DateTime($ts['visit_date']);
			$vd2 = new DateTime($ts[$m]);
			$interval3 = $vd1->diff($vd2);
			$bedavd = $interval3->format("%r%a");
			
			$ad1 = new DateTime($ts['callout_date']);
			$ad2 = new DateTime($ts[$all]);
			$interval4 = $ad1->diff($ad2);
			$bedaad = $interval4->format("%r%a");
			
			if($hasil == "-"){
				?>
				<td style="background: grey;border:1px solid #333;"></td>
				<?php
			}else{
				if(($bedahari > 0) and ($bedahari < 7)){
				?>
				<td style="background: green;border:1px solid #333;"></td>
				<?php
				}else if(($bedacd > 0) and ($bedacd < 7)){
					if(($bedavd > 0) and ($bedavd < 7)){
										?>
					<td style="background: purple;border:1px solid #333;"></td>
					<?php

					}else{
					?>
					<td style="background: blue;border:1px solid #333;"></td>
					<?php
					}
				}else if(($bedavd > 0) and ($bedavd < 7)){
					if(($bedacd > 0) and ($bedacd < 7)){
					?>
					<td style="background: purple;border:1px solid #333;"></td>
					<?php
					}else{
					?>
					<td style="background: red;border:1px solid #333;"></td>
					<?php
					}
				}else{
					if($bedacd > 0){
						if($totalpunya < 357){
							$kk = 91;
						}else if($totalpunya < 713){
							$kk = 121;
						}else if($totalpunya < 1069){
							$kk = 181;
						}else{
							$kk = 10000000000000000;
						}
						if(($bedaad > 0) and ($bedaad < $kk)){
						?>
						<td style="background: #fff;border:1px solid #333;"></td>
						<?php
						}else{
						?>
						<td style="background: #95D7F3;border:1px solid #333;"></td>
						<?php
						}
					}else{
					?>
					<td style="background: #fff;border:1px solid #333;"></td>
					<?php	
					}
				}
			}
			$m++;
		}
		
		?>
	</tr>
	<?php
		$k++;
	}
	?>
</table>