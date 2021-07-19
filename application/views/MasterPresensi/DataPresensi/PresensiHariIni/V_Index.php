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
							$p_wfo		= 0;
							$p_wfh		= 0;
							$p_off		= 0;
							$p_ttl		= 0;
							$p_fb_wfo	= 0;
							$p_fb_wfh	= 0;
							$p_fb_off	= 0;
							$p_nfb_wfo	= 0;
							$p_nfb_wfh	= 0;
							$p_nfb_off	= 0;
							$p_ttl		= 0;
							$t_wfo		= 0;
							$t_wfh		= 0;
							$t_off		= 0;
							$t_ttl		= 0;
							$t_fb_wfo	= 0;
							$t_fb_wfh	= 0;
							$t_fb_off	= 0;
							$t_ttl		= 0;
							
							if (isset($data_original) && !empty($data_original)) {
								foreach ($data_original as $key => $value) {
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
										}
									}
								}
								$p_wfo	= $p_fb_wfo + $p_nfb_wfo;
								$p_wfh	= $p_fb_wfh + $p_nfb_wfh;
								$p_off	= $p_fb_off + $p_nfb_off;
								$p_fb_ttl = $p_fb_wfo + $p_fb_wfh + $p_fb_off;
								$p_nfb_ttl = $p_nfb_wfo + $p_nfb_wfh + $p_nfb_off;
								$p_ttl	= $p_wfo + $p_wfh + $p_off;

								$t_wfo	= $t_fb_wfo;
								$t_wfh	= $t_fb_wfh;
								$t_off	= $t_fb_off;
								$t_fb_ttl = $t_fb_wfo + $t_fb_wfh + $t_fb_off;
								$t_ttl	= $t_wfo + $t_wfh + $t_off;

							}
						?>
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
							.panel-pusat, 
							.panel-pusat .panel {
								border-color: #5BC8AC;
								border-radius: 0px;
							}
							.panel-pusat > .panel-heading {
								background-color: #5BC8AC;
								color: white;
							}
							.panel-pusat .panel > .panel-heading {
								background-color: #98DBC6;
								color: white;
								height: 40px;
								padding-top: 0px;
							}
							.panel-pusat .panel > .panel-heading.heading-total {
								height: 80px;
							}
							.panel-pusat .panel-heading {
								font-weight: bold;
								border-radius: 0px;
							}
							.panel-pusat > .panel-body,
							.panel-pusat > .panel-body .panel-body {
								background-color: #5BC8AC;
							}
							.panel-pusat .panel-body {
								padding: 0px;
							}
							.panel-pusat .panel-body > .row [class*=col] {
								padding: 0px;
							}
							.panel-pusat .panel-body .row {
								margin: 0px;
							}
							/*.panel-pusat .panel {
								margin-bottom: 10px;
							}*/
							.panel-pusat .angka {
								border-bottom: 1px solid #5BC8AC;
								border-top: 1px solid #5BC8AC;
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
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Versi Original
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-pusat">
											<div class="panel-heading">
												<div class="row">
													<div class="col-lg-12 text-center">
														KHS Pusat
													</div>
												</div>
											</div>
											<div class="panel-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="row">
															<div class="col-sm-12 col-lg-5">
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
																								<div class="row angka" data-params="p_o_f_wfo">
																									<div class="col-lg-12 text-center">
																										<?=$p_fb_wfo ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_o_f_wfo">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_fb_wfo	/ $p_fb_ttl) * 100); ?>%
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
																								<div class="row angka" data-params="p_o_f_wfh">
																									<div class="col-lg-12 text-center">
																										<?=$p_fb_wfh ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_o_f_wfh">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_fb_wfh	/ $p_fb_ttl) * 100); ?>%
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
																								<div class="row angka" data-params="p_o_f_off">
																									<div class="col-lg-12 text-center">
																										<?=$p_fb_off ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_o_f_off">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_fb_off	/ $p_fb_ttl) * 100); ?>%
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
																				<div class="row angka" data-params="p_o_f_ttl">
																					<div class="col-lg-12 text-center">
																						<?=$p_fb_ttl ?>
																					</div>
																				</div>
																				<div class="row angka" data-params="p_o_f_ttl">
																					<div class="col-lg-12 text-center">
																						<?=round(($p_fb_ttl	/ $p_fb_ttl) * 100); ?>%
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-sm-12 col-lg-5">
																<div class="row">
																	<div class="col-md-9">
																		<div class="panel">
																			<div class="panel-heading text-center">
																				NON FABRIKASI
																			</div>
																			<div class="panel-body">
																				<div class="row">
																					<div class="col-xs-4">
																						<div class="panel">
																							<div class="panel-heading text-center">
																								WFO
																							</div>
																							<div class="panel-body">
																								<div class="row angka" data-params="p_o_n_wfo">
																									<div class="col-lg-12 text-center">
																										<?=$p_nfb_wfo ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_o_n_wfo">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_nfb_wfo	/ $p_nfb_ttl) * 100); ?>%
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
																								<div class="row angka" data-params="p_o_n_wfh">
																									<div class="col-lg-12 text-center">
																										<?=$p_nfb_wfh ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_o_n_wfh">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_nfb_wfh	/ $p_nfb_ttl) * 100); ?>%
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
																								<div class="row angka" data-params="p_o_n_off">
																									<div class="col-lg-12 text-center">
																										<?=$p_nfb_off ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_o_n_off">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_nfb_off	/ $p_nfb_ttl) * 100); ?>%
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
																				TOTAL NON FABRIKASI
																			</div>
																			<div class="panel-body">
																				<div class="row">
																					<div class="row angka" data-params="p_o_n_ttl">
																						<div class="col-lg-12 text-center">
																							<?=$p_nfb_ttl ?>
																						</div>
																					</div>
																					<div class="row angka" data-params="p_o_n_ttl">
																						<div class="col-lg-12 text-center">
																							<?=round(($p_nfb_ttl	/ $p_nfb_ttl) * 100); ?>%
																						</div>
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
																		TOTAL KHS PUSAT
																	</div>
																	<div class="panel-body">
																		<div class="row angka" data-params="p_o_a_ttl" style="height: 160px;line-height: 159px;">
																			<div class="col-lg-12 text-center">
																				<?=$p_ttl ?>
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
																								<div class="row angka" data-params="t_o_f_wfo">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_wfo ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="t_o_f_wfo">
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
																								<div class="row angka" data-params="t_o_f_wfh">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_wfh ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="t_o_f_wfh">
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
																								<div class="row angka" data-params="t_o_f_off">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_off ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="t_o_f_off">
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
																				<div class="row angka" data-params="t_o_f_ttl">
																					<div class="col-lg-12 text-center">
																						<?=$t_fb_ttl ?>
																					</div>
																				</div>
																				<div class="row angka" data-params="t_o_f_ttl">
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
																		<div class="row angka" data-params="t_o_a_ttl" style="height: 160px;line-height: 159px;">
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
						<?php 
							$p_wfo		= 0;
							$p_wfh		= 0;
							$p_off		= 0;
							$p_ttl		= 0;
							$p_fb_wfo	= 0;
							$p_fb_wfh	= 0;
							$p_fb_off	= 0;
							$p_nfb_wfo	= 0;
							$p_nfb_wfh	= 0;
							$p_nfb_off	= 0;
							$p_ttl		= 0;
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
										}
									}
								}
								$p_wfo	= $p_fb_wfo + $p_nfb_wfo;
								$p_wfh	= $p_fb_wfh + $p_nfb_wfh;
								$p_off	= $p_fb_off + $p_nfb_off;
								$p_fb_ttl = $p_fb_wfo + $p_fb_wfh + $p_fb_off;
								$p_nfb_ttl = $p_nfb_wfo + $p_nfb_wfh + $p_nfb_off;
								$p_ttl	= $p_wfo + $p_wfh + $p_off;

								$t_wfo	= $t_fb_wfo;
								$t_wfh	= $t_fb_wfh;
								$t_off	= $t_fb_off;
								$t_fb_ttl = $t_fb_wfo + $t_fb_wfh + $t_fb_off;
								$t_ttl	= $t_wfo + $t_wfh + $t_off;

							}
						?>
						<div class="box box-success box-solid">
							<div class="box-header with-border">
								Versi Penyesuaian
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-pusat">
											<div class="panel-heading">
												<div class="row">
													<div class="col-lg-12 text-center">
														KHS Pusat
													</div>
												</div>
											</div>
											<div class="panel-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="row">
															<div class="col-sm-12 col-lg-5">
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
																								<div class="row angka" data-params="p_p_f_wfo">
																									<div class="col-lg-12 text-center">
																										<?=$p_fb_wfo ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_p_f_wfo">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_fb_wfo	/ $p_fb_ttl) * 100); ?>%
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
																								<div class="row angka" data-params="p_p_f_wfh">
																									<div class="col-lg-12 text-center">
																										<?=$p_fb_wfh ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_p_f_wfh">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_fb_wfh	/ $p_fb_ttl) * 100); ?>%
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
																								<div class="row angka" data-params="p_p_f_off">
																									<div class="col-lg-12 text-center">
																										<?=$p_fb_off ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_p_f_off">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_fb_off	/ $p_fb_ttl) * 100); ?>%
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
																				<div class="row angka" data-params="p_p_f_ttl">
																					<div class="col-lg-12 text-center">
																						<?=$p_fb_ttl ?>
																					</div>
																				</div>
																				<div class="row angka" data-params="p_p_f_ttl">
																					<div class="col-lg-12 text-center">
																						<?=round(($p_fb_ttl	/ $p_fb_ttl) * 100); ?>%
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-sm-12 col-lg-5">
																<div class="row">
																	<div class="col-md-9">
																		<div class="panel">
																			<div class="panel-heading text-center">
																				NON FABRIKASI
																			</div>
																			<div class="panel-body">
																				<div class="row">
																					<div class="col-xs-4">
																						<div class="panel">
																							<div class="panel-heading text-center">
																								WFO
																							</div>
																							<div class="panel-body">
																								<div class="row angka" data-params="p_p_n_wfo">
																									<div class="col-lg-12 text-center">
																										<?=$p_nfb_wfo ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_p_n_wfo">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_nfb_wfo	/ $p_nfb_ttl) * 100); ?>%
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
																								<div class="row angka" data-params="p_p_n_wfh">
																									<div class="col-lg-12 text-center">
																										<?=$p_nfb_wfh ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_p_n_wfh">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_nfb_wfh	/ $p_nfb_ttl) * 100); ?>%
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
																								<div class="row angka" data-params="p_p_n_off">
																									<div class="col-lg-12 text-center">
																										<?=$p_nfb_off ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="p_p_n_off">
																									<div class="col-lg-12 text-center">
																										<?=round(($p_nfb_off	/ $p_nfb_ttl) * 100); ?>%
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
																				TOTAL NON FABRIKASI
																			</div>
																			<div class="panel-body">
																				<div class="row">
																					<div class="row angka" data-params="p_p_n_ttl">
																						<div class="col-lg-12 text-center">
																							<?=$p_nfb_ttl ?>
																						</div>
																					</div>
																					<div class="row angka" data-params="p_p_n_ttl">
																						<div class="col-lg-12 text-center">
																							<?=round(($p_nfb_ttl	/ $p_nfb_ttl) * 100); ?>%
																						</div>
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
																		TOTAL KHS PUSAT
																	</div>
																	<div class="panel-body">
																		<div class="row angka" data-params="p_p_a_ttl" style="height: 160px;line-height: 159px;">
																			<div class="col-lg-12 text-center">
																				<?=$p_ttl ?>
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
																								<div class="row angka" data-params="t_p_f_wfo">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_wfo ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="t_p_f_wfo">
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
																								<div class="row angka" data-params="t_p_f_wfh">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_wfh ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="t_p_f_wfh">
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
																								<div class="row angka" data-params="t_p_f_off">
																									<div class="col-lg-12 text-center">
																										<?=$t_fb_off ?>
																									</div>
																								</div>
																								<div class="row angka" data-params="t_p_f_off">
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
																				<div class="row angka" data-params="t_p_f_ttl">
																					<div class="col-lg-12 text-center">
																						<?=$t_fb_ttl ?>
																					</div>
																				</div>
																				<div class="row angka" data-params="t_p_f_ttl">
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
																		<div class="row angka" data-params="t_p_a_ttl" style="height: 160px;line-height: 159px;">
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
</section>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="mdlMPPRPresensiHariIniDetail">
	<div class="modal-dialog" style="width: 100%">
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
				 			.dataTables_length, .dataTables_info {
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