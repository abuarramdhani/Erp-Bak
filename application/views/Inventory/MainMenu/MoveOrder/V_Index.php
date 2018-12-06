<!DOCTYPE html>
<html>
<head>
	<title></title>
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
</head>
<body>
	<?php 
	foreach ($dataall as $k => $v) {
		foreach ($v['head'] as $key => $hd) {
			if ($k!=0) {
				echo "<pagebreak />";
			}
		?>
			<table class="table table-head" style="margin-top: -10px;">
				<tr>
					<td width="15%">Lokasi</td>
					<td width="30%">: <?php echo $hd['LOKASI'] ?></td>
					<td width="15%">Job No</td>
					<td>: <?php echo $hd['JOB_NO'] ?></td>
					<td class="ver-top" rowspan="5" width="12%">
						<img src="<?php echo base_url('assets/img/'.$hd['MOVE_ORDER_NO'].'.png') ?>">
						<p><?= $hd['MOVE_ORDER_NO'] ?></p>
					</td>
				</tr>
				<tr>
					<td>Produk</td>
					<td>: <?php echo $hd['KATEGORI_PRODUK'] ?></td>
					<td>Department</td>
					<td>: <?php echo $hd['DEPARTMENT'] ?></td>
				</tr>
				<tr>
					<td>Tanggal Dipakai</td>
					<td>: <?php echo $hd['DATE_REQUIRED'] ?></td>
					<td>Kode Assembly</td>
					<td>: <?php echo $hd['PRODUK'] ?></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>Nama Assembly</td>
					<td>: <?php echo $hd['PRODUK_DESC'] ?></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $hd['SCHEDULE'] ?></td>
					<td>Total Qty</td>
					<td>: <?php echo $hd['START_QUANTITY'] ?></td>
				</tr>
			</table>
			<table class="table table-bordered hor-center ver-top">
				<tr style="background-color: #f0f0f0;" class="table-head">
					<td rowspan="2" width="4%">No</td>
					<td rowspan="2" width="16%">Kode Part</td>
					<td rowspan="2" width="37%">Nama Part</td>
					<td rowspan="2" width="5%">UOM</td>
					<td rowspan="2" width="5%">QTY / Unit</td>
					<td colspan="3">Total Qty</td>
					<td rowspan="2">TTD</td>
					<td rowspan="2">Lokasi</td>
				</tr>
				<tr style="background-color: #f0f0f0;" class="table-head">
					<td width="6%">Minta</td>
					<td width="6%">Serah</td>
					<td width="6%">ATR</td>
				</tr>
				<?php
				$no=1;
				foreach ($dataall[$k]['line'] as $ln) {
					if ($ln['JOB_NO'] == $hd['JOB_NO'] && $ln['LOKASI'] == $hd['LOKASI']) {
				?>
						<tr class=" table-line">
							<td><?php echo $no++; ?></td>
							<td><?php echo $ln['KODE_KOMPONEN']; ?></td>
							<td style="text-align: left;"><?php echo $ln['KODE_DESC']; ?></td>
							<td><?php echo $ln['UOM']; ?></td>
							<td><?php echo $ln['QTY_UNIT']; ?></td>
							<td><?php echo $ln['QTY_MINTA']; ?></td>
							<td></td>
							<td><?php echo $ln['ATR']; ?></td>
							<td></td>
							<td><?php echo $ln['LOC']; ?></td>
						</tr>
				<?php
					}
				}
				?>
			</table>
	<?php }
	} ?>
</body>
</html>