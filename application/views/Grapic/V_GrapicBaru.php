<style type="text/css">
	.html2canvas-container { width: 1900px !important; height: 430px !important; }
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

							</div>
							<div class="box-body">
								<form method="post" action="<?php echo base_url('SDM/GrapicBaru');?>" class="form-horizontal" enctype="multipart/form-data">
									<div class="panel-body">
										<div class="row">
											<div class="form-group text-center">
												<label for="txtTanggalRekap" class="control-label col-lg-4">Fungsi</label>
												<div class="col-lg-4">
													<!-- <p style="margin-right: 50px;" class="btSDMdl btn btn-primary">Download</p> -->
													<a onclick="return false;" target="_blank" style="margin-right: 50px;" href="<?php echo base_url('SDM/getData');?>" class="btSDMdl btn btn-primary">Download</a>
													<button disabled="" type="button" data-toggle="modal" data-target="#myModalSDM" class="btn btn-primary">Upload</button>
												</div>
												<div class="col-lg-2"></div>
											</div>
											<br/>
											<div class="form-group">
												<label for="cmbDepartemen" class="control-label col-lg-4">Data</label>
												<div class="col-lg-4">
													<select name="txtData" class="form-control" style="width: 100%" required="">
														<option value="14">Semua Data</option>
														<option value="0">Tampilkan Semua Data</option>
														<option value="1">Departemen Produksi</option>
														<option value="2">Departemen Personalia</option>
														<option value="3">Departemen Keuangan</option>
														<option value="4">Departemen Pemasaran</option>
														<option value="5">Departemen Produksi - Pusat</option>
														<option value="6">Departemen Produksi - Tuksono</option>
														<option value="7">Departemen Pemasaran - Pusat</option>
														<option value="8">Departemen Pemasaran - Cabang / Showroom / POS</option>
														<option value="9">Akutansi</option>
														<option value="10">ICT</option>
														<option value="11">IA</option>
														<option value="12">Pengembangan Sistem</option>
														<option value="13">Purchasing</option>
													</select>
												</div>
											</div>
											<br/>
											<div class="form-group">
												<label for="cmbBidang" class="control-label col-lg-4">Dengan PKL</label>
												<div class="col-lg-4">
													<input name="pkl" type="checkbox" class="form-control">
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
											<button name="btSubmit" value="true" class="btn btn-info btn-lg" type="submit">
												Proses
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<script>
							var proses = 'false';
						</script>
						<?php if ($submit == 'true') { 
							?>
							<script>
								proses = 'true';
								var targetKaryawan = [];
								var jumlahKaryawan = [];
								var trgTurunBln = [];
								var jumTurunBln = [];
								var trgAkumulasi = [];
								var turAkumulasi = [];
							</script>
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h2 style="margin-top: 10px;" class="box-title">Rekap Efisiensi SDM <?php echo $pkl; ?></h2>
									<?php if ($hitung < '2') {?>
									<button style="float: right; margin-right: 20px; border-color: none" class="btn btn-primary" id="btnExportSDM">Export PDF</button>
									<?php } ?>
								</div>
								<div  class="box-body">
									<form target="_blank" method="post" action="<?php echo base_url('SDM/exportGambar'); ?>">
										<input name="SDMloop" hidden="" type="text" value="<?php echo ($hitung); ?>">
										<input name="SDMpkl" hidden="" type="text" value="<?php echo $truePKL; ?>">
										<input name="SDMval" hidden="" type="text" value="<?php echo $val; ?>">
										<input name="SDMdiv" hidden="" type="text">
										<?php for ($y=0; $y < $hitung; $y++) {  ?>
										<script>
											var inde = <?= $hitung ?> ;
										</script>
										<h3><?php $name = 'nama'.$y; echo ${$name}; ?></h3>
										<table id="SDMdivToCan" style="overflow-x: scroll; width: 100%; display: block;" class="table table-bordered table-hover text-center">
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
												<canvas id="<?php echo 'myChart'.$y; ?>" width="400" height="150"></canvas>
												<div class="col-md-12">
													<div class="col-md-6">
														<canvas id="<?php echo 'myChartbar'.$y; ?>" width="100" height="50"></canvas>
													</div>
													<div class="col-md-6">
														<canvas id="<?php echo 'myChartbar2'.$y; ?>" width="100" height="50"></canvas>
													</div>
												</div>

												<input name="imyChart" type="hidden">
												<input name="imyChartbar" type="hidden">
												<input name="imyChartbar2" type="hidden">
												<button hidden type="submit" id="btSDMexport">simpan</button>

												<?php } 
											} ?>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Modal -->
		<div id="myModalSDM" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Pilih File</h4>
					</div>
					<div class="modal-body text-center">
						<p>File type : .txt</p>
						<form target="_blank" method="POST" action="<?php echo base_url('SDM/input');?>" class="form-horizontal" enctype="multipart/form-data">
							<input name="fileToUpload" type="file">
							<button class="btn btn-primary" type="submit">Submit</button>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<script>
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
		</script>
		<script src="<?php echo base_url('assets/plugins/html2canvas/html2canvas.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/customGR.js');?>"></script>