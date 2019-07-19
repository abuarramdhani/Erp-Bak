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
								<form method="post" action="<?php echo base_url('SDM/grapicProduksi');?>" class="form-horizontal" enctype="multipart/form-data">
									<div class="panel-body">
										<div class="row">
											<div class="form-group text-center">
												<label for="txtTanggalRekap" class="control-label col-lg-4">Fungsi</label>
												<div class="col-lg-4">
													<a target="_blank" style="margin-right: 50px;" href="<?php echo base_url('SDM/getData');?>" class="btSDMdl btn btn-primary">Download</a>
													<?php $a =  substr(base_url(), 7,13); ?>
													<button <?php if ($a == 'erp.quick.com') {
														echo "disabled";
													} ?> title="fitur masih tahap pengembangan" type="button" data-toggle="modal" data-target="#myModalSDM" class="btn btn-primary">Upload</button>
												</div>
												<div class="col-lg-2"></div>
											</div>
											<br/>
											<div hidden="" class="form-group">
												<label for="cmbDepartemen" class="control-label col-lg-4">Data</label>
												<div class="col-lg-4">
													<select id="grapicID" name="txtData" class="form-control" style="width: 100%" required="">
														<option value="0">Tampilkan Semua Data</option>
														<option value="14">Semua Data</option>
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
												<label for="cmbBidang" class="control-label col-lg-4">Hitung Dengan PKL, Magang & TKPW</label>
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
									<!-- <button style="float: right; margin-right: 20px; border-color: none" class="btn btn-primary" id="btnExportSDM">Export PDF</button> -->
								</div>
								<div class="box-body">
									<div class="container">
										<div class="text-center">
										<h2 style="margin-top: 10px;" class="box-title">Rekap Efisiensi SDM <?php echo $pkl; ?></h2>
										</div>
										
									</div>
									<div id="exTab2" class="container col-md-12">	
										<!--<ul class="nav nav-tabs text-center">
											<li class="active col-md-4">
												<a  href="#1" data-toggle="tab">Semua Data</a>
											</li>
											<li class="col-md-4">
												<a href="#2" data-toggle="tab">Per Departemen</a>
											</li>
											<li class="col-md-4">
												<a href="#3" data-toggle="tab">Detail</a>
											</li>
										</ul>-->
										<div class="form-group">
										<label for="cmbPilihData" class="control-label col-lg-4 text-right">Pilih Data : </label> 
											<div class="col-lg-6">
											<select id="divselector" class="form-control" >
												<option value="0">Dept. Produksi</option>
												<option value="1">--Dept. Produksi - Pusat</option>
												<option value="2">--Dept. Produksi - Tuksono</option>
												<option value="5">--Dept. Produksi - Melati</option>
												<option disabled="">=============Dept. Produksi (Pekerja Direct/Indirect Labour=============</option>
												<option value="3">--Dept. Produksi - Pekerja Tidak Langsung / InDirect Labour</option>
												<option value="4">--Dept. Produksi - Pekerja Langsung / Direct Labour</option>
												<option disabled="">======================Dept. Produksi Per Seksi======================</option>
												<option value="89">--Dept. Produksi Atasan Seksi</option>
												<option value="6">--Dept. Produksi - Seksi Administrasi Desain</option>
												<option value="7">--Dept. Produksi - Seksi Assembly</option>
												<option value="8">--Dept. Produksi - Seksi Assembly Gear Trans</option>
												<option value="9">--Dept. Produksi - Seksi Assembly-TKS</option>
												<option value="10">--Dept. Produksi - Seksi Cetakan, Pasir Cetak & Inti Cor, Peleburan-Penuangan</option>
												<option value="11">--Dept. Produksi - Seksi Cetakan, Pasir Cetak & Inti Cor, Pel&Pen-TKS</option>
												<option value="12">--Dept. Produksi - Seksi Desain A</option>
												<option value="13">--Dept. Produksi - Seksi Desain B</option>
												<option value="14">--Dept. Produksi - Seksi Desain C</option>
												<option value="15">--Dept. Produksi - Seksi DOJO Desain</option>
												<option value="16">--Dept. Produksi - Seksi DOJO Foundry</option>
												<option value="17">--Dept. Produksi - Seksi DOJO Machining</option>
												<option value="18">--Dept. Produksi - Seksi Finishing</option>
												<option value="19">--Dept. Produksi - Seksi Finishing-TKS</option>
												<option value="20">--Dept. Produksi - Seksi Gudang Blank Material-TKS</option>
												<option value="21">--Dept. Produksi - Seksi Gudang D & E</option>
												<option value="22">--Dept. Produksi - Seksi Gudang Komponen</option>
												<option value="23">--Dept. Produksi - Seksi Gudang Material Dan Bahan Penolong</option>
												<option value="24">--Dept. Produksi - Seksi Gudang Pengadaan dan Blank Material</option>
												<option value="26">--Dept. Produksi - Seksi Gudang Produksi Dan Ekpedisi</option>
												<option value="27">--Dept. Produksi - Seksi Gudang Produksi Dan Ekpedisi-TKS</option>
												<option value="28">--Dept. Produksi - Seksi Heat Treatmen-TKS</option>
												<option value="29">--Dept. Produksi - Seksi Lab. Kimia dan Pasir Cetak</option>
												<option value="30">--Dept. Produksi - Seksi Machining 1</option>
												<option value="88">--Dept. Produksi - Seksi Machining A</option>
												<option value="31">--Dept. Produksi - Seksi Machining A-TKS</option>
												<option value="32">--Dept. Produksi - Seksi Machining B</option>
												<option value="33">--Dept. Produksi - Seksi Machining B-TKS</option>
												<option value="34">--Dept. Produksi - Seksi Machining C</option>
												<option value="35">--Dept. Produksi - Seksi Machining C-TKS</option>
												<option value="36">--Dept. Produksi - Seksi Machining D</option>
												<option value="37">--Dept. Produksi - Seksi Machining D-TKS</option>
												<option value="38">--Dept. Produksi - Seksi Machining E</option>
												<option value="39">--Dept. Produksi - Seksi Machining Prototype</option>
												<option value="40">--Dept. Produksi - Seksi Maintenace</option>
												<option value="41">--Dept. Produksi - Seksi Maintenace-TKS</option>
												<option value="42">--Dept. Produksi - Seksi Maintenace Dan Pengembangan Alat</option>
												<option value="43">--Dept. Produksi - Seksi Maintenace Dan Pengembangan Alat-TKS</option>
												<option value="44">--Dept. Produksi - Seksi Painting Dan Packaging</option>
												<option value="45">--Dept. Produksi - Seksi Painting Dan Packaging-TKS</option>
												<option value="46">--Dept. Produksi - Seksi Penerimaan Barang Gudang</option>
												<option value="47">--Dept. Produksi - Seksi Penerimaan Barang Gudang-TKS</option>
												<option value="48">--Dept. Produksi - Seksi Pengeluaran Barang Gudang</option>
												<option value="49">--Dept. Produksi - Seksi Pengeluaran Barang Gudang-TKS</option>
												<option value="50">--Dept. Produksi - Seksi Pengembangan Prototype A</option>
												<option value="51">--Dept. Produksi - Seksi Pengembangan Prototype B</option>
												<option value="52">--Dept. Produksi - Seksi Pola</option>
												<option value="53">--Dept. Produksi - Seksi Pola/Pattern-TKS</option>
												<option value="54">--Dept. Produksi - Seksi Potong AS</option>
												<option value="55">--Dept. Produksi - Seksi PPC , Gudang dan Administrasi</option>
												<option value="56">--Dept. Produksi - Seksi PPC Tool Making</option>
												<option value="57">--Dept. Produksi - Seksi PPIC</option>
												<option value="58">--Dept. Produksi - Seksi PPIC-TKS</option>
												<option value="59">--Dept. Produksi - Seksi PPIC, Gudang Dan Administrasi-TKS</option>
												<option value="60">--Dept. Produksi - Seksi PPIC Prototype Desain</option>
												<option value="61">--Dept. Produksi - Seksi Production And Inventory ERP Application</option>
												<option value="62">--Dept. Produksi - Seksi Production Engineering</option>
												<option value="63">--Dept. Produksi - Seksi Production Engineering-DOJO</option>
												<option value="64">--Dept. Produksi - Seksi QC Desain, Riset Dan Testing</option>
												<option value="65">--Dept. Produksi - Seksi Quality Assurance</option>
												<option value="66">--Dept. Produksi - Seksi Quality Control</option>
												<option value="67">--Dept. Produksi - Seksi Quality Control-TKS</option>
												<option value="68">--Dept. Produksi - Seksi Quality Engineering</option>
												<option value="69">--Dept. Produksi - Seksi Quality - TKS</option>
												<option value="70">--Dept. Produksi - Seksi Rekayasa Dan Rebuilding Mensin</option>
												<option value="71">--Dept. Produksi - Seksi Riset Dan Testing Alat Uji</option>
												<option value="72">--Dept. Produksi - Seksi Riset Dan Testing Cultivator</option>
												<option value="73">--Dept. Produksi - Seksi Riset Dan Testing Harvester</option>
												<option value="74">--Dept. Produksi - Seksi Riset Dan Testing Pengembangan</option>
												<option value="75">--Dept. Produksi - Seksi Riset Dan Testing PPIC</option>
												<option value="76">--Dept. Produksi - Seksi Riset Dan Testing Quick Truck</option>
												<option value="77">--Dept. Produksi - Seksi Riset Dan Testing Traktor 2W</option>
												<option value="78">--Dept. Produksi - Seksi Riset Dan Testing Traktor 4W</option>
												<option value="79">--Dept. Produksi - Seksi Sheet Metal-TKS</option>
												<option value="80">--Dept. Produksi - Seksi Tool Making 1</option>
												<option value="81">--Dept. Produksi - Seksi Tool Making A</option>
												<option value="82">--Dept. Produksi - Seksi Tool Making B</option>
												<option value="83">--Dept. Produksi - Seksi Tool Warehouse</option>
												<option value="84">--Dept. Produksi - Seksi Tool Warehouse-TKS</option>
												<option value="85">--Dept. Produksi - Seksi Welding A</option>
												<option value="86">--Dept. Produksi - Seksi Welding B</option>
												<option value="87">--Dept. Produksi - Seksi Welding-TKS</option>
											</select>
											</div>
										</div>
									<br>
										<div class="container" style="width: 100%">
											<!-- div 1 -->
											<!--<div class="tab-pane active" id="1">-->
												<form target="_blank" method="post" action="<?php echo base_url('SDM/exportGambar'); ?>">
													<input name="SDMloop" hidden="" type="text" value="<?php echo ($hitung); ?>">
													<input name="SDMpkl" hidden="" type="text" value="<?php echo $truePKL; ?>">
													<input name="SDMval" hidden="" type="text" value="<?php echo $val; ?>">
													<input name="SDMdiv" hidden="" type="text">
													<?php for ($y=0; $y <= 89; $y++) { ?>
													<script>
														var inde = <?= $hitung ?> ;
													</script>
													<div id="<?php echo $y; ?>">
													<h3><?php $name = 'nama'.$y; echo ${$name}; ?></h3>
													<table id="<?php echo 'SDMdivToCan'.$y; ?>" style="overflow-x: scroll; width: 100%; display: block;" class="table table-bordered table-hover text-center">
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
																$varAg = 'minAg'.$y;
																$trgt = ${$var1}[0]+${$varAg};
																$trgtjav = ${$var1}[0]+${$varAg};
																for ($i=0; $i < 26; $i++) { ?>
																<?php if ($i > 17): ?>
																	<td colspan="2"><?php echo $trgt = $trgt-${$var2}; ?></td>
																<?php else: ?>
																	<td colspan="2"><?php echo $trgt = $trgt-${$varAg}; ?></td>
																<?php endif ?>
																<?php } ?>
																<script>
																	targetKaryawan[<?= ($y+1) ?>] = [<?php 
																	for($j=0;$j<26;$j++){
																		if($j == 25) {
																			echo '"'.$trgtjav = ($trgtjav-${$var2}).'"';
																		}else{
																			if ($j > 17) {
																				echo '"'.$trgtjav = ($trgtjav-${$var2}).'", ';
																			}else{
																				echo '"'.$trgtjav = ($trgtjav-${$varAg}).'", ';
																			}
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
																<?php for ($i=count(${$var1}); $i <26 ; $i++) { ?>
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
																for ($i=0; $i < 25; $i++) { ?>
																<?php if ($i > 16): ?>
																	<td><?php echo ${$var2}; ?></td>
																	<td><?php echo round(${$var2}/${$var1}[0]*100,1) ?>%</td>
																<?php else: ?>
																	<td><?php echo ${$varAg}; ?></td>
																	<td><?php echo round(${$varAg}/${$var1}[0]*100,1) ?>%</td>
																<?php endif ?>
																<?php } ?>
																<script>
																	trgTurunBln[<?= ($y+1) ?>] = ["0", <?php 
																	for($j=0;$j<25;$j++){
																		if($j == 24) {
																			echo '"'.${$var2}.'"';
																		}else{
																			if ($j > 16) {
																				echo '"'.${$var2}.'", ';
																			}else{
																				echo '"'.${$varAg}.'", ';
																			}
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
																	<td><?php if (${$var1}[$i]==0) {
																		echo "0";
																	}else {echo abs(round(($turun/${$var1}[$i]*100),1));} ?>%</td>
																	<?php } ?>
																	<?php for ($i=count(${$var1}); $i <=25 ; $i++) { ?>
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
																	for ($i=0; $i < 25 ; $i++) { 
																		if ($i > 16) {
																			echo '<td>'.$trgaku = ($trgaku+${$var2}).'</td>';
																			echo '<td>'.$trgaku2 = round(($trgaku/${$var1}[0]*100),1).'%</td>';
																		}else{
																			echo '<td>'.$trgaku = ($trgaku+${$varAg}).'</td>';
																			echo '<td>'.$trgaku2 = round(($trgaku/${$var1}[0]*100),1).'%</td>';
																		}
																	} ?>
																	<script>
																		trgAkumulasi[<?= ($y+1) ?>] = ["0", <?php 
																		$trgakumulasi = 0;
																		for($j=0;$j<25;$j++){
																			if($j == 24) {
																				echo '"'.$trgakumulasi = ($trgakumulasi+${$var2}).'"';
																			}else{
																				if ($j > 16) {
																					echo '"'.$trgakumulasi = ($trgakumulasi+${$var2}).'", ';
																				}else{
																					echo '"'.$trgakumulasi = ($trgakumulasi+${$varAg}).'", ';
																				}
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
																		<?php for ($i=count(${$var1}); $i <=25 ; $i++) { ?>
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
															<canvas id="<?php echo 'myChart'.$y; ?>" class="wadaw" width="400" height="150" value="1"></canvas>
															<div class="col-md-12">
																<div class="col-md-6">
																	<canvas id="<?php echo 'myChartbar1'.$y; ?>" width="100" height="50"></canvas>
																</div>
																<div class="col-md-6">
																	<canvas id="<?php echo 'myChartbar2'.$y; ?>" width="100" height="50"></canvas>
																</div>
															</div>

															<input name="imyChart" type="hidden">
															<input name="imyChartbar" type="hidden">
															<input name="imyChartbar2" type="hidden">
															<button hidden type="submit" id="btSDMexport">simpan</button>
															</div>															
															<?php } ?>
																			
																		</div>
																	</div>
																</div>
																<?php } ?>

													

															</form>
														<!--</div> end div tab-->
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
												<input required="" name="fileToUpload" type="file">
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
								$jum2 = 26;
								$a = 0;
								foreach ($tgl as $key => $date) {
									if(++$a === $jum2) {
										echo '"'.$date->format("m.d").'"';
									}else{
										echo '"'.$date->format("m.d").'", ';
									}
								} ?>];
							</script>
							<button onclick="topFunction()" id="myBtn" style="display: none;  position: fixed;  bottom: 20px;  right: 30px;  z-index: 99;  font-size: 18px;  border: none; outline: none; background-color: red;  color: white; cursor: pointer; padding: 15px; border-radius: 4px;" title="Go to top">Go To Top</button>
							<script>
							// When the user scrolls down 20px from the top of the document, show the button
							window.onscroll = function() {scrollFunction()};

							function scrollFunction() {
							  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
							    document.getElementById("myBtn").style.display = "block";
							  } else {
							    document.getElementById("myBtn").style.display = "none";
							  }
							}

							// When the user clicks on the button, scroll to the top of the document
							function topFunction() {
							  document.body.scrollTop = 0;
							  document.documentElement.scrollTop = 0;
							}
							</script>
							<script src="<?php echo base_url('assets/plugins/html2canvas/html2canvas.min.js');?>"></script>
							<script type="text/javascript" src="<?php echo base_url('assets/js/customGR.js');?>"></script>