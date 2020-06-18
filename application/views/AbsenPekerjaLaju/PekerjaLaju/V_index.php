<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?php echo $Title  ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="row">
									<div class="col-lg-12">
										<a href="<?php echo base_url('AbsenPekerjaLaju/PekerjaLaju/tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span>&nbsp; Tambah</a>	
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-hover table-striped table-bordered" id="tblPekerjaLaju">
											<thead>
												<tr>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">No.</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Action</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">No. Induk</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Nama</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Alamat</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Desa</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Kecamatan</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Kabupaten</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Provinsi</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Jenis Transportasi</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Tanggal Input</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">User Input</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Status Aktif</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Tanggal Non Aktif</th>
													<th class="bg-primary" style="vertical-align: middle;text-align: center;">Koordinat Rumah (latitude, longitude)</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														$encrypted_string = $this->encrypt->encode($dt['laju_id']);
                                                		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td>
																<a href="<?php echo base_url('AbsenPekerjaLaju/PekerjaLaju/Edit/'.$encrypted_string) ?>" class="btn btn-info btn-sm"><span class="fa fa-pencil-square-o"></span>&nbsp;Edit</a>
																<a href="<?php echo base_url('AbsenPekerjaLaju/PekerjaLaju/Hapus/'.$encrypted_string) ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus <?php echo $dt['noind'].' - '.$dt['nama'] ?> dari daftar pekerja laju')" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span>&nbsp;Hapus</a>		
															</td>
															<td><?php echo $dt['noind'] ?></td>
															<td><?php echo $dt['nama'] ?></td>
															<td><?php echo $dt['alamat'] ?></td>
															<td><?php echo $dt['desa'] ?></td>
															<td><?php echo $dt['kecamatan'] ?></td>
															<td><?php echo $dt['kabupaten'] ?></td>
															<td><?php echo $dt['provinsi'] ?></td>
															<td>
																<?php 
																$transportasi_text = "";
																if (isset($transportasi) && !empty($transportasi)) {
																	if (isset($dt['jenis_transportasi']) && !empty($dt['jenis_transportasi'])) {
																		$trans = $dt['jenis_transportasi'];
																		$transportasi_pekerja = explode(",", $trans);
																		foreach ($transportasi as $ts) {
																			foreach ($transportasi_pekerja as $tp) {
																				if ($ts['id_transportasi'] == $tp) {
																					if ($transportasi_text == "") {
																						$transportasi_text = $ts['jenis_transportasi'];
																					}else{
																						$transportasi_text .= ", ".$ts['jenis_transportasi'];
																					}
																				}
																			}
																		}
																	}
																}
																echo $transportasi_text;
																?>		
															</td>
															<td><?php echo $dt['tgl_input'] ?></td>
															<td><?php echo $dt['user_input']." - ".$dt['nama_user'] ?></td>
															<td><?php echo $dt['status_active'] == 't' ? 'Aktif' : 'NonAktif' ?></td>
															<td><?php echo $dt['tgl_non_active'] ?></td>
															<td><?php echo $dt['latitude'].",".$dt['longitude'] ?></td>
														</tr>
														<?php 
														$nomor++;
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