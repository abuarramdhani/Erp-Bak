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
							<div class="text-right hidden-xs hidden-sm hidden-md">
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
								<ul class="nav nav-pills nav-justified">
									<li><a data-toggle="pill" href="#awal">Data Awal</a></li>
									<li class="active"><a data-toggle="pill" href="#proses">Proses</a></li>
									<li><a data-toggle="pill" href="#hasil">Rekap</a></li>
								</ul>

								<div class="tab-content">
									<div id="awal" class="tab-pane fade">
										<br>
										<div class="row">
											<div class="col-lg-12">
												<form class="form-horizontal" method="POST" action="<?php echo site_url('ManagementAdmin/Proses/CreateData') ?>">
													<div class="form-group">
														<label class="control-label col-lg-4">Pekerja</label>
														<div class="col-lg-4">
															<select class="selectPekerjaProses" name="selectPekerjaProses" style="width: 100%" required=""></select>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-lg-4">Pekerjaan</label>
														<div class="col-lg-4">
															<select class="selectPekerjaanProses" name="selectPekerjaanProses" style="width: 100%" required=""></select>
															<input type="hidden" name="selectPekerjaanProses">
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-lg-4">Jumlah Dokumen</label>
														<div class="col-lg-4">
															<input type="number" name="txtJumlahDocument" class="form-control" placeholder="Jumlah Dokumen" required="">
														</div>
													</div>
													<div class="form-group">	
														<label class="control-label col-lg-4">Target Total</label>
														<div class="col-lg-4">
															<input type="number" name="txtTargetTotal" class="form-control" placeholder="Target Total" required="">
														</div>
													</div>
													<div class="form-group">
														<div class="col-lg-8 text-right">
															<a href="javascript:history.back(1)" class="btn btn-danger">Cancel</a>
															<button type="submit" class="btn btn-success">Start</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div id="proses" class="tab-pane fade in active">
										<br>
										<div class="row">
											<div class="col-lg-12">
												<form class="form-horizontal" method="post" action="<?php echo site_url('ManagementAdmin/Proses/Selesai') ?>">
													<div class="form-group">
														<div class="col-lg-12">
															<div class="table-responsive">
																<table class="datatable table table-striped table-hover table-bordered datatable-ma text-left">
																	<thead class="bg-primary">
																		<tr>
																			<th>No</th>
																			<th>Check</th>
																			<th>Pekerja</th>
																			<th>Pekerjaan</th>
																			<th>Jumlah Dokumen</th>
																			<th>Total Target(detik)</th>
																			<th>Waktu Mulai</th>
																			<th>Waktu Selesai</th>
																			<th>Total Waktu</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php 
																			if (isset($table_proses) and !empty($table_proses)) {
																				$angka = 1;
																				foreach ($table_proses as $val) { ?>
																					<tr>
																						<td><?php echo $angka; ?></td>
																						<td><input type="checkbox" name="checkSelesai[]" value="<?php echo $val['id_pelaksanaan'] ?>"></td>
																						<td><?php echo $val['pekerja']; ?></td>
																						<td><?php echo $val['pekerjaan']; ?></td>
																						<td><?php echo $val['jml_dokument']; ?></td>
																						<td><?php echo $val['total_target']; ?></td>
																						<td><?php echo $val['start_time']; ?></td>
																						<td><?php echo $val['end_time']; ?></td>
																						<td><?php echo $val['total_waktu']; ?></td>
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
													<div class="form-group">
														<div class="col-lg-10 text-right">
															<button type="submit" class="btn btn-success">Selesai</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div id="hasil" class="tab-pane fade">
										<br>
										<div class="row">
											<div class="col-lg-12">
												<form class="form-horizontal" method="post" action="<?php echo site_url('ManagementAdmin/Proses/Selesai') ?>">
													<div class="form-group">
														<div class="col-lg-12">
															<div class="table-responsive">
																<table class="datatable table table-striped table-hover table-bordered datatable-ma text-left">
																	<thead class="bg-primary">
																		<tr>
																			<th>No</th>
																			<th>Pekerja</th>
																			<th>Pekerjaan</th>
																			<th>Jumlah Dokumen</th>
																			<th>Total Target(detik)</th>
																			<th>Waktu Mulai</th>
																			<th>Waktu Selesai</th>
																			<th>Total Waktu</th>
																			<th>Keterangan</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php 
																			if (isset($table_selesai) and !empty($table_selesai)) {
																				$angka = 1;
																				foreach ($table_selesai as $val) { ?>
																					<tr>
																						<td><?php echo $angka; ?></td>
																						<td><?php echo $val['pekerja']; ?></td>
																						<td><?php echo $val['pekerjaan']; ?></td>
																						<td><?php echo $val['jml_dokument']; ?></td>
																						<td><?php echo $val['total_target']; ?></td>
																						<td><?php echo $val['start_time']; ?></td>
																						<td><?php echo $val['end_time']; ?></td>
																						<td><?php echo $val['total_waktu']; ?></td>
																						<td>
																							<?php  
																								if ($val['status_tercapai'] == 't') {
																									echo "<label class='label label-success'>Tercapai</label>";
																								}else{
																									echo "<label class='label label-danger'>Tidak Tercapai</label>";
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
												</form>
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