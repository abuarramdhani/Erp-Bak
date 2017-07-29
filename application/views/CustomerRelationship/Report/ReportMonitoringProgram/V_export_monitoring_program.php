<h2 style="margin-left:22%;">Report Monitoring Program (Call-Out and Customer Visit)</h2>
<div>
	<table width="100%">
		<tr>
			<td width="15%"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $month_from;?></td>
			<td width="3%">-</td>
			<td><?php echo $month_to;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Ownership Date</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php if($start_ownership_date==""){echo "-";}else{echo date_format(date_create($start_ownership_date),'d-M-Y');};?></td>
			<td width="3%">-</td>
			<td><?php if($end_ownership_date==""){echo "-";}else{echo date_format(date_create($end_ownership_date),'d-M-Y');}?></td>
		</tr>
		<tr>
			<td><b>Area</b></td>
			<td>:</td>
			<td><?php echo $province_chosen;?></td>
		</tr>
		
		
		<tr>
			<td><b>Program</b></td>
			<td>:</td>
			<td><?php echo $program;?></td>
		</tr>
		<tr>
			<td><b>Buying Type</b></td>
			<td>:</td>
			<td><?php echo $buying_type;?></td>
		</tr>
	</table>
</div>
<br />
<table border=1 style="font-size:10px;border-collapse:collapse;border:1px solid #333;text-align:center;">
	<tr>
		<td width="20" rowspan=2>Num.</td>
		<td width="100" rowspan=2>Customer Name</td>
		<td width="70" rowspan=2>City / Regency</td>
		<td width="60" rowspan=2>Contact</td>
		<td width="200" colspan=4>Unit</td>
		<?php foreach($MonthYear as $MonthYear_item){ ?>
		<td colspan=4 width="60"><?php echo $MonthYear_item['month']; ?></td>
		<?php
		}
		?>
	</tr>
	<tr>
		<td width="7">Unit</td>
		<td width="7">Body Number</td>
		<td width="7">Ownership Date</td>
		<td width="7">Buying Type</td>
		<?php foreach($MonthYear as $MonthYear_item){ ?>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<?php
		}
		?>
	</tr>
	<?php
	$k=1;
	$no=1;
	foreach($CustomerOwnership as $CustomerOwnership_item){
	?>
	<tr>
		<?php if($k==1){ ?>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?>><?php echo $no;?></td>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?> align="left" width="20"><?php echo $CustomerOwnership_item['customer_name'];?></td>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?> align="left" width="20"><?php echo $CustomerOwnership_item['city_regency'];?></td>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?> align="left" width="20"><?php echo $CustomerOwnership_item['contact'];?></td>
		<?php } ?>
		<td width="50" align="left"><?php echo $CustomerOwnership_item['type'];?></td>
		<td width="70" align="left"><?php echo $CustomerOwnership_item['no_body'];?></td>
		<td width="80" align="left"><?php echo $CustomerOwnership_item['ownership_date'];?></td>
		<td width="50" align="left"><?php echo $CustomerOwnership_item['buying_type_name'];?></td>
		<?php 	foreach($MonthYear as $MonthYear_item){ 
					$x=0;
					if($k==1){
						foreach($ProgramMonth as $ProgramMonth_item){
							if($MonthYear_item['month'] == $ProgramMonth_item['service_month']
								and $CustomerOwnership_item['customer_id']==$ProgramMonth_item['customer_id']){
									for($i=1;$i<=4;$i++){
										$z=0;
										foreach($ProgramWeek as $ProgramWeek_item){
											if($MonthYear_item['month'] == $ProgramWeek_item['service_month']
												and $CustomerOwnership_item['customer_id']==$ProgramWeek_item['customer_id']){
												if($i==$ProgramWeek_item['service_week']){
													if($ProgramWeek_item['type']=='CO'){
														$bgcolor =  "bgcolor='#4cd2ff'";
													}elseif($ProgramWeek_item['type']=='CV'){
														$bgcolor =  "bgcolor='#ff7396'";
													}else{
														$bgcolor =  "bgcolor='#dc73ff'";
													}
		?>
													<td width="8" <?=$bgcolor?> rowspan=<?=$CustomerOwnership_item['jumlah']?>></td>
		<?php
												}else{
													$z++;
													
													
													if($ProgramWeek_item['total']>1){
														if($ProgramWeek_item['total']==$z){
		?>											
														<td width="8" rowspan=<?=$CustomerOwnership_item['jumlah']?>></td>
		<?php
														}
													}else{
		?>											
													<td width="8" rowspan=<?=$CustomerOwnership_item['jumlah']?>></td>
		<?php											
													}
												}
												
											}
										}
									}
									/* if($ProgramMonth_item['service_week']==1){
		?>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?>><?=$ProgramMonth_item['service_month']?></td>
		
		<?php 			
									}else{
		?>
										<td rowspan=<?=$CustomerOwnership_item['jumlah']?>><?=$x?>0</td>
		<?php
									}*/
							}elseif($MonthYear_item['month'] != $ProgramMonth_item['service_month']
								and $CustomerOwnership_item['customer_id']==$ProgramMonth_item['customer_id']){
									$x++;
									if($ProgramMonth_item['total']==$x){
		?>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?>></td>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?>></td>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?>></td>
		<td rowspan=<?=$CustomerOwnership_item['jumlah']?>></td>
		<?php
									}
							}
						}
					} 
				}
		?>
		<?php
		/*
		$all = ($tt - $awal2 + 1) * 4;
		//echo $all;
		$m = 1;
		while($m <= $all){
			$date1 = new DateTime($CustomerOwnership_item['ownership_date']);
			$date2 = new DateTime($CustomerOwnership_item[$m]);
			$interval = $date1->diff($date2);
			$hasil = $interval->format("%r");
			$bedahari = $interval->format("%r%a");
			
			$od1 = new DateTime($CustomerOwnership_item['ownership_date']);
			$od2 = new DateTime($CustomerOwnership_item[$all]);
			$lama = $od1->diff($od2);
			$hasil2 = $lama->format("%r");
			$totalpunya = $lama->format("%r%a");
			
			$cd1 = new DateTime($CustomerOwnership_item['connect_date']);
			$cd2 = new DateTime($CustomerOwnership_item[$m]);
			$interval2 = $cd1->diff($cd2);
			$bedacd = $interval2->format("%r%a");
			
			$vd1 = new DateTime($CustomerOwnership_item['service_date']);
			$vd2 = new DateTime($CustomerOwnership_item[$m]);
			$interval3 = $vd1->diff($vd2);
			$bedavd = $interval3->format("%r%a");
			
			$ad1 = new DateTime($CustomerOwnership_item['connect_date']);
			$ad2 = new DateTime($CustomerOwnership_item[$all]);
			$interval4 = $ad1->diff($ad2);
			$bedaad = $interval4->format("%r%a");
			
			if($hasil == "-"){
				?>
				<td style="background: grey;border:1px solid #333;">1</td>
				<?php
			}else{
				if(($bedahari > 0) and ($bedahari < 7)){
				?>
				<td style="background: green;border:1px solid #333;">2</td>
				<?php
				}else if(($bedacd > 0) and ($bedacd < 7)){
					if(($bedavd > 0) and ($bedavd < 7)){
										?>
					<td style="background: purple;border:1px solid #333;">3</td>
					<?php

					}else{
					?>
					<td style="background: blue;border:1px solid #333;">4</td>
					<?php
					}
				}else if(($bedavd > 0) and ($bedavd < 7)){
					if(($bedacd > 0) and ($bedacd < 7)){
					?>
					<td style="background: purple;border:1px solid #333;">5</td>
					<?php
					}else{
					?>
					<td style="background: red;border:1px solid #333;">6</td>
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
						<td style="background: #fff;border:1px solid #333;">7</td>
						<?php
						}else{
						?>
						<td style="background: #95D7F3;border:1px solid #333;">8</td>
						<?php
						}
					}else{
					?>
					<td style="background: #fff;border:1px solid #333;">9</td>
					<?php	
					}
				}
			}
			$m++;
		}
		*/
		?>
	</tr>
	<?php
		if($k==$CustomerOwnership_item['jumlah']){$k=0;}
		$k++;
		$no++;
	}
	?>
</table>