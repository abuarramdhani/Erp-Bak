<h2 style="margin-left: 33%">Report Rekap Complain, Feedback and Question</h2>
<div style="width:50%;">
	<table width="100%">
		<tr>
			<td width="30%"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
			<td width="3%">-</td>
			<td ><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="30%"><b>City / Regency</b></td>
			<td width="3%">:</td>
			<td width="50%"><?php echo $city_chosen;?></td>
			<td></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="30%"><b>Category Response</b></td>
			<td width="3%">:</td>
			<td width="50%"><?php echo $faq_type;?></td>
			<td></td>
		</tr>
	
	</table>
	<table width="100%">
		<tr>
			<td width="30%"><b>Activity</b></td>
			<td width="3%">:</td>
			<td width="50%"><?php echo $activities;?></td>
			<td></td>
		</tr>
	</table>
</div>
<?php //print_r($tes); ?>
<div style="width:100%;">
	<div style="float:left;" >
		<table width="100%"  border="1" style="border: 1px solid #333;border-collapse:collapse;">
			<tr>
				<th colspan="4"><b>By Activity</b></th>
			</tr>
			<tr>
				<th width="10%">Num</th>
				<th width="15%">Category Response</th>
				<th width="60%" >Response Description</th>
				<th width="15%">Frequency</th>
			</tr>
			<?php
				$num = 0;
				$total = 0;
				foreach($RekapComplainFaQ as $RekapComplainFaQ_item){
				$num++;
				$total += $RekapComplainFaQ_item['freq'];
			?>
			<tr>
				<td><?php echo $num;?></td>
				<td><?php echo ucfirst($RekapComplainFaQ_item['faq_type']);?></td>
				<td><?php echo $RekapComplainFaQ_item['faq_description1'];?></td>
				<td><?php echo $RekapComplainFaQ_item['freq'];?></td>
			</tr>
			
			<?php
				}
			?>
			<tr>
				<td colspan="2"></td>
				<td><b>Total</b></td>
				<td><?php echo $total;?></td>
			</tr>
		</table>
	</div>
</div>