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
								<a href="<?php echo site_url('SiteManagement') ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/InputAsset/InputDetailData') ?>">
											<div class="form-group">
												<label class="control-label col-lg-2">No PP</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="" value="<?php echo $noPP ?>" disabled>
													<input type="hidden" class="form-control" name="txtIDAsset" value="<?php echo $idAsset ?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12">
													<div class="panel panel-info text-right">
														<div class="panel-heading">
															<div class="col-lg-6 text-left">
																Barang
															</div>
																<button type="button" class="btn btn-primary icon-plus" onclick="addDetailAsset()"></button>
														</div>
														<div class="panel-body">
															<div class="table-responsive">
																<table class="datatable table table-bordered table-striped table-hover text-left">
																	<thead class="bg-primary">
																		<tr>
																			<th>No</th>
																		<th>Nama Barang</th>
																		<th>Kode barang</th>
																		<th>Jumlah</th>
																		<th>Umur Teknis</th>
																		<th>Spesifikasi</th>
																		<th>Action</th>
																		</tr>
																	</thead>
																	<tbody class="tbodyAsset">
																		<?php $angka = 1;
																		if (isset($asset) and !empty($asset)) {
																			foreach ($asset as $val) { ?>
																				<tr class="rowAsset">
																					<td id="angka"><?php echo $angka ?></td>
																					<td style="width: 350px">
																						<select class="select select2 classaset1" name="txtNamaBarang[]" style="width: 100%" onchange="gantiBarang(this)" required>
																							<option value="<?php echo $val['nama_item'] ?>"><?php echo $val['nama_item'] ?></option>
																						</select>
																					</td>
																					<td>
																						<input type="hidden" value="<?php echo $val['kode_item'] ?>" class="form-control classaset kode" name="txtKodebarang[]">
																						<input type="text" placeholder="Kode Barang" class="form-control classaset kode" value="<?php echo $val['kode_item'] ?>" name="txtKodebarang[]" disabled>
																					</td>
																					<td>
																						<input type="text" placeholder="Jumlah" class="form-control classaset" value="<?php echo $val['jumlah_diminta'] ?>" name="txtJumlah[]" required>
																					</td>
																					<td>
																						<input type="text" placeholder="Umur Teknis" class="form-control classaset" value="<?php echo $val['umur_teknis'] ?>" name="txtUmur[]" required>
																					</td>
																					<td>
																						<input type="text" placeholder="Spesifikasi" class="form-control classaset" value="<?php echo $val['spesifikasi_asset'] ?>" name="txtSpesifikasi[]" required>
																					</td>
																					<td>
																						<button type="button" class="btn btn-danger icon-trash" onclick="removeDetailAsset(this)"></button>
																					</td>
																				</tr>
																		<?php $angka++;
																			}
																		}else{ ?>
																			<tr class="rowAsset">
																				<td id="angka">1</td>
																				<td style="width: 350px">
																					<select class="select select2 classaset1" name="txtNamaBarang[]" style="width: 100%" onchange="gantiBarang(this)" required>
																						<option></option>
																					</select>
																				</td>
																				<td>
																					<input type="hidden" class="form-control classaset kode" name="txtKodebarang[]">
																					<input type="text" placeholder="Kode Barang" class="form-control classaset kode" name="txtKodebarang[]" disabled>
																				</td>
																				<td>
																					<input type="text" placeholder="Jumlah" class="form-control classaset" name="txtJumlah[]" required>
																				</td>
																				<td>
																					<input type="text" placeholder="Umur Teknis" class="form-control classaset" name="txtUmur[]" required>
																				</td>
																				<td>
																					<input type="text" placeholder="Spesifikasi" class="form-control classaset" name="txtSpesifikasi[]" required>
																				</td>
																				<td>
																					<button type="button" class="btn btn-danger icon-trash" onclick="removeDetailAsset(this)"></button>
																				</td>
																			</tr>
																		<?php } ?>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>		
											</div>
											<div class="form-group">
												<div class="col-lg-11">
													<button type="submit" class="btn btn-success">Simpan</button>
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
</section>