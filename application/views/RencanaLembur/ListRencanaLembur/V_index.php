<style type="text/css">
	.rencana-lembur-new.active a {
		background-image: linear-gradient(0deg, #ffffff 90%, #0073b7 10%) !important;
		color: #0073b7 !important;
		font-weight: bold;
	}

	.rencana-lembur-new:not(.active) a {
		color: #0073b7 !important;

	}

	.rencana-lembur-approved.active a {
		background-image: linear-gradient(0deg, #ffffff 90%, #00a65a 10%) !important;
		color: #00a65a !important;
		font-weight: bold;
	}

	.rencana-lembur-approved:not(.active) a {
		color: #00a65a !important;
	}

	.rencana-lembur-rejected.active a {
		background-image: linear-gradient(0deg, #ffffff 90%, #dd4b39 10%) !important;
		color: #dd4b39 !important;
		font-weight: bold;
	}

	.rencana-lembur-rejected:not(.active) a {
		color: #dd4b39 !important;
	}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<ul class="nav nav-tabs">
											<li class="rencana-lembur-new active"><a data-toggle="tab" href="#unapproved">Belum Di Setujui</a></li>
											<li class="rencana-lembur-approved"><a data-toggle="tab" href="#approved">Sudah Di Setujui</a></li>
											<li class="rencana-lembur-rejected"><a data-toggle="tab" href="#rejected">Tidak Di Setujui</a></li>
										</ul>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="tab-content">
											<div id="unapproved" class="tab-pane fade in active">
												<form method="POST" action="<?php echo base_url('RencanaLembur/ListRencanaLembur/proses') ?>">
													<div class="row">
														<div class="col-lg-12">
															<br>
															<table class="table table-striped table-bordered table-hover">
																<thead class="bg-blue">
																	<tr>
																		<th>No</th>
																		<th>Action</th>
																		<th>Tanggal Lembur</th>
																		<th>Awal Lembur</th>
																		<th>Akhir Lembur</th>
																		<th>Jenis Lembur</th>
																		<th>pekerjaan</th>
																		<th>Pekerja</th>
																		<th>Makan</th>
																		<th>Tempat Makan</th>
																		<th>Shift</th>
																	</tr>
																</thead>
																<tbody>
																	<?php 
																	if (isset($data) and !empty($data)) {
																		$no = 1;
																		foreach ($data as $dt) {
																			if($dt['status_approve'] == "0"){
																				?>
																				<tr>
																					<td style="text-align: center"><?php echo $no; ?></td>
																					<td style="text-align: center">
																						<input type="checkbox" name="chkPekerjalembur[]" value="<?php echo $dt['id_rencana'] ?>">
																					</td>
																					<td style="text-align: center"><?php echo $dt['tanggal_lembur'] ?></td>
																					<td style="text-align: center"><?php echo $dt['mulai'] ?></td>
																					<td style="text-align: center"><?php echo $dt['selesai'] ?></td>
																					<td><?php echo $dt['nama_lembur'] ?></td>
																					<td><?php echo $dt['pekerjaan'] ?></td>
																					<td><?php echo $dt['noind']." - ".$dt['nama_pekerja'] ?></td>
																					<td style="text-align: center"><?php echo $dt['makan'] == "1" ? "Ya" : "Tidak" ?></td>
																					<td><?php echo $dt['tempat_makan'] ?></td>
																					<td style="text-align: center"><?php echo $dt['shift'] ?></td>
																				</tr>
																				<?php 
																				$no++;
																			}
																		}
																	}
																	?>
																</tbody>
															</table>														
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<input type="submit" value="reject" class="btn btn-danger" name="txtSubmit">
															<input type="submit" value="approve" class="btn btn-primary" name="txtSubmit">
														</div>
													</div>
												</form>
											</div>
											<div id="approved" class="tab-pane fade">
												<div class="row">
													<div class="col-lg-12">
														<br>
														<table class="table table-striped table-bordered table-hover">
															<thead class="bg-green">
																<tr>
																	<th>No</th>
																	<th>Tanggal Lembur</th>
																	<th>Awal Lembur</th>
																	<th>Akhir Lembur</th>
																	<th>Jenis Lembur</th>
																	<th>pekerjaan</th>
																	<th>Pekerja</th>
																	<th>Makan</th>
																	<th>Tempat Makan</th>
																	<th>Shift</th>
																	<th>Waktu Approve</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																if (isset($data) and !empty($data)) {
																	$no = 1;
																	foreach ($data as $dt) {
																		if($dt['status_approve'] == "1"){
																			?>
																			<tr>
																				<td style="text-align: center"><?php echo $no; ?></td>
																				<td style="text-align: center"><?php echo $dt['tanggal_lembur'] ?></td>
																				<td style="text-align: center"><?php echo $dt['mulai'] ?></td>
																				<td style="text-align: center"><?php echo $dt['selesai'] ?></td>
																				<td><?php echo $dt['jenis_lembur'] ?></td>
																				<td><?php echo $dt['pekerjaan'] ?></td>
																				<td><?php echo $dt['noind']." - ".$dt['nama_pekerja'] ?></td>
																				<td style="text-align: center"><?php echo $dt['makan'] == "1" ? "Ya" : "Tidak" ?></td>
																				<td><?php echo $dt['tempat_makan'] ?></td>
																				<td style="text-align: center"><?php echo $dt['shift'] ?></td>
																				<td style="text-align: center"><?php echo $dt['approve_timestamp'] ?></td>
																			</tr>
																			<?php 
																			$no++;
																		}
																	}
																}
																?>
															</tbody>
														</table>														
													</div>
												</div>
											</div>
											<div id="rejected" class="tab-pane fade">
												<div class="row">
													<div class="col-lg-12">
														<br>
														<table class="table table-striped table-bordered table-hover">
															<thead class="bg-red">
																<tr>
																	<th>No</th>
																	<th>Tanggal Lembur</th>
																	<th>Awal Lembur</th>
																	<th>Akhir Lembur</th>
																	<th>Jenis Lembur</th>
																	<th>pekerjaan</th>
																	<th>Pekerja</th>
																	<th>Makan</th>
																	<th>Tempat Makan</th>
																	<th>Shift</th>
																	<th>Waktu Reject</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																if (isset($data) and !empty($data)) {
																	$no = 1;
																	foreach ($data as $dt) {
																		if($dt['status_approve'] == "2"){
																			?>
																			<tr>
																				<td style="text-align: center"><?php echo $no; ?></td>
																				<td style="text-align: center"><?php echo $dt['tanggal_lembur'] ?></td>
																				<td style="text-align: center"><?php echo $dt['mulai'] ?></td>
																				<td style="text-align: center"><?php echo $dt['selesai'] ?></td>
																				<td><?php echo $dt['jenis_lembur'] ?></td>
																				<td><?php echo $dt['pekerjaan'] ?></td>
																				<td><?php echo $dt['noind']." - ".$dt['nama_pekerja'] ?></td>
																				<td style="text-align: center"><?php echo $dt['makan'] == "1" ? "Ya" : "Tidak" ?></td>
																				<td><?php echo $dt['tempat_makan'] ?></td>
																				<td style="text-align: center"><?php echo $dt['shift'] ?></td>
																				<td style="text-align: center"><?php echo $dt['approve_timestamp'] ?></td>
																			</tr>
																			<?php 
																			$no++;
																		}
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
			</div>
		</div>
	</div>
</section>