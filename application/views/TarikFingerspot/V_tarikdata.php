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
							<div class="box-header"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="">
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal</label>
												<div class="col-lg-3">
													<input type="text" name="txtTanggalTarikFinger" class="date form-control" id="tanggalTarikFinger" required>
												</div>
												<div class="col-lg-2">
													<button type="submit" class="btn btn-primary">Cari</button>
												</div>
											</div>
										</form>
									</div>
								</div> 
								<hr>
								<div class="row">
									<?php if (isset($table) and !empty($table)) { ?>
										<div class="col-lg-12">
											<div class="table-responsive">
												<table class="datatable table table-striped table-hover table-bordered text-left datatable-ma">
													<thead class="bg-primary">
														<tr>
															<th>No</th>
															<th>Tanggal</th>
															<th>Noind</th>
															<th>Kodesie</th>
															<th>Waktu</th>
															<th>user</th>
															<th>Noind Baru</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($table as $key) { 
															$no = 1; ?>
															<tr>
																<td><?php echo $no; ?></td>
																<td><?php echo $key['tanggal']; ?></td>
																<td><?php echo $key['noind']; ?></td>
																<td><?php echo $key['kodesie']; ?></td>
																<td><?php echo $key['waktu']; ?></td>
																<td><?php echo $key['user_']; ?></td>
																<td><?php echo $key['noind_baru']; ?></td>
															</tr>
														<?php $no++; } ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-lg-11 text-right">
											<a href="<?php echo base_url('TarikFingerspot/TarikData/'.$tanggal); ?>" target="_blank" class="btn btn-success">Insert</a>
										</div>
									<?php } ?>
								</div> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>