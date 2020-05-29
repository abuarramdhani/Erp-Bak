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
<?= $urut != '0' ? '<pagebreak resetpagenum="1" />' : '' ?>
<table class="table table-bordered hor-center ver-top">
	<tr style="background-color: #f0f0f0;" class="table-head">
        <th style="width: 5%;border:1px solid black;">NO</th>
        <th style="width: 12%;border:1px solid black;">NO. STTT</th>
        <th style="width: 15%;border:1px solid black;">NO. SP/DOSP/SPB</th>
        <th style="border:1px solid black;">TUJUAN</th>
        <th style="width: 8%;border:1px solid black;">JML COLLY</th>
        <th style="width: 30%;border:1px solid black;">BERAT (KG)</th>
	</tr>
	<?php $no=1; foreach ($data as $val) { ?>
            <tr class=" table-line">
                <td style="height:30px;border:1px solid black;"><?= $no?></td>
                <td style="height:30px;border:1px solid black;"></td>
                <td style="height:30px;border:1px solid black;"><?= $val['no_dokumen']?></td>
                <td style="height:30px;border:1px solid black;text-align:left;"><?= $val['tujuan']?></td>
                <td style="height:30px;border:1px solid black;"><?= $val['jumlah']?></td>
                <td style="height:30px;border:1px solid black;"><?= $val['berat']?></td>
            </tr>
	<?php $no++;  }
	if ($size < 28) {
		$kurang = 28 - $size;
		for ($a=0; $a < $kurang; $a++) { 
			echo '<tr>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
				</tr>';
		}
	}elseif ($size > 28 && $size < 58) {
		$kurang = 28 - ($size-28);
		for ($a=0; $a < $kurang; $a++) { 
			echo '<tr>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
					<td style=\'height:30px;border:1px solid black;\'></td>
				</tr>';
		}
	}
	?>
</table>
</body>

