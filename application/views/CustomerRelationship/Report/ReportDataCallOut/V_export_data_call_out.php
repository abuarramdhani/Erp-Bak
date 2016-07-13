<h2 style="margin-left: 33%">Report Data Call-Out</h2>
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
		<tr>
			<td width="80"><b>Buying Type</b></td>
			<td width="20">:</td>
			<td width="320"><?php echo $buying_type;?></td>
		</tr>
	</table>
<table border=1 style="border-collapse:collapse;table-layout:fixed;">
	<thead>
	<col width= "80"/>
	<col width= "120"/>
	<col width= "120"/>
	<col width= "95"/>
	<col width= "110"/>
	<col width= "100"/>
	<col width= "120"/>
	<col width= "70"/>
	<col width= "100"/>
	<col width= "30"/>
	<col width= "150"/>
	<col width= "150"/>
	<tr>
		<th width="80" rowspan=2>Conn. Num</th>
		<th width="120" rowspan=2>Customer Name</th>
		<th width="120" rowspan=2>City / Regency</th>
		<th width="95" rowspan=2>Contact</th>
		<th width="110" rowspan=2>Calling Date</th>
		<th width="100" rowspan=2>Operator</th>
		<th width="300" colspan=4>Unit</th>
		<th width="150" rowspan=2>Customer Response</th>
		<th width="150" rowspan=2>Description</th>
	</tr>
	<tr>
		<th width="120">Type Unit</th>
		<th width="80">Body Num</th>
		<th width="100">Buying Type</th>
		<th width="20">Use (Ha)</th>
	</tr>
	</thead>
	
	<tbody>
	<?php
	$connect_number = "";
	foreach($CallOut as $CallOut_item){
		$row = ($CallOut_item['jlh_unit_connect']==0)?1:$CallOut_item['jlh_unit_connect'];
		
	?>
	<tr>
		<?php if($connect_number != $CallOut_item['connect_number']){ ?>
		<td rowspan="<?php echo $row; ?>"><?php echo $CallOut_item['connect_number']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CallOut_item['customer_name']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CallOut_item['city_regency']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CallOut_item['contact_number']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CallOut_item['calling_date']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CallOut_item['operator']; ?></td>
		<?php } ?>
		
		<td><?php echo $CallOut_item['unit_name']; ?></td>
		<td><?php echo $CallOut_item['body_num']; ?></td>
		<td><?php echo $CallOut_item['buying_type_name']; ?></td>
		<td><?php echo $CallOut_item['use']; ?></td>
		
		<?php if($connect_number != $CallOut_item['connect_number']){ ?>
		<td rowspan="<?php echo $row; ?>">

		<table border=1 style="border-collapse:collapse;" width="100%">
		<?php
		foreach($CustomerResponse as $CustomerResponse_item){
			if($CustomerResponse_item['service_connect_id'] ===	$CallOut_item['connect_id']){
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
		<td align="center"><?php echo strtoupper($CustomerResponse_item['faq_description1']); ?></td>
		</tr>
		<?php
			}
		}
		?></table>
		</td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CallOut_item['connect_description']; ?></td>
	<?php
		}
		$connect_number = $CallOut_item['connect_number'];
	}
	?>
	</tr>
	</tbody>
</table>
