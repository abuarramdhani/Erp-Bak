<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Statistik Tuksono</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo base_url('assets/img/logo.png') ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/plugins/bootstrap/3.3.7/css/bootstrap.min.css") ?>" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/plugins/datatables-latest/datatables.min.css") ?>" />
</head>
<body>
	<div class="container-fluid" style="background-color: #F0EFFE;height: 100vh;">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h1><b>Kehadiran KHS Tuksono <?=date('d/m/Y') ?></b></h1>
			</div>
		</div>
		<div class="row" sty>
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						
					</div>
					<div class="panel-body">
						<style type="text/css">
							.angka{
								font-size: 25pt;
								height: 80px;
								vertical-align: middle;
								line-height: 79px;
								background-color: white;
							}
							.panel-pusat .panel,
							.panel-tuksono .panel {
								margin-bottom: 0px;
							}

							@media only screen and (max-width: 400px) {
								.angka{
									font-size: 20pt;
								}
								.panel-pusat .panel,
								.panel-tuksono .panel {
									margin-bottom: 10px !important;
								}
							}
							@media only screen and (max-width:  1200px){
								.panel-pusat .panel,
								.panel-tuksono .panel {
									margin-bottom: 10px !important;
								}
								.panel-pusat .panel .panel,
								.panel-tuksono .panel .panel {
									margin-bottom: 0px !important;
								}
							}
							/**/
							.panel-tuksono, 
							.panel-tuksono .panel {
								border-color: #A43820;
								border-radius: 0px;
							}
							.panel-tuksono > .panel-heading {
								background-color: #A43820;
								color: white;
							}
							.panel-tuksono .panel > .panel-heading {
								background-color: #BA5536;
								color: white;
								height: 40px;
								padding-top: 0px;
							}
							.panel-tuksono .panel > .panel-heading.heading-total {
								height: 80px;
							}
							.panel-tuksono .panel-heading {
								font-weight: bold;
								border-radius: 0px;
							}
							.panel-tuksono > .panel-body,
							.panel-tuksono > .panel-body .panel-body {
								background-color: #A43820;
							}
							.panel-tuksono .panel-body {
								padding: 0px;
							}
							.panel-tuksono .panel-body > .row [class*=col] {
								padding: 0px;
							}
							.panel-tuksono .panel-body .row {
								margin: 0px;
							}
							.panel-tuksono .panel {
								/*margin-bottom: 10px;*/
								border-color: #A43820;
							}
							.panel-tuksono .angka {
								border-bottom: 1px solid #A43820;
								border-top: 1px solid #A43820;
							}
						</style>
						<div class="row">
							<div class="col-lg-12">
								<?php 
									$t_wfo		= 0;
									$t_wfh		= 0;
									$t_off		= 0;
									$t_ttl		= 0;
									$t_fb_wfo	= 0;
									$t_fb_wfh	= 0;
									$t_fb_off	= 0;
									$t_ttl		= 0;
									
									if (isset($data_penyesuaian) && !empty($data_penyesuaian)) {
										foreach ($data_penyesuaian as $key => $value) {
											if ($value['lokasi'] == "Tuksono") {
												if ($value['jenis'] == "Fabrikasi") {
													$t_fb_wfo	= $value['jumlah_wfo'];
													$t_fb_wfh	= $value['jumlah_wfh'];
													$t_fb_off	= $value['jumlah_off'];
												}
											}
										}

										$t_wfo	= $t_fb_wfo;
										$t_wfh	= $t_fb_wfh;
										$t_off	= $t_fb_off;
										$t_fb_ttl = $t_fb_wfo + $t_fb_wfh + $t_fb_off;
										$t_ttl	= $t_wfo + $t_wfh + $t_off;

									}
								?>
								<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-tuksono">
											<div class="panel-heading">
												<div class="row">
													<div class="col-lg-12 text-center">
														KHS TUKSONO
													</div>
												</div>
											</div>
											<div class="panel-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="row">
															<div class="col-sm-12 col-lg-10">
																<div class="row">
																	<div class="col-md-9">
																		<div class="panel">
																			<div class="panel-heading text-center">
																				FABRIKASI
																			</div>
																			<div class="panel-body">
																				<div class="row">
																					<div class="col-xs-4">
																						<div class="panel">
																							<div class="panel-heading text-center">
																								WFO
																							</div>
																							<div class="panel-body">
																								<div class="row angka jumlah" data-params="t_p_f_wfo">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_wfo ?>
																									</div>
																								</div>
																								<div class="row angka persen" data-params="t_p_f_wfo">
																									<div class="col-lg-12 text-center">
																										<?=round(($t_fb_wfo	/ $t_fb_ttl) * 100); ?>%
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="col-xs-4">
																						<div class="panel">
																							<div class="panel-heading text-center">
																								WFH
																							</div>
																							<div class="panel-body">
																								<div class="row angka jumlah" data-params="t_p_f_wfh">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_wfh ?>
																									</div>
																								</div>
																								<div class="row angka persen" data-params="t_p_f_wfh">
																									<div class="col-lg-12 text-center">
																										<?=round(($t_fb_wfh	/ $t_fb_ttl) * 100); ?>%
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="col-xs-4">
																						<div class="panel">
																							<div class="panel-heading text-center">
																								OFF / TIDAK MASUK
																							</div>
																							<div class="panel-body">
																								<div class="row angka jumlah" data-params="t_p_f_off">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_off ?>
																									</div>
																								</div>
																								<div class="row angka persen" data-params="t_p_f_off">
																									<div class="col-lg-12 text-center">
																										<?=round(($t_fb_off	/ $t_fb_ttl) * 100); ?>%
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="panel">
																			<div class="panel-heading heading-total text-center">
																				TOTAL FABRIKASI
																			</div>
																			<div class="panel-body">
																				<div class="row angka jumlah" data-params="t_p_f_ttl">
																					<div class="col-lg-12 text-center">
																						<?=$t_fb_ttl ?>
																					</div>
																				</div>
																				<div class="row angka persen" data-params="t_p_f_ttl">
																					<div class="col-lg-12 text-center">
																						<?=round(($t_fb_ttl	/ $t_fb_ttl) * 100); ?>%
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-sm-12 col-lg-2">
																<div class="panel">
																	<div class="panel-heading text-center heading-total">
																		TOTAL KHS TUKSONO
																	</div>
																	<div class="panel-body">
																		<div class="row angka jumlah" data-params="t_p_a_ttl" style="height: 160px;line-height: 159px;">
																			<div class="col-lg-12 text-center">
																				<?=$t_ttl ?>
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
										<th class="text-center bg-primary">Dept</th>
										<th class="text-center bg-primary">Bidang</th>
										<th class="text-center bg-primary">Unit</th>
										<th class="text-center bg-primary">Seksi</th>
										<th class="text-center bg-primary">No. Induk</th>
										<th class="text-center bg-primary">Nama</th>
										<th class="text-center bg-primary">Waktu Absen</th>
										<th class="text-center bg-primary">Lokasi Absen</th>
										<th class="text-center bg-primary">Shift</th>
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
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
		        "pageLength": 10,
		        "dom" : 'Blfrtip',
		        "buttons" : [
		            'excel', 'pdf'
		        ],      
		    });
			$('.angka').on('click',function(){
		        params = $(this).data('params');
		        $('#ldgMPRPresensiHariIniLoading').show();
		        $.ajax({
		            url: baseurl+'MasterPresensi/DataPresensi/PresensiHariIni/detail/'+params,
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
		                            value['dept'],
		                            value['bidang'],
		                            value['unit'],
		                            value['seksi'],
		                            value['noind'],
		                            value['nama'],
		                            value['waktu'],
		                            value['lokasi'],
		                            value['shift']
		                        ]).draw(false);

		                    })
		                    tblMPRPresensiHariIniDetail.columns.adjust();
		                }
		                $('#ldgMPRPresensiHariIniLoading').hide();
		            }
		        })
		    })

		    setInterval(function(){
		    	console.log("refresh")
		    	$.ajax({
		    		url: baseurl + "MasterPresensi/DataPresensi/PresensiHariIni/updateData",
		    		success: function(result) {
		    			if(obj = JSON.parse(result)){
		    				$('.panel-heading.waktu').text(obj.waktu);
		    				$('.jumlah [data-params=t_p_f_wfo]').text(obj.t_fb_wfo);
							$('.jumlah [data-params=t_p_f_wfh]').text(obj.t_fb_wfh);
							$('.jumlah [data-params=t_p_f_off]').text(obj.t_fb_off);
							$('.jumlah [data-params=t_p_f_ttl]').text(obj.t_fb_ttl);
							$('.jumlah [data-params=t_p_a_ttl]').text(obj.t_ttl);

		    				$('.persentase [data-params=t_p_f_wfo]').text( Math.round(( Number(obj.t_fb_wfo) / Number(obj.t_fb_ttl) ) * 100) + "%" );
							$('.persentase [data-params=t_p_f_wfh]').text( Math.round(( Number(obj.t_fb_wfh) / Number(obj.t_fb_ttl) ) * 100) + "%" );
							$('.persentase [data-params=t_p_f_off]').text( Math.round(( Number(obj.t_fb_off) / Number(obj.t_fb_ttl) ) * 100) + "%" );
							$('.persentase [data-params=t_p_f_ttl]').text( Math.round(( Number(obj.t_fb_ttl) / Number(obj.t_fb_ttl) ) * 100) + "%" );
		    			}
		    		}
		    	})
		    },30000);
		})
	</script>
</body>
</html>