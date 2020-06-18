<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
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
									<div class="col-lg-12 text-center">
										<label>Jadwal Pelayanan Catering <?php echo $data['lokasi'] == '1' ? 'Yogyakarta & Mlati' : 'Tuksono' ?><br>Bulan : <?php echo $data['bulan'] ?></label>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" target="_blank" method="post" action="<?php echo site_url('CateringManagement/Cetak/JadwalLayanan/Cetak') ?>">
											<div class="form-group">
												<label class="control-label col-lg-1">Paket</label>
												<div class="col-lg-2">
													<input type="text" class="form-control" value="<?php echo $data['paket'] ?>" disabled>
													<input type="hidden" name="txtPaketJadwalLayanan" value="<?php echo $data['paket'] ?>">
												</div>
												<div class="col-lg-7">
													<input type="hidden" name="txtPeriodeJadwalLayanan"  value="<?php echo $data['bulan'] ?>">
													<input type="hidden" name="slcLokasiJadwalLayanan"  value="<?php echo $data['lokasi'] ?>">
												</div>
												<label class="control-label col-lg-5">Dibuat Tanggal</label>
												<div class="col-lg-2">
													<input type="text" class="date form-control" value="<?php echo $data['cetak'] ?>" disabled>
													<input type="hidden" name="txtTanggalJadwalLayanan" value="<?php echo $data['cetak'] ?>">
												</div>
												<div class="col-lg-1 text-right">
													<button class="btn btn-primary" type="submit">Cetak</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="table-resposive">
											<table class="datatable table table-striped table-hover table-bordered text-left" style="font-size: 9pt;">
												<thead class="bg-primary">
													<tr>
														<th>Tanggal</th>
														<th>Shift 1 & Shift Umum</th>
														<th>Shift 2</th>
														<th>Shift 3</th>
														<th>Catering Libur</th>
														<th>Keterangan</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													foreach ($table as $key) { ?>
														<tr>
															<td><?php echo $key['tanggal'] ?></td>
															<td><?php echo $key['shift1'] ?></td>
															<td><?php echo $key['shift2'] ?></td>
															<td><?php echo $key['shift3'] ?></td>
															<td><?php echo $key['libur'] ?></td>
															<td><?php echo $key['keterangan'] ?></td>
														</tr>
													<?php }
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