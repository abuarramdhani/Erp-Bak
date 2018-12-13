<style type="text/css">
	body{
		font-family: 'Arial';
	}
</style>

<body>
<?php foreach ($dataKIB as $key => $value) { ?>
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
				<table style="width: 100% ; font-size: 32px">
					<tr>
						<td>
							<b>DARI</b>
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
							<b>KE</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['TO_SUBINVENTORY_CODE'] ?></b>
						</td>
					</tr>
						
				</table>
				<hr style="border-top: dotted 1px;" />
				</td>
			</tr>
			<tr>
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
			</tr>
			<tr>
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px">
				<p>
					<?php echo $value['DESCRIPTION'] ?>
				</p>
				<b>
					&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['ITEM_CODE'] ?> / <?php echo $value['BATCH_NUMBER'] ?>
				</b>
			</tr>
			<tr>
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm; font-size: 11px">
				<table style=" width: 100%; font-size: 32px">
					<tr>
						<td style="width: 30%" >Tipe Produk</td>
						<td style="width: 40%" ><?php echo $value['TIPE_PRODUCT'] ?></td>
						<td style="width: 30%" rowspan="4">Status <?php echo $value['STATUS'] ?></td>
					</tr>
					<tr>
						<td style="width: 30%" >Qty Aktual</td>
						<td style="width: 40%" ><?php echo $value['QUANTITY'] ?></td>
					</tr>
					<tr>
						<td style="width: 30%" >Qty Handling</td>
						<td style="width: 40%" ><?php echo $value['HANDLING_QTY'] ?></td>
					</tr>
					<tr>
						<td style="width: 30%" >Jenis Handling</td>
						<td style="width: 40%" ><?php echo $value['KODE_KONTAINER'] ?></td>
					</tr>
					<tr>
						<td colspan="3"><?php echo $value['DESKRIPSI_KONTAINER'] ?></td>
					</tr>
				</table>
			</tr>
			<tr>
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px">
					<table style="width: 200mm; font-size: 32px">
						<tr>
							<td style="width: 70mm;vertical-align: top" >
								Keterangan<br>
							</td>
							<td  style="width: 70mm; text-align: right;" rowspan="2">
								<img style="width: 62mm; height: auto;" src="<?php echo base_url('assets/img/'.$value['REQUEST_NUMBER'].'.png') ?>">
							</td>
						</tr>
						<tr>
							<td style="width: 70mm;vertical-align: bottom;">
								<b style="font-size: 86px; ">
								 <?php echo $value['ALIAS_KODE']; ?>
								</b>
							</td>
						</tr>
						<tr>
							<td>FRM-WHS-01-PDN-01</td>
							<td style="text-align: right;"><?php echo $value['REQUEST_NUMBER'] ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- <tr>
				<td style="height: 5mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px">
					&nbsp;
				</td>
			</tr> -->
		</table>
	</div>
<?php } ?>
</body>