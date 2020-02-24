<?php
$prd1 = $periode['0']['0'];
$prd2 = "";
foreach ($periode as $per) {
	$prd2 = $per['0'];
}


?>
<div style="width: 100%;background-color: #00b0ff;text-align: center;color: white"><?php echo "Periode ".$prd1." - ".$prd2; ?></div>
<br>

<?php if (isset($detail) and !empty($detail)) {
$jml = count($periode);
$banyak1 = 0;
$banyak2 = 0;
$banyak3 = 0;
$simpan1 = 0;
$simpan2 = 0;
$simpan3 = 0;
$simpanNoind = "";
for ($i=0; $i < $jml/3; $i++) { ?>
<table style="border-collapse: collapse;width: 100%;font-size: 8pt">
	<thead>
		<tr style="background-color: #00b0ff;">
			<th rowspan="2" style="width: 3%;text-align: center;color: white">NO</th>
			<th rowspan="2" style="width: 7%;text-align: center;color: white">NIK</th>
			<th rowspan="2" style="width: 20%;text-align: center;color: white">NAMA</th>
			<th rowspan="2" style="width: 13%;text-align: center;color: white">MASA KERJA</th>
			<?php if (isset($detail) and !empty($detail)) {
						$loop = 1;
						foreach ($periode as $prd) {
							if($banyak1 < (3*($i+1)) and $loop > $simpan1){ ?>
			<th colspan="8" style="text-align: center;color: white"><?php echo $prd['1']; ?></th>
			<?php 				$banyak1++;
								$simpan1 = $loop;
							}
							$loop++;
						}
					} ?>
		</tr>
		<tr style="background-color: #00b0ff;">
			<?php if (isset($detail) and !empty($detail)) {
						$loop = 1;
						foreach ($periode as $prd) {
							if($banyak2 < (3*($i+1)) and $loop > $simpan2){?>
			<th style="text-align: center;color: white">T</th>
			<th style="text-align: center;color: white">I</th>
			<th style="text-align: center;color: white">M</th>
			<th style="text-align: center;color: white">S</th>
			<th style="text-align: center;color: white">PSP</th>
			<th style="text-align: center;color: white">IP</th>
			<th style="text-align: center;color: white">CT</th>
			<th style="text-align: center;color: white">SP</th>
			<?php 				$banyak2++;
								$simpan2 = $loop;
							}
							$loop++;
						}
					} ?>
		</tr>
	</thead>
	<tbody>
		<?php
		if (isset($rekap_all) and !empty($rekap_all)) {
			$nomor = 1;
			foreach ($rekap_all as $all) { ?>
				<tr>
					<td style="text-align: center"><?php echo $nomor ?></td>
					<td style="text-align: center"><?php echo $all['noind'] ?></td>
					<td><?php echo $all['nama'] ?></td>
					<td style="text-align: center"><?php echo $all['masa_kerja'] ?></td>
					<!-- detail -->
					<?php
					if (isset($detail) and !empty($detail)) {
						$loop = 1;
						if ($all['noind'] !== $simpanNoind) {
							$banyak3 = 3*($i);
							$simpan3 = $banyak3;
						}

						foreach ($periode as $prd) {
							if($banyak3 < (3*($i+1)) and $loop > $simpan3){
								foreach ($detail['rekap_'.$prd['2']] as $dtl) {
									if ($all['noind'] == $dtl['noind']) {
										// echo "<td>$banyak3 $loop $simpan3</td>";
					?>
					<td style="text-align: center">
						<?php if(intval($dtl['frekt'.strtolower($prd['2'])])+intval($dtl['frekts'.strtolower($prd['2'])]) == 0){
							echo '-';
						}else{
							echo intval($dtl['frekt'.strtolower($prd['2'])])+intval($dtl['frekts'.strtolower($prd['2'])]);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($dtl['freki'.strtolower($prd['2'])])+intval($dtl['frekis'.strtolower($prd['2'])]) == 0){
							echo '-';
						}else{
							echo intval($dtl['freki'.strtolower($prd['2'])])+intval($dtl['frekis'.strtolower($prd['2'])]);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($dtl['frekm'.strtolower($prd['2'])])+intval($dtl['frekms'.strtolower($prd['2'])]) == 0){
							echo '-';
						}else{
							echo intval($dtl['frekm'.strtolower($prd['2'])])+intval($dtl['frekms'.strtolower($prd['2'])]);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($dtl['freksk'.strtolower($prd['2'])])+intval($dtl['freksks'.strtolower($prd['2'])]) == 0){
							echo '-';
						}else{
							echo intval($dtl['freksk'.strtolower($prd['2'])])+intval($dtl['freksks'.strtolower($prd['2'])]);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($dtl['frekpsp'.strtolower($prd['2'])])+intval($dtl['frekpsps'.strtolower($prd['2'])]) == 0){
							echo '-';
						}else{
							echo intval($dtl['frekpsp'.strtolower($prd['2'])])+intval($dtl['frekpsps'.strtolower($prd['2'])]);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($dtl['frekip'.strtolower($prd['2'])])+intval($dtl['frekips'.strtolower($prd['2'])]) == 0){
							echo '-';
						}else{
							echo intval($dtl['frekip'.strtolower($prd['2'])])+intval($dtl['frekips'.strtolower($prd['2'])]);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($dtl['frekct'.strtolower($prd['2'])])+intval($dtl['frekcts'.strtolower($prd['2'])]) == 0){
							echo '-';
						}else{
							echo intval($dtl['frekct'.strtolower($prd['2'])])+intval($dtl['frekcts'.strtolower($prd['2'])]);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($dtl['freksp'.strtolower($prd['2'])])+intval($dtl['freksps'.strtolower($prd['2'])]) == 0){
							echo '-';
						}else{
							echo intval($dtl['freksp'.strtolower($prd['2'])])+intval($dtl['freksps'.strtolower($prd['2'])]);
						} ?>
					</td>
					<?php
									}
								}
							$banyak3++;
							$simpan3 = $loop;
						 	}
						 	$loop++;
						 	$simpanNoind = $all['noind'];
						}
					}
					?>
					<!-- detail -->
				</tr>
			<?php $nomor ++;
			}
		}
		?>
	</tbody>
</table>
<?php }
} ?>
<table style="border-collapse: collapse;width: 100%;font-size: 8pt">
	<thead>
		<tr style="background-color: #00b0ff;">
			<th rowspan="2" style="width: 3%;text-align: center;color: white">NO</th>
			<th rowspan="2" style="width: 7%;text-align: center;color: white">NIK</th>
			<th rowspan="2" style="width: 20%;text-align: center;color: white">NAMA</th>
			<th rowspan="2" style="width: 13%;text-align: center;color: white">MASA KERJA</th>
			<th colspan="8" style="text-align: center;color: white;width: 16%">REKAP</th>
			<th rowspan="2" style="width: 8%;text-align: center;color: white">TOTAL HARI KERJA</th>
			<th colspan="8" style="text-align: center;color: white;width: 28%">PRESENTASE</th>
			<th rowspan="2" style="text-align: center;color: white;width: 5%">TOTAL</th>
		</tr>
		<tr style="background-color: #00b0ff;">
			<th style="text-align: center;color: white;width: 2%">T</th>
			<th style="text-align: center;color: white;width: 2%">I</th>
			<th style="text-align: center;color: white;width: 2%">M</th>
			<th style="text-align: center;color: white;width: 2%">S</th>
			<th style="text-align: center;color: white;width: 2%">PSP</th>
			<th style="text-align: center;color: white;width: 2%">IP</th>
			<th style="text-align: center;color: white;width: 2%">CT</th>
			<th style="text-align: center;color: white;width: 2%">SP</th>
			<th style="text-align: center;color: white;width: 3.5%">T</th>
			<th style="text-align: center;color: white;width: 3.5%">I</th>
			<th style="text-align: center;color: white;width: 3.5%">M</th>
			<th style="text-align: center;color: white;width: 3.5%">S</th>
			<th style="text-align: center;color: white;width: 3.5%">PSP</th>
			<th style="text-align: center;color: white;width: 3.5%">IP</th>
			<th style="text-align: center;color: white;width: 3.5%">CT</th>
			<th style="text-align: center;color: white;width: 3.5%">SP</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (isset($rekap_all) and !empty($rekap_all)) {
			$nomor = 1;
			foreach ($rekap_all as $all) { ?>
				<tr>
					<td style="text-align: center"><?php echo $nomor ?></td>
					<td style="text-align: center"><?php echo $all['noind'] ?></td>
					<td><?php echo $all['nama'] ?></td>
					<td style="text-align: center"><?php echo $all['masa_kerja'] ?></td>
					<!-- rekap -->
					<td style="text-align: center">
						<?php if(intval($all['frekt'])+intval($all['frekts']) == 0){
							echo '-';
					}else{
							echo intval($all['frekt'])+intval($all['frekts']);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($all['freki'])+intval($all['frekis']) == 0){
							echo '-';
					}else{
							echo intval($all['freki'])+intval($all['frekis']);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($all['frekm'])+intval($all['frekms']) == 0){
							echo '-';
					}else{
							echo intval($all['frekm'])+intval($all['frekms']);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($all['freksk'])+intval($all['freksks']) == 0){
							echo '-';
					}else{
							echo intval($all['freksk'])+intval($all['freksks']);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($all['frekpsp'])+intval($all['frekpsps']) == 0){
							echo '-';
					}else{
							echo intval($all['frekpsp'])+intval($all['frekpsps']);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($all['frekip'])+intval($all['frekips']) == 0){
							echo '-';
					}else{
							echo intval($all['frekip'])+intval($all['frekips']);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($all['frekct'])+intval($all['frekcts']) == 0){
							echo '-';
					}else{
							echo intval($all['frekct'])+intval($all['frekcts']);
						} ?>
					</td>
					<td style="text-align: center">
						<?php if(intval($all['freksp'])+intval($all['freksps']) == 0){
							echo '-';
					}else{
							echo intval($all['freksp'])+intval($all['freksps']);
						} ?>
					</td>
					<!-- rekap -->
					<td style="text-align: center"><?php echo intval($all['totalhk'])+intval($all['totalhks']) ?></td>
					<!-- presentase -->
					<td style="text-align: center"><?php echo number_format((intval($all['frekt'])+intval($all['frekts']))/ (intval($all['totalhk'])+intval($all['totalhks'])) * 100,'2',',','.'); ?>%</td>
					<td style="text-align: center"><?php echo number_format((intval($all['freki'])+intval($all['frekis']))/ (intval($all['totalhk'])+intval($all['totalhks'])) * 100,'2',',','.'); ?>%</td>
					<td style="text-align: center"><?php echo number_format((intval($all['frekm'])+intval($all['frekms']))/ (intval($all['totalhk'])+intval($all['totalhks'])) * 100,'2',',','.'); ?>%</td>
					<td style="text-align: center"><?php echo number_format((intval($all['freksk'])+intval($all['freksks']))/ (intval($all['totalhk'])+intval($all['totalhks'])) * 100,'2',',','.'); ?>%</td>
					<td style="text-align: center"><?php echo number_format((intval($all['frekpsp'])+intval($all['frekpsps']))/ (intval($all['totalhk'])+intval($all['totalhks'])) * 100,'2',',','.'); ?>%</td>
					<td style="text-align: center"><?php echo number_format((intval($all['frekip'])+intval($all['frekips']))/ (intval($all['totalhk'])+intval($all['totalhks'])) * 100,'2',',','.'); ?>%</td>
					<td style="text-align: center"><?php echo number_format((intval($all['frekct'])+intval($all['frekcts']))/ (intval($all['totalhk'])+intval($all['totalhks'])) * 100,'2',',','.'); ?>%</td>
					<td style="text-align: center"><?php echo number_format((intval($all['freksp'])+intval($all['freksps']))/ (intval($all['totalhk'])+intval($all['totalhks'])) * 100,'2',',','.'); ?>%</td>
					<!-- presentase -->
					<!-- total -->
					<td style="text-align: center">
						<?php
							$totalRekap = (
								(
									($all['totalhk']+$all['totalhks']) -
									(
										($all['freki']+$all['frekis']) +
										($all['frekm']+$all['frekms']) +
										($all['freksk']+$all['freksks']) +
										($all['frekpsp']+$all['frekpsps']) +
										($all['frekip']+$all['frekips']) +
										($all['frekct']+$all['frekcts']) +
										($all['frekmnon']+$all['frekmsnon'])

									)
								) /
								(
									($all['totalhk']+$all['totalhks']) -
									($all['frekct']+$all['frekcts']) -
									($all['frekmnon']+$all['frekmsnon'])
								) * 100
							);
							echo number_format($totalRekap,2).'%';
						?>
					</td>
					<!-- total -->
				</tr>
			<?php $nomor ++;
			}
		}
		?>
	</tbody>
</table>
