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
<?php foreach ($data as $key => $value) {
	$target_laju = ($hari - 4) - $tanggal == 0 ? 0 : round(($total[$key]['TARGET'] - $total[$key]['REAL_PROD'])/ (($hari - 4) - $tanggal));
	$satuan_laju = $value[0]['ID_CATEGORY'] == 15 || $value[0]['ID_CATEGORY'] == 19 || $value[0]['ID_CATEGORY'] == 13 || $value[0]['ID_CATEGORY'] == 14 ? 'pcs' : 'unit';
?>
<div class="row" style="padding-left:0px;padding-right:0px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 20px">Laporan Produksi <?= substr($key,3) ?></td>
    </tr>
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 12px"><?= date('l, d  F  Y')?></td>
    </tr>
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 12px"><?= ($tanggal)?>/<?= ($hari - 4)?> hari kerja = <?= round((($tanggal)/($hari - 4)) * 100, 2)?>% </td>
    </tr>
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 12px">Target laju saat ini : <?= $target_laju.' '.$satuan_laju?></td>
    </tr>
</table>
</div>
<br>
<?php if ($value[0]['ID_CATEGORY'] == 15 || $value[0]['ID_CATEGORY'] == 19) { // tampilan jika kategori sparepart ?>
<table class="table table-bordered hor-center ver-center" repeat_header="1">
<thead>
	<tr style="background-color: #f0f0f0;" class="table-head">
        <!-- <th rowspan="2" style="width: 3%;border:1px solid black;">No</th> -->
        <th rowspan="2" style="border:1px solid black;">Produk</th>
        <th colspan="<?= $hari?>" style="border:1px solid black;">Produksi</th>
        <th rowspan="2" style="border:1px solid black;">Target</th>
        <th rowspan="2" style="border:1px solid black;">WOS / JOB</th>
        <th rowspan="2" style="border:1px solid black;">% JOB PPIC</th>
        <th rowspan="2" style="border:1px solid black;">Completion INT-ASSY + NO PACKG</th>
        <th rowspan="2" style="border:1px solid black;">% Completion ASSY</th>
        <th rowspan="2" style="border:1px solid black;">In YSP</th>
        <th rowspan="2" style="border:1px solid black;">YSP</th>
	</tr>
	<tr style="background-color: #f0f0f0;" class="table-head">
		<?php for ($i=0; $i < $hari; $i++) { ?>
        <th class="text-nowrap" style="border:1px solid black;"><?= $i+1?></th>
		<?php }?>
	</tr>
</thead>
<tbody>
	<?php $no=1; 
		$total_wos = $total_comp = $total_real = 0;
		foreach ($value as $val) { 
        $wosjob 	= number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['WOS_JOB'] / $val['TARGET']) * 100 : 0 ,2);
        $completion = number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['COMPLETION'] / $val['TARGET']) * 100 : 0 ,2);
        $kecapaian 	= number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['REAL_PROD'] / $val['TARGET']) * 100 : 0 ,2);
        $wos        = $val['WOS_JOB'] > $val['TARGET'] ? $val['TARGET'] : $val['WOS_JOB'];
        $comp       = $val['COMPLETION'] > $val['TARGET'] ? $val['TARGET'] : $val['COMPLETION'];
        $real       = $val['REAL_PROD'] > $val['TARGET'] ? $val['TARGET'] : $val['REAL_PROD'];
        $total_wos  += $wos;
        $total_comp  += $comp;
        $total_real  += $real;
	?>
            <tr class=" table-line">
                <!-- <td style="border:1px solid black;"><?= $no?></td> -->
                <td style="border:1px solid black;"><?= $val['DESKRIPSI'] ?></td>
				<?php for ($i=0; $i < $hari; $i++) { 
					$tgl = sprintf("%02d", $i+1); ?>
                <td style="border:1px solid black;"><?= $val['TANGGAL'.($tgl).''] == 0 ? '' : $val['TANGGAL'.($tgl).'']; ?></td>
				<?php }?>
                <td style="border:1px solid black;"><?= $val['TARGET'] ?></td>
                <td style="border:1px solid black;"><?= $wos ?></td>
                <td style="border:1px solid black;"><?= $wosjob > 100 ? number_format(100,2) : $wosjob ?></td>
                <td style="border:1px solid black;"><?= $comp ?></td>
                <td style="border:1px solid black;"><?= $completion > 100 ? number_format(100,2) : $completion ?></td>
                <td style="border:1px solid black;"><?= $real ?></td>
                <td style="border:1px solid black;"><?= $kecapaian > 100 ? number_format(100,2) : $kecapaian ?></td>
            </tr>
	<?php $no++;  }?>
