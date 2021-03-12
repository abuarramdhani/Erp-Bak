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
	<?php if (count($dataall['beda']) > 0) { ?>
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
	<pagebreak resetpagenum="1" />
	<?php }?>
    <!-- view perbedaan item -->

	<table class="table table-bordered hor-center ver-top" >
	<tr style="background-color: #f0f0f0;vertical-align: middle;" class="table-head">
				<td style="vertical-align: middle;" rowspan="2" width="4%">No</td>
				<td style="vertical-align: middle;" rowspan="2" width="16%">Kode Part</td>
				<td style="vertical-align: middle;" rowspan="2" width="37%">Nama Part</td>
				<td style="vertical-align: middle;" rowspan="2" width="5%">UOM</td>
				<td style="vertical-align: middle;" rowspan="2" width="5%">QTY / Unit</td>
				<td style="vertical-align: middle;" colspan="2">Total Qty</td>
				<td style="vertical-align: middle;" rowspan="2">ATT</td>
				<td style="vertical-align: middle;" rowspan="2" width="7%">TTD</td>
				<td style="vertical-align: middle;" rowspan="2" width="14%">Lokasi</td>
			</tr>
			<tr style="background-color: #f0f0f0;" class="table-head">
				<td width="6%">Minta</td>
				<td width="6%">Serah</td>
			</tr>
	<?php 
	$no=1;
	foreach ($dataall['line'] as $k => $ln) {
		?>
						<tr class=" table-line">
							<td width="4%"><?php echo $no++; ?></td>
							<td width="16%"><?php echo $ln['KODE_KOMPONEN']; ?></td>
							<td width="37%" style="text-align: left;"><?php echo $ln['KODE_DESC']; ?></td>
							<td width="5%"><?php echo $ln['UOM']; ?></td>
							<td width="5%"><?php echo $ln['QTY_UNIT']; ?></td>
							<td width="6%"><?php echo $ln['QTY_MINTA']; ?></td>
							<td width="6%"></td>
							<td width="7%"><?php echo $ln['ATT']; ?></td>
							<td width="7%"></td>
							<td width="14%"><?php echo $ln['LOC']; ?></td>
						</tr>
	<?php } ?>
			</table>
</div>
</body>
