<html>

<head>
	<style media="screen">
		td {
			padding: 5px;
		}
	</style>
</head>

<body  style="font-size: 9pt">
	<div style="position:absolute;right:-59mm;top:76mm">
			<table style="width: 40%; border-collapse: collapse; border-spacing: 0;">
				<tr>
				<?php $no = 0; foreach ($get_colly as $key => $gc){
					if ($no % 2 === 0) {
						echo '</tr><tr>';
					}
				?>
					<td style="font-size: 9px; padding: 3.5px; text-align: left;">
						<?php echo $gc['CNUM'].' : '.number_format($gc['BERAT'],1).' kg' ?>
					</td>
					<!-- <td style="font-size: 8px; padding: 3.5px; text-align: right; border: 1px solid red;">
						<?php echo number_format($gc['BERAT'],1).' KG' ?>
					</td>				 -->
				<?php $no++; } ?>
				</tr>
			</table>
	</div>
	<div style="height: 256mm; width: 205mm;">
		<div id="headerArea" style="height: 51mm;">
			<table id="tableHeaderTitle" style="border-collapse:collapse; width: 197mm">
				<tr>
					<td rowspan=2 width="127mm">
					<td height="6.5mm" width="70mm"></td>
				</tr>
				<tr>
					<td style="padding-left: 28mm; font-size:14pt; height: 9mm;padding-top:2mm"> <?php echo $row['REQUEST_NUMBER']; ?></td>
				</tr>
			</table>
			<table style="border-collapse:collapse; width: 197mm">
				<tr>
					<td style="height: 21mm; width: 89mm; padding-left: 4mm;font-size: 10pt;">
						<?php echo $row['NAMA_ASAL'].'<br>'.$row['ALAMAT_ASAL'].'<br>'.$row['KOTA_ASAL']; ?>
					</td>
					<td style="width: 108mm; padding-left: 25mm; vertical-align: middle;font-size: 10pt;">
						<?php echo $row['ORGANIZATION_CODE'].'<br>'.$row['NAMA_KIRIM'].'<br>'.$row['ALAMAT_KIRIM'].'<br>'.$row['KOTA_KIRIM'];?>
					</td>
				</tr>
			</table>
			<table style="border-collapse:collapse; width: 197mm;">
				<tr>
					<td colspan="2" style="vertical-align: top; height: 11mm;"><!-- No Order : --></td>
					<td colspan="2" style="vertical-align: top;"><!-- Tgl. Order : --></td>
					<td rowspan="2" style="vertical-align: middle; width: 108mm; padding-left: 15mm">
							<?php
								$arr = explode("#", $row['LAIN']);
								foreach($arr as $i) {
									echo $i.'<br>';
								}
							?>
					</td>
				</tr>
				<tr>
					<td style="height: 17mm; vertical-align: top; width: 20mm;padding-left:2.5mm;padding-top:6.2mm"><!-- Berat : --> <?php echo number_format($get_berat[0]['TTL_BERAT'],3).' Kg' ?></td>
					<td style="vertical-align: middle;padding-left:15mm; width: 40mm;font-size:12px;" colspan="2">
						<!-- Ekspedisi : -->
						<?php echo $row['EKSPEDISI']; ?>
					</td>
					<td style="vertical-align: top; width: 25mm"><!-- No.Polisi : --></td>
				</tr>
			</table>
		</div>
		<div class="content" style="width: 197mm; height: 128mm;margin-top:-2mm">
			<table style="border-collapse: collapse; width: 199mm;">
				<tr>
					<th rowspan=2 style="height:20px; width: 6mm"><!-- NO --></th>
					<th colspan=2 style="height:15px;"><!-- QTY --></th>
					<th rowspan=2 style="height:20px; width: 15mm"><!-- SATUAN --></th>
					<th rowspan=2 style="height:20px; width: 33mm"><!-- KODE BARANG --></th>
					<th rowspan=2 style="height:20px; width: 81mm"><!-- NAMA BARANG --></th>
					<th rowspan=2 style="padding-left:8mm;height:20px; width: 47mm"><!-- TIPE/NOMOR BARANG --></th>
				</tr>
				<tr>
					<th style="height:15px; width: 12mm"><!-- MINTA --></th>
					<th style="width: 13mm"><!-- DIKIRIM --></th>
				</tr>
				<?php
				// foreach ($get_body as $key => $rowKit) {
				?>
				<!-- <tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="font-weight:bold; padding-left: 3mm"><?php //echo $rowKit['KODE_BRG']; ?></td>
					<td style="font-weight:bold; padding-left: 3mm"><?php //echo $rowKit['NAMA_TRAKTOR']; ?></td>
					<td></td>
				</tr> -->
				<?php
				// }
				$i=1;
				foreach ($get_body as $key => $rowCont) {?>
				<tr>
					<td style="text-align: center; vertical-align: top"><?php echo $i++; ?></td>
					<td style="padding-left: 1mm;text-align: center; vertical-align: top"><?php echo $rowCont['QTY_REQUESTED']; ?></td>
					<td style="padding-left: 1.8mm;text-align: center; vertical-align: top"><?php echo $rowCont['QTY_DELIVERED']; ?></td>
					<td style="padding-left: 2mm;text-align: center; vertical-align: top"><?php echo $rowCont['UOM_CODE']; ?></td>
					<td style="padding-left: 2mm;text-align: center; vertical-align: top"><?php echo $rowCont['SEGMENT1']; ?></td>
					<td style="padding-left: 4mm;text-align: left;"><?php echo $rowCont['DESCRIPTION'] ?></td>
					<td style="padding-left: 4mm;text-align: left;">
					</td>
				</tr>
				<?php $z++; }?>
			</table>
		</div>
		<div class="qrCodeArea" style="width: 197mm; height: 25mm;">
			<table style="width: 100%; text-align: right;">
				<tr>
					<td width="156mm"></td>
					<td width="41mm">
						<img style="float:left;width:100px;height:auto;position: relative" src="<?php echo base_url('assets/img/monitoringDOSPQRCODE/'.$get_header[0]['REQUEST_NUMBER'].'.png') ?>" />
					</td>
				</tr>
				<tr>
					<td width="156mm"></td>
					<td width="41mm" style="text-align: left;color:white">
						Estimasi
						<br>
						Total Berat : <?php echo number_format($get_berat[0]['TTL_BERAT'],3).' Kg' ?>
					</td>
				</tr>
			</table>

		</div>
		<div class="footer" style="padding-top:-1.5mm;height:34mm;">
				<table style="width:199mm;text-align: center">
					<!-- <tr>
						<td style="height:20px;width:17%">Penerima Barang</td>
						<td style="width:17%">Ekspedisi</td>
						<td style="width:17%">Pengirim</td>
						<td style="width:17%">Gudang</td>
						<td colspan="2" style="width:32%">Pemasaran</td>
					</tr> -->
					<tr>
						<td width="52mm"  style="text-align:left;padding-top:-20mm" rowspan="4">
								<span style="padding-left:20mm"><?= $get_do[0]['BATCH_ID'] ?></span> <br>
								<?php echo $row['CATATAN']; ?>
						</td>
						<td width="25mm"><!-- Tgl.....................<br><br><br><br><br><br>
								<p style="font-size:7pt">(Ttd dan nama jelas)</p> -->
						</td>
						<td width="26mm"><!-- Tgl.....................<br><br><br><br><br><br>
								<p style="font-size:7pt">(Ttd dan nama jelas)</p> -->
						</td>
						<td width="20mm">
						</td>
						<td style="padding-left:1mm;text-align:right" width="24mm"><br><br><br><br><br><br>
								<?php echo $row['ASSIGNER_NAME']; ?>
						</td>
						<td style="padding-left:2mm;text-align:right" width="25mm"><!-- Mengetahui : --><br><br><br><br><br><br>
								<?php echo '('.$row['APPROVE_TONAME'].')'; ?>
						</td>
						<td style="padding-left:2mm;text-align:right;width:20mm!important" width="30mm"><br> <span style="color:white"><?php echo $row['ASSIGN_DATE']?></span> <br>
								<br><br><br><br><?php echo '('.$row['CREATED_BYNAME'].')';?>
						</td>
					</tr>
				</table>
		</div>
		<!-- <div style="padding-top:0mm;font-size: 7pt; width: 199mm;">
			<table style="width: 100%;">
				<tr>
					<td style="text-align: right;">
						Tanggal Kirim : <?php //echo $row['DELIVERY_DATE']; ?>
					</td>
				</tr>
			</table>
		</div> -->
	</div>
	<div style="position:absolute;right: 12mm;bottom: 38mm"><?php echo $row['ASSIGN_DATE']?></div>
</body>
</html>
