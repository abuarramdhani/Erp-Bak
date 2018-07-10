<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/MasterOrientasi/OrientasiBaru_Save');?>" enctype="multipart/form-data">
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
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Daftar Orientasi</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<table class="table table-bordered table-striped table-hover" id="MonitoringOJT-tabelDaftarOrientasi" style="width: 100%">
											<thead>
												<tr>
													<th>No.</th>
													<th>Action</th>
													<th>Nama Orientasi</th>
													<th>Periode</th>
													<th>Tanggal Otomatis</th>
													<th>Jumlah Hari</th>
													<th>Alur Orientasi</th>
													<th>Pemberitahuan</th>
													<th>Keterangan</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$no 	=	1;
													foreach ($DaftarOrientasiTabel as $daftarOrientasi) 
													{
														$idOrientasi 		=	$daftarOrientasi['id_orientasi'];
														$idOrientasi_Encode	=	$this->encrypt->encode($daftarOrientasi['id_orientasi']);
														$idOrientasi_Encode	=	str_replace(array('+', '/', '='), array('-', '_', '~'), $idOrientasi_Encode);
												?>
												<tr>
													<td><?php echo $no;?></td>
													<td style="white-space: nowrap;">
														<a style="margin-right:4px" href="<?php echo base_url('OnJobTraining/MasterOrientasi/OrientasiBaru_Update/'.$idOrientasi_Encode.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                		<a href="<?php echo base_url('OnJobTraining/MasterOrientasi/OrientasiBaru_Delete/'.$idOrientasi_Encode.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Apakah Anda ingin menghapus data ini?');"><span class="fa fa-trash fa-2x"></span></a>
													</td>
													<td><?php echo $daftarOrientasi['tahapan'];?></td>
													<td>Bulan <?php echo $daftarOrientasi['periode'];?></td>
													<td>
														<?php
															if($daftarOrientasi['ck_tgl'] == 't')
															{
																echo 1;
															}
															else
															{
																echo 0;
															}
														?>
													</td>
													<td><?php echo $daftarOrientasi['lama_hari'];?> hari</td>
													<td>
														<?php
															if($daftarOrientasi['ck_tgl'] == 't')
															{
																foreach ($DaftarOrientasiTabelKolomJadwal as $orientasiJadwal) 
																{
																	if($idOrientasi==$orientasiJadwal['id_orientasi'])
																	{
														?>
														<?php echo '<b>'.$orientasiJadwal['waktu'].'</b><br/>'.$orientasiJadwal['penerima'];?>
														<?php
																	}
																}
															}
															else
															{
																echo '-';
															}
														?>
													</td>
													<td>
														<ul>
															<?php
																foreach ($DaftarOrientasiTabelKolomPemberitahuan as $orientasiPemberitahuan) 
																{
																	if($idOrientasi==$orientasiPemberitahuan['id_orientasi'])
																	{
															?>
															<li>
																<?php echo $orientasiPemberitahuan['penerima'].' - <b>'.$orientasiPemberitahuan['waktu'].'</b>';?>
															</li>
															<?php
																	}
																}
															?>
														</ul>
													</td>
													<td><?php echo $daftarOrientasi['keterangan'];?></td>
												</tr>
												<?php
														$no++;
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Pembuatan Orientasi Baru -->
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Pembuatan Orientasi Baru</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
													<label for="numPeriodeBulan" class="control-label col-lg-4">Periode Bulan</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numPeriodeBulan" min="1" max="12" value="1" />
													</div>
												</div>
												<div class="form-group">
													<label for="numSequence" class="control-label col-lg-4">Sequence</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numSequence" min="1" max="99" value="1" />
													</div>
												</div>
												<div class="form-group">
													<label for="txtTahapan" class="control-label col-lg-4">Tahapan</label>
													<div class="col-lg-6">
														<input type="text" class="form-control" style="text-transform: uppercase;" name="txtTahapan" />
													</div>
												</div>
												<div class="form-group">
													<label for="numLamaPelaksanaan" class="control-label col-lg-4">Pelaksanaan (hari)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numLamaPelaksanaan" min="1" max="99" value="1" />
													</div>
												</div>
												<div class="form-group">
													<label for="radioCekEvaluasi" class="control-label col-lg-4">Cek Evaluasi</label>
													<div class="col-lg-3">
														<input type="radio" name="radioCekEvaluasi" value="1">Ya</input>
													</div>
													<div class="col-lg-3">
														<input type="radio" name="radioCekEvaluasi" value="0">Tidak</input>
													</div>
												</div>
												<div class="form-group">
													<label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
													<textarea name="txtKeterangan" class="col-lg-6"></textarea>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label for="radioTanggalOtomatis" class="control-label col-lg-4">Tanggal Otomatis</label>
													<div class="col-lg-2">
														<input type="radio" name="radioTanggalOtomatis" value="1" id="MonitoringOJT-radioTanggalOtomatisTrue">Ya</input>
													</div>
													<div class="col-lg-2">
														<input type="radio" name="radioTanggalOtomatis" value="0" id="MonitoringOJT-radioTanggalOtomatisFalse">Tidak</input>
													</div>
												</div>
												<div class="form-group">
													<label for="radioPemberitahuan" class="control-label col-lg-4">Pemberitahuan</label>
													<div class="col-lg-2">
														<input type="radio" name="radioPemberitahuan" value="1" id="MonitoringOJT-radioPemberitahuanTrue">Ya</input>
													</div>
													<div class="col-lg-2">
														<input type="radio" name="radioPemberitahuan" value="0" id="MonitoringOJT-radioPemberitahuanFalse">Tidak</input>
													</div>
												</div>
												<div class="form-group">
													<label for="radioCetak" class="control-label col-lg-4">Cetak</label>
													<div class="col-lg-2">
														<input type="radio" name="radioCetak" value="1" id="MonitoringOJT-radioCetakTrue">Ya</input>
													</div>
													<div class="col-lg-2">
														<input type="radio" name="radioCetak" value="0" id="MonitoringOJT-radioCetakFalse">Tidak</input>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box box-primary box-solid" id="MonitoringOJT-PengaturanAlurOrientasiBaru">
								<div class="box-header with-border">
									<h3 class="box-title">Pengaturan Alur Orientasi</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-2">
												<input type="number" name="numJadwalIntervalHari" class="form-control" min="0" max="99" step="1" placeholder="Hari" />
											</div>
											<div class="col-lg-2">
												<input type="number" name="numJadwalIntervalMinggu" class="form-control" min="0" max="10" step="1" placeholder="Minggu" />
											</div>
											<div class="col-lg-2">
												<input type="number" name="numJadwalIntervalBulan" class="form-control" min="0" max="10" step="1" placeholder="Bulan" />
											</div>
											<div class="col-lg-2">
												<select class="select2 form-control MonitoringOJT-cmbJadwalPelaksanaan" name="cmbJadwalPelaksanaan" placeholder="Pelaksanaan">
													<option></option>
													<option value="0">Sebelum</option>
													<option value="1">Sesudah</option>
												</select>
											</div>
											<div class="col-lg-4">
												<select class="select2 form-control MonitoringOJT-cmbJadwalTahapan" name="cmbJadwalTahapan" placeholder="Tahapan">
													<option></option>
													<?php
														foreach ($DaftarOrientasi as $orientasi) 
														{
													?>
													<option value="<?php echo $orientasi['id_orientasi'];?>"><?php echo $orientasi['tahapan'];?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box box-primary box-solid" id="MonitoringOJT-PengaturanPemberitahuanOrientasiBaru">
								<div class="box-header with-border">
									<h3 class="box-title">Pengaturan Pemberitahuan</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="row">
											<table class="table" style="width: 100%" id="MonitoringOJT-pengaturanPemberitahuan">
												<tr>
													<td class="text-right" colspan="7">
														<a type="button" class="btn btn-sm btn-success" onclick="MonitoringOJT_tambahPemberitahuan()">
															<i class="fa fa-plus"></i>
														</a>
													</td>
												</tr>
												<!-- Jangan lupa cek di JS -->
												<tr>
													<td>
														<a class="btn btn-sm btn-danger" onclick="MonitoringOJT_hapusPemberitahuan(this)" ><i class="fa fa-times"></i></a>
														<input class="hidden" type="text" name="idPemberitahuan[0]" value="" />
													</td>
													<td>
														<div class="row">
															<input type="checkbox" name="chkPemberitahuanAllDay[0]" value="1" />
															<label for="chkPemberitahuanAllDay[0]" class="control-label">All Day</label>
														</div>
													</td>
													<td>
														<input type="number" name="numPemberitahuanIntervalHari[0]" class="form-control" min="0" max="99" step="1" placeholder="Hari" />
													</td>
													<td>
														<input type="number" name="numPemberitahuanIntervalMinggu[0]" class="form-control" min="0" max="10" step="1" placeholder="Minggu" />
													</td>
													<td>
														<input type="number" name="numPemberitahuanIntervalBulan[0]" class="form-control" min="0" max="10" step="1" placeholder="Bulan" />
													</td>
													<td>
														<select class="select2 form-control MonitoringOJT-cmbPemberitahuanPelaksanaan" style="width: 100%" name="cmbPemberitahuanPelaksanaan[0]" placeholder="Pelaksanaan">
															<option></option>
															<option value="0">Sebelum</option>
															<option value="1">Sesudah</option>
														</select>
													</td>
													<td>
														<select class="select2 form-control MonitoringOJT-cmbPemberitahuanTujuan" style="width: 100%" name="cmbPemberitahuanTujuan[0]" placeholder="Tujuan">
															<option></option>
															<option value="1">People Development</option>
															<option value="2">Pekerja</option>
															<option value="3">Atasan Pekerja</option>
														</select>
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="box">
								<div class="box-body">
									<div class="row text-center">
											<input class="hidden" type="text" name="actionType" value="CREATE" />
											<!-- <button type="reset" class="btn btn-warning btn-lg btn-rect">Reset Data</button> -->
											<button type="submit" class="btn btn-success btn-lg btn-rect">Simpan Data</button>
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>