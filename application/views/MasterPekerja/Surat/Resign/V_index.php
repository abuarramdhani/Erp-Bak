<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<a href="<?php echo site_url('MasterPekerja/Surat/SuratResign/create') ?>" class="btn btn-primary">
									<span class="fa fa-plus fa-2x"></span>
								</a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover" id="tblSuratResign">
											<thead class="bg-primary">
												<tr>
													<th>No</th>
													<th style="width: 100px">Action</th>
													<th>No Induk</th>
													<th>Nama</th>
													<th>No Induk baru</th>
													<th>Tanggal Resign</th>
													<th>Sebab Resign</th>
													<th>Diterima HubKer</th>
													<th>DiCutoff</th>
													<th>Dibuat</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if(isset($data) && !empty($data)){
														$nomor = 1;
														foreach ($data as $dt) {
															$id_encrypted = $this->encrypt->encode($dt['pengajuan_id']);
 															$id_encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_encrypted);
															?>
																<tr>
																	<td><?=$nomor ?></td>
																	<td>
																		<a href="<?php echo site_url('MasterPekerja/Surat/SuratResign/edit/'.$id_encrypted) ?>" class="btn btn-primary btn-sm">
																			<span class="fa fa-wrench"></span>Edit
																		</a>
																		<a href="<?php echo site_url('MasterPekerja/Surat/SuratResign/delete/'.$id_encrypted) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?')">
																			<span class="fa fa-trash"></span>Hapus
																		</a>
																	</td>
																	<td><?php echo $dt['noind'] ?></td>
																	<td><?php echo $dt['nama'] ?></td>
																	<td><?php echo $dt['noind_baru'] ?></td>
																	<td><?php echo strftime("%d %B %Y",strtotime($dt['tgl_resign'])) ?></td>
																	<td><?php echo $dt['sebab'] ?></td>
																	<td><?php echo strftime("%d %B %Y",strtotime($dt['tgl_diterima'])) ?></td>
																	<td><?php echo $dt['reffgaji'] ? $dt['reffgaji'] : 'Belum Dihitung' ?></td>
																	<td><?php echo strftime("Tanggal : %d %B %Y <br>Pukul : %X",strtotime($dt['creation_date'])) ?></td>
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