<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h3><b><?=$Title ?></b></h3>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="<?php echo base_url('PNBP') ?>" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="" data-toggle="modal" data-target="#PNBPIndikator-Create" class="btn btn-primary"><i class="icon-plus icon-2x"></i></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover dataTable-pnbd">
												<thead class="bg-primary">
													<tr>
														<th class="text-center">No</th>
														<th class="text-center">Action</th>
														<th class="text-center">Kelompok</th>
														<th class="text-center">Indikator</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														if (isset($indikator) and !empty($indikator)) {
															$angka = 1;
															foreach ($indikator as $key) { 
																	$encrypted_string = $this->encrypt->encode($key['id_aspek']);
            														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																?>
																<tr>
																	<td class="text-center"><?php echo $angka; ?></td>
																	<td class="text-center">
																		<a href='#' data-idaspek="<?php echo $encrypted_string ?>" data-idkelompok="<?php echo $key['id_kelompok'] ?>" data-aspek="<?php echo $key['nama_aspek'] ?>" data-kelompok="<?php echo $key['kelompok'] ?>" id="btnEditIndikatorPNBP"><span data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data' class='fa fa-pencil-square-o fa-2x'></span></a>
																		<a href='<?php echo site_url('PNBP/SetupIndikator/Delete/'.$encrypted_string) ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')" style="color:red;"><span class='fa fa-trash fa-2x' title='Hapus'></span></a>
																	</td>
																	<td><?php echo $key['kelompok'] ?></td>
																	<td><?php echo $key['nama_aspek'] ?></td>
																</tr>
															<?php $angka++;
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

<!-- Modal create start -->
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="PNBPIndikator-Create">
	<div role="document" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<label class="modal-title">Tambah Aspek Kelompok Baru</label>
			</div>
			<div class="modal-body">
				<form class="form form-horizontal">
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label col-lg-4">Nama Kelompok</label>
							<div class="col-lg-8">
								<select class="selectPNBPKelompok" style="width: 100%"></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">Nama Indikator</label>
							<div class="col-lg-8">
								<input type="text" name="txtIndikatorPNBP" class="form-control">
							</div>
						</div>
						<div class="form-group col-lg-8 text-right">
							<button type="button" class="btn btn-primary" id="btnSubmitIndikatorCreate">Ok</button>
							<button type="button" class="btn btn-danger" id="btnCancelIndikator">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal create End -->

<!-- Modal edit start -->
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="PNBPIndikator-Edit">
	<div role="document" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<label class="modal-title">Ubah Aspek Kelompok</label>
			</div>
			<div class="modal-body">
				<form class="form form-horizontal">
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label col-lg-4">Nama Kelompok</label>
							<div class="col-lg-8">
								<select class="selectPNBPKelompokEdit" style="width: 100%"></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">Nama Indikator</label>
							<div class="col-lg-8">
								<input type="text" name="txtIndikatorPNBPEdit" class="form-control">
								<input type="hidden" name="txtIDIndikatorPNBP" class="form-control">
							</div>
						</div>
						<div class="form-group col-lg-8 text-right">
							<button type="button" class="btn btn-primary" id="btnSubmitIndikatorEdit">Ok</button>
							<button type="button" class="btn btn-danger" id="btnCancelIndikator">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal edit End -->