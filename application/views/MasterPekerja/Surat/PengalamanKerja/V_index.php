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
										<a href="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/Tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span>&nbsp;Tambah</a>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-hover table-bordered" id="tbl" .$new_table_name. "">
											<thead class="bg-primary">
												<tr>
													<th style="text-align:center" width="5%">No.</th>
													<th style="text-align:center" width="20%">Action</th>
													<th style="text-align:center" width="5%">No. Surat</th>
													<th style="text-align:center" width="10%">Tanggal surat</th>
													<th style="text-align:center" width="10%">Pekerja</th>
													<th style="text-align:center" width="50%">Isi Surat</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if (isset($data) && !empty($data)) {
														$nomor = 1;
														foreach ($data as $dt) {


															?>
															<tr>
																<td><?php echo $nomor ?></td>
																<td style="text-align: center">
																	<a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Ubah') ?>" class="btn btn-primary">Edit</a>
																	<a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/PDF') ?>" target="_blank" class="btn btn-warning">PDF</a>
																	<a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Hapus') ?>" class="btn btn-danger" onclick="return confirm('apakah anda yakin ingin menghapus data ini ?')">Delete</a>
																</td>
																<td><?php echo $dt['no_surat'] ?></td>
																<td><?php echo $dt['tgl_surat'] ?></td>
																<td><?php echo $dt['pekerja'] ?></td>
																<td><?php echo $dt['isi_surat'] ?></td>
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