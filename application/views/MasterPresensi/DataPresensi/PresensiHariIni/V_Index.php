<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<style type="text/css">
							.box-body .box-body .box-body {
								text-align: center;
								font-size: 30pt;
							}
							.box .box .box {
								margin-bottom: 0px;
							}
							/*.box-body .box-body {
								padding: 0px;
							}*/
							.box-body .box-body .row {
								margin: 0px;
							}
							.box-body .box-body .col-lg-4 {
								padding: 0px;
							}
						</style>
						<?php 
							$all_masuk = 0;
							$all_tidak = 0;
							$all_total = 0;
							$pst_masuk = 0;
							$pst_tidak = 0;
							$pst_total = 0;
							$tks_masuk = 0;
							$tks_tidak = 0;
							$tks_total = 0;
							$cbg_masuk = 0;
							$cbg_tidak = 0;
							$cbg_total = 0;
							if (!empty($data)) {
								foreach ($data as $key => $value) {
									if ($value['lokasi'] == "Cabang") {
										$cbg_masuk = $value['jumlah_masuk'];
										$cbg_tidak = $value['jumlah_tdk_masuk'];
										$cbg_total = $cbg_masuk + $cbg_tidak;
										$all_masuk += $cbg_masuk;
										$all_tidak += $cbg_tidak;
										$all_total += $cbg_total;
									}elseif ($value['lokasi'] == "PusatMlati") {
										$pst_masuk = $value['jumlah_masuk'];
										$pst_tidak = $value['jumlah_tdk_masuk'];
										$pst_total = $pst_masuk + $pst_tidak;
										$all_masuk += $pst_masuk;
										$all_tidak += $pst_tidak;
										$all_total += $pst_total;
									}elseif ($value['lokasi'] == "Tuksono") {
										$tks_masuk = $value['jumlah_masuk'];
										$tks_tidak = $value['jumlah_tdk_masuk'];
										$tks_total = $tks_masuk + $tks_tidak;
										$all_masuk += $tks_masuk;
										$all_tidak += $tks_tidak;
										$all_total += $tks_total;
									}
								}
							}
						?>
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<style type="text/css">
												.table-tidak-masuk td, .table-tidak-masuk th {
													text-align: center;
												}
												.table-tidak-masuk td {
													font-size: 30pt;
												}
												.table-tidak-masuk > thead > tr > th, .table-tidak-masuk > tbody > tr > td {
													border-color: #FF420E;
												}
											</style>
											<table class="table table-bordered table-hover table-tidak-masuk" id="tblMPRPresensiHariIniRekap" style="width: 100%;border: 1px solid #FF420E;">
												<thead>
													<tr>
														<th colspan="12" style="background-color: #FF420E;color: white;">Data Kehadiran (Absen Barcode)</th>
														<?php $lebar_col = 100/12; ?>
													</tr>
													<tr>
														<th colspan="3" style="background-color: #46211A;color: white;">All</th>
														<th colspan="3" style="background-color: #A43820;color: white;">Pusat & Mlati</th>
														<th colspan="3" style="background-color: #A43820;color: white;">Tuksono</th>
														<th colspan="3" style="background-color: #A43820;color: white;">Cabang</th>
													</tr>
													<tr>
														<th style="background-color: #46211A;color: white;width: <?=$lebar_col; ?>%">Masuk</th>
														<th style="background-color: #46211A;color: white;width: <?=$lebar_col; ?>%">Tidak Masuk</th>
														<th style="background-color: #46211A;color: white;width: <?=$lebar_col; ?>%">Total</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Masuk</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Tidak Masuk</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Total</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Masuk</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Tidak Masuk</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Total</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Masuk</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Tidak Masuk</th>
														<th style="background-color: #A43820;color: white;width: <?=$lebar_col; ?>%">Total</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td data-params="all_masuk"><?=$all_masuk ?></td>
														<td data-params="all_tidak"><?=$all_tidak ?></td>
														<td data-params="all_total"><?=$all_total ?></td>
														<td data-params="pst_masuk"><?=$pst_masuk ?></td>
														<td data-params="pst_tidak"><?=$pst_tidak ?></td>
														<td data-params="pst_total"><?=$pst_total ?></td>
														<td data-params="tks_masuk"><?=$tks_masuk ?></td>
														<td data-params="tks_tidak"><?=$tks_tidak ?></td>
														<td data-params="tks_total"><?=$tks_total ?></td>
														<td data-params="cbg_masuk"><?=$cbg_masuk ?></td>
														<td data-params="cbg_tidak"><?=$cbg_tidak ?></td>
														<td data-params="cbg_total"><?=$cbg_total ?></td>
													</tr>
													<tr>
														<td data-params="all_masuk"><?=round(($all_masuk/$all_total)*100); ?>%</td>
														<td data-params="all_tidak"><?=round(($all_tidak/$all_total)*100); ?>%</td>
														<td data-params="all_total"><?=round(($all_total/$all_total)*100); ?>%</td>
														<td data-params="pst_masuk"><?=round(($pst_masuk/$pst_total)*100); ?>%</td>
														<td data-params="pst_tidak"><?=round(($pst_tidak/$pst_total)*100); ?>%</td>
														<td data-params="pst_total"><?=round(($pst_total/$pst_total)*100); ?>%</td>
														<td data-params="tks_masuk"><?=round(($tks_masuk/$tks_total)*100); ?>%</td>
														<td data-params="tks_tidak"><?=round(($tks_tidak/$tks_total)*100); ?>%</td>
														<td data-params="tks_total"><?=round(($tks_total/$tks_total)*100); ?>%</td>
														<td data-params="cbg_masuk"><?=round(($cbg_masuk/$cbg_total)*100); ?>%</td>
														<td data-params="cbg_tidak"><?=round(($cbg_tidak/$cbg_total)*100); ?>%</td>
														<td data-params="cbg_total"><?=round(($cbg_total/$cbg_total)*100); ?>%</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
								 			.dataTables_length,.dataTables_info {
								 				float: left;
								 				width: 33%;
								 			}
								 			.dataTables_filter, .dataTables_paginate {
								 				float: right;
								 			}
								 		</style>
										<table class='table table-bordered table-hover table-striped' id="tblMPRPresensiHariIniDetail" style='width: 100%'>
											<thead>
												<tr>
													<th class="text-center bg-primary">No.</th>
													<th class="text-center bg-primary">No. Induk</th>
													<th class="text-center bg-primary">Nama</th>
													<th class="text-center bg-primary">Kodesie</th>
													<th class="text-center bg-primary">Shift</th>
													<th class="text-center bg-primary">Waktu Absen</th>
													<th class="text-center bg-primary">Noind Baru</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style type="text/css">
	.loading {
	    width: 100%;
	    height: 100%;
	    position: fixed;
	    top: 0;
	    right: 0;
	    bottom: 0;
	    left: 0;
	    background-color: rgba(0,0,0,.5);
	    z-index: 9999 !important;
	}
	.loading-wheel {
	    width: 40px;
	    height: 40px;
	    margin-top: -80px;
	    margin-left: -40px;
	    
	    position: absolute;
	    top: 50%;
	    left: 50%;
	}
	.loading-wheel-2 {
	    width: 100%;
	    height: 20px;
	    margin-top: -50px;
	    
	    position: absolute;
	    top: 70%;
	    font-weight: bold;
	    font-size: 30pt;
	    color: white;
	    text-align: center;
	}
</style>
<div class="loading" id="ldgMPRPresensiHariIniLoading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>