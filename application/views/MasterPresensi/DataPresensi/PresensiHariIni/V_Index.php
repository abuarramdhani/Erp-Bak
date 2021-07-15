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
							if (!empty($data_barcode)) {
								foreach ($data_barcode as $key => $value) {
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
											.tblMPRPresensiHariIniWfhall > tbody > tr > td, .tblMPRPresensiHariIniWfhlokasi > tbody > tr > td, .tblMPRPresensiHariIniWfhjenis > tbody > tr > td    {
												font-size: 30pt;
											}
											.tblMPRPresensiHariIniWfhall > thead > tr > th, .tblMPRPresensiHariIniWfhall > tbody > tr > td {
												border-color: #7CAA2D;
												text-align: center;
											}
											.tblMPRPresensiHariIniWfhall > thead > tr > th {
												background-color: #7CAA2D;
												border-color: #F1F3CE;
											}

											.tblMPRPresensiHariIniWfhlokasi > thead > tr > th, .tblMPRPresensiHariIniWfhlokasi > tbody > tr > td {
												border-color: #F5E356;
												text-align: center;
											}
											.tblMPRPresensiHariIniWfhlokasi > thead > tr > th {
												background-color: #F5E356;
												border-color: #F1F3CE;
											}

											.tblMPRPresensiHariIniWfhjenis > thead > tr > th, .tblMPRPresensiHariIniWfhjenis > tbody > tr > td {
												border-color: #CB6318;
												text-align: center;
											}
											.tblMPRPresensiHariIniWfhjenis > thead > tr > th {
												background-color: #CB6318;
												border-color: #F1F3CE;
											}
										</style>
										<?php 
											$a_wfo		= 0;
											$a_wfh		= 0;
											$a_off		= 0;
											$a_total	= 0;
											$p_wfo		= 0;
											$p_wfh		= 0;
											$p_off		= 0;
											$p_total	= 0;
											$p_fb_wfo	= 0;
											$p_fb_wfh	= 0;
											$p_fb_off	= 0;
											$p_nfb_wfo	= 0;
											$p_nfb_wfh	= 0;
											$p_nfb_off	= 0;
											$p_total	= 0;
											$t_wfo		= 0;
											$t_wfh		= 0;
											$t_off		= 0;
											$t_total	= 0;
											$t_fb_wfo	= 0;
											$t_fb_wfh	= 0;
											$t_fb_off	= 0;
											$t_nfb_wfo	= 0;
											$t_nfb_wfh	= 0;
											$t_nfb_off	= 0;
											$t_total	= 0;
											
											if (isset($data_wfh) && !empty($data_wfh)) {
												foreach ($data_wfh as $key => $value) {
													if ($value['lokasi'] == "Pusat") {
														if ($value['jenis'] == "Fabrikasi") {
															$p_fb_wfo	= $value['jumlah_wfo'];
															$p_fb_wfh	= $value['jumlah_wfh'];
															$p_fb_off	= $value['jumlah_off'];
														}elseif($value['jenis'] = "Non Fabrikasi"){
															$p_nfb_wfo	= $value['jumlah_wfo'];
															$p_nfb_wfh	= $value['jumlah_wfh'];
															$p_nfb_off	= $value['jumlah_off'];
														}
													}elseif ($value['lokasi'] == "Tuksono") {
														if ($value['jenis'] == "Fabrikasi") {
															$t_fb_wfo	= $value['jumlah_wfo'];
															$t_fb_wfh	= $value['jumlah_wfh'];
															$t_fb_off	= $value['jumlah_off'];
														}elseif($value['jenis'] = "Non Fabrikasi"){
															$t_nfb_wfo	= $value['jumlah_wfo'];
															$t_nfb_wfh	= $value['jumlah_wfh'];
															$t_nfb_off	= $value['jumlah_off'];
														}
													}
												}
												$p_wfo		= $p_fb_wfo + $p_nfb_wfo;
												$p_wfh		= $p_fb_wfh + $p_nfb_wfh;
												$p_off		= $p_fb_off + $p_nfb_off;
												$p_total	= $p_wfo + $p_wfh + $p_off;

												$t_wfo		= $t_fb_wfo + $t_nfb_wfo;
												$t_wfh		= $t_fb_wfh + $t_nfb_wfh;
												$t_off		= $t_fb_off + $t_nfb_off;
												$t_total	= $t_wfo + $t_wfh + $t_off;

												$a_wfo = $p_wfo + $t_wfo;
												$a_wfh = $p_wfh + $t_wfh;
												$a_off = $p_off + $t_off;
												$a_total = $a_wfo + $a_wfh + $a_off;
											}
										?>
										<div class="row">
											<div class="col-lg-6">
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-bordered table-hover table-striped tblMPRPresensiHariIniWfhall" style="width: 100%;">
															<thead>
																<tr>
																	<th colspan="4">ALL (PUSAT + TUKSONO)</th>
																</tr>
																<tr>
																	<th style="width: 25%;">WFO</th>
																	<th style="width: 25%;">WFH</th>
																	<th style="width: 25%;">OFF/TIDAK MASUK</th>
																	<th style="width: 25%;">TOTAL</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td data-params="p_wfo"><?=$a_wfo ?></td>
																	<td data-params="p_wfh"><?=$a_wfh ?></td>
																	<td data-params="p_off"><?=$a_off ?></td>
																	<td data-params="p_ttl"><?=$a_total ?></td>
																</tr>
																<tr>
																	<td data-params="p_wfo"><?=round(($a_wfo	/ $a_total) * 100); ?>%</td>
																	<td data-params="p_wfh"><?=round(($a_wfh	/ $a_total) * 100); ?>%</td>
																	<td data-params="p_off"><?=round(($a_off	/ $a_total) * 100); ?>%</td>
																	<td data-params="p_ttl"><?=round(($a_total	/ $a_total) * 100); ?>%</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-bordered table-hover table-striped tblMPRPresensiHariIniWfhlokasi" style="width: 100%;">
															<thead>
																<tr>
																	<th colspan="4">KHS PUSAT</th>
																</tr>
																<tr>
																	<th style="width: 25%;">WFO</th>
																	<th style="width: 25%;">WFH</th>
																	<th style="width: 25%;">OFF/TIDAK MASUK</th>
																	<th style="width: 25%;">TOTAL</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td data-params="p_wfo"><?=$p_wfo ?></td>
																	<td data-params="p_wfh"><?=$p_wfh ?></td>
																	<td data-params="p_off"><?=$p_off ?></td>
																	<td data-params="p_ttl"><?=$p_total ?></td>
																</tr>
																<tr>
																	<td data-params="p_wfo"><?=round(($p_wfo	/ $p_total) * 100); ?>%</td>
																	<td data-params="p_wfh"><?=round(($p_wfh	/ $p_total) * 100); ?>%</td>
																	<td data-params="p_off"><?=round(($p_off	/ $p_total) * 100); ?>%</td>
																	<td data-params="p_ttl"><?=round(($p_total	/ $p_total) * 100); ?>%</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-bordered table-hover table-striped tblMPRPresensiHariIniWfhjenis" style="width: 100%;">
															<thead>
																<tr>
																	<th colspan="7">KHS PUSAT</th>
																</tr>
																<tr>
																	<th colspan="3">FABRIKASI</th>
																	<th colspan="3">NON FABRIKASI</th>
																	<th>TOTAL</th>
																</tr>
																<tr>
																	<th style="width: <?=100/7 ?>%;">WFO</th>
																	<th style="width: <?=100/7 ?>%;">WFH</th>
																	<th style="width: <?=100/7 ?>%;">OFF/TIDAK MASUK</th>
																	<th style="width: <?=100/7 ?>%;">WFO</th>
																	<th style="width: <?=100/7 ?>%;">WFH</th>
																	<th style="width: <?=100/7 ?>%;">OFF/TIDAK MASUK</th>
																	<th style="width: <?=100/7 ?>%;">TOTAL</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td data-params="p_fb_wfo"><?=$p_fb_wfo ?></td>
																	<td data-params="p_fb_wfh"><?=$p_fb_wfh ?></td>
																	<td data-params="p_fb_off"><?=$p_fb_off ?></td>
																	<td data-params="p_nfb_wfo"><?=$p_nfb_wfo ?></td>
																	<td data-params="p_nfb_wfh"><?=$p_nfb_wfh ?></td>
																	<td data-params="p_nfb_off"><?=$p_nfb_off ?></td>
																	<td data-params="p_ttl"><?=$p_total ?></td>
																</tr>
																<tr>
																	<td data-params="p_fb_wfo"><?=round(($p_fb_wfo		/$p_total) * 100); ?>%</td>
																	<td data-params="p_fb_wfh"><?=round(($p_fb_wfh		/$p_total) * 100); ?>%</td>
																	<td data-params="p_fb_off"><?=round(($p_fb_off		/$p_total) * 100); ?>%</td>
																	<td data-params="p_nfb_wfo"><?=round(($p_nfb_wfo	/$p_total) * 100); ?>%</td>
																	<td data-params="p_nfb_wfh"><?=round(($p_nfb_wfh	/$p_total) * 100); ?>%</td>
																	<td data-params="p_nfb_off"><?=round(($p_nfb_off	/$p_total) * 100); ?>%</td>
																	<td data-params="p_ttl"><?=round(($p_total		/$p_total) * 100); ?>%</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-bordered table-hover table-striped tblMPRPresensiHariIniWfhall" style="width: 100%;">
															<thead>
																<tr>
																	<th colspan="4">ALL (PUSAT + TUKSONO)</th>
																</tr>
																<tr>
																	<th style="width: 25%;">WFO</th>
																	<th style="width: 25%;">WFH</th>
																	<th style="width: 25%;">OFF/TIDAK MASUK</th>
																	<th style="width: 25%;">TOTAL</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td data-params="t_wfo"><?=$a_wfo ?></td>
																	<td data-params="t_wfh"><?=$a_wfh ?></td>
																	<td data-params="t_off"><?=$a_off ?></td>
																	<td data-params="t_ttl"><?=$a_total ?></td>
																</tr>
																<tr>
																	<td data-params="t_wfo"><?=round(($a_wfo	/ $a_total) * 100); ?>%</td>
																	<td data-params="t_wfh"><?=round(($a_wfh	/ $a_total) * 100); ?>%</td>
																	<td data-params="t_off"><?=round(($a_off	/ $a_total) * 100); ?>%</td>
																	<td data-params="t_ttl"><?=round(($a_total	/ $a_total) * 100); ?>%</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-bordered table-hover table-striped tblMPRPresensiHariIniWfhlokasi" style="width: 100%;">
															<thead>
																<tr>
																	<th colspan="4">KHS TUKSONO</th>
																</tr>
																<tr>
																	<th style="width: 25%;">WFO</th>
																	<th style="width: 25%;">WFH</th>
																	<th style="width: 25%;">OFF/TIDAK MASUK</th>
																	<th style="width: 25%;">TOTAL</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td data-params="t_wfo"><?=$t_wfo ?></td>
																	<td data-params="t_wfh"><?=$t_wfh ?></td>
																	<td data-params="t_off"><?=$t_off ?></td>
																	<td data-params="t_ttl"><?=$t_total ?></td>
																</tr>
																<tr>
																	<td data-params="t_wfo"><?=round(($t_wfo	/ $t_total) * 100); ?>%</td>
																	<td data-params="t_wfh"><?=round(($t_wfh	/ $t_total) * 100); ?>%</td>
																	<td data-params="t_off"><?=round(($t_off	/ $t_total) * 100); ?>%</td>
																	<td data-params="t_ttl"><?=round(($t_total	/ $t_total) * 100); ?>%</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-bordered table-hover table-striped tblMPRPresensiHariIniWfhjenis" style="width: 100%;">
															<thead>
																<tr>
																	<th colspan="7">KHS TUKSONO</th>
																</tr>
																<tr>
																	<th colspan="3">FABRIKASI</th>
																	<th colspan="3">NON FABRIKASI</th>
																	<th>TOTAL</th>
																</tr>
																<tr>
																	<th style="width: <?=100/7 ?>%;">WFO</th>
																	<th style="width: <?=100/7 ?>%;">WFH</th>
																	<th style="width: <?=100/7 ?>%;">OFF/TIDAK MASUK</th>
																	<th style="width: <?=100/7 ?>%;">WFO</th>
																	<th style="width: <?=100/7 ?>%;">WFH</th>
																	<th style="width: <?=100/7 ?>%;">OFF/TIDAK MASUK</th>
																	<th style="width: <?=100/7 ?>%;">TOTAL</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td data-params="t_fb_wfo"><?=$t_fb_wfo ?></td>
																	<td data-params="t_fb_wfh"><?=$t_fb_wfh ?></td>
																	<td data-params="t_fb_off"><?=$t_fb_off ?></td>
																	<td data-params="t_nfb_wfo"><?=$t_nfb_wfo ?></td>
																	<td data-params="t_nfb_wfh"><?=$t_nfb_wfh ?></td>
																	<td data-params="t_nfb_off"><?=$t_nfb_off ?></td>
																	<td data-params="t_ttl"><?=$t_total ?></td>
																</tr>
																<tr>
																	<td data-params="t_fb_wfo"><?=round(($t_fb_wfo		/$t_total) * 100); ?>%</td>
																	<td data-params="t_fb_wfh"><?=round(($t_fb_wfh		/$t_total) * 100); ?>%</td>
																	<td data-params="t_fb_off"><?=round(($t_fb_off		/$t_total) * 100); ?>%</td>
																	<td data-params="t_nfb_wfo"><?=round(($t_nfb_wfo	/$t_total) * 100); ?>%</td>
																	<td data-params="t_nfb_wfh"><?=round(($t_nfb_wfh	/$t_total) * 100); ?>%</td>
																	<td data-params="t_nfb_off"><?=round(($t_nfb_off	/$t_total) * 100); ?>%</td>
																	<td data-params="t_ttl"><?=round(($t_total		/$t_total) * 100); ?>%</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
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