    <style type="text/css">
        body {
            font-size: 12px;
        }

        .table {
            width: 100%;
        }

        .table-head td {
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
    </style>

<body>
<?= $urut != '0' ? '<pagebreak resetpagenum="1" />' : '' ?>
    <!-- view perbedaan item -->
    <span>List Item Berbeda :</span>
	<table class="table table-bordered hor-center ver-top" style="font-size:11px">
	<tr style="background-color: #f0f0f0;vertical-align: middle;" class="table-head">
				<td style="vertical-align: middle;" width="4%">No</td>
				<td style="vertical-align: middle;" width="16%">Kode Part</td>
				<td style="vertical-align: middle;" width="37%">Nama Part</td>
				<td style="vertical-align: middle;">Keterangan</td>
			</tr>
	<?php 
	$no=1;
	foreach ($dataall['beda'] as $k => $ln) {
		?>
						<tr class=" table-line">
							<td width="4%"><?php echo $no++; ?></td>
							<td width="16%"><?php echo $ln['COMPONENT']; ?></td>
							<td width="37%" style="text-align: left;"><?php echo $ln['COMP_DESC']; ?></td>
							<td style="text-align: left;"><?php echo $ln['PERBEDAAN']; ?></td>
						</tr>
	<?php } ?>
			</table>
    <!-- view perbedaan item -->
</div>
</body>