</tbody>
</tfoot>
	<?php $ttl_wosjob = number_format(!empty($total[$key]['TARGET']) && $total[$key]['TARGET'] != 0 ? ($total_wos / $total[$key]['TARGET']) * 100 : 0 ,2);
		$ttl_comp 	= number_format(!empty($total[$key]['TARGET']) && $total[$key]['TARGET'] != 0 ? ($total_comp / $total[$key]['TARGET']) * 100 : 0 ,2);
		$ttl_capai 	= number_format(!empty($total[$key]['TARGET']) && $total[$key]['TARGET'] != 0 ? ($total_real / $total[$key]['TARGET']) * 100 : 0 ,2);
        $wosjobnya	= $total_wos > $total[$key]['TARGET'] ? $total[$key]['TARGET'] : $total_wos;
        $compnya	= $total_comp > $total[$key]['TARGET'] ? $total[$key]['TARGET'] : $total_comp;
        $pencapaian	= $total_real > $total[$key]['TARGET'] ? $total[$key]['TARGET'] : $total_real;
	?>
	<tr class=" table-line">
		<td style="border:1px solid black;">Total</td>
		<?php for ($i=0; $i < $hari; $i++) { 
			$tgl = sprintf("%02d", $i+1); ?>
		<td style="border:1px solid black;"><?= $total[$key]['TANGGAL'.($tgl).''] ?></td>
		<?php }?>
		<td style="border:1px solid black;"><?= $total[$key]['TARGET'] ?></td>
		<td style="border:1px solid black;"><?= $wosjobnya ?></td>
		<td style="border:1px solid black;"><?= $ttl_wosjob > 100 ? number_format(100,2) : $ttl_wosjob; ?></td>
		<td style="border:1px solid black;"><?= $compnya ?></td>
		<td style="border:1px solid black;"><?= $ttl_comp > 100 ? number_format(100,2) : $ttl_comp;?></td>
		<td style="border:1px solid black;"><?= $pencapaian ?></td>
		<td style="border:1px solid black;"><?= $ttl_capai > 100 ? number_format(100,2) : $ttl_capai; ?></td>
	</tr>
</tfoot>
</table>
<p>Note  -</p>
<?php }else{ //tampilan bukan kategori sparepart ?>
<table class="table table-bordered hor-center ver-center" repeat_header="1">
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
	<?php foreach ($value as $val) {	?>
            <tr class=" table-line">
                <!-- <td style="border:1px solid black;"><?= $no?></td> -->
                <td style="border:1px solid black;"><?= $val['DESKRIPSI'] ?></td>
				<?php for ($i=0; $i < $hari; $i++) { 
					$tgl = sprintf("%02d", $i+1); ?>
                <td style="border:1px solid black;"><?= $val['TANGGAL'.($tgl).''] == 0 ? '' : $val['TANGGAL'.($tgl).'']; ?></td>
				<?php }?>
                <td style="border:1px solid black;"><?= $val['REAL_PROD'] ?></td>
                <td style="border:1px solid black;"><?= $val['TARGET'] ?></td>
                <td style="border:1px solid black;"><?= number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['REAL_PROD'] / $val['TARGET']) * 100 : 0 ,2)?></td>
            </tr>
    <?php $no++;  } ?>
</tbody>
</tfoot>
	<tr class=" table-line">
		<td style="border:1px solid black;">Total</td>
		<?php for ($i=0; $i < $hari; $i++) { 
			$tgl = sprintf("%02d", $i+1); ?>
		<td style="border:1px solid black;"><?= $total[$key]['TANGGAL'.($tgl).''] ?></td>
		<?php }?>
		<td style="border:1px solid black;"><?= $total[$key]['REAL_PROD'] ?></td>
		<td style="border:1px solid black;"><?= $total[$key]['TARGET'] ?></td>
		<td style="border:1px solid black;"><?= number_format(!empty($total[$key]['TARGET']) && $total[$key]['TARGET'] != 0 ? ($total[$key]['REAL_PROD'] / $total[$key]['TARGET']) * 100 : 0 ,2)?></td>
	</tr>
</tfoot>
</table>
<p>Prosentase Pencapaian Produksi : <?= number_format(!empty($total[$key]['TARGET']) && $total[$key]['TARGET'] != 0 ? ($total[$key]['REAL_PROD'] / $total[$key]['TARGET']) * 100 : 0 ,2)?> %</p>
<?php }?>
<pagebreak resetpagenum="1" />
<?php
}
?>
</body>
