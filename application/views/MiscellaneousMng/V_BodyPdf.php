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
			font-size:12px;
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
<p style="margin-left:10px">Mohon dilakukan transaksi miscellaneous untuk item berikut :</p>
<table class="table table-bordered hor-center ver-top" repeat_header="1">
<thead>
	<tr style="background-color: #f0f0f0;" class="table-head">
			<th style="width: 3%;border:1px solid black;">NO</th>
			<th style="width: 7%;border:1px solid black;">ISSUE / RECEIPT <sup style="font-size:9px">1</sup></th>
			<th style="width: 12%;border:1px solid black;">KODE BARANG</th>
			<th style="width: 17%;border:1px solid black;">DESKRIPSI</th>
			<th style="width: 5%;border:1px solid black;">QTY</th>
			<th style="width: 5%;border:1px solid black;">UOM</th>
			<th style="width: 11%;border:1px solid black;">SUBINVENTORY</th>
			<th style="width: 8%;border:1px solid black;">LOCATOR</th>
			<th style="width: 8%;border:1px solid black;">NO SERI</th>
			<th style="width: 14%;border:1px solid black;">ALASAN</th>
			<th style="width: 10%;border:1px solid black;">STATUS</th>
	</tr>
</thead>
<tbody>
	<?php $no=1; 
		foreach ($data as $key => $value) {?>
			<tr class="table-line">
                <td style="height:30px;border:1px solid black;"><?= $no?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['issue_receipt']?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['kode_item']?></td>
                <td style="height:30px;border:1px solid black;text-align:left;"><?= $value['deskripsi_item']?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['qty']?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['uom']?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['inventory']?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['locator']?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['no_serial']?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['alasan']?> <br> <?= $value['deskripsi_alasan']?></td>
                <td style="height:30px;border:1px solid black;"><?= $value['status']?></td>
			</tr>
    <?php $no++; }?>
</tbody>
</table>
</body>

