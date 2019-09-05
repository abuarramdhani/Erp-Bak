<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<a href="<?php echo site_url('CateringManagement/Extra/EditTempatMakan') ?>" class="btn btn-default btn-lg">
								<span class="icon-wrench icon-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<ul class="nav nav-pills nav-justified">
								<li class="active"><a data-toggle="pill" href="#shift1">Edit Tempat Makan Per Seksi/ Unit/ Bidang/ Dep</a></li>
								<li><a data-toggle="pill" href="#shift2">Edit Tempat Makan Per Pekerja</a></li>
							</ul>
							<div class="tab-content">
								<div id="shift1" class="tab-pane fade in active">
									<div class="row text-center">
										<div class="col-lg-12">
										<br>
										<div class="box box-primary box-solid">
												<table class="datatable table table-bordered table-hover table-striped text-left">
												<form class="" action="index.html" method="post">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<label>Seksi/Unit/Bidang/Departement</label>
																</div>
														</div>
													<br><br><br>
													<div class="row text-left">
															<input type="hidden" name="noind" value="<?php echo "string";?>" >
													<label for="txtSeksi" class="control-label col-lg-4 text-right">Kode Seksi</label>
															<div class="col-lg-4">
																<select class="select select2 text-left" id="txtSeksiEdit" style="width: 100%" data-placeholder="--Pilih Kodesie--">
																	<option></option>
																	<?php foreach ($Kode as $key) { ?>
																		<option value="<?php echo $key['kodesie'] ?>"><?php echo $key['kodesie']." - ".$key['seksi']." - ".$key['pekerjaan']?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<label class="control-label col-lg-4 text-right">Departement</label>
															<div class="col-lg-4">
																<input type="text" class="form-control" id="txtDepartmenEditMakan" readonly>
															</div>
														</div>
														<br>
														<div class="row">
															<label class="control-label col-lg-4 text-right">Bidang</label>
															<div class="col-lg-4">
																<input type="text" class="form-control" id="txtEditBidangMakan" readonly>
															</div>
														</div>
														<br>
														<div class="row">
															<label class="control-label col-lg-4 text-right">Unit</label>
															<div class="col-lg-4">
																<input type="text" class="form-control" id="txtEditUnitMakan" readonly>
															</div>
														</div>
														<br>
														<div class="row">
															<label class="control-label col-lg-4 text-right">Seksi</label>
															<div class="col-lg-4">
																<input type="text" class="form-control" id="txtEditSeksiMakan" readonly>
															</div>
														</div>
														<br>
														<div class="row">
															<label class="control-label col-lg-4 text-right">Pekerjaan</label>
															<div class="col-lg-4">
																<input type="text" class="form-control" id="txtEditPekerjaanMakan" readonly>
															</div>
														</div>
														<br>
														<hr>
														<br>
														<div class="row text-left">
															<label class="control-label col-lg-4 text-right">Tempat Makan 1</label>
															<div class="col-lg-4">
																<select class="select2 text-left" id="makan1" style="width: 100%" disabled>
																	<option></option>
																	<?php foreach ($Makan as $key) { ?>
																		<option value="<?php echo $key['tempat_makan'] ?>"><?php echo $key['tempat_makan']?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
														<br>
														<div class="row text-left">
															<label class="control-label col-lg-4 text-right">Tempat Makan 2</label>
															<div class="col-lg-4">
																<select class="select2 text-left" id="makan2" style="width: 100%" disabled>
																	<option></option>
																	<?php foreach ($Makan as $key) { ?>
																		<option value="<?php echo $key['tempat_makan'] ?>"><?php echo $key['tempat_makan']?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
														<br>
															<button type="button" class="btn btn-primary edit_tempat_makan_semua" id="kirimAll" onclick="simpansemua()">Edit Semua</button>&nbsp
															<button type="button" class="btn btn-primary edit_tempat_makan_staff" id="kirimStaff" onclick="simpanstaff()">Edit Staff</button>&nbsp
															<button type="button" class="btn btn-primary edit_tempat_makan_nonstaff" id="kirimNonStaff" onclick="simpannonstaff()">Edit NonStaff</button>&nbsp
															<button type="button" class="btn btn-danger edit_tempat_makan_batal" id="batal1" onclick="batal()" style="display:none ;">Batal</button>&nbsp
															<button type="reset" class="btn btn-info" onclick="resetEdit()" >Reset</button>
														<br>
														</form>
												</table>
												</div>
										</div>
									</div>
								</div>
								<div id="shift2" class="tab-pane fade">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center" ></div>
																	<label>Tempat Makan Per-Pekerja</label>
																</div>
																<br>
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table dataTable-EditTmp table-bordered text-left" style="font-size:12px; width: 100%; margin: 1px; text-align: left;">
																	<div class="row"></div>

											                <thead>
											                <tr>
											                    <th>No</th>
											                    <th>Action</th>
											                    <th>No. Induk</th>
											                    <th>Nama</th>
											                    <th>Lokasi Kerja</th>
											                    <th>Tempat Makan 1</th>
											                    <th>Tempat Makan 2</th>
											                    <th>Seksi</th>
											                    <th>Unit</th>
											                    <th>Bidang</th>
											                    <th>Departement</th>
											                </tr>
											                </thead>
																			<tbody>
																				<?php
																					if (empty($data)) {
																						# code...
																					}else{
																						$no=1;
																						foreach ($data as $key) {
																							?>
																							<tr>
																								<td><?php echo $no; ?></td>
																								<td><a style="margin-right:4px" href="<?php echo base_url('CateringManagement/Extra/EditTempatMakan/edit/'.$key['noind']); ?>"
																									data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a></td>
																								<td><?php echo $key['noind']; ?></td>
																								<td><?php echo $key['nama']; ?></td>
																								<td><?php echo $key['lokasi_kerja']; ?></td>
																								<td><?php echo $key['tempat_makan1']; ?></td>
																								<td><?php echo $key['tempat_makan2']; ?></td>
																								<td><?php echo $key['seksi']; ?></td>
																								<td><?php echo $key['unit']; ?></td>
																								<td><?php echo $key['bidang'] ?></td>
																								<td><?php echo $key['dept'] ?></td>
																							</tr>
																							<?php
																							$no++;
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
	</div>

</section>
