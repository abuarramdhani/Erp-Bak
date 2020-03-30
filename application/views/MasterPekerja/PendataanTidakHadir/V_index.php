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
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover" id="tblPendataanTidakHadir">
											<thead class="bg-primary">
												<tr>
													<th rowspan="2" style="vertical-align: middle;text-align: center">No.</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">No. Induk</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">Nama</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">Jenis</th>
													<th colspan="4" style="vertical-align: middle;text-align: center">Gejala</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">Diagnosa</th>
													<th colspan="2" style="vertical-align: middle;text-align: center">Periode Sakit</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">Lokasi Pekerja</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">SK</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">Keterangan</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">User Input</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">Waktu Input</th>
													<th rowspan="2" style="vertical-align: middle;text-align: center">IP Address Input</th>
												</tr>
												<tr>
													<td style="vertical-align: middle;text-align: center">Batuk</td>
													<td style="vertical-align: middle;text-align: center">Pilek</td>
													<td style="vertical-align: middle;text-align: center">Demam</td>
													<td style="vertical-align: middle;text-align: center">Sesak Nafas</td>
													<td style="vertical-align: middle;text-align: center">Tanggal Mulai</td>
													<td style="vertical-align: middle;text-align: center">Tanggal Selesai</td>
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
															<td><?php echo $dt['noind'] ?></td>
															<td><?php echo $dt['nama'] ?></td>
															<td><?php echo $dt['jenis'] ?></td>
															<td><?php echo $dt['batuk'] ?></td>
															<td><?php echo $dt['pilek'] ?></td>
															<td><?php echo $dt['demam'] ?></td>
															<td><?php echo $dt['sesak'] ?></td>
															<td><?php echo $dt['diagnosa'] ?></td>
															<td><?php echo $dt['tanggal_mulai']=='0000-00-00' ? '-' : $dt['tanggal_mulai'] ?></td>
															<td><?php echo $dt['tanggal_selesai']=='0000-00-00' ? '-' : $dt['tanggal_selesai'] ?></td>
															<td style="width: 200px"><?php echo $dt['lokasi_pekerja'] ?></td>
															<td>
																<?php 
																	if($dt['foto_sk'] !== 'none'){
																			?>
																			<a href="<?php echo 'http://erp.quick.com/pendataan'.$dt['foto_sk'] ?>" target="_blank" class="btn btn-primary">Foto SK</a>
																			<?php 
																	}else{
																		echo "-";
																	}
																?>
															</td>
															<td style="width: 200px"><?php echo $dt['keterangan'] ?></td>
															<td><?php echo $dt['user_input'] ?></td>
															<td><?php echo $dt['tanggal_input'] ?></td>
															<td><?php echo $dt['ip_address'] ?></td>
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