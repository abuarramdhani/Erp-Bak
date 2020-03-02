<?php $x = 1; foreach ($list_pr as $key): ?>
<?php if ($x == 4): ?>
	<div class="col-md-1">&nbsp;</div>	
<?php endif ?>

	<div class="col-md-1">
		<label>Minggu <?= $x ?></label>
	</div>
	<div class="col-md-2">
		<select name="minggu[]" class="form-control pss_gs">
			<option></option>
		</select>
	</div>
	<div class="col-md-1 nopad pss_pr_js">
		<?php if ($key['awal']==$key['akhir']): ?>
			<label><?= substr($key['awal'], 8) ?></label>
		<?php else: ?>
			<label><?= substr($key['awal'], 8).' - '.substr($key['akhir'], 8) ?></label>
		<?php endif ?>
	</div>
<?php $x++; endforeach ?>
<div class="col-md-12 text-center">
	<label style="color: red">*List Tanggal Hari Libur di Periode ini : <?= implode(", ", $list_week) ?></label>
</div>

<div class="col-md-12 text-center" style="margin-top: 30px;">
	<button class="btn btn-success" id="pssbtnsmpcr"><i class="fa fa-plus"></i> Tambahkan</button>
</div>

<script type="text/javascript">
	var list_hari_libur = [<?= implode(', ', $list_week) ?>];
	var total_hari = <?= date('d', strtotime($list_pr[count($list_pr)-1]['akhir'])) ?>;
	var arr_total_hari = [];
	for(let i = 1; i <= total_hari; i++){
		arr_total_hari.push(i);
	}
	var createShiftPr = '<?= $pr ?>';
</script>