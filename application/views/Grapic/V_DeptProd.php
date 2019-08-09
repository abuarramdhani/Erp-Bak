<style type="text/css">
	html, body { scroll-behavior: smooth; }
	td { height: 60px; }
	thead tr th { height: auto; }
	.dataTable tbody tr td { height: auto; }
	.fixed-column { position: absolute; background: white; width: 100px; left: 16px; margin-bottom: 2px; }
</style>
<script>
	const proses = <?= $submit ?>;
	const filterData = '<?= $filterData ?>';
	const withPKL = '<?= $withPKL ?>';
</script>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left" style="margin-top: -12px; margin-bottom: 18px;">
							<h1 style="font-weight: bold"><?= $Title ?></h1>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<form method="post" action="<?php echo base_url('SDM/grapicProduksi');?>" class="form-horizontal" enctype="multipart/form-data">
									<div class="panel-body">
										<div class="col-lg-12" style="padding: 0">
											<div class="col-lg-8" style="padding: 0">
												<div class="col-lg-1 text-left" style="padding: 0; margin-right: 16px;">
													<label class="control-label">Aksi :</label>
												</div>
												<div class="col-lg-7 text-left" style="padding: 0">
													<a disabled title="Fitur masih dalam tahap pengembangan" class="btn btn-primary" style="margin-right: 6px;"><i class="fa fa-download" style="margin-right: 8px;"></i>Download</a>
													<a disabled title="Fitur masih dalam tahap pengembangan" class="btn btn-primary"><i class="fa fa-upload" style="margin-right: 8px;"></i>Upload</a>
													<!-- <a target="_blank" style="margin-right: 6px;" href="<?= base_url('SDM/getData'); ?>" class="btSDMdl btn btn-primary"><i class="fa fa-download" style="margin-right: 8px;"></i>Download</a> -->
													<!-- <a <?= (substr(base_url(), 7, 13) == 'erp.quick.com') ? 'disabled' : 'data-toggle="modal" data-target="#myModalSDM"' ?> title="Fitur masih dalam tahap pengembangan" type="button" class="btn btn-primary"><i class="fa fa-upload" style="margin-right: 8px;"></i>Upload</a> -->	
												</div>
											</div>
											<div class="col-lg-4 text-right" style="padding: 0">
												<input style="display: none;" id="pkl-checkbox" name="withPKL" type="checkbox" class="form-control">
												<label for="pkl-checkbox" class="control-label" style="margin-left: 8px; padding-top: 2px; cursor: pointer;">Hitung dengan PKL, Magang & TKPW</label>
											</div>
										</div>
										<div class="col-lg-12"  style="margin-top: 12px; padding: 0;">
											<div class="col-lg-8 text-left" style="padding: 0">
												<div class="col-lg-1" style="padding: 0; margin-right: 16px;">
													<label class="control-label">Data :</label>
												</div>
												<div class="col-lg-7" style="padding: 0;">
													<select disabled name="filterData" id="filter-data" class="form-control" style="width: 100%;" required>
														<option id="filter-data-loading" value="0">Memuat data...</option>
														<option value="1">-- Dept. Produksi - Pusat</option>
														<option value="2">-- Dept. Produksi - Tuksono</option>
														<option value="5">-- Dept. Produksi - Melati</option>
														<option style="font-weight: bolder;" disabled>========== Dept. Produksi (Pekerja Direct/Indirect Labour ==========</option>
														<option value="tabelseksi">-- Pekerja Langsung & Tidak Langsung Per Seksi Dept.Produksi</option>
														<option value="11">-- Dept. Produksi - Pekerja Tidak Langsung / InDirect Labour</option>
														<option value="12">-- Dept. Produksi - Pekerja Langsung / Direct Labour</option>
														<option style="font-weight: bolder;" disabled>====================== Dept. Produksi Per Seksi ======================</option>
														<option value="89">-- Dept. Produksi Atasan Seksi</option>
														<option value="6">-- Dept. Produksi - Seksi Administrasi Desain</option>
														<option value="7">-- Dept. Produksi - Seksi Assembly</option>
														<option value="8">-- Dept. Produksi - Seksi Assembly Gear Trans</option>
														<option value="9">-- Dept. Produksi - Seksi Assembly-TKS</option>
														<option value="10">-- Dept. Produksi - Seksi Cetakan, Pasir Cetak & Inti Cor, Peleburan-Penuangan</option>
														<option value="3">-- Dept. Produksi - Seksi Cetakan, Pasir Cetak & Inti Cor, Pel&Pen-TKS</option>
														<option value="4">-- Dept. Produksi - Seksi Desain A</option>
														<option value="13">-- Dept. Produksi - Seksi Desain B</option>
														<option value="14">-- Dept. Produksi - Seksi Desain C</option>
														<option value="15">-- Dept. Produksi - Seksi DOJO Desain</option>
														<option value="16">-- Dept. Produksi - Seksi DOJO Foundry</option>
														<option value="17">-- Dept. Produksi - Seksi DOJO Machining</option>
														<option value="18">-- Dept. Produksi - Seksi Finishing</option>
														<option value="19">-- Dept. Produksi - Seksi Finishing-TKS</option>
														<option value="20">-- Dept. Produksi - Seksi Gudang Blank Material-TKS</option>
														<option value="21">-- Dept. Produksi - Seksi Gudang D & E</option>
														<option value="22">-- Dept. Produksi - Seksi Gudang Komponen</option>
														<option value="23">-- Dept. Produksi - Seksi Gudang Material Dan Bahan Penolong</option>
														<option value="24">-- Dept. Produksi - Seksi Gudang Pengadaan dan Blank Material</option>
														<option value="26">-- Dept. Produksi - Seksi Gudang Produksi Dan Ekpedisi</option>
														<option value="27">-- Dept. Produksi - Seksi Gudang Produksi Dan Ekpedisi-TKS</option>
														<option value="28">-- Dept. Produksi - Seksi Heat Treatmen-TKS</option>
														<option value="29">-- Dept. Produksi - Seksi Lab. Kimia dan Pasir Cetak</option>
														<option value="30">-- Dept. Produksi - Seksi Machining 1</option>
														<option value="88">-- Dept. Produksi - Seksi Machining A</option>
														<option value="31">-- Dept. Produksi - Seksi Machining A-TKS</option>
														<option value="32">-- Dept. Produksi - Seksi Machining B</option>
														<option value="33">-- Dept. Produksi - Seksi Machining B-TKS</option>
														<option value="34">-- Dept. Produksi - Seksi Machining C</option>
														<option value="35">-- Dept. Produksi - Seksi Machining C-TKS</option>
														<option value="36">-- Dept. Produksi - Seksi Machining D</option>
														<option value="37">-- Dept. Produksi - Seksi Machining D-TKS</option>
														<option value="38">-- Dept. Produksi - Seksi Machining E</option>
														<option value="39">-- Dept. Produksi - Seksi Machining Prototype</option>
														<option value="40">-- Dept. Produksi - Seksi Maintenace</option>
														<option value="41">-- Dept. Produksi - Seksi Maintenace-TKS</option>
														<option value="42">-- Dept. Produksi - Seksi Maintenace Dan Pengembangan Alat</option>
														<option value="43">-- Dept. Produksi - Seksi Maintenace Dan Pengembangan Alat-TKS</option>
														<option value="44">-- Dept. Produksi - Seksi Painting Dan Packaging</option>
														<option value="45">-- Dept. Produksi - Seksi Painting Dan Packaging-TKS</option>
														<option value="46">-- Dept. Produksi - Seksi Penerimaan Barang Gudang</option>
														<option value="47">-- Dept. Produksi - Seksi Penerimaan Barang Gudang-TKS</option>
														<option value="48">-- Dept. Produksi - Seksi Pengeluaran Barang Gudang</option>
														<option value="49">-- Dept. Produksi - Seksi Pengeluaran Barang Gudang-TKS</option>
														<option value="50">-- Dept. Produksi - Seksi Pengembangan Prototype A</option>
														<option value="51">-- Dept. Produksi - Seksi Pengembangan Prototype B</option>
														<option value="52">-- Dept. Produksi - Seksi Pola</option>
														<option value="53">-- Dept. Produksi - Seksi Pola/Pattern-TKS</option>
														<option value="54">-- Dept. Produksi - Seksi Potong AS</option>
														<option value="55">-- Dept. Produksi - Seksi PPC , Gudang dan Administrasi</option>
														<option value="56">-- Dept. Produksi - Seksi PPC Tool Making</option>
														<option value="57">-- Dept. Produksi - Seksi PPIC</option>
														<option value="58">-- Dept. Produksi - Seksi PPIC-TKS</option>
														<option value="59">-- Dept. Produksi - Seksi PPIC, Gudang Dan Administrasi-TKS</option>
														<option value="60">-- Dept. Produksi - Seksi PPIC Prototype Desain</option>
														<option value="61">-- Dept. Produksi - Seksi Production And Inventory ERP Application</option>
														<option value="62">-- Dept. Produksi - Seksi Production Engineering</option>
														<option value="63">-- Dept. Produksi - Seksi Production Engineering-DOJO</option>
														<option value="64">-- Dept. Produksi - Seksi QC Desain, Riset Dan Testing</option>
														<option value="65">-- Dept. Produksi - Seksi Quality Assurance</option>
														<option value="66">-- Dept. Produksi - Seksi Quality Control</option>
														<option value="67">-- Dept. Produksi - Seksi Quality Control-TKS</option>
														<option value="68">-- Dept. Produksi - Seksi Quality Engineering</option>
														<option value="69">-- Dept. Produksi - Seksi Quality - TKS</option>
														<option value="70">-- Dept. Produksi - Seksi Rekayasa Dan Rebuilding Mensin</option>
														<option value="71">-- Dept. Produksi - Seksi Riset Dan Testing Alat Uji</option>
														<option value="72">-- Dept. Produksi - Seksi Riset Dan Testing Cultivator</option>
														<option value="73">-- Dept. Produksi - Seksi Riset Dan Testing Harvester</option>
														<option value="74">-- Dept. Produksi - Seksi Riset Dan Testing Pengembangan</option>
														<option value="75">-- Dept. Produksi - Seksi Riset Dan Testing PPIC</option>
														<option value="76">-- Dept. Produksi - Seksi Riset Dan Testing Quick Truck</option>
														<option value="77">-- Dept. Produksi - Seksi Riset Dan Testing Traktor 2W</option>
														<option value="78">-- Dept. Produksi - Seksi Riset Dan Testing Traktor 4W</option>
														<option value="79">-- Dept. Produksi - Seksi Sheet Metal-TKS</option>
														<option value="80">-- Dept. Produksi - Seksi Tool Making 1</option>
														<option value="81">-- Dept. Produksi - Seksi Tool Making A</option>
														<option value="82">-- Dept. Produksi - Seksi Tool Making B</option>
														<option value="83">-- Dept. Produksi - Seksi Tool Warehouse</option>
														<option value="84">-- Dept. Produksi - Seksi Tool Warehouse-TKS</option>
														<option value="85">-- Dept. Produksi - Seksi Welding A</option>
														<option value="86">-- Dept. Produksi - Seksi Welding B</option>
														<option value="87">-- Dept. Produksi - Seksi Welding-TKS</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-12 text-right" style="margin-bottom: 12px;">
										<button name="buttonSubmit" value="true" class="btn btn-primary" type="submit"><i class="fa fa-search" style="margin-right: 8px;"></i>Tampilkan</button>
									</div>
								</form>
							</div>
						</div>
						<?php if ($submit): ?>
						<script>
							const nama = '<?= $nama ?>';

							// Chart 1
							let targetKaryawan = [];
							let jumlahKaryawan = [];
							
							// Chart Bar 1
							let targetTurunPerBulan = [];
							let jumlahTurunPerBulan = [];

							// Chart Bar 2
							let targetTurunAkumulasi = [];
							let jumlahTurunAkumulasi = [];

							if(nama === 'Semua Data') {
								// Chart 1
								let targetSemuaKaryawanTidakLangsung = [];
								let targetSemuaKaryawanLangsung = [];
								let jumlahSemuaKaryawanTidakLangsung = [];
								let jumlahSemuaKaryawanLangsung = [];
								
								// Chart Bar 1
								let jumlahSemuaKaryawanLangsungTurunPerBulan = [];
								let jumlahSemuaKaryawanTidakLangsungTurunPerBulan = [];

								// Chart Bar 2
								let jumlahSemuaKaryawanTurunLangsungAkumulasi = [];
								let jumlahSemuaKaryawanTurunTidakLangsungAkumulasi = [];
							}
						</script>
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="col-lg-6">
									<h3 style="margin-top: 4px; margin-bottom: 0;"><?= $nama ?></h3>
								</div>
								<div class="col-lg-6" style="padding: 0;">
									<div class="btn-group pull-right">
										<button id="button-fullscreen" class="btn btn-primary"><i class="fa fa-desktop" style="margin-right: 8px;"></i>Show in Fullscreen</button>
										<button disabled title="Fitur sedang dalam proses pengembangan" id="button-print" class="btn btn-primary"><i id="btn-print-box" style="margin-right: 8px;" class="fa fa-print"></i>Print</button>
										<button title="Fitur sedang dalam proses pengembangan" id="button-save" class="btn btn-primary"><i id="btn-save-box" style="margin-right: 8px;" class="fa fa-floppy-o"></i>Save</button>
									</div>
								</div>
							</div>
							<div id="box-body-data" class="box-body" style="padding: 16px; overflow-y: auto; background-color: white;">
								<?php if($filterData == 'tabelseksi'): ?>
								<table id="datatableSeksi" class="table table-bordered table-hover text-center" style="width: 100%;">
								<thead>
									<tr>
										<th class="bg-primary" style="vertical-align: middle;">No.</th>
										<th class="bg-orange" style="vertical-align: middle;">Bidang</th>
										<th class="bg-primary" style="vertical-align: middle;">Unit</th>
										<th class="bg-orange" style="vertical-align: middle;">Seksi</th>
										<th class="bg-primary" style="vertical-align: middle;">Pekerja Tidak Langsung</th>
										<th class="bg-orange" style="vertical-align: middle;">Pekerja Langsung</th>
										<th class="bg-primary" style="vertical-align: middle;">Total Pekerja</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; foreach($tabelseksi as $item): ?>
									<tr>
										<td><?= $i++ ?>.</td>
										<td><?= $item['bidang'] ?></td>
										<td><?= $item['unit'] ?></td>
										<td><?= $item['seksi'] ?></td>
										<td><?= $item['tidak_langsung'] ?></td>
										<td><?= $item['langsung'] ?></td>
										<td><?= $item['total'] ?></td>
									</tr>
									<?php endforeach ?>
								</tbody>
								</table>
								<?php else: ?>
								<div style="margin-left: 98px;">
									<table id="tableRekapSDM" class="table table-bordered table-hover text-center" style="overflow-x: scroll; width: 100%; display: block;">
										<thead>
											<th class="fixed-column" style="background-color: #00a65a; color: white; min-width: 100px;">Keterangan</th>
											<?php $a = 1; foreach ($akhir as $key => $value): ?>
											<th class="<?= ($a++ % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="<?= $value ?>"><?= $key ?></th>
											<?php endforeach ?>
										</thead>
										<tbody>
											<tr>
												<td class="fixed-column">Tanggal</td>
												<?php foreach ($tgl as $key => $date): ?>
												<td colspan="2" style="text-align: center;"><?= $date->format("m.d") ?></td>
												<?php endforeach ?>
											</tr>
											<tr>
												<td class="fixed-column">Target Karyawan</td>
												<?php
													$printTarget = $target[0] + $minAg;
													$processTarget = $target[0] + $minAg;
													if($nama == 'Semua Data') {
														$processTarget1 = $target1[0] + $minAg1;
														$processTarget2 = $target2[0] + $minAg2;
													}
													for($i = 0; $i < 26; $i++):
												?>
												<?php if ($i <= 17): ?>
												<td colspan="2"><?= $printTarget = $printTarget - $minAg; ?></td>
												<?php else: ?>
												<td colspan="2"><?= $printTarget = $printTarget - $min; ?></td>
												<?php endif ?>
												<?php endfor ?>
												<script>
													targetKaryawan = [
														<?php 
															for($j = 0; $j < 26; $j++) {
																echo ($j < 25) ? ($j <= 17) ? '"'.$processTarget = ($processTarget - $minAg).'",' : '"'.$processTarget = ($processTarget - $min).'",' : '"'.$processTarget = ($processTarget - $min).'"';
															}
														?>
													];
													targetSemuaKaryawanTidakLangsung = [
														<?php
															if($nama == 'Semua Data') {
																for($j = 0; $j < 26; $j++) {
																	echo ($j < 25) ? ($j <= 17) ? '"'.$processTarget1 = ($processTarget1 - $minAg1).'",' : '"'.$processTarget1 = ($processTarget1 - $min1).'",' : '"'.$processTarget1 = ($processTarget1 - $min1).'"';
																}
															}
														?>
													];
													targetSemuaKaryawanLangsung = [
														<?php 
															if($nama == 'Semua Data') {
																for($j = 0; $j < 26; $j++) {
																	echo ($j < 25) ? ($j <= 17) ? '"'.$processTarget2 = ($processTarget2 - $minAg2).'",' : '"'.$processTarget2 = ($processTarget2 - $min2).'",' : '"'.$processTarget2 = ($processTarget2 - $min2).'"';
																}
															}
														?>
													];
												</script>
											</tr>
											<tr>
												<td class="fixed-column">Jumlah Karyawan</td>
												<?php foreach ($target as $key => $value): ?>
												<td colspan="2"><?= $value ?></td>
												<?php endforeach ?>
												<?php for ($i = count($target); $i < 26; $i++): ?>
												<td colspan="2"></td>
												<?php endfor ?>
												<script>
													jumlahKaryawan = [
														<?php 
															for ($j = 0; $j < count($target); $j++) {
																echo (($j < (count($target) - 1)) ? '"'.$target[$j].'",' : '"'.$target[$j].'"');
															}
														?>
													];
													jumlahSemuaKaryawanTidakLangsung = [
														<?php
															if($nama == 'Semua Data') {
																for ($j = 0; $j < count($target1); $j++) {
																	echo (($j < (count($target1) - 1)) ? '"'.$target1[$j].'",' : '"'.$target1[$j].'"');
																}
															}
														?>
													];
													jumlahSemuaKaryawanLangsung = [
														<?php
															if($nama == 'Semua Data') {
																for ($j = 0; $j < count($target2); $j++) {
																	echo (($j < (count($target2) - 1)) ? '"'.$target2[$j].'",' : '"'.$target2[$j].'"');
																}
															}
														?>
													];
												</script>
											</tr>
											<tr>
												<td class="fixed-column">Target Turun Perbulan</td>
												<td>0</td>
												<td>0%</td>
												<?php for($i = 0; $i < 25; $i++): ?>
												<td><?= $minAg ?></td>
												<?php if($target[0] != 0): ?>
												<?php 	if($i > 16): ?>
												<td><?= round($min / $target[0] * 100, 1) ?>%</td>
												<?php 	else: ?>
												<td><?= round($minAg / $target[0] * 100, 1) ?>%</td>
												<?php 	endif ?>
												<?php else: ?>
												<td>0%</td>
												<?php endif ?>
												<?php endfor ?>
												<script>
													targetTurunPerBulan = [
														"0",
														<?php 
															for($j = 0; $j < 25; $j++) {
																echo (($j < 24) ? ($j <= 16) ? '"'.$minAg.'",' : '"'.$min.'",' : '"'.$min.'"');
															}
														?>
													];
												</script>
											</tr>
											<tr>
												<td class="fixed-column">Jumlah Turun Per Bulan</td>
												<td>0</td>
												<td>0%</td>
												<?php for($i = 0; $i < count($target) - 1; $i++): $turun = ($target[$i + 1] - $target[$i]); ?>
												<td><?= abs($turun) ?></td>
												<td><?= ($target[$i] == '0' ? '0' : abs(round(($turun / $target[$i] * 100), 1))) ?>%</td>
												<?php endfor ?>
												<?php for ($i = count($target) - 1; $i < 25 ; $i++): ?>
												<td></td>
												<td></td>
												<?php endfor ?>
												<script>
													jumlahTurunPerBulan = [
														"0",
														<?php
															for($j = 0; $j < count($target) - 1; $j++) {
																$x = ($target[$j + 1] - $target[$j]);
																echo (($j < (count($target) - 2)) ? '"'.abs($x).'",' : '"'.abs($x).'"');
															}
														?>
													];
													jumlahSemuaKaryawanTidakLangsungTurunPerBulan = [
														"0",
														<?php
															if($nama == 'Semua Data') {
																for($j = 0; $j < count($target1) - 1; $j++) {
																	$x = ($target1[$j + 1] - $target1[$j]);
																	echo (($j < (count($target1) - 2)) ? '"'.abs($x).'",' : '"'.abs($x).'"');
																}
															}
														?>
													];
													jumlahSemuaKaryawanLangsungTurunPerBulan = [
														"0",
														<?php
															if($nama == 'Semua Data') {
																for($j = 0; $j < count($target2) - 1; $j++) {
																	$x = ($target2[$j + 1] - $target2[$j]);
																	echo (($j < (count($target2) - 2)) ? '"'.abs($x).'",' : '"'.abs($x).'"');
																}
															}
														?>
													];
												</script>
											</tr>
											<tr>
												<td class="fixed-column">Target Turun Akumulasi</td>
												<td>0</td>
												<td>0%</td>
												<?php
													$trgaku = 0;
													$trgaku2 = 0;
													for($i = 0; $i < 25; $i++) { 
														if($i > 16) {
															echo '<td>'.$trgaku = ($trgaku + $min).'</td>';
														} else {
															echo '<td>'.$trgaku = ($trgaku + $minAg).'</td>';
														}
														if($target[0] != 0) {
															echo '<td>'.$trgaku2 = round($trgaku / $target[0] * 100, 1).'%</td>';
														} else {
															echo '<td>0%</td>';
														}
													}
												?>
												<script>
													targetTurunAkumulasi = [
														"0",
														<?php
															$trgakumulasi = 0;
															for($j = 0; $j < 25; $j++) {
																echo (($j < 24) ? ($j <= 16) ? '"'.$trgakumulasi = ($trgakumulasi+ $minAg).'",' : '"'.$trgakumulasi = ($trgakumulasi + $min).'",' : '"'.$trgakumulasi = ($trgakumulasi + $min).'"' );
															}
														?>
													];
												</script>
											</tr>
											<tr>
												<td class="fixed-column">Jumlah Turun Akumulasi</td>
												<td>0</td>
												<td>0%</td>
												<?php for ($i = 0; $i < count($target) - 1; $i++): $turun = ($target[$i + 1] - $target[0]); ?>
												<td><?= abs($turun) ?></td>
												<?php if($target[0] != 0): ?>
												<td><?= abs(round(($turun / $target[0] * 100), 1)) ?>%</td>
												<?php else: ?>
												<td>0%</td>
												<?php endif ?>
												<?php endfor ?>
												<?php for ($i = count($target); $i < 26; $i++): ?>
												<td></td>
												<td></td>
												<?php endfor ?>
												<script>
													jumlahTurunAkumulasi = [
														"0",
														<?php
															for($j = 0; $j < count($target) - 1; $j++) {
																$x = ($target[$j + 1] - $target[0]);
																echo (($j < (count($target) - 2)) ? '"'.abs($x).'",' : '"'.abs($x).'"');
															}
														?>
													];
													jumlahSemuaKaryawanTurunTidakLangsungAkumulasi = [
														"0",
														<?php
															if($nama == 'Semua Data') {
																for($j = 0; $j < count($target1) - 1; $j++) {
																	$x = ($target1[$j + 1] - $target1[0]);
																	echo (($j < (count($target1) - 2)) ? '"'.abs($x).'",' : '"'.abs($x).'"');
																}
															}
														?>
													];
													jumlahSemuaKaryawanTurunLangsungAkumulasi = [
														"0",
														<?php
															if($nama == 'Semua Data') {
																for($j = 0; $j < count($target2) - 1; $j++) {
																	$x = ($target2[$j + 1] - $target2[0]);
																	echo (($j < (count($target2) - 2)) ? '"'.abs($x).'",' : '"'.abs($x).'"');
																}
															}
														?>
													];
												</script>
											</tr>
										</tbody>
									</table>
								</div>
								<canvas style="margin-top: 18px;" id="chart1" width="400" height="150"></canvas>
								<canvas style="margin-top: 18px;" id="chartBar1" width="400" height="100"></canvas>
								<canvas style="margin-top: 18px;" id="chartBar2" width="400" height="100"></canvas>
								<?php endif ?>
							</div>
						<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="myModalSDM" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload Data</h4>
			</div>
			<div class="modal-body">
				<form id="formUploadData" method="POST" action="<?php echo base_url('SDM/input');?>" enctype="multipart/form-data" style="margin-bottom: 22px;">
					<div class="col-lg-4 text-left" style="padding: 0;">
						<b>Pilih file (format .txt) :</b>
					</div>
					<div class="col-lg-8 text-left" style="padding: 0;">
						<input name="fileToUpload" type="file" required>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 8px"></i>Batal</button>
				<button type="button" class="btn btn-primary" onclick="javascript:document.getElementById('formUploadData').submit();"><i class="fa fa-upload" style="margin-right: 8px"></i>Upload</button>
			</div>
		</div>
	</div>
</div>
<a href="#" id="buttonScrollTop" class="buttonScrollTop btn btn-danger" title="Scroll to top"><i class="fa fa-arrow-up" style="margin-right: 8px;"></i> Scroll to top</a>
<script>
	var tgl = [
		<?php
			if(isset($tgl)) {
				$jum2 = 26;
				$a = 0;
				foreach ($tgl as $key => $date) {
					if(++$a === $jum2) {
						echo '"'.$date->format("m.d").'"';
					} else {
						echo '"'.$date->format("m.d").'", ';
					}
				}
			}
		?>
	];

	document.addEventListener('DOMContentLoaded', async _ => {
		if(filterData === 'tabelseksi') {
			$('#datatableSeksi').DataTable({
				language: {
					"processing":       "Memuat data...",
					"loadingRecords":   "Memuat...",
					"search":           "Cari : ",
					"lengthMenu":       "Menampilkan _MENU_ baris per halaman",
					"emptyTable":       "Belum ada data",
					"zeroRecords":      "Tidak ada data yang sesuai dengan kata kunci",
					"infoEmpty":        "Data tidak tersedia",
					"infoFiltered":     "(di filter dari _MAX_ total data)",
					"info":             "Menampilkan data ke _START_ sampai _END_ dari _TOTAL_ data",
					"paginate": {
						"first":        "Pertama",
						"last":         "Terakhir",
						"next":         "Selanjutnya",
						"previous":     "Sebelumnya"
					},
					"aria": {
						"sortAscending":    ": aktifkan untuk mengurutkan data secara ascending",
						"sortDescending":   ": aktifkan untuk mengurutkan data secara descending"
					},
					"buttons": {
						"pageLength": {
							_: "Menampilkan %d baris",
							'-1': "Tampilkan semua"
						}
					}
				}
			});
		}
		document.getElementById('filter-data-loading').innerHTML = 'Dept. Produksi';
		let buttonScrollTopIsHidden = true;
		window.onscroll = async _ => { 
			if (document.documentElement.scrollTop >= 20) {
				if(buttonScrollTopIsHidden) {
					animation.fadeIn(document.getElementById('buttonScrollTop'));
					buttonScrollTopIsHidden = false;
				}
			} else {
				if(!buttonScrollTopIsHidden) {
					animation.fadeOut(document.getElementById('buttonScrollTop'));
					buttonScrollTopIsHidden = true;
				}
			}
		};
	});
</script>
<script src="<?php echo base_url('assets/js/customGR.js');?>"></script>