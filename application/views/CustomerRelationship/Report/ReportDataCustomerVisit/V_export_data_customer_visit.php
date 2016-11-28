<h2 style="margin-left: 33%">Report Data Customer Visit</h2>
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
	<col width= "180"/>
	<col width= "95"/>
	<col width= "80"/>
	<col width= "90"/>
	<col width= "110"/>
	<col width= "60"/>
	<col width= "110"/>
	<col width= "100"/>
	<col width= "100"/>
	<col width= "100"/>
	<tr>
		<th width="70" rowspan=2>No</th>
		<th width="100" rowspan=2>Customer Name</th>
		<th width="180" rowspan=2>Address</th>
		<th width="95" rowspan=2>Contact</th>
		<th width="80" rowspan=2>Visit Date</th>
		<th width="90" rowspan=2>Petugas</th>
		<th width="280" colspan=3>Unit</th>
		<th width="100" rowspan=2>Customer Response</th>
		<th width="100" rowspan=2>Add. Activity</th>
		<th width="100" rowspan=2>Description</th>
	</tr>
	<tr>
		<th>Type Unit</th>
		<th>Buying Type</th>
		<th>Trouble Part</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$service_number = "";
	foreach($CustomerVisit as $CustomerVisit_item){
		$row = ($CustomerVisit_item['jlh_unit_service']==0)?1:$CustomerVisit_item['jlh_unit_service'];
		
	?>
	
	<tr>
		<?php if($service_number != $CustomerVisit_item['service_number']){ ?>
		<td rowspan="<?php echo $row; ?>"><?php echo $CustomerVisit_item['service_number']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CustomerVisit_item['customer_name']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CustomerVisit_item['address']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CustomerVisit_item['contact']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CustomerVisit_item['visit_date']; ?></td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CustomerVisit_item['teknisi']; ?></td>
		<?php } ?>
		
		<td><?php echo $CustomerVisit_item['item_name']; ?></td>
		<td><?php echo $CustomerVisit_item['buying_type_name']; ?></td>
		<td><table border=1 style="border-collapse:collapse;" width="100%">
			<?php
			foreach($TroubledPart as $TroubledPart_item){
				if($TroubledPart_item['service_product_id'] === $CustomerVisit_item['service_product_id'] && 
				$TroubledPart_item['ownership_id'] === $CustomerVisit_item['ownership_id']){
					if($TroubledPart_item['line_status'] == "CLOSE"){
								$background = "bgcolor=#ACD1F2";
							}else{
								$background = "bgcolor=#F2ACB0";
							}
			?>
			<tr <?= $background ?> >
			<td><?php echo $TroubledPart_item['spare_part_name']; ?></td>
			</tr>
			<?php
				}
			}
			?></table>
		</td>
		
		<?php if($service_number != $CustomerVisit_item['service_number']){ ?>
		<td rowspan="<?php echo $row; ?>">
			<table border=1 style="border-collapse:collapse;" width="100%">
			<?php
			foreach($CustomerResponse as $CustomerResponse_item){
				if($CustomerResponse_item['service_connect_id'] === $CustomerVisit_item['service_product_id']){
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
			<tr <?php echo $bgcolor; ?>>
			<td><?php echo $CustomerResponse_item['faq_description1']; ?></td>
			</tr>
			<?php
				}
			}
			?></table>
		</td>
		<td rowspan="<?php echo $row; ?>">
			
			<ul style="list-style-type:none;font-size: 0.8em;">
				<?php foreach($AdditionalActivity as $AdditionalActivity_item){
						if($AdditionalActivity_item['service_product_id'] === $CustomerVisit_item['service_product_id']){
				?>
				<li><?php echo $AdditionalActivity_item['additional_activity_desc']; ?></li>
				<?php 		}
						} 
				?>
			</ul>
		</td>
		<td rowspan="<?php echo $row; ?>"><?php echo $CustomerVisit_item['description']; ?></td>
	</tr>
	<?php
		}
		$service_number = $CustomerVisit_item['service_number'];
	}
	?>
	</tbody>
</table>