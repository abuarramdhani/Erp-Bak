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
										<label class="form-label" style="font-size: 20pt;">Jadwal Pengiriman Catering <?php echo $pengiriman['nama_catering'] ?></label><br>
										<label class="form-label" style="font-size: 18pt;">Bulan : <?php echo $pengiriman['bulan'] ?></label>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" target="_blank" method="post" action="<?php echo site_url('CateringManagement/Cetak/JadwalPengiriman/Cetak') ?>">
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label col-lg-6">Menu Paket</label>
													<div class="col-lg-6">
														<input type="text" name="txtMenuPaketJadwalPengiriman" class="form-control" value="<?php echo $pengiriman['paket'] ?>" disabled>
														<input type="hidden" name="txtMenuPaketJadwalPengiriman" class="form-control" value="<?php echo $pengiriman['paket'] ?>">
														<input type="hidden" name="txtPeriodeJadwalPengiriman" class="date form-control" value="<?php echo $pengiriman['bulan'] ?>">
														<input type="hidden" name="txtKdCateringJadwalPengiriman" class="form-control" value="<?php echo $pengiriman['kode_catering'] ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-6">Tanggal Pembuatan</label>
													<div class="col-lg-6">
														<input type="text" name="txtTanggalPembuatanJadwalPengiriman" class="form-control" value="<?php echo $pengiriman['tanggalbuat'] ?>" disabled>
														<input type="hidden" name="txtTanggalPembuatanJadwalPengiriman" class="form-control" value="<?php echo $pengiriman['tanggalbuat'] ?>">
													</div>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label col-lg-12">Yang Bertandatangan :</label>
												</div>
												<div class="form-group">
													<div class="col-lg-12 text-center">
														<button class="btn btn-primary" type="submit">Cetak</button>
													</div>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label col-lg-4">Personalia</label>
													<div class="col-lg-8">
														<input type="text" name="txtPersonaliaJadwalPengiriman" class="form-control" value="<?php echo $pengiriman['ppersonalia'] ?>" disabled>
														<input type="hidden" name="txtPersonaliaJadwalPengiriman" class="form-control" value="<?php echo $pengiriman['ppersonalia'] ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Catering</label>
													<div class="col-lg-8">
														<input type="text" class="form-control" name="txtCateringJadwalPengiriman" value="<?php echo $pengiriman['pcatering'] ?>" disabled>
														<input type="hidden" class="form-control" name="txtCateringJadwalPengiriman" value="<?php echo $pengiriman['pcatering'] ?>">
														
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-bordered text-left">
												<thead class="bg-primary">
													<tr>
														<th>Tanggal</th>
														<th>Jadwal Kirim</th>
														<th>Waktu</th>
														<th>Keterangan</th>
													</tr>
												</thead>
												<tbody>
													<?php $a=1;
														foreach ($table as $key) { if (isset($key['tanggal'])) {$a++;}?>
															<tr class="<?php if ($a%2 == 0) { echo "bg-info";} ?>">
																<?php if (isset($key['tanggal'])): ?>
																	<td rowspan="<?php echo $key['jumlah'] ?>"><?php echo $key['tanggal'];$tgl = $key['tanggal']  ?></td>
																<?php endif ?>
																<td><?php echo $key['jadwal']  ?></td>
																<td><?php echo $key['waktu'] ?></td>
																<td>
																	<div class="col-lg-10">
																		<input type="text" name="txtKeteranganJadwalPengiriman" id="txtKeteranganJadwalPengiriman" class="form-control" value="<?php echo $key['keterangan']  ?>">
																	</div>
																		<button class="btn btn-success icon-check" onclick="saveKeterangan(this,<?php echo "'".$tgl."','".$pengiriman['kode_catering']."','".$key['shift']."'"; ?>);"></button>
																</td>
															</tr>
													<?php } ?>
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