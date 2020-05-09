<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<br><h1><?=$Title ?></h1></div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="row">
									<div class="col-lg-12 text-right">
										<a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span>&nbsp;Tambah</a>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-hover table-bordered" id="tblMPSuratIsolasiMandiriIndex">
											<thead class="bg-primary">
												<tr>
													<th>No.</th>
													<th>Action</th>
													<th>No. Surat</th>
													<th>Pekerja</th>
													<th>Tanggal Wawancara</th>
													<th>Tanggal Cetak</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if (isset($data) && !empty($data)) {
														$nomor = 1;
														foreach ($data as $dt) {
															$encrypted_string = $this->encrypt->encode($dt['id_isolasi_mandiri']);
															$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

															?>
															<tr>
																<td><?php echo $nomor ?></td>
																<td style="text-align: center">
																	<a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Ubah/'.$encrypted_string) ?>" class="btn btn-primary" disabled>Edit</a>
																	<a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/PDF/'.$encrypted_string) ?>" target="_blank" class="btn btn-warning">PDF</a>
																	<a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Hapus/'.$encrypted_string) ?>" class="btn btn-danger" onclick="return confirm('apakah anda yakin ingin menghapus data ini ?')">Delete</a>
																</td>
																<td><?php echo $dt['no_surat'] ?></td>
																<td><?php echo $dt['pekerja'] ?></td>
																<td><?php echo $dt['tgl_wawancara'] ?></td>
																<td><?php echo $dt['tgl_cetak'] ?></td>
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