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
							<div class="box-header with-border text-right">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('ADMPelatihan/Cetak/Undangan/Create') ?>">
											<div class="form-group">
												<label class="control-label col-lg-3">Tanggal</label>
												<div class="col-lg-6" id="cetakTanggalUndangan">
													<input type="text" class="date form-control" name="txtTanggalUndanganPelatihan" id="txtTanggalUndanganPelatihan" value="<?php echo date('d F Y') ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Waktu</label>
												<div class="col-lg-6">
													<div class="col-lg-12 input-group bootstrap-timepicker timepicker">
														<input type="text" class="date form-control" name="txtWaktuUndanganPelatihan" id="txtWaktuUndanganPelatihan" required>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Tempat</label>
												<div class="col-lg-6">
													<input type="text" class="form-control" placeholder="Tempat" name="txtTempatUndanganPelatihan" id="txtTempatUndanganPelatihan" maxlength="30" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Acara</label>
												<div class="col-lg-6">
													<input type="text" class="form-control" placeholder="Acara" name="txtAcaraUndanganPelatihan" id="txtAcaraUndanganPelatihan" maxlength="30" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Approval</label>
												<div class="col-lg-6">
													<select class="select select2" name="txtApprovalUndanganPelatihan" id="txtApprovalUndanganPelatihan" data-placeholder="Approval" style="width:100%" required>
														<option></option>
														<?php foreach ($pekerja as $value) { ?>
															<option value="<?php echo $value['noind'] ?>"> <?php echo $value['noind']." - ".$value['nama'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Peserta</label>
												<div class="col-lg-6">
													<select class="select select2" data-placeholder="Peserta" name="txtPesertaUndanganPelatihan[]" id="txtPesertaUndanganPelatihan" multiple="multiple" style="width:100%" required>
														<option></option>
														<?php foreach ($pekerja as $value) { ?>
															<option value="<?php echo $value['noind'] ?>"> <?php echo $value['noind']." - ".$value['nama'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button type="button" class="btn btn-info" data-toggle="modal" data-target="#import-Pelatihan-Create">Cari Pelatihan</button>
													<button type="submit" class="btn btn-primary">Cetak</button>
												</div>
											</div>
										</form>
								<!-- Modal create start -->
								<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="import-Pelatihan-Create">
									<div role="document" class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-primary text-center">
												<label class="modal-title">Cari Pelatihan</label>
											</div>
											<div class="modal-body">
												<form class="form form-horizontal">
													<div class="panel-body">
														<div class="form-group">
															<label class="control-label col-lg-4">Tanggal Pelatihan</label>
															<div class="col-lg-8" id="cetakTanggalUndangan2">
																<input type="text" class="date form-control" name="txtTanggalPelatihanUndangan" id="txtTanggalPelatihanUndangan">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-lg-4">Nama Pelatihan</label>
															<div class="col-lg-8">
																<select class="txtNamaPelatihanUndangan" data-placeholder="Nama Pelatihan" name="txtNamaPelatihanUndangan" id="txtNamaPelatihanUndangan" style="width: 100%"></select>
															</div>
														</div>
														<div class="form-group col-lg-8 text-right">
															<button type="button" class="btn btn-primary" id="btnSubmitImportPelatihan">Ok</button>
															<button type="button" class="btn btn-danger" id="btnCancelPelatihanUndangan">Cancel</button>
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
			</div>
		</div>
	</div>
</section>