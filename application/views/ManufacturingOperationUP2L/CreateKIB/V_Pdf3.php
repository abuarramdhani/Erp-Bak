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
				<table style="width: 100% ; font-size: 27px">
					<tr>
						<td>
							<b>TANGGAL</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['TANGGAL'] ?></b>
						</td>
					</tr>
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
							<b>LOCATOR</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['FROM_LOCATOR'] ?></b>
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
					<tr>
						<td>
							<b>LOCATOR KE</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['TO_LOCATOR'] ?></b>
						</td>
					</tr>
				</table>
				<hr style="border-top: dotted 1px;" />
				</td>
			</tr>
			<tr >
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm;">
				<table style="width: 100% ; font-size: 27px">
					<tr>
						<td>
							<b>ASSY</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['KODE_ASSY'] ?></b>
						</td>
					</tr>
					<tr>
						<td>
							<b>DESC</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['DESC_ASSY'] ?></b>
						</td>
					</tr>
					<tr>
						<td>
							<b>QTY</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['QTY_ASSY'] ?></b>
						</td>
					</tr>
					<tr>
						<td>
							<b>UOM</b>
						</td>
						<td>
							<b>:</b>
						</td>
						<td>
							<b><?php echo $value['UOM_ASSY'] ?></b>
						</td>
					</tr>
				</table>
				<hr style="border-top: dotted 1px;" />
				</td>
			</tr>


			<tr style="width: 100%;">
				<td style="height: 20mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px" width="100%">
					<table style="width: 100%; font-size: 22px">
						<tr style="width: 100%;">
							<td><u><b>KOMPONEN</b></u> </td>
							<td><u><b>QTY</b></u> </td>
							<td><u><b>UOM</b></u> </td>
						</tr>
						<?php foreach ($value['KOMPONEN'] as $op => $opr) { ?>
						<tr style="width: 100%;">
							<td><?php echo $opr['KODE_KOMP'] ?><br><?php echo $opr['DESC_KOMP'] ?></td>
							<td><?php echo $opr['QTY_KIB'] ?></td>
							<td><?php echo $opr['UOM_KOMP'] ?></td>
						</tr>
						<?php } ?>
					</table>
					<hr style="border-top: dotted 1px;" />
				</td>
			</tr>






			<tr>
				<td style="height: 10mm; padding-left: 5mm;padding-right: 5mm; font-size: 32px">
					<table style="width: 200mm; font-size: 32px">
						<tr>
							<td style="width: 70mm;vertical-align: top" >
								Keterangan :<br>
							</td>
							<td  style="width: 70mm; text-align: right;" rowspan="2">
								<img style="width: 40mm; height: auto;" src="<?php echo base_url('assets/img/'.$value['NOMORSET'].'.png') ?>">
							</td>
						</tr>
						<tr>
							<td style="width: 70mm;vertical-align: bottom;">
								<b style="font-size: 86px; ">
								 <?php echo $value['ALIAS_KODE']; ?>
								</b>
							</td>
						</tr>
						<tr style="border-bottom: 6px solid black;">
							<td>FRM-WHS-01-PDN-01</td>
							<td style="text-align: right;"><?php echo $value['NOMORSET'] ?></td>
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
	</div>
<?php } ?>
</body>