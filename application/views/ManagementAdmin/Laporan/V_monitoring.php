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
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-bordered table-hover table-striped datatable-ma text-left">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>Pekerja</th>
														<th>Pekerjaan</th>
														<th>Total Target (Detik)</th>
														<th>Waktu Mulai</th>
														<th>Waktu Selesai</th>
														<th>Total Waktu</th>
														<th>Keterangan</th>
														<th>Alasan</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														if (isset($table) and !empty($table)) {
															$angka = 1;
															foreach ($table as $val) { ?>
																<tr>
																	<td><?php echo $angka ?></td>
																	<td><?php echo $val['pekerja'] ?></td>
																	<td><?php echo $val['pekerjaan'] ?></td>
																	<td><?php echo $val['total_target'] ?></td>
																	<td><?php echo $val['start_time'] ?></td>
																	<td><?php echo $val['end_time'] ?></td>
																	<td><?php echo $val['total_waktu'] ?></td>
																	<td><?php  
																			if ($val['status_tercapai'] == 't') {
																				echo "<label class='label label-success'>Tercapai</label>";
																			}else{
																				echo "<label class='label label-danger'>Tidak Tercapai</label>";
																			}
																		?>
																	</td>
																	<td><?php  
																			if ($val['alasan'] == 'Quick1953') {
																				echo "<label class='label label-warning'>Belum Memberikan Alasan</label>";
																			}else{
																				echo $val['alasan'];
																			}
																		?>
																	</td>
																</tr>
													<?php		$angka++;
															}
														}
													?>
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
</section>