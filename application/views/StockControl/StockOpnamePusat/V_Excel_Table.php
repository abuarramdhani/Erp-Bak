<?php 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=exceldata.xlsx");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<?php
	if (!empty($item_classification)) {
		$count = sizeof($item_classification);
		foreach ($item_classification as $ic) {
?>
<table class="table table-hover table-striped" style="font-size:8px;">
	<thead>
		<tr>
			<td style="border: none;padding-bottom: 4px;font-weight: bold" colspan="13" align="center"><h5>DAFTAR KODE BARANG - STOCK OPNAME - CV. KARYA HIDUP SENTOSA</h5></td>
		</tr>
		<tr>
			<td style="border: none;padding-bottom: 4px;" colspan="13" align="center">
				<table style="margin-bottom: 5px;font-size: 10px">
					<tr>
						<td align="left" width="5cm" style="padding: 3px 3px;border:none">Nama IO</td>
						<td align="left" width="0.5cm" style="padding: 3px 3px;border:none">:</td>
						<td align="left" width="6cm" style="padding: 3px 3px;border:none"><?php echo $ic['io_name'] ?></td>
						<td align="left" width="3.5cm" style="padding: 3px 3px;border:none">&emsp;</td>
						<td align="left" width="5cm" style="padding: 3px 3px;border:none">Petugas Input</td>
						<td align="left" width="0.5cm" style="padding: 3px 3px;border:none">:</td>
						<td align="left" width="6cm" style="padding: 3px 3px;border:none">..........................................................</td>
					</tr>
					<tr>
						<td align="left" style="padding: 3px 3px;border:none">Sub Inventory</td>
						<td align="left" style="padding: 3px 3px;border:none">:</td>
						<td align="left" style="padding: 3px 3px;border:none"><?php echo $ic['sub_inventory'] ?></td>
						<td align="left" style="padding: 3px 3px;border:none">&emsp;</td>
						<td align="left" style="padding: 3px 3px;border:none">Tanggal SO</td>
						<td align="left" style="padding: 3px 3px;border:none">:</td>
						<td align="left" style="padding: 3px 3px;border:none"><?php echo $tanggal_so ?></td>
					</tr>
					<tr>
						<td align="left" style="padding: 3px 3px;border:none">Area</td>
						<td align="left" style="padding: 3px 3px;border:none">:</td>
						<td align="left" style="padding: 3px 3px;border:none"><?php echo $ic['area'] ?></td>
						<td align="left" style="padding: 3px 3px;border:none">&emsp;</td>
						<td align="left" style="padding: 3px 3px;border:none">Nama Pencatat</td>
						<td align="left" style="padding: 3px 3px;border:none">:</td>
						<td align="left" style="padding: 3px 3px;border:none">..........................................................</td>
					</tr>
					<tr>
						<td align="left" style="padding: 3px 3px;border:none">Locator</td>
						<td align="left" style="padding: 3px 3px;border:none">:</td>
						<td align="left" style="padding: 3px 3px;border:none"><?php echo $ic['locator'] ?></td>
						<td align="left" style="padding: 3px 3px;border:none">&emsp;</td>
						<td align="left" style="padding: 3px 3px;border:none">PIC Area</td>
						<td align="left" style="padding: 3px 3px;border:none">:</td>
						<td align="left" style="padding: 3px 3px;border:none">..........................................................</td>
					</tr>
				</table>
			</td>
		</tr>
	</thead>
	<thead class="bg-primary">
		<tr>
			<td style="text-align: center; vertical-align : middle; border: 1px solid #000" width="1cm" height="25px">
				
					<b>NO</b>
				
			</td>
			<td style="text-align: center; vertical-align : middle; border: 1px solid #000" width="3cm" height="25px">
				
					<b>KODE BARANG</b>
				
			</td>
			<td style="text-align: center; vertical-align : middle; border: 1px solid #000" width="10cm" height="25px">
				
					<b>NAMA BARANG</b>
				
			</td>
			<td style="text-align: center; vertical-align : middle; border: 1px solid #000" width="2cm" height="25px">
				
					<b>TYPE</b>
				
			</td>
			<td style="text-align: center; vertical-align : middle; border: 1px solid #000" width="3cm" height="25px">
				
					<b>LOKASI SIMPAN</b>
				
			</td>
			<td style="text-align: center; vertical-align : middle; border: 1px solid #000" width="1cm" height="25px">
				
					<b>ON HAND</b>
				
			</td>
			<td style="text-align: center; vertical-align : middle; border: 1px solid #000" width="1cm" height="25px">
				
					<b>UOM</b>
				
			</td>
			<td colspan="5" style="text-align: center; vertical-align : middle; border: 1px solid #000" width="3cm" height="25px">
				
					<b>SO QTY</b>
				
			</td>
			<td style="text-align: center; vertical-align : middle; border: 1px solid #000" width="4cm" height="25px">
				
					<b>KETERANGAN</b>
				
			</td>
		</tr>
	</thead>
	<tbody>
		<?php
		if(!(empty($stock_opname_pusat))){
			$no=0;
			foreach($stock_opname_pusat as $data) {;
				if ($data['io_name'] == $ic['io_name'] && $data['sub_inventory'] == $ic['sub_inventory'] && $data['area'] == $ic['area'] && $data['locator'] == $ic['locator']) {
					$no++
		?>
		<tr class="multiple-row">
			<td align="center" style="border: 1px solid #000" height="0.75cm"><?php echo $no?></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"><?php echo $data['component_code']?></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"><?php echo $data['component_desc']?></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"><?php echo $data['type']?></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"><?php echo $data['saving_place']?></td>
			<td align="center" style="padding:1px 10px; border: 1px solid #000"><?php echo $data['onhand_qty']?></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"><?php echo $data['uom']?></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"></td>
			<td align="left" style="padding: 1px 10px; border: 1px solid #000"></td>
		</tr>
		<?php
				}
			}
		}

		?>
	</tbody>																				
</table>
<?php
			
		}
	}
?>