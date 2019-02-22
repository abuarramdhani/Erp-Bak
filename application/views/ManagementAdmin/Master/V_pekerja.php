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
								<button data-toggle="modal" data-target="#pekerja-Create" class="btn btn-primary"><i class="fa fa-plus fa-2x"></i></button>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-striped table-bordered table-hover datatable-ma text-left">
												<thead class="bg-primary">
													<tr>
														<th class="text-center" style="width: 50px">No</th>
														<th class="text-center" style="width: 150px">No Induk</th>
														<th class="text-center">Nama</th>
														<th class="text-center" style="width: 150px">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php if (isset($table) and !empty($table)) {
														$angka = 1;
														foreach ($table as $key) { 
														$encrypted_string = $this->encrypt->encode($key['id_pekerja']);
            											$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string); ?>
														<tr>
															<td class="text-center"><?php echo $angka ?></td>
															<td class="text-center"><?php echo $key['noind'] ?></td>
															<td><?php echo $key['nama_pekerja'] ?></td>
															<td class="text-center">
																<a href="<?php echo site_url('ManagementAdmin/Pekerja/Delete/'.$encrypted_string) ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?')"><i class="fa fa-trash fa-2x"></i></a>
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
						<!-- Modal create start -->
								<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="pekerja-Create">
									<div role="document" class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-primary text-center">
												<label class="modal-title">Tambah Pekerjaan Baru</label>
											</div>
											<div class="modal-body">
												<form class="form form-horizontal">
													<div class="panel-body">
														<div class="form-group">
															<label class="control-label col-lg-4">Noind</label>
															<div class="col-lg-8">
																<select class="selectPekerjaMasterMA" id="selectPekerjaMasterMA" name="txtNoind" style="width: 100%"></select>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-lg-4">Nama Pekerja</label>
															<div class="col-lg-8">
																<input type="text" class="form-control" name="txtNamaPekerja" disabled>
															</div>
														</div>
														<div class="form-group col-lg-8 text-right">
															<button type="button" class="btn btn-primary" id="btnSubmitPekerja">Ok</button>
															<button type="button" class="btn btn-danger" id="btnCancelPekerja">Cancel</button>
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
</section>