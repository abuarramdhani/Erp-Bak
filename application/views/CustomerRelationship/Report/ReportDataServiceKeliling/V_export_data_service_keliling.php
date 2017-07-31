<h2 style="margin-left:36%;">Report Data Service Keliling</h2>
<br />
<table width="100%">
	<tr>
		<td width="15%"><b>Period</b></td>
		<td width="3%">:</td>
		<td width="20%"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
		<td width="3%">-</td>
		<td><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td width="15%"><b>City / Regency</b></td>
		<td width="3%">:</td>
		<td width="82%"><?php echo $city_chosen;?></td>
	</tr>
</table>
<table width="100%" border=1 style="border-collapse:collapse;font-size: 11px;padding:2px;">
	<tr>
		<th width="5%"   rowspan=2>No</th>
		<th width="9.5%"  rowspan=2>Customer Name</th>
		<th width="11%"  rowspan=2>Address</th>
		<th width="8%"   rowspan=2>Contact</th>
		<th width="6%"   rowspan=2>Visit Date</th>
		<th width="34.5%"  colspan=4>Unit</th>
		<th width="12.5%" rowspan=2>Customer Response</th>
		<th width="7.5%" rowspan=2>Description</th>
	</tr>
	<tr>
		<th width="14%">Unit Type</th>
		<th width="6.5%">Buying Type</th>
		<th width="6%" >Technician</th>
		<th width="14%">Troubled Part</th>
	</tr>
	<?php
	
	foreach($AllServiceKeliling as $ask){
		$i=0;
		foreach($AllServiceKelilingUnit as $asku){
			if($ask['service_number'] == $asku['service_number']){
				$i++;
			}else{}
		}
	?>
	<tr >
		<td style="padding:3px" rowspan=<?php echo $i;?> ><?php echo $ask['service_number'];?></td>
		<td style="padding:3px" rowspan=<?php echo $i;?> ><?php echo $ask['customer_name'];?></td>
		<td style="padding:3px" rowspan=<?php echo $i;?> ><?php echo $ask['customer_address'];?></td>
		<td style="padding:3px" rowspan=<?php echo $i;?> ><?php echo $ask['contact'];?></td>
		<td style="padding:3px" rowspan=<?php echo $i;?> align="center"><?php echo $ask['service_date'];?></td>
		
		<?php
		if(sizeOf($AllServiceKelilingUnit) == 0){
		?>
		<td></td>
		<td></td>
		<td></td>
		<?php
		}
		$nn =1;
		if($ask['jumlah_asli']!=""){
			foreach($AllServiceKelilingUnit as $asku){
				if($nn < 2){
					if($ask['service_number'] == $asku['service_number']){
						if($asku['line_status'] == "CLOSE"){
							$background = "#ACD1F2";
						}else{
							$background = "#F2ACB0";
						}
					?>
					<td style="padding:3px"><?php echo $asku['item_name']?></td>
					<td style="padding:3px"><?php echo $asku['buying_type_name']?></td>
					<td style="padding:3px"><?php echo $asku['employee_name'];?></td>
					<td style="background:<?php echo $background;?>;padding:3px;"><?php echo $asku['spare_part_name']?></td>
					
					<?php
					$nn++;
					}
				}
			}
		}
		else{
			?>
					<td style="padding:3px">-</td>
					<td style="padding:3px">-</td>
					<td style=";padding:3px;">-</td>
					<td style=";padding:3px;">-</td>
			<?php
		}
		?>
		<td rowspan=<?php echo $i;?> style="vertical-align:top;padding:0;" width="300px">
			<?php
			/* 
			foreach($AllServiceKelilingResponse as $askr){
				if($ask['service_number'] == $askr['service_number']){
					if($askr['faq_type'] == "complain"){
					?>
					<div style="width:100%;height:100%;position:relative;border-collapse:collapse;background:#F2ACB0;border-bottom: 1px solid black;text-align:justify;">
						<?php echo strtolower(trim($askr['faq_description1']));?>
					</div>
					<?php
					}else if($askr['faq_type'] == "feedback"){
					?>
					<div style="width:100%;height:100%;position:relative;border-collapse:collapse;background:#AFF2AC;border-bottom: 1px solid black;text-align:justify;">
						<?php echo strtolower(trim($askr['faq_description1']));?>
					</div>
					<?php
					}else if($askr['faq_type'] == "question"){
					?>
					
					<div style="width:100%;height:100%;position:relative;border-collapse:collapse;background:#ACD1F2;border-bottom: 1px solid black;text-align:justify;">
						<?php echo strtolower(trim($askr['faq_description1']));?>
					</div>
					
					<?php
					}else{
					?>
					<div style="width:100%;height:100%;position:relative;border-collapse:collapse;background:#E1ACF2;border-bottom: 1px solid black;text-align:justify;">
						<?php echo strtolower(trim($askr['faq_description1']));?>
					</div>
					<?php
					}
				}else{} 
			}*/
			?>
			<table border=1 style="border-collapse:collapse;" width="100%">
			<?php
			foreach($AllServiceKelilingResponse as $askr){
				if($ask['service_number'] == $askr['service_number']){
					if($askr['faq_type']=='Complain'){
						$bgcolor =  "bgcolor='#ff7396'";
					}elseif($askr['faq_type']=='Feedback'){
						$bgcolor =  "bgcolor='#67cd00'";
					}
					elseif($askr['faq_type']=='Question'){
						$bgcolor =  "bgcolor='#0080ff'";
					}
					else{
						$bgcolor =  "bgcolor='#dc73ff'";
					} 
			?>
			<tr <?php echo $bgcolor; ?> >
			<td align="center"><?php echo $askr['faq_description1']; ?></td>
			</tr>
			<?php
				}
			}
			?></table>
		</td>
		<td rowspan=<?php echo $i;?> ><?php echo $ask['description'];?></td>
	</tr>
	<?php
		$q = 1;
		foreach($AllServiceKelilingUnit as $asku){
			if($ask['service_number'] == $asku['service_number']){
				if($q == 1){
					
				}else{
					if($asku['line_status'] == "CLOSE"){
						$background = "#ACD1F2";
					}else{
						$background = "#F2ACB0";
					}
				?>
				<tr style="font-size:9px;">
				<td style="padding:3px"><?php echo $asku['item_name']?></td>
				<td style="padding:3px"><?php echo $asku['buying_type_name']?></td>
				<td style="padding:3px"><?php echo $asku['employee_name'];?></td>
				<td style="background:<?php echo $background;?>;padding:3px;"><?php echo $asku['spare_part_name']?></td>
				</tr>
				<?php
				}
				$q++;
			}else{}
		}
		?>
	<?php
	}
	?>
</table>