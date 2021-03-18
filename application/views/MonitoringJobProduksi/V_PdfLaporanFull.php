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
<?php $jml_baris = $jml_kategori = 0; 
foreach ($data as $key => $value) {
// if (($jml_baris + count($value)+1 > 6 && $jml_kategori > 1) || $jml_kategori > 3 || ($jml_kategori >= 1 && $jml_baris + count($value)+1 > 8)) {
// 	$jml_baris = $jml_kategori = 0;
// 	echo '<pagebreak resetpagenum="1" />';
// }else {
// 	echo "<br>";
// } 
$jml_kategori++; ?>
<div class="row" style="padding-left:0px;padding-right:0px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 20px">Laporan Produksi <?= $value[0]['CATEGORY_NAME'] ?></td>
    </tr>
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 12px"><?= date('l, d  F  Y')?></td>
    </tr>
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 12px"><?= date('d')?>/<?= ($hari - 4)?> hari kerja = <?= round((date('d')/($hari - 4)) * 100, 2)?>% </td>
    </tr>
</table>
</div>
<br>
<table class="table table-bordered hor-center ver-top" repeat_header="1">
<thead>
	<tr style="background-color: #f0f0f0;" class="table-head">
        <!-- <th rowspan="2" style="width: 3%;border:1px solid black;">No</th> -->
        <th rowspan="2" style="border:1px solid black;">Produk</th>
        <th colspan="<?= $hari?>" style="border:1px solid black;">Produksi</th>
        <th rowspan="2" style="border:1px solid black;">Real Prod</th>
        <th rowspan="2" style="border:1px solid black;">Target</th>
        <th rowspan="2" style="border:1px solid black;">Pencapaian Produksi (%)</th>
	</tr>
	<tr style="background-color: #f0f0f0;" class="table-head">
		<?php for ($i=0; $i < $hari; $i++) { ?>
        <th class="text-nowrap" style="border:1px solid black;"><?= $i+1?></th>
		<?php }?>
	</tr>
</thead>
<tbody>
	<?php foreach ($value as $val) { 
		// echo "<pre>";print_r($total);exit();
	?>
            <tr class=" table-line">
                <!-- <td style="border:1px solid black;"><?= $no?></td> -->
                <td style="border:1px solid black;"><?= $val['DESCRIPTION'] ?></td>
				<?php for ($i=0; $i < $hari; $i++) { 
					$tgl = sprintf("%02d", $i+1); ?>
                <td style="border:1px solid black;"><?= $val['TANGGAL'.($tgl).''] == 0 ? '' : $val['TANGGAL'.($tgl).'']; ?></td>
				<?php }?>
                <td style="border:1px solid black;"><?= $val['REAL_PROD'] ?></td>
                <td style="border:1px solid black;"><?= $val['TARGET'] ?></td>
                <td style="border:1px solid black;"><?= round($val['KECAPAIAN_TARGET'], 2) ?></td>
            </tr>
    <?php $no++; $jml_baris++; } ?>
</tbody>
</tfoot>
	<tr class=" table-line">
		<td style="border:1px solid black;">Total</td>
		<?php for ($i=0; $i < $hari; $i++) { 
			$tgl = sprintf("%02d", $i+1); ?>
		<td style="border:1px solid black;"><?= $total[$value[0]['CATEGORY_NAME']]['TANGGAL'.($tgl).''] ?></td>
		<?php }?>
		<td style="border:1px solid black;"><?= $total[$value[0]['CATEGORY_NAME']]['REAL_PROD'] ?></td>
		<td style="border:1px solid black;"><?= $total[$value[0]['CATEGORY_NAME']]['TARGET'] ?></td>
		<td style="border:1px solid black;"><?= round($total[$value[0]['CATEGORY_NAME']]['KECAPAIAN_TARGET'], 2) ?></td>
	</tr>
	<?php $jml_baris++;?>
</tfoot>
</table>
<p>Prosentase Pencapaian Produksi : <?= round($total[$value[0]['CATEGORY_NAME']]['KECAPAIAN_TARGET'], 2) ?>%</p>
<pagebreak resetpagenum="1" />
<?php
}
?>
</body>
