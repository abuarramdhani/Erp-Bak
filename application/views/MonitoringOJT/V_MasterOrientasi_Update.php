<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/MasterOrientasi/OrientasiBaru_Update/'.$id);?>" enctype="multipart/form-data">
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
							<!-- Pembuatan Orientasi Baru -->
							<?php
								foreach ($editOrientasi as $masterOrientasi) 
								{
							?>
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Edit Orientasi</h3>
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
														<input type="number" class="form-control" name="numPeriodeBulan" min="1" max="12" value="<?php echo $masterOrientasi['periode'];?>" />
													</div>
												</div>
												<div class="form-group">
													<label for="numSequence" class="control-label col-lg-4">Sequence</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numSequence" min="1" max="99" value="<?php echo $masterOrientasi['sequence'];?>" />
													</div>
												</div>
												<div class="form-group">
													<label for="txtTahapan" class="control-label col-lg-4">Tahapan</label>
													<div class="col-lg-6">
														<input type="text" class="form-control" style="text-transform: uppercase;" name="txtTahapan" value="<?php echo $masterOrientasi['tahapan'];?>" />
													</div>
												</div>
												<div class="form-group">
													<label for="numLamaPelaksanaan" class="control-label col-lg-4">Pelaksanaan (hari)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numLamaPelaksanaan" min="1" max="99" value="<?php echo $masterOrientasi['lama_hari'];?>" />
													</div>
												</div>
												<div class="form-group">
													<label for="radioCekEvaluasi" class="control-label col-lg-4">Cek Evaluasi</label>
													<div class="col-lg-3">
														<input type="radio" name="radioCekEvaluasi" value="1" <?php if($masterOrientasi['evaluasi']=='1'){echo 'checked';};?>>Ya</input>
													</div>
													<div class="col-lg-3">
														<input type="radio" name="radioCekEvaluasi" value="0" <?php if($masterOrientasi['evaluasi']=='0'){echo 'checked';};?>>Tidak</input>
													</div>
												</div>
												<div class="form-group">
													<label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
													<textarea name="txtKeterangan" class="col-lg-6"><?php echo $masterOrientasi['keterangan'];?></textarea>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label for="radioTanggalOtomatis" class="control-label col-lg-4">Tanggal Otomatis</label>
													<div class="col-lg-2">
														<input type="radio" name="radioTanggalOtomatis" value="1" id="MonitoringOJT-radioTanggalOtomatisTrue" <?php if($masterOrientasi['ck_tgl']=='1'){echo 'checked';};?>>Ya</input>
													</div>
													<div class="col-lg-2">
														<input type="radio" name="radioTanggalOtomatis" value="0" id="MonitoringOJT-radioTanggalOtomatisFalse" <?php if($masterOrientasi['ck_tgl']=='0'){echo 'checked';};?>>Tidak</input>
													</div>
												</div>
												<div class="form-group">
													<label for="radioPemberitahuan" class="control-label col-lg-4">Pemberitahuan</label>
													<div class="col-lg-2">
														<input type="radio" name="radioPemberitahuan" value="1" id="MonitoringOJT-radioPemberitahuanTrue" <?php if($masterOrientasi['pemberitahuan']=='1'){echo 'checked';};?>>Ya</input>
													</div>
													<div class="col-lg-2">
														<input type="radio" name="radioPemberitahuan" value="0" id="MonitoringOJT-radioPemberitahuanFalse" <?php if($masterOrientasi['pemberitahuan']=='0'){echo 'checked';};?>>Tidak</input>
													</div>
												</div>
												<div class="form-group">
													<label for="radioCetak" class="control-label col-lg-4">Cetak</label>
													<div class="col-lg-2">
														<input type="radio" name="radioCetak" value="1" id="MonitoringOJT-radioCetakTrue" <?php if($masterOrientasi['memo']=='1'){echo 'checked';};?>>Ya</input>
													</div>
													<div class="col-lg-2">
														<input type="radio" name="radioCetak" value="0" id="MonitoringOJT-radioCetakFalse" <?php if($masterOrientasi['memo']=='0'){echo 'checked';};?>>Tidak</input>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box box-primary box-solid <?php if($masterOrientasi['ck_tgl']=='0'){echo 'hidden';};?>" id="MonitoringOJT-PengaturanAlurOrientasiBaru">
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
												<input type="number" name="numJadwalIntervalHari" class="form-control" min="0" max="99" step="1" placeholder="Hari" value="<?php echo $masterOrientasi['hari'];?>" />
											</div>
											<div class="col-lg-2">
												<input type="number" name="numJadwalIntervalMinggu" class="form-control" min="0" max="10" step="1" placeholder="Minggu" value="<?php echo $masterOrientasi['minggu'];?>" />
											</div>
											<div class="col-lg-2">
												<input type="number" name="numJadwalIntervalBulan" class="form-control" min="0" max="10" step="1" placeholder="Bulan" value="<?php echo $masterOrientasi['bulan'];?>" />
											</div>
											<div class="col-lg-2">
												<select class="select2 form-control MonitoringOJT-cmbJadwalPelaksanaan" name="cmbJadwalPelaksanaan" placeholder="Pelaksanaan">
													<option></option>
													<option value="0" <?php if($masterOrientasi['urutan']=='0'){echo 'selected';};?>>Sebelum</option>
													<option value="1" <?php if($masterOrientasi['urutan']=='1'){echo 'selected';};?>>Sesudah</option>
												</select>
											</div>
											<div class="col-lg-4">
												<select class="select2 form-control MonitoringOJT-cmbJadwalTahapan" name="cmbJadwalTahapan" placeholder="Tahapan">
													<option></option>
													<?php
														foreach ($DaftarOrientasi as $orientasi) 
														{
															$selected_status	=	'';
															if($masterOrientasi['tujuan']==$orientasi['id_orientasi'])
															{
																$selected_status 	=	'selected';
															}
													?>
													<option value="<?php echo $orientasi['id_orientasi'];?>" <?php echo $selected_status;?>><?php echo $orientasi['tahapan'];?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box box-primary box-solid <?php if($masterOrientasi['pemberitahuan']=='0'){echo 'hidden';};?>" id="MonitoringOJT-PengaturanPemberitahuanOrientasiBaru">
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
												<?php
													$indeks_pemberitahuan 	=	0;
													foreach ($editPemberitahuanOrientasi as $pemberitahuan) 
													{
														$id_pemberitahuan 			=	$pemberitahuan['id_pemberitahuan'];
														$id_pemberitahuan_encode	=	$this->encrypt->encode($id_pemberitahuan);
														$id_pemberitahuan_encode 	=	str_replace(array('+', '/', '='), array('-', '_', '~'), $id_pemberitahuan_encode);
												?>
												<tr>
													<td>
														<a class="btn btn-sm btn-danger" onclick="MonitoringOJT_hapusPemberitahuan(this)" ><i class="fa fa-times"></i></a>
														<input class="hidden" type="text" name="idPemberitahuan[<?php echo $indeks_pemberitahuan;?>]" value="<?php echo $id_pemberitahuan_encode;?>" />
													</td>
													<td>
														<div class="row">
															<input type="checkbox" name="chkPemberitahuanAllDay[<?php echo $indeks_pemberitahuan;?>]" value="1" <?php if($pemberitahuan['pengulang']=='1'){echo 'checked';};?> />
															<label for="chkPemberitahuanAllDay[<?php echo $indeks_pemberitahuan;?>]" class="control-label">All Day</label>
														</div>
													</td>
													<td>
														<input type="number" name="numPemberitahuanIntervalHari[<?php echo $indeks_pemberitahuan;?>]" class="form-control" min="0" max="99" step="1" placeholder="Hari" value="<?php echo $pemberitahuan['hari'];?>" />
													</td>
													<td>
														<input type="number" name="numPemberitahuanIntervalMinggu[<?php echo $indeks_pemberitahuan;?>]" class="form-control" min="0" max="10" step="1" placeholder="Minggu" value="<?php echo $pemberitahuan['minggu'];?>" />
													</td>
													<td>
														<input type="number" name="numPemberitahuanIntervalBulan[<?php echo $indeks_pemberitahuan;?>]" class="form-control" min="0" max="10" step="1" placeholder="Bulan" value="<?php echo $pemberitahuan['bulan']?>"/>
													</td>
													<td>
														<select class="select2 form-control MonitoringOJT-cmbPemberitahuanPelaksanaan" style="width: 100%" name="cmbPemberitahuanPelaksanaan[<?php echo $indeks_pemberitahuan;?>]" placeholder="Pelaksanaan">
															<option></option>
															<option value="0" <?php if($pemberitahuan['urutan']=='0'){echo 'selected';};?>>Sebelum</option>
															<option value="1" <?php if($pemberitahuan['urutan']=='1'){echo 'selected';};?>>Sesudah</option>
														</select>
													</td>
													<td>
														<select class="select2 form-control MonitoringOJT-cmbPemberitahuanTujuan" style="width: 100%" name="cmbPemberitahuanTujuan[<?php echo $indeks_pemberitahuan;?>]" placeholder="Tujuan">
															<option></option>
															<option value="1" <?php if($pemberitahuan['penerima']=='1'){echo 'selected';};?>>People Development</option>
															<option value="2" <?php if($pemberitahuan['penerima']=='2'){echo 'selected';};?>>Pekerja</option>
															<option value="3" <?php if($pemberitahuan['penerima']=='3'){echo 'selected';};?>>Atasan Pekerja</option>
														</select>
													</td>
												</tr>
												<?php
														$indeks_pemberitahuan++;
													}
												?>
											</table>
										</div>
									</div>
								</div>
							</div>
							<?php
								}
							?>
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