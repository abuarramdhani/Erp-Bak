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
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px; width: 20%">PRODUCT NAME</td>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px;width: 30%"><?=$descprod?></td>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px; width:20%">SECTION / UNIT</td>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$seksi?></td>
	</tr>
	<tr>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">COMPONENT NAME</td>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?= $desckomp?></td>
		<td colspan="2" rowspan="3" style="border: 2px solid black;border-collapse: collapse; text-align: left;font-size: 12px;padding-left: 7px;vertical-align: top;">REMARK :</td>
	</tr>
	<tr>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">PART NUMBER</td>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$kode?></td>
	</tr>
	<tr>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">ORGANIZATION</td>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$organization?></td>
	</tr>
</table>

<div style="margin-top: 20px;border: 2px solid black;border-collapse: collapse;"><h3 style="text-align: center;">Resource and Process</h3></div>
<table style="border: 1px solid black; border-collapse: collapse; width: 100%;margin-top: 5px;margin-right: 7px;margin-left: 7px">
		<tr style="background-color: grey">
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">No</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Kode Proses</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 13%">Resource</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Machine QT</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Operator Qty</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Alternate Routing</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 7%">Proses</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">No Mesin</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Usage Rate<br>(Hour)</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Cycle Time<br>(Second)</th>
			<th colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Target</th>
			<!-- <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Inverse</th> -->
		</tr>
		<tr style="background-color: grey" >
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Qty</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Status</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Tgl Upload</th>
		</tr>
		<?php $b=1;  $no=1; for ($i=0; $i < sizeof($datapdf); $i++) {
			 if ($i != 0 && $datapdf[$i]['KODE_PROSES'] == $datapdf[$i-1]['KODE_PROSES']) {  
			 		// $b+1;
			 	?>      

			  <tr>                     
				  <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['MACHINE_QT']?></td>
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['OPT_QTY']?></td>
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['ALTERNATE_ROUTING']?></td>
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['NO_MESIN']?></td>
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['USAGE_RATE_OR_AMOUNT']?></td>
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['CYCLE_TIME']?></td>
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['TARGET']?></td>
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>   
				<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>                            
			  	</tr>   
			   <?php  } else { ?>
			   	<tr>
			<td  rowspan="<?= $kodee[$datapdf[$i]['KODE_PROSES']]?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$no?></td>
			<td  rowspan="<?= $kodee[$datapdf[$i]['KODE_PROSES']]?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['KODE_PROSES']?></td>
			<td  rowspan="<?= $kodee[$datapdf[$i]['KODE_PROSES']]?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['RESOURCE_CODE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['MACHINE_QT']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['OPT_QTY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['ALTERNATE_ROUTING']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['NO_MESIN']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['USAGE_RATE_OR_AMOUNT']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['CYCLE_TIME']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$datapdf[$i]['TARGET']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>   
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td> 
		</tr>
		<?php $no++; } } ?>
	
		
</table>


<div style="margin-top: 20px;border: 2px solid black;border-collapse: collapse;"><h3 style="margin-top: 20px;text-align: center; ">Bills of Material</h3></div>

<table style="border: 1px solid black; border-collapse: collapse; width: 100%;margin-top: 5px;margin-right: 7px;margin-left: 7px">
		<tr style="background-color: grey">
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">No</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Alternate</th>
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
		<?php $nom=1; foreach ($datapdf2 as $pdf2) {?>
		<tr>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$nom?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['ALT']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['COMPONENT_NUM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['DESCRIPTION']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['QTY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['PRIMARY_UOM_CODE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['SUPPLY_TYPE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['SUPPLY_SUBINVENTORY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['SUPPLY_LOCATOR']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['FROM_SUBINVENTORY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf2['FROM_LOCATOR']?></td>

		</tr>
		<?php $nom++; } ?>
</table>
</div>
