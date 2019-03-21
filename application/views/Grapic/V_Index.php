<style type="text/css">
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-xs hidden-md">
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button style="float: right; margin-right: 20px; border-color: none" class="btn btn-primary" id="bt_trig">Export PDF</button>
							</div>
							<div class="box-body">
								<table style="overflow-x: scroll; width: 100%; display: block;" class="table table-bordered table-hover text-center">
									<thead style="border-color: black">
										<tr>
											<td style="background-color: #00b300; color: white;">Ket</td>
											<?php $a = 1; foreach ($akhir as $key=>$value) { ?>
											<td style="background-color: <?php if ($a%2 == 0) {
												echo "#FF9900";
											}else{
												echo "#3c8dbc";
											} ?>; color: white;" colspan="<?php echo $value; ?>"><?php echo $key; ?></td>
											<?php $a++;} ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Tanggal</td>
											<?php foreach ($tgl as $key => $date): ?>
												<td colspan="2"><?php echo $date->format("m.d"); ?></td>
											<?php endforeach ?>
										</tr>
										<tr>
											<td>Trgt Karyawan</td>
											<?php foreach ($target as $key) { ?>
											<td colspan="2"><?php echo $key; ?></td>
											<input hidden="" class="trgt-karyawan" value="<?php echo $key; ?>">
											<?php } ?>
										</tr>
										<tr>
											<td>Jml Karyawan</td>
											<?php foreach ($karyawan as $key=>$value) { ?>
											<td colspan="2"><?php echo $value; ?></td>
											<?php } ?>
											<!-- jika kolom ada yang kosong -->
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td colspan="2"></td>
											<?php } ?>
										</tr>
										<tr>
											<td>Trgt Turun Per Bulan</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < 17; $i++) { ?>
											<td>47</td>
											<td>1,3%</td>
											<?php } ?>
										</tr>
										<tr>
											<td>Jml Turun Per Bulan</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < $banyak-1 ; $i++) { 
												echo '<td>'.$min[$i].'</td>';
												echo '<td>'.$rateup[$i].'%</td>';
											} ?>
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td></td>
											<td></td>
											<?php } ?>
										</tr>
										<tr>
											<td>Trgt Turun Akumulasi</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < 17 ; $i++) { 
												echo '<td>'.$min2[$i].'</td>';
												echo '<td>'.$rateup2[$i].'%</td>';
											} ?>
										</tr>
										<tr>
											<td>Jml Turun Akumulasi</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < $banyak-1 ; $i++) { 
												echo '<td>'.$min3[$i].'</td>';
												echo '<td>'.$rateup3[$i].'%</td>';
											} ?>
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td></td>
											<td></td>
											<?php } ?>
										</tr>
									</tbody>
								</table>
								<canvas id="myChart" width="400" height="150"></canvas>
								<div class="col-md-12">
									<div class="col-md-6">
										<canvas id="myChartBar" width="100" height="50"></canvas>
									</div>
									<div class="col-md-6">
										<canvas id="myChartBar2" width="100" height="50"></canvas>
									</div>
								</div>
								<form target="_blank" method="post" action="<?php echo base_url('openPDF'); ?>">
									<input type="hidden" name="myChart">
									<input type="hidden" name="myChartBar">
									<input type="hidden" name="myChartBar2">
									<button hidden type="submit" id="bt_export">simpan</button>
								</form>
								<div id="xxxxxxxx"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	var arr = [<?php 
	$jum = count($target);
	$i = 0;
	foreach ($target as $key) {
		if(++$i === $jum) {
			echo $key;
		}else{
			echo $key.', ';
		}
	} ?>];

	var tgl = [<?php 
	$jum2 = 18;
	$a = 0;
	foreach ($tgl as $key => $date) {
		if(++$a === $jum2) {
			echo '"'.$date->format("m.d").'"';
		}else{
			echo '"'.$date->format("m.d").'", ';
		}
	} ?>];

	var kar = [<?php 
	$jum2 = count($karyawan);
	$a = 0;
	foreach ($karyawan as $key ){
		if(++$a === $jum2) {
			echo $key;
		}else{
			echo $key.', ';
		}
	} ?>];

	var jumTur = [<?php for ($i=0; $i < $banyak-1 ; $i++) { 
		if($i === $banyak-2) {
			echo -1*$min[$i];
		}else{
			echo -1*$min[$i].', ';
		}
	} ?>];

	var consta = [<?php for ($i=0; $i < 17 ; $i++) { 
		if($i === 16) {
			echo 47;
		}else{
			echo '47, ';
		}
	} ?>];

	var TurAku = [<?php for ($i=0; $i < $banyak-1 ; $i++) { 
		if($i === $banyak-2) {
			echo -1*$min3[$i];
		}else{
			echo -1*$min3[$i].', ';
		}
	} ?>];

	var TrgAku = [<?php for ($i=0; $i < 17 ; $i++) { 
		if($i === 16) {
			echo -1*$min2[$i];
		}else{
			echo -1*$min2[$i].', ';
		}
	} ?>];
</script>
<script src="<?php echo base_url('assets/plugins/html2canvas/html2canvas.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/customGR.js');?>"></script>