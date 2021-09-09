<style type="text/css">
	body{
		font-family: 'Arial';
	}
</style>
<?php
	date_default_timezone_set("Asia/Jakarta");
	$tanggal = date("d-M-Y G:i:s");
?>
<body>
<?php foreach ($dataKIB as $key => $value) {
	if ($value['STATUS'] == null) {
		$color = '#fff';
	} else {
		$color = '#000';
	}

	?>
	<div style="width:210mm; height: 330mm; float: left; padding-top: 20mm" >
		<table style="width: 100%; height: 100%; ">
			<tr>
				<td style="height: 15mm; vertical-align: bottom;">
					<center>
						<b style="font-size: 38px">
							KARTU IDENTITAS BARANG
						</b>
						<p style="font-size: 32px">
							CV. KARYA HIDUP SENTOSA
						</p>
					</center>
				</td>
			</tr>
			<tr >
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm;">
				<table style="width: 100% ; font-size: 30px">
					<tr>
						<td>
							<b>Tanggal Selep</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><span style="font-size: 30px;"><?= date_format(date_create($value['PLANED_DATE']),"d-M-Y H:i:s") ;?></span></b>
						</td>
					</tr>
					<tr>
						<td>
							<b>Tanggal Cetak</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><span style="font-size: 30px;"><?= $tanggal;?></span></b>
						</td>
					</tr>
					<tr>
						<td>
							<b>Dari</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['FROM_SUBINVENTORY_CODE'] ?></b>
						</td>
					</tr>
					<tr>
						<td>
							<b>Ke </b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['TO_SUBINVENTORY_CODE'] ?></b>
						</td>
					</tr>
					<tr>
						<td>
							<b>Locator</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['TO_LOCATOR_CODE'] ?></b>
						</td>
					</tr>
					<tr>
						<td>
							<b>Lokasi Simpan</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['LOKASI_SIMPAN'] ?></b>
						</td>
					</tr>
				</table>
				<hr style="border-top: dotted 1px;" />
				<table style="width: 100% ; font-size: 30px">
					<tr>
						<td>
							<b>Operator Produksi</b>
						</td>
						<td>
							<b></b>
						</td>
						<td>
							<b></b>
						</td>
					</tr>
				</table>
				<table style="width: 200mm; font-size: 30px;">
					<?php foreach ($value['OPERATOR'] as $key2 => $val2): ?>
						<tr>
							<td style="width: 21mm;vertical-align: top;" >
								<?php if ($key2 == 0){ ?>
									Nama
								<?php } ?>
							</td>
							<td style="">
								<?php if ($key2 == 0){ ?>
									:
								<?php } ?>
							</td>
							<td style="width: 147mm;vertical-align: top;" >
							 <span style="text-transform:capitalize"><?php echo $val2['employee_name'] ?></span> (<?php echo $val2['employee_code'] ?>),
							</td>
						</tr>
					<?php endforeach; ?>
					<?php
					if (sizeof($value['OPERATOR']) < 4) {
						for ($i=0; $i < (4-sizeof($value['OPERATOR'])); $i++) {
							echo '<tr>
											<td style="width: 21mm;vertical-align: top;" ></td>
											<td style=""></td>
											<td style="width: 147mm;vertical-align: top;color:white" >blabla</td>
										</tr>';
						}
					}
					?>
				</table>
				<hr style="border-top: dotted 1px;" />
				</td>
			</tr>
			<!-- <tr>
				<td style="height: 20mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px">
					<p>OPERATOR PRODUKSI</p>
					<table style="width: 100%; font-size: 32px">
						<tr>
							<td><u><b>OPR</b></u> </td>
							<td><u><b>ACTIVITY</b></u> </td>
						</tr>
						<?php foreach ($value['OPR'] as $op => $opr) { ?>
						<tr>
							<td><?php echo $opr['OPR_SEQ'] ?></td>
							<td><?php echo $opr['ACTIVITY'] ?></td>
						</tr>
						<?php } ?>

					</table>
					<hr style="border-top: dotted 1px;" />
				</td>
			</tr> -->
			<tr>
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px">
				<p>
					<?php echo $value['DESCRIPTION'] ?>
				</p>
				<b>
					&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['ITEM_CODE'] ?>  <span style="color: <?=$color;?>"> / <?php echo $value['BATCH_NUMBER'] ?> </span>
				</b>
			</tr>
			<tr>
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm; font-size: 11px">
				<table style=" width: 100%; font-size: 32px">
					<tr>
						<td style="width: 100%" style="color: <?=$color;?>">Status <?php echo $value['STATUS'] ?></td>
					</tr>
					<tr>
						<td style="width: 30%" >Qty Aktual</td>
						<td style="width: 40%" >: <?php echo $value['QUANTITY'] ?></td>
					</tr>
					<tr>
						<td style="width: 30%" >Qty Handling</td>
						<td style="width: 40%" >: <?php echo $value['HANDLING_QTY'] ?></td>
					</tr>
					<tr>
						<td style="width: 30%" >Jenis Handling</td>
						<td style="width: 40%" >: <?php echo $value['KODE_KONTAINER'] ?></td>
					</tr>
					<tr>
						<td colspan="3"><?php echo $value['DESKRIPSI_KONTAINER'] ?></td>
					</tr>
				</table>
			</tr>
			<tr>
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px">
					<table style="width: 200mm; font-size: 32px;">
						<tr>
							<td style="width: 54mm;vertical-align: top;" >
								Hasil QC<br>
							</td>
							<td  style="" rowspan="2">
								<table style="border-collapse: collapse;text-align:center;font-size:28px">
									<tr>
										<td style="width: 32mm;border-left:1px solid black;border-top:1px solid black;">OK</td>
										<td style="width: 45mm;border-left:1px solid black;border-top:1px solid black;">Repair</td>
										<td style="width: 45mm;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;">Scrap</td>
									</tr>
									<tr>
										<td style="height: 25mm;border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black"></td>
										<td style="height: 25mm;border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black"></td>
										<td style="height: 25mm;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;border-bottom:1px solid black"></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px">
					<table style="width: 200mm; font-size: 32px">
						<tr>
							<td style="width: 70mm;vertical-align: top" >
								Keterangan<br>
							</td>
							<td  style="width: 70mm; text-align: right;" rowspan="2">
								<img style="width: 55mm; height: auto;" src="<?php echo base_url('assets/img/'.$value['REQUEST_NUMBER'].'.png') ?>">
							</td>
						</tr>
						<tr>
							<td style="width: 70mm;vertical-align: bottom;">
								<b style="font-size: 80px; ">
								 <?php echo $value['ALIAS_KODE']; ?>
								</b>
							</td>
						</tr>
						<tr style="border-bottom: 6px solid black;">
							<td>FRM-WHS-01-PDN-01</td>
							<td style="text-align: right;"><?php echo $value['REQUEST_NUMBER'] ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- <tr>
				<td style="height: 5mm; padding-left: 5mm;padding-right: 5mm; font-size: 10px">
					&nbsp;
				</td>
			</tr> -->
		</table>
		<br>
		<hr style="border-top: dotted 1px;" />
	</div>
<?php } ?>
</body>
