<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post">
											<?php foreach ($Pekerja as $val) { ?>
												<div class="form-group">
													<label class="control-label col-lg-4">Periode</label>
													<div class="col-lg-5">
														<input type="text" class="date form-control cmpuasadaterange" name="txtBulanTransferPuasa" id="txtBulanTransferPuasa" value="<?php echo $Tanggal ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">No Induk</label>
													<div class="col-lg-2"style="margin-right: 0px;">
														<select class="select select2" name="txtNoindPenguranganPuasa" id="txtNoindPenguranganPuasa" style="width: 100%" disabled>
															<option value="<?php echo $val['noind'] ?>"><?php echo $val['noind'] ?></option>
														</select>
													</div>
													<div class="col-lg-3">
														<input type="text" class="form-control" id="txtNamaTransferPuasa" value="<?php echo $val['nama'] ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Kode Seksi</label>
													<div class="col-lg-5">
														<input type="text" class="form-control" value="<?php echo $val['kodesie'] ?>" id="txtKodesieTransferPuasa" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Nama Seksi</label>
													<div class="col-lg-5">
														<input type="text" class="form-control" value="<?php echo $val['seksi'] ?>" id="txtSeksiTransferPuasa" disabled>
													</div>
												</div>
												
												
											<?php } ?>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/Puasa/Pengurangan/Read/'.$encrypted_date) ?>" id="formReadPuasaCatering">
											<div class="form-group" id="formEditReadPuasaCatering" style="display: none;">
												<label class="control-label col-lg-2">Tanggal Edit</label>
												<div class="col-lg-4">
													<input type="text" class="date form-control cmpuasadaterange" name="txtTanggalPuasaEdit" required>
												</div>
											</div>
											<div class="form-group" id="formDeleteReadPuasaCatering" style="display: none;">
												<label class="control-label col-lg-2">Tanggal Hapus</label>
												<div class="col-lg-4">
													<input type="text" class="date form-control cmpuasadaterange" name="txtTanggalPuasaDelete" required>
												</div>
											</div>
											<div class="form-group" id="formStatusReadPuasaCatering" style="display: none;">
												<label class="control-label col-lg-2">Status</label>
												<div class="col-lg-4">
													<div class="col-lg-6">
														<input type="radio" name="radioStatusPuasa" value="1"> Puasa
													</div>
													<div class="col-lg-6">
														<input type="radio" name="radioStatusPuasa" value="0"> Tidak Puasa
													</div>
												</div>
											</div>
											<div class="form-group" id="btnSubmitReadPuasaCatering" style="display: none;">
												<input type="hidden" name="txtNoindPuasaEdit" value="<?php echo $noind ?>">
												<div class="col-lg-6 text-right">
													<button type="submit" class="btn btn-primary">Simpan</button>
													<button type="button" class="btn btn-danger" onclick="batalPilihPuasa()">Batal</button>
												</div>
											</div>
											<div class="form-group" id="btnPilihReadPuasaCatering">
												<div class="col-lg-6 text-right">
													<button type="button" class="btn btn-info" onclick="pilihEditPuasa()">Edit Data</button>
													<button type="button" class="btn btn-warning" onclick="pilihDeletePuasa()">Hapus Data</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-bordered table-striped table-hover text-left">
												<thead class="bg-primary">
													<tr>
														<th>No.</th>
														<th>Tanggal</th>
														<th>No Induk</th>
														<th>Status Puasa</th>
													</tr>
												</thead>
												<tbody>
													<?php $angka = 1;foreach ($puasa as $key) { ?>
														<tr>
														<td><?php echo $angka ?></td>
														<td><?php echo $key['tanggal'] ?></td>
														<td><?php echo $noind ?></td>
														<td><?php if ($key['status'] == 't') {
															echo "Puasa";
														}else{echo "Tdak Puasa";}   ?></td>
													</tr>
													<?php $angka++;} ?>
													
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