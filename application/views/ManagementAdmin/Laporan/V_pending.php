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
														<th>Alasan</th>
														<th>Action</th>
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
																	<td><?php echo $val['alasan'] ?></td>
																	<td><?php if ($val['status_isi'] !== 't') { ?>
																		<button class="btn btn-info" data-id="<?php echo $val['id_pending'] ?>" onclick="ModalTampilPending(this)"><i class="fa fa-arrow-right"></i></button>
																	<?php }else{ ?>
																		<button class="btn btn-info" disabled><i class="fa fa-arrow-right"></i></button>
																	<?php } ?>
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
							<!-- Modal create start -->
								<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="pending-Create">
									<div role="document" class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-primary text-center">
												<label class="modal-title">Tambah Alasan</label>
											</div>
											<div class="modal-body">
												<form class="form form-horizontal" method="post" action="<?php echo site_url('ManagementAdmin/Pending/Create') ?>">
													<div class="panel-body">
														<div class="form-group">
															<label class="control-label col-lg-4">Alasan</label>
															<textarea name="txtAlasan" class="form-control" style="height: 150px"></textarea>
															<input type="hidden" name="txtId">
														</div>
														<div class="form-group col-lg-8 text-right">
															<button type="submit" class="btn btn-primary">Ok</button>
															<button type="button" class="btn btn-danger" id="btnCancelPendingAdmin">Cancel</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							<!-- Modal create End -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>