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
							<div class="text-right hidden-sm hidden-md hidden-xs">
								<a href="<?php echo site_url('ManagementAdmin') ?>" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<button data-toggle="modal" data-target="#target-Create" class="btn btn-primary"><i class="fa fa-plus fa-2x"></i></button>

								<!-- Modal create start -->
								<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="target-Create">
									<div role="document" class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-primary text-center">
												<label class="modal-title">Tambah Pekerjaan Baru</label>
											</div>
											<div class="modal-body">
												<form class="form form-horizontal">
													<div class="panel-body">
														<div class="form-group">
															<label class="control-label col-lg-4">Kode</label>
															<div class="col-lg-8">
																<input type="text" class="form-control" name="txtKode" value="<?php echo $kode['0']['kode']; ?>" disabled>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-lg-4">Nama Pekerjaan</label>
															<div class="col-lg-8">
																<input type="text" class="form-control" name="txtNamaPekerjaanTarget">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-lg-4">target Waktu</label>
															<div class="col-lg-8">
																<div class="input-group">
																	<input type="text" class="form-control" name="txtTargetWaktuTarget">
																	<span class="input-group-addon">Detik</span>
																</div>
																
															</div>
														</div>
														<div class="form-group col-lg-8 text-right">
															<button type="button" class="btn btn-primary" id="btnSubmitTargetAdmin">Ok</button>
															<button type="button" class="btn btn-danger" id="btnCancelTargetAdmin">Cancel</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<!-- Modal create End -->
								<!-- Modal update start -->
								<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="target-update">
									<div role="document" class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-primary text-center">
												<label class="modal-title">Edit Pekerjaan</label>
											</div>
											<div class="modal-body">
												<form class="form form-horizontal">
													<div class="panel-body">
														<div class="form-group">
															<label class="control-label col-lg-4">Kode</label>
															<div class="col-lg-8">
																<input type="text" class="form-control" name="txtKode" id="txtUpdateId" disabled>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-lg-4">Nama Pekerjaan</label>
															<div class="col-lg-8">
																<input type="text" class="form-control" name="txtNamaPekerjaanTarget" id="txtUpdatePekerjaan">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-lg-4">target Waktu</label>
															<div class="col-lg-8">
																<div class="input-group">
																	<input type="text" class="form-control" name="txtTargetWaktuTarget" id="txtUpdateTargetWaktu">
																	<span class="input-group-addon">Detik</span>
																</div>
																
															</div>
														</div>
														<div class="form-group col-lg-8 text-right">
															<button type="button" class="btn btn-primary" id="btnSubmitUpdateTargetAdmin">Ok</button>
															<button type="button" class="btn btn-danger" id="btnCancelUpdateTargetAdmin">Cancel</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<!-- Modal update End -->
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-striped table-bordered table-hover datatable-ma text-left">
												<thead class="bg-primary">
													<tr>
														<th class="text-center" style="width: 50px">No</th>
														<th class="text-center">Pekerjaan</th>
														<th class="text-center" style="width: 150px">Target Waktu (Detik)</th>
														<th class="text-center" style="width: 150px">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php if (isset($table) and !empty($table)) {
														$angka = 1;
														foreach ($table as $key) { 
														$encrypted_string = $this->encrypt->encode($key['id_target']);
            											$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string); ?>
														<tr>
															<td class="text-center"><?php echo $angka ?></td>
															<td><?php echo $key['pekerjaan'] ?></td>
															<td class="text-center"><?php echo $key['target_waktu'] ?></td>
															<td class="text-center">
																<button type="button" data-pekerjaan="<?php echo $key['pekerjaan'] ?>" data-targetwaktu="<?php echo $key['target_waktu'] ?>" data-idtarget="<?php echo $key['id_target'] ?>" id="btnUpdateDataTargetPekerjaan" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o fa-2x"></i></button>
																<a href="<?php echo site_url('ManagementAdmin/Target/Delete/'.$encrypted_string) ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-2x" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?')"></i></a>
															</td>
														</tr>
													<?php	$angka++;	}}  ?>
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