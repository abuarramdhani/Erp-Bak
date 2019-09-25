<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
								<br>
								<h4>Input Tambahan / Potongan</h4>
								<a class="btn btn-primary pull-right" href="<?php echo base_url("HitungHlcm/TambahanPotongan/History") ?>">History Potongan Tambahan</a>
								<a class="btn btn-primary pull-right" href="<?php echo base_url("HitungHlcm/TambahanPotongan/add_data") ?>">Add Potongan Tambahan</a>
								<br>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table id="hlcm-tbl-potongantambahan" class="table table-striped table-hover table-bordered">
											<thead>
												<tr>
													<th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
													<th rowspan="2" style="text-align: center; vertical-align: middle;">Action</th>
													<th rowspan="2" style="text-align: center; vertical-align: middle;">No. Induk</th>
													<th rowspan="2" style="text-align: center; vertical-align: middle;">Nama</th>
													<th rowspan="2" style="text-align: center; vertical-align: middle;">Pekerjaan</th>
													<th rowspan="2" style="text-align: center; vertical-align: middle;">Lokasi Kerja</th>
													<th colspan="6" style="text-align: center; vertical-align: middle;">Tambahan</th>
													<th colspan="6" style="text-align: center; vertical-align: middle;">Potongan</th>
												</tr>
												<tr>
													<th style="text-align: center; vertical-align: middle;">GP</th>
													<th style="text-align: center; vertical-align: middle;">UM</th>
													<th style="text-align: center; vertical-align: middle;">Lembur</th>
													<th style="text-align: center; vertical-align: middle;">Nominal GP</th>
													<th style="text-align: center; vertical-align: middle;">Nominal UM</th>
													<th style="text-align: center; vertical-align: middle;">Nominal Lembur</th>
													<th style="text-align: center; vertical-align: middle;">GP</th>
													<th style="text-align: center; vertical-align: middle;">UM</th>
													<th style="text-align: center; vertical-align: middle;">Lembur</th>
													<th style="text-align: center; vertical-align: middle;">Nominal GP</th>
													<th style="text-align: center; vertical-align: middle;">Nominal UM</th>
													<th style="text-align: center; vertical-align: middle;">Nominal Lembur</th>
												</tr>
											</thead>
											<tbody>
												<?php if (isset($data) and !empty($data)) {
													$angka = 1;
													foreach ($data as $key) { 

														$link = $this->encrypt->encode($key['awal'].'--'.$key['akhir'].'--'.$key['noind']);
														$link = str_replace(array('+', '/', '='), array('-', '_', '~'), $link);
														?>
														<tr>
															<td><?php echo $angka; ?></td>
															<td>
																<a href="<?php echo site_url('HitungHlcm/TambahanPotongan/editdata/'.$link) ?>"><span class="fa fa-pencil fa-2x" title="Edit Data"></span></a>
																<a onclick="return confirm('Apakah anda Yakin Ingin Menghapus Data Ini ?')" href="<?php echo site_url('HitungHlcm/TambahanPotongan/hapusdata/'.$link) ?>"><span class="fa fa-trash fa-2x" title="Hapus Data"></span></a>
															</td>
															<td><?php echo $key['noind'] ?></td>
															<td><?php echo $key['nama'] ?></td>
															<td><?php echo $key['pekerjaan'] ?></td>
															<td><?php echo $key['lokasi_kerja'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['tam_gp'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['tam_um'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['tam_lembur'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['nom_tam_gp'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['nom_tam_um'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['nom_tam_lembur'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['pot_gp'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['pot_um'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['pot_lembur'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['nom_pot_gp'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['nom_pot_um'] ?></td>
															<td style="text-align: center; vertical-align: middle;"><?php echo $key['nom_pot_lembur'] ?></td>
														</tr>
														<?php
														$angka++;
													}
												} ?>
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
</section>