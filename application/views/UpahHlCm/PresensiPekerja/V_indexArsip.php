<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?= $Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-xs hidden-md">
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table id="hlcm-tbl-arsippresensi" class="table table-striped table-hover table-bordered">
												<thead class="bg-primary">
													<tr>
														<th class="text-center">No</th>
														<th class="text-center">Periode Awal</th>
														<th class="text-center">Periode Akhir</th>
														<th class="text-center">Jenis</th>
														<th class="text-center">Keterangan</th>
														<th class="text-center">Pembuat</th>
														<th class="text-center">Tanggal Dibuat</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													if (isset($data) and !empty($data)) {
														$nomor = 1;
														foreach ($data as $key) { 
															$valLink = $this->encrypt->encode($key['id_presensi']);
															$valLink = str_replace(array('+', '/', '='), array('-', '_', '~'), $valLink);
															?>
															<tr>
																<td><?php echo $nomor; ?></td>
																<td><?php echo $key['tgl_awal_periode'] ?></td>
																<td><?php echo $key['tgl_akhir_periode'] ?></td>
																<td><?php echo $key['asal'] ?></td>
																<td><?php echo $key['keterangan'] ?></td>
																<td><?php echo $key['created_by'] ?></td>
																<td><?php echo $key['created_date'] ?></td>
																<td>
																	<a target="_blank" href="<?php echo site_url('HitungHlcm/ArsipPresensi/detail_arsip?method=view&data='.$valLink); ?>" class="fa fa-file-o fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Read Data'></a>
																	<a target="_blank" href="<?php echo site_url('HitungHlcm/ArsipPresensi/detail_arsip?method=xls&data='.$valLink); ?>" class="fa fa-file-excel-o fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Export Excel'></a>
																	<a target="_blank" href="<?php echo site_url('HitungHlcm/ArsipPresensi/detail_arsip?method=pdf&data='.$valLink); ?>" class="fa fa-file-pdf-o fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Export PDF'></a>
																</td>
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
	</div>
</section>