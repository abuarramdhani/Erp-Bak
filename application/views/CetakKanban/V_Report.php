<style type="text/css">
	table{
		font-family: 'arial';
	}
	.kolomisi{
		border-left: 1px solid black;
		border-top: 1px solid black;
		vertical-align: top;
		/*padding-left: 2px;*/
		padding-top: 4px;
		text-align: center;
	}

	.tbl_1 td {
		/*padding: 3px;*/
		font-size: 10px;
		padding: 2px;
		/*margin-right: 10px;*/
		word-wrap: break-word;
	}

	.tbl_2 td {
		word-wrap: break-word;
		border: 1px solid black;
		height: 24px;
	}

</style>
<body>
	<?php  
	if($dataprint):
	
	foreach ($dataprint as $key => $value) {
		for ($p=0; $p < count($value); $p++) {
			
			$qty_per_handling = $value[$p]['UNIT_VOLUME'];
			if ($qty_per_handling && $qty_per_handling != 0 && $value[$p]['STATUS_STEP'] != 'WIP') {
				$jml_kanban = ceil($value[$p]['TARGET_PPIC']/$value[$p]['UNIT_VOLUME']);
			}else{
				$jml_kanban = 1;
			}
			for ($x=0; $x < $jml_kanban; $x++) { ?>
			<div style="width: 104mm;height: 162.0mm; border-bottom: 1px solid black; float: left" >
				<div style="<?= (($x+1)%2 != 0) ? 'border-right: 2px dotted black;' : ''; ?> height: 162.0mm; padding: 8px; padding-right: 8px; width:100%; vertical-align: top; float: left; ">
					<table style="width: 100%; height: 162.0mm; " class="tbl_1">
						<tr>
							<td colspan="3"></td>
							<td style="text-align: left; border: 1px solid black; padding-left: 5px; font-size: 12px"><b>TUJUAN:&nbsp;<?= $value[$p]['TUJUAN'] ?></b>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="font-family: 'Arial'; text-align: center;">
								<b style="font-size: 18px">KANBAN <?= strtoupper($value[$p]['ROUTING_CLASS_DESC']) ?></b><br>
							</td>

						</tr>
						<tr>
							<td  colspan="2" style="font-family: 'Arial'; text-align: center;border: 1px solid black;">
								<b style="font-size: 14px"><?= $value[$p]['DESCRIPTION'] ?></b>
							</td>
							<td colspan="2 " style="font-family: 'Arial'; text-align: center;border: 1px solid black;">
								<b style="font-size: 14px;"><?= $value[$p]['TYPE_PRODUCT'] ?></b>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="font-family: 'Arial'; text-align: center;border: 1px solid black;">
								<b style="font-size: 14px">(<?= $value[$p]['ITEM_CODE'] ?>)</b>
							</td>
						</tr>
						<tr>
							<td  style="font-family: 'Arial'; text-align: left;">
								<b style="font-size: 14px;">QTY</b>
							</td>
							<td style="font-family: 'Arial'; text-align: left;">
								<b style="font-size: 14px;">:&nbsp;<?= $value[$p]['TARGET_PPIC'].' '.$value[$p]['UOM_CODE'] ?></b>
							</td>
							<td style="font-family: 'Arial'; text-align: left;">
								<b style="font-size: 10px;">NEED BY</b>
							</td>
							<td style="font-family: 'Arial'; text-align: left;">
								<!-- <b style="font-size: 10px;">:&nbsp;<?= $value[$p]['NEED_BY'] ?></b> -->
								<b style="font-size: 10px;">:&nbsp;<?php 
									$waktu1 = strtotime($value[$p]['NEED_BY']);
									$waktufrm1 = date('d/m/Y : H:i:s', $waktu1);
									echo $waktufrm1;
									?></b>
							</td>
						</tr>
						<tr>
								<td colspan="2"></td>
								<td style="font-family: 'Arial'; text-align: left;">
									<!-- <b style="font-size: 10px;">DATE RELEASED</b> -->
									<b style="font-size: 10px;">CREATION DATE</b>

								</td>
								<td style="font-family: 'Arial'; text-align: left;">
									<b style="font-size: 10px;">:&nbsp;<?php 
									// $waktu = strtotime($value[$p]['DATE_RELEASED']);
									$waktu = strtotime($value[$p]['CREATION_DATE']);
									$waktufrm = date('d/m/Y : H:i:s', $waktu);
									echo $waktufrm;
									?></b>

								</td>
						</tr>
							<tr>
								<td style="padding-top: 20px">
									<b>Qty Handling</b>
								</td>
								<td style="padding-top: 20px" >
									<b>:&nbsp;<?= ($value[$p]['UNIT_VOLUME']) ? ($x+1 != $jml_kanban ? $value[$p]['UNIT_VOLUME'].' '.$value[$p]['UOM_CODE']
										: ( $value[$p]['TARGET_PPIC']%$value[$p]['UNIT_VOLUME'] != 0
											? $value[$p]['TARGET_PPIC']%$value[$p]['UNIT_VOLUME'].' '.$value[$p]['UOM_CODE']
											: $value[$p]['UNIT_VOLUME'].' '.$value[$p]['UOM_CODE'] )) : '' ?></b>
										</td>
										<td style="padding-top: 20px;font-size:14px">
											<b>NO JOB</b>
										</td>
										<td style="padding-top: 20px; font-size:14px">
											<b>:&nbsp;<?= $value[$p]['JOB_NUMBER'] ?></b>
										</td>
							</tr>
									<tr>
										<td>
											<b>Resource</b>
										</td>
										<td colspan="2">
											<b>:&nbsp;<?= $value[$p]['OPERATION'] ?></b>
										</td>
										<td  rowspan="3" style="text-align: left;" >
											<?php
											$codeContents = $value[$p]['QR_CODE'];
											$fileName = 'img/'.$codeContents.'.png';
											QRcode::png($codeContents, $fileName, H, 3, 3);
											?>
											<img  style=" float:right;  opacity: 1 ; width:18mm; padding:;  height:auto;" src="img/<?php echo $codeContents.'.png'; ?>" />
										</td>
									</tr>
									<tr>
										<td >
											<b style="font-size: 8px">Target PE SK</b>
										</td>
										<td>
											<b style="font-size: 8px">:&nbsp;<?= floor($value[$p]['TARGETSK']).' '.$value[$p]['UOM_CODE'] ?>
												(<?= round(($value[$p]['TARGET_PPIC']/$value[$p]['TARGETSK'])*100) ?> %)</b>
											</td>
									</tr>
									<tr>
											<td>
												<b style="font-size: 8px">Target PE JS</b>
											</td>
											<td >
												<b style="font-size: 8px">:&nbsp;<?= floor($value[$p]['TARGETJS']).' '.$value[$p]['UOM_CODE'] ?>
													(<?= round(($value[$p]['TARGET_PPIC']/$value[$p]['TARGETJS'])*100) ?> %)</b>
												</td>
									</tr>
					</table>
										<table  style="margin-top: 10px;width:100%;border: 1px solid black;border-collapse: collapse;" >
											<tr>
												<td  style="height: 25px;  width: 70px;font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black; padding-left: 5px"><b>NO INDUK</b></td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 0px solid black; border-bottom: 1px solid black">&nbsp;</td>
											</tr>
											<tr>
												<td  style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black; padding-left: 5px"><b>TANGGAL</b></td>
												<td align="center" style="height: 25px; font-size: 10px; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 0px solid black; border-bottom: 1px solid black">&nbsp;</td>
											</tr>
											<tr>
												<td  style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black; padding-left: 5px"><b>SHIFT</b></td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S1</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S2</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S3</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S1</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S2</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S3</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S1</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S2</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">S3</td>
											</tr>
											<tr>
												<td  style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black; padding-left: 5px"><b>OK</b></td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 0px solid black; border-bottom: 1px solid black">&nbsp;</td>
											</tr>
											<tr>
												<td  style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black; padding-left: 5px"><b>REPAIR</b></td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 0px solid black; border-bottom: 1px solid black">&nbsp;</td>
											</tr>
											<tr>
												<td  style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black; padding-left: 5px"><b>SCRAP</b></td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 0px solid black; border-bottom: 1px solid black">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black"><b>TOTAL</b></td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;</td>
												<td align="center" style="height: 25px; font-size: 10px; border-right: 0px solid black; border-bottom: 1px solid black">&nbsp;</td>
											</tr>

										</table>
										<table  style="margin-top: 10px;width:100%;border-collapse: collapse;">
											<tr>
												<td style="height: 25px; width: 70px;font-size: 10px; border-right: 1px solid black;padding-left: 5px"><b>URUTAN</b></td>
												<?php foreach ($proses[$value[$p]['JOB_NUMBER']] as $prs) { ?>

												<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-top: 1px solid black;border-bottom: 1px solid black"><?php echo $prs['OPR_SEQ'] ?></td>
												<?php } ?>
											</tr>
											<tr>
												<td style="height: 25px; font-size: 10px; border-right: 1px solid black;padding-left: 5px"><b>PROSES</b></td>
												<?php foreach ($proses[$value[$p]['JOB_NUMBER']] as $prs) { ?>
													<td align="center" style="height: 25px; 
													<?php 
													if ($prs['KODE_PROSES'] == $value[$p]['KODE_PROSES']) {
														echo "font-size: 15px; ";
													} else {
														echo "font-size: 10px; ";
													}

													?>border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;<?php 
													if ($prs['KODE_PROSES'] == $value[$p]['KODE_PROSES']) {
														echo "<b>".$prs['KODE_PROSES']."</b>";
													} else {
														echo $prs['KODE_PROSES'];
													}
													 
													?></td>

													}
												<?php } ?>
											</tr>
											<tr>
												<td style="height: 25px; font-size: 10px; border-right: 1px solid black; padding-left: 5px"><b>NO. MESIN</b></td> -->
												<?php foreach ($proses[$value[$p]['JOB_NUMBER']] as $prs) { ?>

												<td align="center" style="height: 25px; font-size: 10px;border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;
												<?php
													if ($prs['KODE_PROSES'] == $value[$p]['KODE_PROSES']) {
														echo "<b>".$prs['NO_MESIN']."</b>";
													} else {
														echo $prs['NO_MESIN'];
													}
												 ?>
												</td>
												<?php } ?>
											</tr>
										</table>
										<tr style="margin-top: 10px;">
											<td style="font-size: 16px;">
												<b style="padding-left: 5px">current proses : <?= $value[$p]['KODE_PROSES'] ?></b>
											</td>
										</tr>
				</div>
			</div>
	<?php
			}
		}
	}
	else: echo "no data found :(";
	endif;
	?>

</body>
