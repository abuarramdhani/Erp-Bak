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
								<a href="" data-toggle="modal" data-target="#PNBPPernyataan-Create" class="btn btn-primary"><i class="icon-plus icon-2x"></i></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover dataTable-pnbp">
												<thead class="bg-primary">
													<tr>
														<th rowspan="2" class="text-center" style="vertical-align: middle;">No</th>
														<th rowspan="2" class="text-center" style="vertical-align: middle;">Action</th>
														<th rowspan="2" class="text-center" style="vertical-align: middle;">Kelompok</th>
														<th rowspan="2" class="text-center" style="vertical-align: middle;">Indikator</th>
														<th rowspan="2" class="text-center" style="vertical-align: middle;">Pernyataan</th>
														<th colspan="4" class="text-center" style="vertical-align: middle;">Bobot Nilai</th>
														<th rowspan="2" class="text-center" style="vertical-align: middle;">Status Aktif</th>
													</tr>
													<tr>
														<th class="text-center">1</th>
														<th class="text-center">2</th>
														<th class="text-center">3</th>
														<th class="text-center">4</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														if (isset($pernyataan) and !empty($pernyataan)) {
															$angka = 1;
															foreach ($pernyataan as $key) { 
																	$encrypted_string = $this->encrypt->encode($key['id_pernyataan']);
            														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																?>
																<tr>
																	<td class="text-center"><?php echo $angka; ?></td>
																	<td class="text-center">
																		<a href='#' 
																		data-idpernyataan="<?php echo $encrypted_string ?>" 
																		data-idaspek="<?php echo $key['id_aspek'] ?>" 
																		data-aspek="<?php echo $key['nama_aspek'] ?>" 
																		data-pernyataan="<?php echo $key['pernyataan'] ?>" 
																		data-kelompok="<?php echo $key['kelompok'] ?>" 
																		data-n1="<?php echo $key['nilai_pil1'] ?>" 
																		data-n2="<?php echo $key['nilai_pil2'] ?>" 
																		data-n3="<?php echo $key['nilai_pil3'] ?>" 
																		data-n4="<?php echo $key['nilai_pil4'] ?>" 
																		data-aktif ="<?php echo $key['set_active'] ?>"
																		id="btnEditPernyataanPNBP">
																			<span data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data' class='fa fa-pencil-square-o fa-2x'></span>
																		</a>
																		<a href='<?php echo site_url('PNBP/SetupPernyataan/Delete/'.$encrypted_string) ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')" style="color:red;">
																			<span class='fa fa-trash fa-2x' title='Hapus'></span>
																		</a>
																	</td>
																	<td><?php echo $key['kelompok'] ?></td>
																	<td><?php echo $key['nama_aspek'] ?></td>
																	<td><?php echo $key['pernyataan'] ?></td>
																	<td><?php echo $key['nilai_pil1'] ?></td>
																	<td><?php echo $key['nilai_pil2'] ?></td>
																	<td><?php echo $key['nilai_pil3'] ?></td>
																	<td><?php echo $key['nilai_pil4'] ?></td>
																	<td><?php echo $key['set_active'] ?></td>
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
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="PNBPPernyataan-Create">
	<div role="document" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<label class="modal-title">Tambah Pernyataan Aspek Kelompok Baru</label>
			</div>
			<div class="modal-body">
				<form class="form form-horizontal">
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label col-lg-4">Nama Indikator</label>
							<div class="col-lg-8">
								<select class="selectPNBPIndikator" style="width: 100%"></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">Pernyataan</label>
							<div class="col-lg-8">
								<input type="text" name="txtPernyataanPNBP" placeholder="Pernyatan" class="form-control">
							</div>
						</div>
						<fieldset>
							<legend>Setting Nilai <i style="font-size: 8pt;color: red">(dapat dikosongi dahulu)</i></legend>
							<div class="form-group">
								<label class="control-label col-lg-4">Bobot Pilihan 1</label>
								<div class="col-lg-4">
									<input type="text" name="txtBobotPenilaian1PNBP" placeholder="Bobot 1" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Bobot Pilihan 2</label>
								<div class="col-lg-4">
									<input type="text" name="txtBobotPenilaian2PNBP" placeholder="Bobot 2" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Bobot Pilihan 3</label>
								<div class="col-lg-4">
									<input type="text" name="txtBobotPenilaian3PNBP" placeholder="Bobot 3" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Bobot Pilihan 4</label>
								<div class="col-lg-4">
									<input type="text" name="txtBobotPenilaian4PNBP" placeholder="Bobot 4" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Status Aktif</label>
								<div class="col-lg-4">
									<select class="select select2 statusAktifPernyataanPNBP" style="width: 100%">
										<option value="0">Non Aktif</option>
										<option value="1">Aktif</option>
									</select>
								</div>
							</div>
						</fieldset>
						<div class="form-group col-lg-8 text-right">
							<button type="button" class="btn btn-primary" id="btnSubmitPernyataanCreate">Ok</button>
							<button type="button" class="btn btn-danger" id="btnCancelPernyataan">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal create End -->

<!-- Modal edit start -->
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="PNBPPernyataan-Edit">
	<div role="document" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<label class="modal-title">Ubah Pernyataan Aspek Kelompok</label>
			</div>
			<div class="modal-body">
				<form class="form form-horizontal">
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label col-lg-4">Nama Indikator</label>
							<div class="col-lg-8">
								<select class="selectPNBPIndikatorEdit" style="width: 100%"></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">Pernyataan</label>
							<div class="col-lg-8">
								<input type="text" name="txtPernyataanPNBPEdit" class="form-control">
								<input type="hidden" name="txtIDPernyataanPNBP" class="form-control">
							</div>
						</div>
						<fieldset>
							<legend>Setting Nilai <i style="font-size: 8pt;color: red">(dapat dikosongi dahulu)</i></legend>
							<div class="form-group">
								<label class="control-label col-lg-4">Bobot Pilihan 1</label>
								<div class="col-lg-4">
									<input type="text" name="txtBobotPenilaian1PNBPEdit" placeholder="Bobot 1" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Bobot Pilihan 2</label>
								<div class="col-lg-4">
									<input type="text" name="txtBobotPenilaian2PNBPEdit" placeholder="Bobot 2" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Bobot Pilihan 3</label>
								<div class="col-lg-4">
									<input type="text" name="txtBobotPenilaian3PNBPEdit" placeholder="Bobot 3" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Bobot Pilihan 4</label>
								<div class="col-lg-4">
									<input type="text" name="txtBobotPenilaian4PNBPEdit" placeholder="Bobot 4" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Status Aktif</label>
								<div class="col-lg-4">
									<select class="select select2 statusAktifPernyataanPNBPEdit" style="width: 100%">
										<option value="0">Non Aktif</option>
										<option value="1">Aktif</option>
									</select>
								</div>
							</div>
						</fieldset>
						<div class="form-group col-lg-8 text-right">
							<button type="button" class="btn btn-primary" id="btnSubmitPernyataanEdit">Ok</button>
							<button type="button" class="btn btn-danger" id="btnCancelPernyataan">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal edit End -->