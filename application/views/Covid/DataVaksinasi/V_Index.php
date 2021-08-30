<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<b><h1><?=$Title ?></h1></b>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover" id="tbl-CVD-DataVaksinasi-table">
											<thead>
												<tr>
													<th class="bg-primary">No.</th>
													<th class="bg-primary">No. Induk</th>
													<th class="bg-primary">Nama</th>
													<th class="bg-primary">NIK</th>
													<th class="bg-primary">Kelompok Vaksin</th>
													<th class="bg-primary">Tanggal Vaksin</th>
													<th class="bg-primary">Jenis Vaksin</th>
													<th class="bg-primary">Lokasi Vaksin</th>
													<th class="bg-primary">Vaksin Ke</th>
													<th class="bg-primary">Kartu Vaksin</th>
													<th class="bg-primary">Sertifikat Vaksin</th>
													<th class="bg-primary">Tanggal Input</th>
													<th class="bg-primary">User Input</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														?>
														<tr>
															<td><?=$nomor ?></td>
															<td><?=$dt['noind'] ?></td>
															<td><?=$dt['nama'] ?></td>
															<td><?=$dt['nik'] ?></td>
															<td><?=$dt['kelompok_vaksin'] ?></td>
															<td><?=$dt['tanggal_vaksin'] ?></td>
															<td><?=$dt['jenis_vaksin'] ?></td>
															<td><?=$dt['lokasi_vaksin'] ?></td>
															<td><?=$dt['vaksin_ke'] ?></td>
															<td>
																<a target="_blank" href="<?php echo base_url('assets/upload/pemutihan_data_pekerja/attachment/'.$dt['path_kartu_vaksin']) ?>">
																	<span class="fa fa-image"></span>
																</a>
															</td>
															<td>
																<a target="_blank" href="<?php echo base_url('assets/upload/pemutihan_data_pekerja/attachment/'.$dt['path_sertifikat_vaksin']) ?>">
																	<span class="fa fa-image"></span>
																</a>
															</td>
															<td><?=$dt['tanggal_input'] ?></td>
															<td><?=$dt['user_input'] ?></td>
														</tr>
														<?php
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
</section>