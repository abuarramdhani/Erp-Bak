<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h3><b><?=$Title ?></b></h3>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-md hidden-xs">
								<a href="" class="btn btn-default btn-lg"><i class="icon icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('HitungHlcm/DataOvertimePHL/Show') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<input name="periode" class="overtimephl-daterangepicker form-control"></input>
												</div>
												<button type="submit" class="btn btn-primary">Proses</button>
												<?php if (isset($linkExport) and !empty($linkExport)) { ?>
													<a class="btn btn-success" href="<?php echo $linkExport ?>">Export</a>
												<?php } ?>
											</div>
										</form>
									</div>
								</div>
								<?php 
									if (isset($data) and !empty($data)) { 
										$angka = 1;
										?>
										<div class="table-responsive">
											<table class="table table-hover table-striped table-bordered" id="HLCMOvertime-datatable">
												<thead class="bg-primary">
													<tr>
														<th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
														<th rowspan="2" style="text-align: center;vertical-align: middle;">No Induk</th>
														<th rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>
														<th rowspan="2" style="text-align: center;vertical-align: middle;">Lokasi Kerja</th>
														<?php $simpanBulan = ""; foreach ($tanggal as $tgl) { 
															if ($simpanBulan !== $tgl['bulan']) { ?>
															<th colspan="<?php echo $tgl['jmlhari'] ?>" style="text-align: center;vertical-align: middle;"><?php echo $tgl['bulan'] ?></th>
														<?php }
																$simpanBulan = $tgl['bulan']; } ?>
														<th rowspan="2" style="text-align: center;vertical-align: middle;">Total</th>
													</tr>
													<tr>
														<?php foreach ($tanggal as $tgl) { ?>
															<th style="text-align: center;vertical-align: middle;"><?php echo $tgl['tgl'] ?></th>
														<?php } ?>
													</tr>
												</thead>
												<tbody>
													<?php 	foreach ($data as $key) { ?>
														<tr>
															<td style="text-align: center;vertical-align: middle;"><?php echo $angka ?></td>
															<td style="text-align: center;vertical-align: middle;"><?php echo $key['noind'] ?></td>
															<td><?php echo $key['nama'] ?></td>
															<td><?php echo $key['lokasi_kerja'] ?></td>
															<?php $total = 0;
															foreach ($tanggal as $tgl) {
																foreach ($key['data'] as $val) {
																	if ($val['tanggal'] == $tgl['tanggal']) { ?>
																		<td style="text-align: center;vertical-align: middle;"><?php echo number_format($val['overtime'],2) ?></td>
																	<?php $total += $val['overtime'];
																	}
																}
															} ?>
															<td style="text-align: center;vertical-align: middle;"><?php echo number_format($total,2) ?></td>
														</tr>
													<?php 
																$angka++;
															} ?>
												</tbody>
											</table>
										</div>
								<?php }
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>