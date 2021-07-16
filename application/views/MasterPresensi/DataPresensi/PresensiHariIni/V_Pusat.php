<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Statistik Pusat</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo base_url('assets/img/logo.png') ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/plugins/bootstrap/3.3.7/css/bootstrap.min.css") ?>" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/plugins/datatables-latest/datatables.min.css") ?>" />
</head>
<body>
	<div class="container-fluid" style="background-color: #F0EFFE;height: 100vh;">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h1><b>Kehadiran KHS Pusat <?=date('d/m/Y') ?></b></h1>
			</div>
		</div>
		<div class="row" sty>
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						
					</div>
					<div class="panel-body">
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
											}
										}
										$p_wfo		= $p_fb_wfo + $p_nfb_wfo;
										$p_wfh		= $p_fb_wfh + $p_nfb_wfh;
										$p_off		= $p_fb_off + $p_nfb_off;
										$p_total	= $p_wfo + $p_wfh + $p_off;
									}
								?>
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-12">
												<div  class="table-responsive">
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
										</div>
									</div>
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-12">
												<div  class="table-responsive">
													<table class="table table-bordered table-hover table-striped tblMPRPresensiHariIniWfhjenis" style="width: 100%;">
														<thead>
															<tr>
																<th colspan="7">KHS PUSAT</th>
															</tr>
															<tr>
																<th colspan="3">FABRIKASI</th>
																<th colspan="3">NON FABRIKASI</th>
																<th style="width: <?=100/7 ?>%;" rowspan="2">TOTAL</th>
															</tr>
															<tr>
																<th style="width: <?=100/7 ?>%;">WFO</th>
																<th style="width: <?=100/7 ?>%;">WFH</th>
																<th style="width: <?=100/7 ?>%;">OFF/TIDAK MASUK</th>
																<th style="width: <?=100/7 ?>%;">WFO</th>
																<th style="width: <?=100/7 ?>%;">WFH</th>
																<th style="width: <?=100/7 ?>%;">OFF/TIDAK MASUK</th>
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
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="width: 90%">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
			</div>
			<div class="modal-body">
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
						<div  class="table-responsive">
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
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
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
</div>
	<script src="<?php echo base_url("assets/plugins/jQuery/jQuery-2.1.4.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js") ?>"></script>
	<script src="<?php echo base_url("assets/plugins/datatables-latest/datatables.min.js") ?>"></script>
	<script type="text/javascript">
		var baseurl = "<?php echo base_url() ?>";
		$(document).ready(function(){
			var tblMPRPresensiHariIniDetail = $('#tblMPRPresensiHariIniDetail').DataTable({
		        "lengthMenu": [
		            [ 5, 10, 25, 50, -1 ],
		            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
		        ],
		        "dom" : 'Blfrtip',
		        "buttons" : [
		            'excel', 'pdf'
		        ],      
		    });
			$('[class*=tblMPRPresensiHariIniWfh]').on('dblclick','td',function(){
		        params = $(this).data('params');
		        $('#ldgMPRPresensiHariIniLoading').show();
		        $.ajax({
		            url: baseurl+'MasterPresensi/DataPresensi/PresensiHariIni/detailWfh/'+params,
		            error: function(xhr,status,error){
		                $('#ldgMPRPresensiHariIniLoading').hide();
		                swal.fire({
		                    title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                    html: xhr['responseText'],
		                    type: "error",
		                    confirmButtonText: 'OK',
		                    confirmButtonColor: '#d63031',
		                })
		            },
		            success: function(result){
		            	// console.log(result)
		                if(obj = JSON.parse(result)){
		                	$('.modal-detail').modal('show');
		                    tblMPRPresensiHariIniDetail.clear().draw();
		                    obj.map(function(value,index){
		                        tblMPRPresensiHariIniDetail.row.add([
		                            (index +1),
		                            value['noind'],
		                            value['nama'],
		                            value['kodesie'],
		                            value['shift'],
		                            value['waktu'],
		                            value['noind_baru']
		                        ]).draw(false);

		                    })
		                    tblMPRPresensiHariIniDetail.columns.adjust();
		                }
		                $('#ldgMPRPresensiHariIniLoading').hide();
		            }
		        })
		    })
		})
	</script>
</body>
</html>