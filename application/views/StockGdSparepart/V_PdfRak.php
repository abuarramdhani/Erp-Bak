<style type="text/css">
		body {
			font-size: 12px;
		}

		.table {
			width: 100%;
			table-layout:fixed;
		}

		.table-head th {
			font-size:13px;
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

		.hor-right {
			text-align: right;
		}

		.ver-center {
			vertical-align: middle;
		}

		.ver-top {
			vertical-align: top;
		}
		tfoot td{
			border:1px solid white;
		}
	</style>

<body>
<!-- <div class="row" style="padding-left:0px;padding-right:0px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <tr>
        <td rowspan="2" style="border-bottom:0px solid black; width:20px"><img style="max-width: 70px;max-height: 70px" src="<?php echo base_url("assets/img/logo.png")?>"></td>
        <td style="border-bottom:1px solid black; border-collapse: collapse;text-align:left;font-weight:bold;font-size: 30px">Daftar Barang Rak <?= $lokasi?></td>
    </tr>
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:left;font-size: 12px">Tanggal : <?= date('l, d  F  Y')?></td>
    </tr>
</table>
</div>
<br> -->
<table class="table table-bordered hor-center ver-top">
	<tr style="background-color: #f0f0f0;" class="table-head">
        <th style="width: 5%;border:1px solid black;">No</th>
        <th style="border:1px solid black;">Kode Barang</th>
        <th style="width: 35%;border:1px solid black;">Nama Barang</th>
        <th style="border:1px solid black;">Alamat</th>
        <th style="border:1px solid black;">Min</th>
        <th style="border:1px solid black;">Max</th>
        <th style="border:1px solid black;">Onhand</th>
        <th style="border:1px solid black;">Actual</th>
	</tr>
	<?php $no=1; foreach ($data as $val) { ?>
            <tr class=" table-line">
                <td style="border:1px solid black;"><?= $no?></td>
                <td style="border:1px solid black;"><?= $val['ITEM'] ?></td>
                <td style="border:1px solid black;text-align:left;"><?= $val['DESCRIPTION'] ?></td>
                <td style="border:1px solid black;"><?= $val['LOKASI'] ?></td>
                <td style="border:1px solid black;"><?= $val['MIN'] ?></td>
                <td style="border:1px solid black;"><?= $val['MAX'] ?></td>
                <td style="border:1px solid black;"><?= $val['ONHAND'] ?></td>
                <td style="border:1px solid black;"></td>
            </tr>
	<?php $no++;  }?>
</table>
</body>

