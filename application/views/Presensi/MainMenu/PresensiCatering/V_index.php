<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('Presensi/PresensiCatering/proses_rekap');?>" enctype="multipart/form-data">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
									<h1><b><?php echo $Title;?></b></h1>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/MasterOrientasi');?>">
										<i class="icon-wrench icon-2x"></i>
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<!-- Tabel Orientasi -->
							<?php
								$minimize_box 	=	'';
								if(isset($RiwayatPenarikan) && isset($RiwayatProses))
								{
									$minimize_box	=	'collapsed-box';
								}
							?>
							<div class="box box-primary box-solid <?php echo $minimize_box;?>">
								<div class="box-header with-border">
									<h3 class="box-title">Parameter Pencarian</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="form-group">
											<label for="PresensiCatering-txtTanggalPencarian" class="control-label col-lg-2">Tanggal</label>
											<div class="col-lg-4">
												<input type="text" class="form-control PresensiCatering-daterangepickersingledate" name="txtTanggalPencarian" id="PresensiCatering-txtTanggalPencarian" />
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Rekap</button>
                                        </div>
									</div>
								</div>
							</div>

							<?php
								if(isset($RiwayatPenarikan) && isset($RiwayatProses))
								{
							?>
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Hasil Rekap Transaksi Catering</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<table class="table table-bordered table-striped table-hover" id="PresensiCatering-tabelRekapTransaksiCatering" style="width: 100%">
											<thead>
												<tr>
													<th>No.</th>
													<th>Waktu Proses</th>
													<th>Nomor Induk</th>
													<!-- <th>Kodesie</th>
													<th>Kode Shift</th> -->
													<th>Waktu Presensi</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$indeks_tabel	=	1;
													$indeks_tarik 	=	0;
													$indeks_proses	=	0;
													foreach ($RiwayatPenarikan as $tarik)
													{
												?>
												<tr>
													<td><?php echo $indeks_tabel;?></td>
													<td><?php echo $tarik['waktu_proses'];?></td>
													<td><?php echo $tarik['noind'];?></td>
													<!-- <td><?php echo $tarik['kodesie'];?></td>
													<td><?php echo $tarik['kd_shift'];?></td> -->
													<td><?php echo $tarik['waktu_masuk'];?></td>
												</tr>
												<?php
														$indeks_tabel++;
														if(isset($RiwayatProses[$indeks_proses]['waktu_proses']) && $indeks_tarik<(count($RiwayatPenarikan)-1))
														{
															if(strtotime($RiwayatProses[$indeks_proses]['waktu_proses'])>strtotime($tarik['waktu_proses']) && strtotime($RiwayatProses[$indeks_proses]['waktu_proses'])<strtotime($RiwayatPenarikan[$indeks_tarik+1]['waktu_proses']))
															{
												?>
												<tr class="bg-warning">
													<td><?php echo $indeks_tabel;?></td>
													<td><?php echo $RiwayatProses[$indeks_proses]['waktu_proses'];?></td>
													<!-- <td colspan="4" style="text-align: center;"><strong>Hitung Catering</strong></td> -->
													<td colspan="2" style="text-align: center;"><strong>Hitung Catering</strong></td>
												</tr>
												<?php
																$indeks_proses++;
															}
														}
														elseif(isset($RiwayatProses[$indeks_proses]['waktu_proses']) && $indeks_tarik=(count($RiwayatPenarikan)-1))
														{
															if(strtotime($RiwayatProses[$indeks_proses]['waktu_proses'])>strtotime($tarik['waktu_proses']))
															{
												?>
												<tr class="bg-warning">
													<td><?php echo $indeks_tabel;?></td>
													<td><?php echo $RiwayatProses[$indeks_proses]['waktu_proses'];?></td>
													<!-- <td colspan="4" style="text-align: center;"><strong>Hitung Catering</strong></td> -->
													<td colspan="2" style="text-align: center;"><strong>Hitung Catering</strong></td>
												</tr>
												<?php
																$indeks_proses++;
															}
														}
														$indeks_tarik++;
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<?php
								}
							?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>