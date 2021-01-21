<style type="text/css">
		body {
			font-size: 12px;
		}

		.table {
			width: 100%;
			table-layout:fixed;
			margin: 10px;
		}

		.table-head th {
			font-size:11px;
			padding: 1px 3px;
		}

		.table-line td {
			padding: 4px 3px;
		}

		.table-bordered, .table-bordered td {
			border: 1px solid #8f8f8f;
			border-collapse: collapse;
		}

		.hor-center {
			text-align: center;
		}

		.ver-top {
			vertical-align: top;
		}

	 	#page-border{
		 width: 100%;
		 height: 100%;
		 border:2px solid black;   
         margin-top: 100px;
		}   
	</style>

<body>
<table class="table table-bordered hor-center ver-top">
	<tr style="background-color: #f0f0f0;" class="table-head">
			<th rowspan="2" style="width: 3px;border:1px solid black;">NO</th>
			<th rowspan="2" style="width: 6px;border:1px solid black;">STATUS (*1)</th>
			<th rowspan="2" style="width: 12%;border:1px solid black;">ITEM</th>
			<th rowspan="2" style="width: 18%;border:1px solid black;">DESKRIPSI</th>
			<th rowspan="2" style="width: 3px;border:1px solid black;">UOM (*2)</th>
			<th rowspan="2" style="width: 4%;border:1px solid black;">DUAL UOM (Y/N) (*2)</th>
			<th rowspan="2" style="width: 4px;border:1px solid black;">MAKE / BUY (*4)</th>
			<th rowspan="2" style="width: 5%;border:1px solid black;">STOCK (Y/N)</th>
			<th rowspan="2" style="width: 5%;border:1px solid black;">NO SERIAL (Y/N)</th>
			<th rowspan="2" style="width: 6%;border:1px solid black;">INSPECT AT RECEIPT (Y/N)</th>
			<th rowspan="2" style="width: 5%;border:1px solid black;">ORG. ASSIGN (*5)</th>
			<th colspan="3" style="width: 11%;border:1px solid black;">PROSES LANJUT (*6)</th>
			<th colspan="2" style="width: 14%;border:1px solid black;">ACCOUNTING</th>
			<th rowspan="2" style="width: 10%;border:1px solid black;">KETERANGAN</th>
	</tr>
	<tr style="background-color: #f0f0f0;" class="table-head">
			<th style="border:1px solid black;">ODM</th>
			<th style="border:1px solid black;">OPM</th>
			<th style="border:1px solid black;">JUAL</th>
			<th style="width:4.5%;border:1px solid black;">INV VALUE (Y/N)</th>
			<th style="width:7%;border:1px solid black;">EXP ACC (*7)</th>
	</tr>
	<?php $no=1;
		foreach ($data as $key => $value) {?>
			<tr class=" table-line">
					<td style="height:30px;border:1px solid black;"><?= $no?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['STATUS_REQUEST']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['ITEM_FIX']?></td>
					<td style="height:30px;border:1px solid black;text-align:left;"><?= $value['DESC_FIX']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['KODE_UOM']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['STATUS_REQUEST'] == 'I' ? '-' : $value['DUAL_UOM']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['STATUS_REQUEST'] == 'I' ? '-' : $value['MAKE_BUY']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['STATUS_REQUEST'] == 'I' ? '-' : $value['STOK']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['STATUS_REQUEST'] == 'I' ? '-' : $value['NO_SERIAL']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['STATUS_REQUEST'] == 'I' ? '-' : $value['INSPECT_AT_RECEIPT']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['STATUS_REQUEST'] == 'I' ? '-' : $value['ORG_ASSIGN']?></td>
					<td style="height:30px;border:1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:14px"><?= $value['ODM'] == 'ODM' ? '&#10003;' : ''?></span></td>
					<td style="height:30px;border:1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:14px"><?= $value['OPM'] == 'OPM' ? '&#10003;' : ''?></span></td>
					<td style="height:30px;border:1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:14px"><?= $value['JUAL'] == 'JUAL' ? '&#10003;' : ''?></span></td>
					<td style="height:30px;border:1px solid black;"><?= $value['INV_VALUE']?></td>
					<td style="height:30px;border:1px solid black;"><?= $value['EXP_ACC']?></td>
					<td style="height:30px;border:1px solid black;text-align:left">
					<strong>Latar belakang :</strong><br><?= $value['LATAR_BELAKANG'] ?><br><br>
					<strong>Keterangan :</strong><br><?= $value['KETERANGAN']?></td>
			</tr>
		<?php $no++; } ?>
</table>
</body>

