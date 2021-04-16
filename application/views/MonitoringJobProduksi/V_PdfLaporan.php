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
<div class="row" style="padding-left:0px;padding-right:0px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 20px">Laporan Produksi <?= substr($data['kategori'],3) ?></td>
    </tr>
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 12px"><?= date('l, d  F  Y')?></td>
    </tr>
    <tr>
        <td style="border-bottom:0px solid black; border-collapse: collapse;text-align:center;font-size: 12px"><?= ($tanggal)?>/<?= ($data['hari'] - 4)?> hari kerja = <?= round((($tanggal)/($data['hari'] - 4)) * 100, 2)?>% </td>
    </tr>
</table>
</div>
<br>
<?php if ($data['kategori'] != 'SPAREPART') { // tampilan jika kategori bukan sparepart ?>
<table class="table table-bordered hor-center ver-center" repeat_header="1">
<thead>
	<tr style="background-color: #f0f0f0;" class="table-head">
        <!-- <th rowspan="2" style="width: 3%;border:1px solid black;">No</th> -->
        <th rowspan="2" style="border:1px solid black;">Produk</th>
        <th colspan="<?= $data['hari']?>" style="border:1px solid black;">Produksi</th>
        <th rowspan="2" style="border:1px solid black;">Real Prod</th>
        <th rowspan="2" style="border:1px solid black;">Target</th>
        <th rowspan="2" style="border:1px solid black;">Pencapaian Produksi (%)</th>
	</tr>
	<tr style="background-color: #f0f0f0;" class="table-head">
		<?php for ($i=0; $i < $data['hari']; $i++) { ?>
        <th class="text-nowrap" style="border:1px solid black;"><?= $i+1?></th>
		<?php }?>
	</tr>
</thead>
<tbody>
	<?php $no=1; foreach ($data['value'] as $val) { ?>
            <tr class=" table-line">
                <!-- <td style="border:1px solid black;"><?= $no?></td> -->
                <td style="border:1px solid black;"><?= $val['item'] ?></td>
				<?php for ($i=0; $i < $data['hari']; $i++) { ?>
                <td style="border:1px solid black;"><?= $val['tanggal'.($i+1).''] ?></td>
				<?php }?>
                <td style="border:1px solid black;"><?= $val['real_prod'] ?></td>
                <td style="border:1px solid black;"><?= $val['target'] ?></td>
                <td style="border:1px solid black;"><?= $val['kecapaian'] ?></td>
            </tr>
	<?php $no++;  }?>
</tbody>
</tfoot>
	<tr class=" table-line">
		<td style="border:1px solid black;">Total</td>
		<?php for ($i=0; $i < $data['hari']; $i++) { ?>
		<td style="border:1px solid black;"><?= $data['ttl_tgl'.($i+1).''] ?></td>
		<?php }?>
		<td style="border:1px solid black;"><?= $data['ttl_real'] ?></td>
		<td style="border:1px solid black;"><?= $data['ttl_target'] ?></td>
		<td style="border:1px solid black;"><?= $data['ttl_kecapaian'] ?></td>
	</tr>
</tfoot>
</table>
<p>Prosentase Pencapaian Produksi : <?= $data['ttl_kecapaian'] ?>%</p>

<?php }else{ //tampilan khusus kategori sparepart ?>
<table class="table table-bordered hor-center ver-center" repeat_header="1">
<thead>
	<tr style="background-color: #f0f0f0;" class="table-head">
        <!-- <th rowspan="2" style="width: 3%;border:1px solid black;">No</th> -->
        <th rowspan="2" style="border:1px solid black;">Produk</th>
        <th colspan="<?= $data['hari']?>" style="border:1px solid black;">Produksi</th>
        <th rowspan="2" style="border:1px solid black;">Target</th>
        <th rowspan="2" style="border:1px solid black;">WOS / JOB</th>
        <th rowspan="2" style="border:1px solid black;">% JOB PPIC</th>
        <th rowspan="2" style="border:1px solid black;">Completion INT-ASSY + NO PACKG</th>
        <th rowspan="2" style="border:1px solid black;">% Completion ASSY</th>
        <th rowspan="2" style="border:1px solid black;">In YSP</th>
        <th rowspan="2" style="border:1px solid black;">YSP</th>
	</tr>
	<tr style="background-color: #f0f0f0;" class="table-head">
		<?php for ($i=0; $i < $data['hari']; $i++) { ?>
        <th class="text-nowrap" style="border:1px solid black;"><?= $i+1?></th>
		<?php }?>
	</tr>
</thead>
<tbody>
	<?php $no=1; foreach ($data['value'] as $val) { ?>
            <tr class=" table-line">
                <!-- <td style="border:1px solid black;"><?= $no?></td> -->
                <td style="border:1px solid black;"><?= $val['item'] ?></td>
				<?php for ($i=0; $i < $data['hari']; $i++) { ?>
                <td style="border:1px solid black;"><?= $val['tanggal'.($i+1).''] ?></td>
				<?php }?>
                <td style="border:1px solid black;"><?= $val['target'] ?></td>
                <td style="border:1px solid black;"><?= $val['wosjob'] ?></td>
                <td style="border:1px solid black;"><?= $val['wosjob2'] ?></td>
                <td style="border:1px solid black;"><?= $val['completion'] ?></td>
                <td style="border:1px solid black;"><?= $val['completion2'] ?></td>
                <td style="border:1px solid black;"><?= $val['real_prod'] ?></td>
                <td style="border:1px solid black;"><?= $val['kecapaian'] ?></td>
            </tr>
	<?php $no++;  }?>
</tbody>
</tfoot>
	<tr class=" table-line">
		<td style="border:1px solid black;">Total</td>
		<?php for ($i=0; $i < $data['hari']; $i++) { ?>
		<td style="border:1px solid black;"><?= $data['ttl_tgl'.($i+1).''] ?></td>
		<?php }?>
		<td style="border:1px solid black;"><?= $data['ttl_target'] ?></td>
		<td style="border:1px solid black;"><?= $data['ttl_wosjob'] ?></td>
		<td style="border:1px solid black;"><?= $data['ttl_wosjob2'] ?></td>
		<td style="border:1px solid black;"><?= $data['ttl_completion'] ?></td>
		<td style="border:1px solid black;"><?= $data['ttl_completion2'] ?></td>
		<td style="border:1px solid black;"><?= $data['ttl_real'] ?></td>
		<td style="border:1px solid black;"><?= $data['ttl_kecapaian'] ?></td>
	</tr>
</tfoot>
</table>
<p>Note -</p>
<?php }?>
</body>
