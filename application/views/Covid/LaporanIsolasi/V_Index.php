<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}

											.dataTables_info {
												float: left
											}
											td:not(:nth-child(2)) {
												text-overflow: ellipsis;
												overflow: hidden;
												white-space: nowrap;
												max-width: 200px;
											}
										</style>
										<table class="table table-striped table-bordered table-hover" id="tbl-CVD-LaporanIsolasi">
											<thead>
												<tr>
													<th>No.</th>
													<th>Action</th>
													<th>No. Induk</th>
													<th>Nama</th>
													<th>Seksi</th>
													<th>Departemen</th>
													<th>Tanggal Interaksi</th>
													<th>Kasus</th>
													<th>Keputusan</th>
													<th>Mulai Masuk</th>
													<th>Tunda Masuk</th>
													<th>Keterangan Keputusan</th>
													<th>PIC</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $key => $value) {
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td>
																<a href="#" class="btn btn-xs btn-info"><span class="fa fa-edit"></span>&nbsp;&nbsp;edit</a>
																<button class="btn btn-xs btn-danger"><span class="fa fa-trash"></span>&nbsp;&nbsp;Hapus</button>
																<a href="#" class="btn btn-xs btn-warning"><span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;Berita Acara</a>
															</td>
															<td><?php echo $value['noind'] ?></td>
															<td><?php echo $value['nama'] ?></td>
															<td><?php echo $value['seksi'] ?></td>
															<td><?php echo $value['dept'] ?></td>
															<td><?php echo $value['tgl_interaksi'] ?></td>
															<td><?php echo $value['kasus'] ?></td>
															<td><?php echo $value['keputusan'] == '1' ? 'Masuk' : 'Tunda Masuk'; ?></td>
															<td><?php echo $value['keputusan'] == '1' ? $value['tgl_keputusan'] : '-'; ?></td>
															<td><?php echo $value['keputusan'] == '1' ? '-' : $value['tgl_keputusan']; ?></td>
															<td><?php echo $value['keterangan'] ?></td>
															<td><?php echo $value['created_by'] ?></td>
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