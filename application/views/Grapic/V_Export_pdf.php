<style type="text/css">
</style>
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
								<!-- <a class="btn btn-dark" target="_blank" href="<?php echo base_url('openPDF'); ?>">Export PDF</a> -->
							</div>
							<div class="box-body">
								<table border="1" style="overflow: scroll; width: 100%; display: block; border-collapse: collapse;" class="table table-bordered table-hover table-striped text-center">
									<thead>
										<tr>
										<td align="center">Ket</td>
										<?php $a = 1; foreach ($akhir as $key=>$value) { ?>
											<td align="center" style="background-color: <?php if ($a%2 == 0) {
												echo "";
											}else{
												echo "";
												} ?>; color: black;" colspan="<?php echo $value; ?>"><?php echo $key; ?></td>
										<?php $a++;} ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td align="center">Tanggal</td>
											<?php foreach ($tgl as $key => $date): ?>
											<td align="center" colspan="2"><?php echo $date->format("m.d"); ?></td>	
											<?php endforeach ?>
										</tr>
										<tr>
											<td align="center">Trgt Karyawan</td>
											<?php foreach ($target as $key) { ?>
												<td align="center" colspan="2"><?php echo $key; ?></td>
											<?php } ?>
										</tr>
										<tr>
											<td align="center">Jml Karyawan</td>
											<?php foreach ($karyawan as $key=>$value) { ?>
												<td align="center" colspan="2"><?php echo $value; ?></td>
											<?php } ?>
											<!-- jika kolom ada yang kosong -->
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
												<td align="center" colspan="2"></td>
											<?php } ?>
										</tr>
										<tr>
											<td align="center">Trgt Turun Per Bulan</td>
											<td align="center">0</td>
											<td align="center">0%</td>
											<?php for ($i=0; $i < 17; $i++) { ?>
												<td align="center">47</td>
												<td align="center">1,3%</td>
											<?php } ?>
										</tr>
										<tr>
											<td align="center">Jml Turun Per Bulan</td>
											<td align="center">0</td>
											<td align="center">0%</td>
											<?php for ($i=0; $i < $banyak-1 ; $i++) { 
												echo '<td align="center">'.$min[$i].'</td>';
												echo '<td align="center">'.$rateup[$i].'%</td>';
											 } ?>
											 <?php for ($i=$banyak; $i <18 ; $i++) { ?>
												<td></td>
												<td></td>
											<?php } ?>
										</tr>
										<tr>
											<td align="center">Trgt Turun Akumulasi</td>
											<td align="center">0</td>
											<td align="center">0%</td>
											<?php for ($i=0; $i < 17 ; $i++) { 
												echo '<td>'.$min2[$i].'</td>';
												echo '<td>'.$rateup2[$i].'%</td>';
											 } ?>
										</tr>
										<tr>
											<td align="center">Jml Turun Akumulasi</td>
											<td align="center">0</td>
											<td align="center">0%</td>
											<?php for ($i=0; $i < $banyak-1 ; $i++) { 
												echo '<td align="center">'.$min3[$i].'</td>';
												echo '<td align="center">'.$rateup3[$i].'%</td>';
											 } ?>
											 <?php for ($i=$banyak; $i <18 ; $i++) { ?>
												<td></td>
												<td></td>
											<?php } ?>
										</tr>
									</tbody>
								</table>
								<div style="text-align: center;">
									<img width="600" height="300" src="<?php echo $img; ?>">
									<img width="500" height="300" src="<?php echo $img2; ?>">
									<img width="500" height="300" src="<?php echo $img3; ?>">
								</div>
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
			echo $min[$i];
		}else{
			echo $min[$i].', ';
		}
	 } ?>];

	 var consta = [<?php for ($i=0; $i < 17 ; $i++) { 
		if($i === 16) {
			echo -47;
		}else{
			echo '-47, ';
		}
	 } ?>];

	 var TurAku = [<?php for ($i=0; $i < $banyak-1 ; $i++) { 
		if($i === $banyak-2) {
			echo $min3[$i];
		}else{
			echo $min3[$i].', ';
		}
	 } ?>];

	 var TrgAku = [<?php for ($i=0; $i < 17 ; $i++) { 
		if($i === 16) {
			echo $min2[$i];
		}else{
			echo $min2[$i].', ';
		}
	 } ?>];
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/customGR.js');?>"></script>