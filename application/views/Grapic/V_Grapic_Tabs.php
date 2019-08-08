<style type="text/css">
	html, body { scroll-behavior: smooth; }
	td { height: 60px; }
	thead tr th { height: auto; }
	.dataTable tbody tr td { height: auto; }
	.html2canvas-container { width: 1900px !important; height: 430px !important; }
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
								<form method="post" action="<?php echo base_url('SDM/grapicTabs');?>" class="form-horizontal" enctype="multipart/form-data">
									<div class="panel-body">
										<div class="col-lg-12" style="padding: 0">
											<div class="col-lg-8" style="padding: 0">
												<div class="col-lg-1 text-left" style="padding: 0; margin-right: 16px;">
													<label class="control-label">Aksi :</label>
												</div>
												<div class="col-lg-7 text-left" style="padding: 0">
													<a disabled target="_blank" style="margin-right: 6px;" class="btSDMdl btn btn-primary"><i class="fa fa-download" style="margin-right: 8px;"></i>Download</a>
													<a <?= (substr(base_url(), 7, 13) == 'erp.quick.com') ? 'disabled' : 'disabled' ?>  title="Fitur masih dalam tahap pengembangan" type="button" class="btn btn-primary"><i class="fa fa-upload" style="margin-right: 8px;"></i>Upload</a>
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
														<option id="filter-data-loading" value="10">Memuat data...</option>
														<option value="11">-- Semua Pekerja Tidak Langsung / InDirect Labour</option>
														<option value="12">-- Semua Pekerja Langsung / Direct Labour</option>
														<option style="font-weight: bolder;" disabled>===================== Departemen Personalia =====================</option>
														<option value="0">Dept. Personalia</option>
														<option value="17">-- Dept. Personalia Atasan</option>
														<option value="13">-- Dept. Personalia Unit Civil Maintenance</option>
														<option value="18">-- Dept. Personalia Unit ELECTRONIC DATA PROCESSING</option>
														<option value="19">-- Dept. Personalia Unit GENERAL AFFAIR & HUBUNGAN KERJA</option>
														<option value="20">-- Dept. Personalia Unit PELATIHAN</option>
														<option value="21">-- Dept. Personalia Unit PEOPLE DEVELOPMENT</option>
														<option value="22">-- Dept. Personalia Unit RECRUITMENT & SELECTION</option>
														<option value="23">-- Dept. Personalia Unit WASTE MANAGEMENT</option>
														<option style="font-weight: bolder;" disabled>===================== Departemen Keuangan =====================</option>
														<option value="1">Dept. Keuangan</option>
														<option value="16">-- Dept. Keuangan Atasan</option>
														<option value="5">-- Dept. Keuangan Unit Akuntansi</option>
														<option value="6">-- Dept. Keuangan Unit ICT</option>
														<option value="7">-- Dept. Keuangan Unit Internal Audit</option>
														<option value="8">-- Dept. Keuangan Unit Pengembangan Sistem</option>
														<option value="9">-- Dept. Keuangan Unit Pembelian Subkontraktor</option>
														<option value="14">-- Dept. Keuangan Unit Pembelian Supplier</option>
														<option value="15">-- Dept. Keuangan Unit Pengembangan Pembelian</option>
														<option style="font-weight: bolder;" disabled>===================== Departemen Pemasaran =====================</option>
														<option value="2">Dept. Pemasaran</option>
														<option value="3">-- Dept. Pemasaran - Pusat</option>
														<option value="4">-- Dept. Pemasaran - Cabang / Showroom / POS</option>
														<option value="24">-- Dept. Pemasaran Atasan</option>
														<option value="25">-- Dept. Pemasaran Unit CABANG JAKARTA</option>
														<option value="26">-- Dept. Pemasaran Unit CABANG MAKASSAR</option>
														<option value="27">-- Dept. Pemasaran Unit CABANG MEDAN</option>
														<option value="28">-- Dept. Pemasaran Unit CABANG PERWAKILAN JAKARTA</option>
														<option value="29">-- Dept. Pemasaran Unit CABANG PERWAKILAN MAKASSAR</option>
														<option value="30">-- Dept. Pemasaran Unit CABANG PERWAKILAN MEDAN</option>
														<option value="31">-- Dept. Pemasaran Unit CABANG PERWAKILAN SURABAYA</option>
														<option value="32">-- Dept. Pemasaran Unit CABANG PERWAKILAN TANJUNG KARANG</option>
														<option value="33">-- Dept. Pemasaran Unit CABANG PERWAKILAN YOGYAKARTA</option>
														<option value="34">-- Dept. Pemasaran Unit CABANG SURABAYA</option>
														<option value="35">-- Dept. Pemasaran Unit CABANG TANJUNG KARANG</option>
														<option value="36">-- Dept. Pemasaran Unit CABANG YOGYAKARTA</option>
														<option value="37">-- Dept. Pemasaran Unit PEMASARAN 1</option>
														<option value="38">-- Dept. Pemasaran Unit PEMASARAN 2</option>
														<option value="39">-- Dept. Pemasaran Unit PEMASARAN 3</option>
														<option value="40">-- Dept. Pemasaran Unit PEMASARAN 4</option>
														<option value="41">-- Dept. Pemasaran Unit PEMASARAN 5</option>
														<option value="42">-- Dept. Pemasaran Unit PEMASARAN DEMO & PURNA JUAL</option>
														<option value="43">-- Dept. Pemasaran Unit PEMASARAN EXPORT & DIRECT SELLING PRODUCT</option>
														<option value="44">-- Dept. Pemasaran Unit PEMASARAN JOB ORDER</option>
														<option value="45">-- Dept. Pemasaran Unit PEMASARAN PROMOSI</option>
														<option value="46">-- Dept. Pemasaran Unit PEMASARAN SPARE PART</option>
														<option value="47">-- Dept. Pemasaran Unit PEMASARAN SPECIAL CUSTOMER</option>
														<option value="48">-- Dept. Pemasaran Unit PEMASARAN SUPPORT</option>
														<option value="49">-- Dept. Pemasaran Unit PEMASARAN TR-2</option>
														<option value="50">-- Dept. Pemasaran Unit VDE & GENSET AUDIT & PENGEMB. ORG. PMS & CAB</option>
														<option style="font-weight: bolder;" disabled>================= Departemen Pemasaran Seksi =====================</option>
														<option value="51">Dept. Pemasaran Atasan Seksi</option>
														<option value="52">-- Dept. Pemasaran Seksi AUDIT PEMASARAN & CABANG</option>
														<option value="53">-- Dept. Pemasaran Seksi CABANG JAKARTA</option>
														<option value="54">-- Dept. Pemasaran Seksi CABANG MAKASSAR</option>
														<option value="55">-- Dept. Pemasaran Seksi CABANG MEDAN</option>
														<option value="56">-- Dept. Pemasaran Seksi CABANG PERWAKILAN JAKARTA</option>
														<option value="57">-- Dept. Pemasaran Seksi CABANG PERWAKILAN MAKASSAR</option>
														<option value="58">-- Dept. Pemasaran Seksi CABANG PERWAKILAN MEDAN
														<option value="59">-- Dept. Pemasaran Seksi CABANG PERWAKILAN SURABAYA</option>
														<option value="60">-- Dept. Pemasaran Seksi CABANG PERWAKILAN TANJUNG KARANG</option>
														<option value="61">-- Dept. Pemasaran Seksi CABANG PERWAKILAN YOGYAKARTA</option>
														<option value="62">-- Dept. Pemasaran Seksi CABANG SURABAYA</option>
														<option value="63">-- Dept. Pemasaran Seksi CABANG TANJUNG KARANG</option>
														<option value="64">-- Dept. Pemasaran Seksi CABANG YOGYAKARTA</option>
														<option value="65">-- Dept. Pemasaran Seksi CUSTOMER CARE</option>
														<option value="66">-- Dept. Pemasaran Seksi CUSTOMER CARE & KLAIM</option>
														<option value="67">-- Dept. Pemasaran Seksi DEMO & PURNA JUAL</option>
														<option value="68">-- Dept. Pemasaran Seksi DEMO & SERVICE AREA I</option>
														<option value="69">-- Dept. Pemasaran Seksi DEMO & SERVICE AREA II</option>
														<option value="70">-- Dept. Pemasaran Seksi ***DESAIN PROMOSI</option>
														<option value="71">-- Dept. Pemasaran Seksi DESAIN PROMOSI</option>
														<option value="72">-- Dept. Pemasaran Seksi DIGITAL MARKETING & KOMUNITAS QUICK</option>
														<option value="73">-- Dept. Pemasaran Seksi DIGITAL MARKETING&KOMUNITAS QUICK</option>
														<option value="74">-- Dept. Pemasaran Seksi ***PEMASARAN ALAT TRANSPORTASI</option>
														<option value="75">-- Dept. Pemasaran Seksi PEMASARAN ALAT TRANSPORTASI AREA I</option>
														<option value="76">-- Dept. Pemasaran Seksi PEMASARAN ALAT TRANSPORTASI AREA II</option>
														<option value="77">-- Dept. Pemasaran Seksi ***PEMASARAN EXPORT</option>
														<option value="78">-- Dept. Pemasaran Seksi PEMASARAN EXPORT</option>
														<option value="79">-- Dept. Pemasaran Seksi PEMASARAN HARVESTER</option>
														<option value="80">-- Dept. Pemasaran Seksi PEMASARAN JOB ORDER</option>
														<option value="81">-- Dept. Pemasaran Seksi PEMASARAN MESIN PERTANIAN A</option>
														<option value="82">-- Dept. Pemasaran Seksi PEMASARAN MESIN PERTANIAN B</option>
														<option value="83">-- Dept. Pemasaran Seksi PEMASARAN ONLINE</option>
														<option value="84">-- Dept. Pemasaran Seksi PEMASARAN SPARE PART AREA I</option>
														<option value="85">-- Dept. Pemasaran Seksi PEMASARAN SPARE PART AREA II</option>
														<option value="86">-- Dept. Pemasaran Seksi PEMASARAN SPARE PART AREA III</option>
														<option value="87">-- Dept. Pemasaran Seksi PEMASARAN SPARE PART ENGINE</option>
														<option value="88">-- Dept. Pemasaran Seksi PEMASARAN SP (SAP&BDL)</option>
														<option value="89">-- Dept. Pemasaran Seksi PEMASARAN TR-2 AREA I</option>
														<option value="90">-- Dept. Pemasaran Seksi PEMASARAN TR-2 AREA II</option>
														<option value="91">-- Dept. Pemasaran Seksi PEMASARAN TR-2 AREA III</option>
														<option value="92">-- Dept. Pemasaran Seksi PEMASARAN TR4&COMBINE HARVESTER</option>
														<option value="93">-- Dept. Pemasaran Seksi PEMASARAN TRAKTOR RODA 4</option>
														<option value="94">-- Dept. Pemasaran Seksi PEMASARAN VDE&GENSET</option>
														<option value="95">-- Dept. Pemasaran Seksi PENGEMBANGAN & PENYEDIAAN PRD TR-2</option>
														<option value="96">-- Dept. Pemasaran Seksi PENGIRIMAN PRODUK</option>
														<option value="97">-- Dept. Pemasaran Seksi PENJUALAN SPARE PART</option>
														<option value="98">-- Dept. Pemasaran Seksi POS BANYUASIN</option>
														<option value="99">-- Dept. Pemasaran Seksi POS SAMARINDA</option>
														<option value="100">-- Dept. Pemasaran Seksi POS SAMPIT</option>
														<option value="101">-- Dept. Pemasaran Seksi PRODUKSI PROMOSI</option>
														<option value="102">-- Dept. Pemasaran Seksi PUSAT PELATIHAN PELANGGAN & STANDARISASI</option>
														<option value="103">-- Dept. Pemasaran Seksi RISET&IMPLEMENTASI PROMOSI</option>
														<option value="104">-- Dept. Pemasaran Seksi SHOWROOM BANJARMASIN</option>
														<option value="105">-- Dept. Pemasaran Seksi SHOWROOM JAMBI</option>
														<option value="106">-- Dept. Pemasaran Seksi SHOWROOM PALU</option>
														<option value="107">-- Dept. Pemasaran Seksi SHOWROOM PEKANBARU</option>
														<option value="108">-- Dept. Pemasaran Seksi SHOWROOM PONTIANAK</option>
														<option value="109">-- Dept. Pemasaran Seksi SHOWROOM SIDRAP</option>
														<option value="110">-- Dept. Pemasaran Seksi SISTEM PENGEMBANGAN ORGANISASI CABANG&ORACLE</option>
														<option value="111">-- Dept. Pemasaran Seksi SPECIAL CUSTOMER BARAT</option>
														<option value="112">-- Dept. Pemasaran Seksi SPECIAL CUSTOMER MOS</option>
														<option value="113">-- Dept. Pemasaran Seksi ***SPECIAL CUSTOMER PUSAT</option>
														<option value="114">-- Dept. Pemasaran Seksi SPECIAL CUSTOMER PUSAT</option>
														<option value="115">-- Dept. Pemasaran Seksi SPECIAL CUSTOMER QUALITY CONTROL</option>
														<option value="116">-- Dept. Pemasaran Seksi SPECIAL CUSTOMER TENGAH</option>
														<option value="117">-- Dept. Pemasaran Seksi SPECIAL CUSTOMER TIME KEEPER</option>
														<option value="118">-- Dept. Pemasaran Seksi SPECIAL CUSTOMER TIMUR</option>
														<option value="119">-- Dept. Pemasaran Seksi TOKO ONLINE</option>
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
										<button disabled title="Fitur sedang dalam proses pengembangan" id="button-save" class="btn btn-primary"><i id="btn-save-box" style="margin-right: 8px;" class="fa fa-floppy-o"></i>Save</button>
									</div>
								</div>
							</div>
							<div id="box-body-data" class="box-body" style="padding: 16px; overflow-y: auto; background-color: white;">
								<div style="margin-left: 98px;">
									<table id="tabelDataSDM" style="overflow-x: scroll; width: 100%; display: block;" class="table table-bordered table-hover text-center">
										<thead style="border-color: black">
											<tr>
												<th class="fixed-column" style="background-color: #00a65a; color: white; min-width: 100px;">Keterangan</th>
												<?php $a = 1; foreach ($akhir as $key => $value): ?>
												<th class="<?= ($a++ % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="<?= $value ?>"><?= $key ?></th>
												<?php endforeach ?>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="fixed-column">Tanggal</td>
												<?php foreach ($tgl as $key => $date): ?>
												<td colspan="2"><?= $date->format("m.d") ?></td>	
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
												<?php for ($i = (count($target) - 1); $i < count($akhir); $i++): ?>
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
												<?php if(0 != $target[0]): ?>
												<td><?= abs(round(($turun / $target[0] * 100), 1)) ?>%</td>
												<?php else: ?>
												<td>0%</td>
												<?php endif ?>
												<?php endfor ?>
												<?php for ($i = (count($target) - 1); $i < 25; $i++): ?>
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
				$jum2 = 26; $a = 0;
				foreach ($tgl as $key => $date) {
					echo (++$a < $jum2) ? '"'.$date->format("m.d").'",' : '"'.$date->format("m.d").'"';
				}
			}
		?>
	];

	document.addEventListener('DOMContentLoaded', async _ => {
		document.getElementById('filter-data-loading').innerHTML = 'Semua Data';
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
<script src="<?= base_url('assets/js/customGR.js') ?>"></script>