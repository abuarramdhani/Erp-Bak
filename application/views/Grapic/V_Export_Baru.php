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

							</div>
							<div class="box-body">
								<form target="_blank" method="post" action="<?php echo base_url('openPDF'); ?>">
									<?php for ($y=0; $y < $hitung; $y++) {  ?>
									<script>
										var inde = <?= $hitung ?> ;
									</script>
									<h3><?php $name = 'nama'.$y; echo ${$name}; ?></h3>
									<table border="1" style="overflow-x: scroll; width: 100%; display: block; border-collapse: collapse; text-align: center; padding: 10px;" class="table table-bordered table-hover text-center">
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
												<td>Target Karyawan</td>
												<?php $var1 = 'target'.$y;
												$var2 = 'min'.$y;
												$trgt = ${$var1}[0]+${$var2};
												$trgtjav = ${$var1}[0]+${$var2};
												for ($i=0; $i < 18; $i++) { ?>
												<td colspan="2"><?php echo $trgt = $trgt-${$var2}; ?></td>
												<?php } ?>
												<script>
													targetKaryawan[<?= ($y+1) ?>] = [<?php 
													for($j=0;$j<18;$j++){
														if($j == 17) {
															echo '"'.$trgtjav = ($trgtjav-${$var2}).'"';
														}else{
															echo '"'.$trgtjav = ($trgtjav-${$var2}).'", ';
														}
													}
													?>];
												</script>
											</tr>
											<tr>
												<td>Jml Karyawan</td>
												<?php foreach (${$var1} as $key=>$value) { ?>
												<td colspan="2"><?php echo $value; ?></td>
												<?php } ?>
												<!-- jika kolom ada yang kosong -->
												<?php for ($i=count(${$var1}); $i <18 ; $i++) { ?>
												<td colspan="2"></td>
												<?php } ?>
												<script>
													jumlahKaryawan[<?= ($y+1) ?>] = [<?php 
													for($j=0;$j<count(${$var1});$j++){
														if($j == count(${$var1})-1) {
															echo '"'.${$var1}[$j].'"';
														}else{
															echo '"'.${$var1}[$j].'", ';
														}
													}
													?>];
												</script>
											</tr>
											<tr>
												<td>Trgt Turun Perbulan</td>
												<td>0</td>
												<td>0%</td>
												<?php
												for ($i=0; $i < 17; $i++) { ?>
												<td><?php echo ${$var2}; ?></td>
												<td>1,3%</td>
												<?php } ?>
												<script>
													trgTurunBln[<?= ($y+1) ?>] = ["0", <?php 
													for($j=0;$j<17;$j++){
														if($j == 16) {
															echo '"'.${$var2}.'"';
														}else{
															echo '"'.${$var2}.'", ';
														}
													}
													?>];
												</script>
											</tr>
											<tr>
												<td>Jml Turun Per Bulan</td>
												<td>0</td>
												<td>0%</td>
												<?php for ($i=0; $i < count(${$var1})-1; $i++) { 
													$turun = (${$var1}[$i+1]-${$var1}[$i]); ?>
													<td><?php echo abs($turun); ?></td>
													<td><?php echo abs(round(($turun/${$var1}[$i]*100),1)); ?>%</td>
													<?php } ?>
													<?php for ($i=count(${$var1}); $i <=17 ; $i++) { ?>
													<td></td>
													<td></td>
													<?php } ?>
													<script>
														jumTurunBln[<?= ($y+1) ?>] = ["0", <?php 
														for($j=0;$j<count(${$var1})-1;$j++){
															$midun = (${$var1}[$j+1]-${$var1}[$j]);
															if($j == count(${$var1})-2) {
																echo '"'.abs($midun).'"';
															}else{
																echo '"'.abs($midun).'", ';
															}
														}
														?>];
													</script>
												</tr>
												<tr>
													<td>Trgt Turun Akumulasi</td>
													<td>0</td>
													<td>0%</td>
													<?php $trgaku = 0;
													$trgaku2 = 0;
													for ($i=0; $i < 17 ; $i++) { 
														echo '<td>'.$trgaku = ($trgaku+${$var2}).'</td>';
														echo '<td>'.$trgaku2 = round(($trgaku/${$var1}[0]*100)).'%</td>';
														// echo '<td>'.${$var1}[0].'%</td>';
													} ?>
													<script>
														trgAkumulasi[<?= ($y+1) ?>] = ["0", <?php 
														$trgakumulasi = 0;
														for($j=0;$j<17;$j++){
															if($j == 16) {
																echo '"'.$trgakumulasi = ($trgakumulasi+${$var2}).'"';
															}else{
																echo '"'.$trgakumulasi = ($trgakumulasi+${$var2}).'", ';
															}
														}
														?>];
													</script>
												</tr>
												<tr>
													<td>Jml Turun Akumulasi</td>
													<td>0</td>
													<td>0%</td>
													<?php for ($i=0; $i < count(${$var1})-1; $i++) { 
														$turun = (${$var1}[$i+1]-${$var1}[0]); ?>
														<td><?php echo abs($turun); ?></td>
														<td><?php echo abs(round(($turun/${$var1}[0]*100),1)); ?>%</td>
														<?php } ?>
														<?php for ($i=count(${$var1}); $i <=17 ; $i++) { ?>
														<td></td>
														<td></td>
														<?php } ?>
														<script>
															turAkumulasi[<?= ($y+1) ?>] = ["0", <?php 
															for($j=0;$j<count(${$var1})-1;$j++){
																$midun = (${$var1}[$j+1]-${$var1}[0]);
																if($j == count(${$var1})-2) {
																	echo '"'.abs($midun).'"';
																}else{
																	echo '"'.abs($midun).'", ';
																}
															}
															?>];
														</script>
													</tr>
												</tbody>
											</table>
											<div style="text-align: center;">
												<img width="600" height="300" src="<?php echo $img; ?>">
												<img width="500" height="300" src="<?php echo $img2; ?>">
												<img width="500" height="300" src="<?php echo $img3; ?>">
												<img src="<?php echo $div; ?>">
											</div>
											<?php } 
										 ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>