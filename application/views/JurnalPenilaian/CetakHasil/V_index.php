<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?php echo $Title; ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
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
										<form class="form-horizontal" method="POST" action="<?php echo site_url('PenilaianKinerja/CetakHasil/Proses') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">No. SKDU</label>
												<div class="col-lg-4">
													<input type="text" name="txtNoSKDU" id="txtNoSKDU" class="form-control" placeholder="No SKDU" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal SKDU</label>
												<div class="col-lg-4">
													<input type="text" class="date form-control" name="txtTanggalSKDU" id="txtTanggalSKDU" placeholder="Tanggal SKDU" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">periode</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtPeriodeSKDU" data-placeholder="periode" style="width: 100%">
														<option></option>
														<?php if (isset($periode) and !empty($periode)) {
															foreach ($periode as $key) { ?>
																<option><?php echo $key['periode'] ?></option>
															<?php }
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button type="submit" class="btn btn-primary">Proses</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- <div class="row">
									<div class="col-lg-12 text-right">
										<a href="<?php  //echo site_url('PenilaianKinerja/CetakHasil/Cetak/lrJEPRehqMXJzKk7JFkVbj8tkw7BL2TtWEh-88heme63R4BlWMVvFHdHn_Z2BI7RXVRwt7kFOaT6uIZb7_4E3w~~') ?>" class="btn btn-danger fa fa-file-pdf-o fa-2x"></a>
									</div>
								</div> -->
								<?php if (isset($table) and !empty($table)): ?>
									<div class="row">
										<div class="col-lg-12 text-right">
											<a target="_blank" href="<?php echo site_url('PenilaianKinerja/CetakHasil/Cetak/'.$encrypted_link) ?>" class="btn btn-danger fa fa-file-pdf-o fa-2x"></a>
											<a target="_blank" href="<?php echo site_url('PenilaianKinerja/CetakHasil/Excel/'.$encrypted_link) ?>" class="btn btn-success fa fa-file-excel-o fa-2x"></a>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="table-responsive">
												<table class="table table-striped table-bordered table-hover" id="JurnalPenilaian-masterSuratPeringatan">
													<thead class="bg-primary">
														<tr>
															<th>No</th>
															<th>Noind</th>
															<th>Nama</th>
															<th>Unit</th>
															<th>Seksi</th>
															<th>Skor</th>
															<th>Gol. Nilai</th>
															<th>naik/Bulan</th>
															<th>GP Lama</th>
															<th>GP Baru</th>
														</tr>
													</thead>
													<tbody>
														<?php 
															$nomor = 1;
															foreach ($table as $val) { ?>
																<tr>
																	<td><?php echo $nomor; ?></td>
																	<td><?php echo $val['noind'] ?></td>
																	<td><?php echo $val['nama'] ?></td>
																	<td><?php echo $val['unit'] ?></td>
																	<td><?php echo $val['seksi'] ?></td>
																	<td><?php echo $val['skor'] ?></td>
																	<td><?php echo $val['gol_nilai'] ?></td>
																	<td><?php echo $val['nominal_kenaikan'] ?></td>
																	<td><?php echo $val['gp_lama'] ?></td>
																	<td><?php echo $val['gp_baru'] ?></td>
																</tr>
															<?php $nomor++; }
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								<?php endif ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>