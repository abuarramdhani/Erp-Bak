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
										<form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo base_url('HitungHlcm/THR/Perhitungan/hitung') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Idul Fitri</label>
												<div class="col-lg-4">
													<input type="text" name="txtHLCMIdulFitri" id="txtHLCMIdulFitri" class="form-control" placeholder="Pilih Tanggal Idul Fitri..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Periode Awal</label>
												<div class="col-lg-4">
													<input type="text" name="txtHLCMPeriodeAwalTHR" id="txtHLCMPeriodeAwalTHR" class="form-control" placeholder="Pilih Periode Awal..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Periode Akhir</label>
												<div class="col-lg-4">
													<input type="text" name="txtHLCMPeriodeAkhirTHR" id="txtHLCMPeriodeAkhirTHR" class="form-control" placeholder="Pilih Periode Akhir..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">File Bulan THR</label>
												<div class="col-lg-4">
													<input type="file" name="flHLCMBulanTHR" id="flHLCMBulanTHR" class="form-control" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button class="btn btn-primary" type="submit" id="btnHLCMHitungTHR" disabled>Hitung THR</button>
													<button class="btn btn-danger" type="button" id="btnHLCMCetakTHR" <?php echo !isset($data) ? 'disabled' : '' ?>>Cetak Struk</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover">
											<thead class="bg-primary">
												<tr>
													<th style="text-align: center;vertical-align: middle;">No.</th>
													<th style="text-align: center;vertical-align: middle;">No. Induk</th>
													<th style="text-align: center;vertical-align: middle;">Nama</th>
													<th style="text-align: center;vertical-align: middle;">Lokasi Kerja</th>
													<th style="text-align: center;vertical-align: middle;">Masuk Kerja</th>
													<th style="text-align: center;vertical-align: middle;">Masa Kerja</th>
													<th style="text-align: center;vertical-align: middle;">Bulan THR</th>
													<th style="text-align: center;vertical-align: middle;">Nominal THR</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														?>
															<tr>
																<td style="vertical-align: middle;text-align: center;"><?php echo $nomor ?></td>
																<td style="vertical-align: middle;text-align: center;"><?php echo $dt['noind'] ?></td>
																<td><?php echo $dt['nama'] ?></td>
																<td><?php echo $dt['lokasi'] ?></td>
																<td><?php echo $dt['masuk'] ?></td>
																<td><?php echo $dt['masa'] ?></td>
																<td style="vertical-align: middle;text-align: right;"><?php echo $dt['bulan'] ?></td>
																<td style="vertical-align: middle;text-align: right;"><?php echo number_format($dt['thr'],2,',','.') ?></td>
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