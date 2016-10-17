<h2 style="margin-left: 33%">Report Data Call-In</h2>
<div style="width:49%;float:left;">
	<table width="100%">
		<tr>
			<td width="15%"><b>City / Regency</b></td>
			<td width="3%">:</td>
			<td width="82%"><?php echo $city_chosen;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Unit</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $unit;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Customer</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $customer;?></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="15%"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
			<td width="3%">-</td>
			<td><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
		</tr>
	</table>
</div>
<div style="width:40%;float:left;">
	<table width="100%">
		<tr>
			<td width="15%"><b>Line</b></td>
			<td width="3%">:</td>
			<td width="82%"><?php echo $line;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Category Response</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $faq_type;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Operator</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $operator;?></td>
		</tr>
	</table>
</div>
<div style="width:100%;">
<table border="1" style="border-collapse:collapse;table-layout:fixed;" width="100%">
	<thead>
	<tr>
		<th width="70" rowspan=2>No</th>
		<th width="150" rowspan=2>Customer Name</th>
		<th width="120" rowspan=2>City / Regency</th>
		<th width="120" rowspan=2>Contact</th>
		<th width="150" rowspan=2>Description</th>
		<th width="50" rowspan=2>Line</th>
		<th width="100" rowspan=2>Operator</th>
		<th width="130" rowspan=2>Customer Response</th>
		<th width="360" colspan=3>Unit</th>
	</tr>
	<tr>
		<th width="120">Type Unit</th>
		<th width="120">Trouble Part</th>
		<th width="120">Action</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	foreach($CallIn as $CallIn_item){
	?>
	
	<tr>
		<td rowspan="<?php echo $CallIn_item['jumlah']; ?>" style="word-wrap: break-word" align="center"><?php echo $CallIn_item['connect_number']; ?></td>
		<td rowspan="<?php echo $CallIn_item['jumlah']; ?>" align="center"><?php echo $CallIn_item['customer_name']; ?></td>
		<td rowspan="<?php echo $CallIn_item['jumlah']; ?>" align="center"><?php echo $CallIn_item['city_regency']; ?></td>
		<td rowspan="<?php echo $CallIn_item['jumlah']; ?>" align="center"><?php echo $CallIn_item['contact_number']; ?></td>
		<td rowspan="<?php echo $CallIn_item['jumlah']; ?>" align="center"><?php echo $CallIn_item['description']; ?></td>
		<td rowspan="<?php echo $CallIn_item['jumlah']; ?>" align="center"><?php echo $CallIn_item['line_operator']; ?></td>
		<td rowspan="<?php echo $CallIn_item['jumlah']; ?>" align="center" style="word-wrap: break-word"><?php echo $CallIn_item['employee_name']; ?></td>
		<td  rowspan="<?php echo $CallIn_item['jumlah']; ?>">
		<table border=1 style="border-collapse:collapse;" width="100%">
		<?php
		foreach($CustomerResponse as $CustomerResponse_item){
			if($CustomerResponse_item['service_connect_id'] ===	$CallIn_item['connect_id']){
				if($CustomerResponse_item['faq_type']=='Complain'){
					$bgcolor =  "bgcolor='#ff7396'";
				}elseif($CustomerResponse_item['faq_type']=='Feedback'){
					$bgcolor =  "bgcolor='#67cd00'";
				}
				elseif($CustomerResponse_item['faq_type']=='Question'){
					$bgcolor =  "bgcolor='#4cd2ff'";
				}
				else{
					$bgcolor =  "bgcolor='#dc73ff'";
				} 
		?>
		<tr <?php echo $bgcolor; ?> >
		<td align="center"><?php echo $CustomerResponse_item['faq_description1']; ?></td>
		</tr>
		<?php
			}
		}
		?></table>
		</td>
		<?php
		if($CallIn_item['jumlah_asli']!=""){
			foreach($TroubledPart as $TroubledPart_item){
				if($TroubledPart_item['connect_id'] === $CallIn_item['connect_id']){
					if($TroubledPart_item['line_status']=='OPEN'){
						$bgcolor = "bgcolor='#ff6666'";
					}
					else{
						$bgcolor = "bgcolor='#66b2ff'";
					}
					if($i!=0){
			?>
			<tr <?php echo $bgcolor; ?> width="120" >
			<?php
					}
			?>
			<td align="center" style="word-wrap: break-word">-</td>
			<td align="left" style="word-wrap: break-word"><?php echo $TroubledPart_item['spare_part_name']; ?></td>
			<td align="center" style="word-wrap: break-word"><?php echo $TroubledPart_item['action']; ?></td>
			<?php 
					if($i!=0){
			?>
			</tr>
			<?php
					}
				$i++;
				}
				else{ 
					$i=0;
				}
			}
		}
		else{
		?>
			<td align="center" style="word-wrap: break-word">-</td>
			<td align="left" style="word-wrap: break-word">-</td>
			<td align="center" style="word-wrap: break-word">-</td>
		<?php
		}
		?>
		
	</tr>
	<?php
	}
	?>
	</tbody>
</table>
</div>