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
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">-</td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">PART NUMBER</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$kode?></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">ACTIVITY</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$act?></td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">COMPONENT NAME</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?= $desckomp?></td>
		<td colspan="2" rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px;padding-left: 7px;vertical-align: top;">REMARK :</td>
		
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px">ORGANIZATION</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: left;padding-left: 7px;font-size: 12px"><?=$organization?></td>
	</tr>
</table>

<div style="margin-top: 20px;border: 2px solid black;border-collapse: collapse;"><h3 style="text-align: center;margin-top: 5px;margin-bottom: 5px;">Resource and Process</h3></div>
<table style="border: 2px solid black; border-collapse: collapse; width: 100%;margin-top: 5px;margin-right: 7px;margin-left: 7px">
		<tr style="background-color: grey">
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">No</th>
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Routing ID</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Routing Class</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Routing No</th>
			<!-- <th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Routing Desc</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Routing Vers</th>
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Routing Qty</th>
			<th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Routing UOM</th>
			<th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Rout Status</th> -->
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Step</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Opr Num</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Opr No</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Opr Vers</th>
			<!-- <th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Opr Desc</th> -->
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Step Qty</th> -->
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Process UOM</th> -->
			<!-- <th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Opr Status</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Activity</th>
			<!-- <th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Activity Desc</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Kode Proses</th>
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Activity Factor</th> -->
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Activity Factor</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Resources</th>
			<!-- <th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Resource Desc</th> -->
			<!-- <th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Resource Class</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Machine Qty</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Operator Qty</th>
			<!-- <th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Process Qty (PCS)</th> -->
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Resource Proses UOM</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Resource Usage (Hours)</th>
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Cycle Time (Seconds)</th>
			<th colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Target</th>
			<!-- <th  style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt;">Resource Usage UOM</th> -->
			<!-- <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 10%">Inverse</th> -->
			<th rowspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt;">Proses Detail</th>
		</tr>
		<tr style="background-color: grey" >
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 3%">Qty</th>

			<!-- <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Status</th> -->
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 5%">Last<br> Update</th>
		</tr>
		<?php 
		$route_id = '#$%';
		// echo "<pre>"; print_r($dataopm2);exit(); 
		$b=1;  $no=1; for ($i=0; $i < sizeof($dataopm2); $i++) {
			if (sizeof($r_id[$dataopm2[$i]['ROUTING_ID']]) > 1) {
				$merge = 'rowspan="'.sizeof($r_id[$dataopm2[$i]['ROUTING_ID']]).'"';
			} else {
				$merge = '';
			}
			?>
		<tr>
			<?php 
				if ($route_id != $dataopm2[$i]['ROUTING_ID']) {
			?>
				<td <?=$merge?> style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$no?></td>
				<td <?=$merge?> style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['ROUTING_CLASS']?></td>
				<td <?=$merge?> style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['ROUTING_NO']?></td>
				<td <?=$merge?> style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['ROUTING_VERS']?></td>
			<?php
					$no++;
					$route_id = $dataopm2[$i]['ROUTING_ID'];
				}
			?>
			
			<?php ?>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['ROUTING_ID']?></td> -->
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['ROUTING_DESC']?></td> -->
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['ROUTING_QTY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['ROUTING_UOM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['ROUT_STATUS']?></td> -->
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['STEP']?></td> -->
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['OPRN_NUM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['OPRN_NO']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['OPRN_VERS']?></td>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['OPRN_DESC']?></td>    -->
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['STEP_QTY']?></td> -->
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['PROCESS_QTY_UOM']?></td>	 -->
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['OPRN_STATUS']?></td> -->
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['ACTIVITY']?></td>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['ACTIVITY_DESC']?></td> -->
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['KODE_PROSES']?></td>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['ACTIVITY_FACTOR']?></td> -->
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['RESOURCES']?></td>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['RESOURCE_DESC']?></td> -->
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['RESOURCE_CLASS']?></td> -->
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['MACHINE_QTY']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['OPERATOR_QTY']?></td>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['PROCESS_QTY']?></td> -->
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['RESOURCE_PROCESS_UOM']?></td>    -->
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['RESOURCE_USAGE']?>
				<?php 
					// $ruMinutes = $dataopm2[$i]['RESOURCE_USAGE']*60;
					// // echo "<pre>";
					// // echo $dataopm2[$i]['RESOURCE_USAGE'];
					// // echo "<br>";
					// // print_r($ruMinutes);
					// // exit();
					// if (strpos($ruMinutes,'.') == null) {
					// 	echo $ruMinutes;
					// } else {
					// 	echo number_format((float)$ruMinutes, 2, '.', '');
					// }
					// // $dataopm2[$i]['RESOURCE_USAGE']
				?>
			
			</td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['CT']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=round($dataopm2[$i]['TARGET'])?></td>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"></td> -->
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['LAST_UPDATE_DATE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12pt"><?=$dataopm2[$i]['DETAILPROSES']?></td>
			

			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 10pt"><?=$dataopm2[$i]['RESOURCE_USAGE_UOM']?></td> -->


		</tr>
		<?php } ?>
	
		
</table>


<div style="margin-top: 20px;border: 2px solid black;border-collapse: collapse;"><h3 style="margin-top: 5px;margin-bottom: 5px;text-align: center; ">Formula</h3></div>

<table style="border: 2px solid black; border-collapse: collapse; width: 100%;margin-top: 5px;margin-right: 7px;margin-left: 7px">
		<tr style="background-color: grey">
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">No</th>
			<!-- <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Formula Id</th> -->
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Tipe</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Line MO</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Komponen</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Description</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Qty</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">UoM</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">IO KIB</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Subinv KIB</th>
			<th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">Loc KIB</th>
		</tr>
		<?php $nom=1; for ($i=0; $i < sizeof($dataopm3); $i++) {
		?>

			<tr>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$nom?></td>
			<!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['FORMULA_ID']?></td> -->
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['TIPE']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['LINE_NO']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['SEGMENT1']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['DESCRIPTION']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
			<?php
				if (strpos($dataopm3[$i]['QTY'],'.') == null) {
					echo $dataopm3[$i]['QTY'];
				} else {
					echo number_format((float)$dataopm3[$i]['QTY'], 5, '.', '');
				}
			?>
			</td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['UOM']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['IO_KIB']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['SUBINV_KIB']?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?=$dataopm3[$i]['LOC_KIB']?></td>

		</tr>

		<?php $nom++; } ?>
</table>
</div>
