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
										<a href="<?php echo base_url('HitungHlcm/THR/Perhitungan/proses') ?>" class="btn btn-primary">Hitung THR</a>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered">
											<thead class="bg-primary">
												<tr>
													<th style="text-align: center;vertical-align: middle;">NO.</th>
													<th style="text-align: center;vertical-align: middle;">IDUL FITRI</th>
													<th style="text-align: center;vertical-align: middle;">JUMLAH</th>
													<th style="text-align: center;vertical-align: middle;">LIHAT</th>
													<th style="text-align: center;vertical-align: middle;">EXPORT EXCEL</th>
													<th style="text-align: center;vertical-align: middle;">CETAK PDF</th>
													<th style="text-align: center;vertical-align: middle;">HAPUS</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if (isset($data) && !empty($data)) {
														$nomor = 1;
														foreach ($data as $dt) {
															?>
															<tr>
																<td rowspan="3" style="text-align: center;vertical-align: middle;"><?php echo $nomor ?></td>
																<td rowspan="3" style="text-align: center;vertical-align: middle;">
																	<?php echo date('d M Y',strtotime($dt['tgl_idul_fitri'])) ?>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	TOTAL : <?php echo $dt['jumlah'] ?><br>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-info" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/read?tanggal='.$dt['tgl_idul_fitri']) ?>" target="blank"><span class="fa fa-file-o"></span>&nbsp;SEMUA</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-success" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/export?tanggal='.$dt['tgl_idul_fitri']) ?>" target="blank"><span class="fa fa-file-excel-o"></span>&nbsp;SEMUA</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-warning" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/cetak?tanggal='.$dt['tgl_idul_fitri']) ?>" target="blank"><span class="fa fa-file-pdf-o"></span>&nbsp;SEMUA</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-danger" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/delete?tanggal='.$dt['tgl_idul_fitri']) ?>" target="blank"><span class="fa fa-trash"></span>&nbsp;SEMUA</a>
																</td>
															</tr>
															<tr>
																<td style="text-align: center;vertical-align: middle;">
																	YOGYAKARTA : <?php echo $dt['ygy'] ?><br>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-info" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/read?tanggal='.$dt['tgl_idul_fitri']."&lokasi=01") ?>" target="blank"><span class="fa fa-file-o"></span>&nbsp;YOGYAKARTA</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-success" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/export?tanggal='.$dt['tgl_idul_fitri']."&lokasi=01") ?>" target="blank"><span class="fa fa-file-excel-o"></span>&nbsp;YOGYAKARTA</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-warning" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/cetak?tanggal='.$dt['tgl_idul_fitri']."&lokasi=01") ?>" target="blank"><span class="fa fa-file-pdf-o"></span>&nbsp;YOGYAKARTA</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-danger" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/delete?tanggal='.$dt['tgl_idul_fitri']."&lokasi=01") ?>" target="blank"><span class="fa fa-trash"></span>&nbsp;YOGYAKARTA</a>
																</td>
															</tr>
															<tr>
																<td style="text-align: center;vertical-align: middle;">
																	TUKSONO : <?php echo $dt['tks'] ?><br>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-info" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/read?tanggal='.$dt['tgl_idul_fitri']."&lokasi=02") ?>" target="blank"><span class="fa fa-file-o"></span>&nbsp;TUKSONO</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-success" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/export?tanggal='.$dt['tgl_idul_fitri']."&lokasi=02") ?>" target="blank"><span class="fa fa-file-excel-o"></span>&nbsp;TUKSONO</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-warning" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/cetak?tanggal='.$dt['tgl_idul_fitri']."&lokasi=02") ?>" target="blank"><span class="fa fa-file-pdf-o"></span>&nbsp;TUKSONO</a>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a class="btn btn-danger" href="<?php echo base_url('HitungHlcm/THR/Perhitungan/delete?tanggal='.$dt['tgl_idul_fitri']."&lokasi=02") ?>" target="blank"><span class="fa fa-trash"></span>&nbsp;TUKSONO</a>
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
</section>