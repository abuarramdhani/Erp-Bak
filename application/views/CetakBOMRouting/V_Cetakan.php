	<style>           
	 #page-border{                
		 width: 100%;                
		 height: 100%;                
		 border:2px solid black;   
		 padding: 5px;         
		}       
</style>
<div>
<table  style="border: 1px solid black; border-collapse: collapse; width: 100%; margin:7px"  >
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px; width: 20%">PRODUCT NAME</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$descprod?></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px; width:20%">SECTION / UNIT</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$seksi?></td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">COMPONENT NAME</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?= $desckomp?></td>
		<td colspan="2" rowspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px;padding-left: 7px;vertical-align: top;">REMARK :</td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">PART NUMBER</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$kode?></td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">ORGANIZATION</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$organization?></td>
	</tr>
</table>

<div style="margin-top: 20px;border: 2px solid black;border-collapse: collapse;"><h3 style="text-align: center;">Resource and Process</h3></div>
<table style="border: 1px solid black; border-collapse: collapse; width: 100%;margin-top: 5px;margin-right: 7px;margin-left: 7px">
		<tr style="background-color: grey">
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">No</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Kode Proses</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 15%">Resource</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Assigned Unit</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Proses</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 15%">No Mesin</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Usage Rate<br>(Hour)</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Cycle Time<br>(Second)</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Target<br>(Pcs)</th>
			<!-- <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Inverse</th> -->
		</tr>
		<?php $no=1; foreach ($datapdf as $pdf) {?>
		<tr>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$no?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf['KODE_PROSES']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf['RESOURCE_CODE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf['ASSIGNED_UNITS']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf['NO_MESIN']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf['USAGE_RATE_OR_AMOUNT']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf['CYCLE_TIME']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf['TARGET']?></td>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$pdf['INVERSE']?></td> -->
		</tr>
		<?php $no++; } ?>
</table>


<div style="margin-top: 20px;border: 2px solid black;border-collapse: collapse;"><h3 style="margin-top: 20px;text-align: center; ">Bills of Material</h3></div>

<table style="border: 1px solid black; border-collapse: collapse; width: 100%;margin-top: 5px;margin-right: 7px;margin-left: 7px">
		<tr style="background-color: grey">
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">No</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 15%">Component</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 20%">Description</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Qty</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">UoM</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 15%">Supply Type</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Supply SubInv</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Supply Locator</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 15%">SubInv Picklist</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Locator Picklist</th>
		</tr>
		<?php $nom=1; foreach ($datapdf2 as $pdf2) {?>
		<tr>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$nom?></td>
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

     

