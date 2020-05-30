	<style>           
	 #page-border{                
		 width: 100%;                
		 height: 100%;                
		 border:2px solid black;   
		 padding: 5px;         
		}       
</style>
<div>
<table  style="border: 2px solid black; border-collapse: collapse; width: 100%; margin:7px"  >
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px; width: 20%">PRODUCT NAME</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px;width: 30%"><?=$descprod?></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px; width:20%">SECTION / UNIT</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$seksi?></td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">PART NUMBER</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$kode?></td>
		<td colspan="2" rowspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px;padding-left: 7px;vertical-align: top;">REMARK :</td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">COMPONENT NAME</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?= $desckomp?></td>
		
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">ORGANIZATION</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$organization?></td>
	</tr>
</table>

<div style="margin-top: 20px;border: 2px solid black;border-collapse: collapse;"><h3 style="text-align: center;margin-top: 5px;margin-bottom: 5px;">Resource and Process</h3></div>
<table style="border: 2px solid black; border-collapse: collapse; width: 100%;margin-top: 5px;margin-right: 7px;margin-left: 7px">
		<tr style="background-color: grey">
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">No</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Alternate</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 8%">Opr Number</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 8%">Kode Proses</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 13%">Resource</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 7%">Proses</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">No Mesin</th>

			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 7%">Machine Qty</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 7%">Operator Qty</th>
			
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Usage Rate<br>(Hour)</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Cycle Time<br>(Second)</th>
			<th colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Target</th>
			<!-- <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Inverse</th> -->
		</tr>
		<tr style="background-color: grey" >
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Qty</th>

			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Status</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Last<br> Update</th>
		</tr>
		<?php $b=1;  $no=1; 
		$alter = '#$%';
        $opr_no = '#$%';
        $kode_pros = '#$%';
        $resource_code = '#$%';
        $machine_qt = '#$%';
        $opt_qt = '#$%';
        $usage_rate = '#$%';
        $ct = '#$%';
        $tgt = '#$%';
		$last_update = '#$%';
		$routing_seq = '#$%';
		$opr_seq = '#$%';
		$opr_seq1 = '#$%'; 
		$opr_seq2 = '#$%'; 
		$opr_seq3 = '#$%'; 
		$opr_seq4 = '#$%'; 
		$opr_seq5 = '#$%'; 
		$opr_seq6 = '#$%'; 
		$opr_seq7 = '#$%'; 
		$opr_seq8 = '#$%'; 
		$opr_seq9 = '#$%';  
		for ($i=0; $i < sizeof($datapdf); $i++) {
			//  if ($i != 0 && $datapdf[$i]['RESOURCE_CODE'] == $datapdf[$i-1]['RESOURCE_CODE']) {  
			 		// $b+1;
			 	?>      

			  <!-- <tr> 
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['NO_MESIN']?></td>
			  </tr>    -->
			   <?php  
			//    } else { 
				?>
			   	<tr>
				<!----ALT------>
				   <?php 
						if (sizeof($arrayR['ALT'][$datapdf[$i]['ALTERNATE_ROUTING']]) <= sizeof($arrayR['ROUTING_SEQUENCE_ID'][$datapdf[$i]['ROUTING_SEQUENCE_ID']])) {
							$mergeALT = sizeof($arrayR['ALT'][$datapdf[$i]['ALTERNATE_ROUTING']]);
							if ($alter != $datapdf[$i]['ALTERNATE_ROUTING']) {
					?> 
								<td rowspan="<?php echo $mergeALT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$no?></td>
								<td rowspan="<?php echo $mergeALT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['ALTERNATE_ROUTING']?></td>
					<?php
								$alter = $datapdf[$i]['ALTERNATE_ROUTING'];
							}
						}else{
							$mergeALT = sizeof($arrayR['ROUTING_SEQUENCE_ID'][$datapdf[$i]['ROUTING_SEQUENCE_ID']]);
							if ($routing_seq != $datapdf[$i]['ROUTING_SEQUENCE_ID']) {
					?> 
								<td rowspan="<?php echo $mergeALT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$no?></td>
								<td rowspan="<?php echo $mergeALT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['ALTERNATE_ROUTING']?></td>
					<?php
								$routing_seq = $datapdf[$i]['ROUTING_SEQUENCE_ID'];
							}
						}
					?>
				<!----OPR NO------>
					<?php
						if (sizeof($arrayR['OPR_NO'][$datapdf[$i]['OPR_NO']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeOPR = sizeof($arrayR['OPR_NO'][$datapdf[$i]['OPR_NO']]);
							if ($opr_no != $datapdf[$i]['OPR_NO']) {
					?>
							<td rowspan="<?php echo $mergeOPR;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['OPR_NO']?></td>
					<?php
								$opr_no = $datapdf[$i]['OPR_NO'];
							}
						} else {
							$mergeOPR = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq1 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					?>
							<td rowspan="<?php echo $mergeOPR;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['OPR_NO']?></td>
					<?php
								$opr_seq1 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
				<!----KODE PROSES------>
					<?php
						if (sizeof($arrayR['KODE_PROSES'][$datapdf[$i]['KODE_PROSES']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeKoPros = sizeof($arrayR['KODE_PROSES'][$datapdf[$i]['KODE_PROSES']]);
							if ($kode_pros != $datapdf[$i]['KODE_PROSES']) {
					?>
							<td rowspan="<?php echo $mergeKoPros;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['KODE_PROSES']?></td>
					<?php
								$kode_pros = $datapdf[$i]['KODE_PROSES'];
							}
						} else {
							$mergeKoPros = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq2 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					?>
							<td rowspan="<?php echo $mergeKoPros;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['KODE_PROSES']?></td>
					<?php
								$opr_seq2 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
				<!----Resource------>
					<?php
						if (sizeof($arrayR['RESOURCE_CODE'][$datapdf[$i]['RESOURCE_CODE']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeRes = sizeof($arrayR['RESOURCE_CODE'][$datapdf[$i]['RESOURCE_CODE']]);
							if ($resource_code != $datapdf[$i]['RESOURCE_CODE']) {
					?>
							<td rowspan="<?php echo $mergeRes;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['RESOURCE_CODE']?></td>
					<?php
								$resource_code = $datapdf[$i]['RESOURCE_CODE'];
							}
						} else {
							$mergeRes = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq3 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					?>
							<td rowspan="<?php echo $mergeRes;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['RESOURCE_CODE']?></td>
					<?php
								$opr_seq3 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
			
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['NO_MESIN']?></td>
				<!----Machine QT------>
					<?php
						if (sizeof($arrayR['MACHINE_QT'][$datapdf[$i]['MACHINE_QT']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeMQT = sizeof($arrayR['MACHINE_QT'][$datapdf[$i]['MACHINE_QT']]);
							if ($machine_qt != $datapdf[$i]['MACHINE_QT']) {
					?>
							<td rowspan="<?php echo $mergeMQT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['MACHINE_QT']?></td>
					<?php
								$machine_qt = $datapdf[$i]['MACHINE_QT'];
							}
						} else {
							$mergeMQT = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq4 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					?>
							<td rowspan="<?php echo $mergeMQT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['MACHINE_QT']?></td>
					<?php
								$opr_seq4 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
				<!----OPT QT------>
					<?php
						if (sizeof($arrayR['OPT_QTY'][$datapdf[$i]['OPT_QTY']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeOQT = sizeof($arrayR['OPT_QTY'][$datapdf[$i]['OPT_QTY']]);
							if ($opt_qt != $datapdf[$i]['OPT_QTY']) {
					?>
							<td rowspan="<?php echo $mergeOQT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['OPT_QTY']?></td>
					<?php
								$opt_qt = $datapdf[$i]['OPT_QTY'];
							}
						} else {
							$mergeOQT = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq5 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					?>
							<td rowspan="<?php echo $mergeOQT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['OPT_QTY']?></td>
					<?php
								$opr_seq5 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
				<!----USAGE RATE------>
					<?php
						if (sizeof($arrayR['USAGE_RATE_OR_AMOUNT'][$datapdf[$i]['USAGE_RATE_OR_AMOUNT']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeUR = sizeof($arrayR['USAGE_RATE_OR_AMOUNT'][$datapdf[$i]['USAGE_RATE_OR_AMOUNT']]);
							if ($usage_rate != $datapdf[$i]['USAGE_RATE_OR_AMOUNT']) {
					?>
							<td rowspan="<?php echo $mergeUR;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['USAGE_RATE_OR_AMOUNT']?></td>
					<?php
								$usage_rate = $datapdf[$i]['USAGE_RATE_OR_AMOUNT'];
							}
						} else {
							$mergeUR = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq6 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					?>
							<td rowspan="<?php echo $mergeUR;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['USAGE_RATE_OR_AMOUNT']?></td>
					<?php
								$opr_seq6 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
				<!----CT------>
					<?php
						if (sizeof($arrayR['CYCLE_TIME'][$datapdf[$i]['CYCLE_TIME']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeCT = sizeof($arrayR['CYCLE_TIME'][$datapdf[$i]['CYCLE_TIME']]);
							if ($ct != $datapdf[$i]['CYCLE_TIME']) {
					?>
							<td rowspan="<?php echo $mergeCT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=round($datapdf[$i]['CYCLE_TIME'],2)?></td>
					<?php
								$ct = $datapdf[$i]['CYCLE_TIME'];
							}
						} else {
							$mergeCT = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq7 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					?>
							<td rowspan="<?php echo $mergeCT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=round($datapdf[$i]['CYCLE_TIME'],2)?></td>
					<?php
								$opr_seq7 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
				<!----TARGET------>
					<?php
						if (sizeof($arrayR['TARGET'][$datapdf[$i]['TARGET']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeTGT = sizeof($arrayR['TARGET'][$datapdf[$i]['TARGET']]);
							if ($tgt != $datapdf[$i]['TARGET']) {
					?>
							<td rowspan="<?php echo $mergeTGT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=floor($datapdf[$i]['TARGET'])?></td>
							<td rowspan="<?php echo $mergeTGT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>
					<?php
								$tgt = $datapdf[$i]['TARGET'];
							}
						} else {
							$mergeTGT = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq8 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					?>
							<td rowspan="<?php echo $mergeTGT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=floor($datapdf[$i]['TARGET'])?></td>
							<td rowspan="<?php echo $mergeTGT;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>
					<?php
								$opr_seq8 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
				<!----LAST UPDATE------>
					<?php
						if (sizeof($arrayR['LAST_UPDATE_DATE'][$datapdf[$i]['LAST_UPDATE_DATE']]) <= sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']])) {
							$mergeLUD = sizeof($arrayR['LAST_UPDATE_DATE'][$datapdf[$i]['LAST_UPDATE_DATE']]);
							if ($last_update != $datapdf[$i]['LAST_UPDATE_DATE']) {
					 ?>
					 		<td rowspan="<?php echo $mergeLUD;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['LAST_UPDATE_DATE']?></td>
					 <?php
								$last_update = $datapdf[$i]['LAST_UPDATE_DATE'];
							}
						} else {
							$mergeLUD = sizeof($arrayR['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']]);
							if ($opr_seq9 != $datapdf[$i]['OPERATION_SEQUENCE_ID']) {
					 ?>
					 		<td rowspan="<?php echo $mergeLUD;?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['LAST_UPDATE_DATE']?></td>
					 <?php
								$opr_seq9 = $datapdf[$i]['OPERATION_SEQUENCE_ID'];
							}
						}
				  	?>
				

			
			
			
			
			   
			

		</tr>
		<?php $no++; } ?>
	
		
</table>


<div style="margin-top: 20px;border: 2px solid black;border-collapse: collapse;"><h3 style="margin-top: 5px;margin-bottom: 5px;text-align: center; ">Bills of Material</h3></div>

<table style="border: 2px solid black; border-collapse: collapse; width: 100%;margin-top: 5px;margin-right: 7px;margin-left: 7px">
		<tr style="background-color: grey">
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">No</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Alternate</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Item Num</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Opr Num</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 15%">Component</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 20%">Description</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Qty</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">UoM</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Supply Type</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Supply SubInv</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Supply Locator</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">SubInv Picklist</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Locator Picklist</th>
		</tr>
		<?php $nom=1; 
			$alter2 = '#$%';
			$bsi = '#$%';
			for ($i=0; $i < sizeof($datapdf2); $i++) {
			//  if ($i != 0 && $datapdf2[$i]['ALT'] == $datapdf2[$i-1]['ALT']) {  
			?>
		<!-- <tr>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['NUM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['OPR_NUM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['COMPONENT_NUM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['DESCRIPTION']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= round($datapdf2[$i]['QTY'],4)?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['PRIMARY_UOM_CODE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['SUPPLY_TYPE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['SUPPLY_SUBINVENTORY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['SUPPLY_LOCATOR']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['FROM_SUBINVENTORY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['FROM_LOCATOR']?></td>

		</tr> -->
		<?php  
			// } else { 
		?>

			<tr>
			<!----ALT------>
			<?php 
			if ($datapdf2[$i]['ALT'] == null) {
				$datapdf2[$i]['ALT'] = 'Primary';
			}
						if (sizeof($arrayR2['ALT'][$datapdf2[$i]['ALT']]) <= sizeof($arrayR2['BILL_SEQUENCE_ID'][$datapdf2[$i]['BILL_SEQUENCE_ID']])) {
							$mergeALT2 = sizeof($arrayR2['ALT'][$datapdf2[$i]['ALT']]);
							if ($alter2 != $datapdf2[$i]['ALT']) {
					?> 
								<td rowspan="<?=$mergeALT2 ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$nom?></td>
								<td rowspan="<?=$mergeALT2 ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['ALT']?></td>
					<?php
								$alter2 = $datapdf2[$i]['ALT'];
							}
						}else{
							$mergeALT2 = sizeof($arrayR2['BILL_SEQUENCE_ID'][$datapdf2[$i]['BILL_SEQUENCE_ID']]);
							if ($bsi != $datapdf2[$i]['BILL_SEQUENCE_ID']) {
					?> 
								<td rowspan="<?=$mergeALT2 ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$nom?></td>
								<td rowspan="<?=$mergeALT2 ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['ALT']?></td>
					<?php
								$bsi = $datapdf2[$i]['BILL_SEQUENCE_ID'];
							}
						}
					?>
			
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['NUM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['OPR_NUM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['COMPONENT_NUM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['DESCRIPTION']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= round($datapdf2[$i]['QTY'],4)?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['PRIMARY_UOM_CODE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['SUPPLY_TYPE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['SUPPLY_SUBINVENTORY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['SUPPLY_LOCATOR']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['FROM_SUBINVENTORY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf2[$i]['FROM_LOCATOR']?></td>

		</tr>


		<?php $nom++; } ?>
</table>
</div>
