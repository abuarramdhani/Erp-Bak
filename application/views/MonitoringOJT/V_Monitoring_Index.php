<section class="content">
	<div class="inner">
		<div class="row">
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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/Monitoring');?>">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
<style type="text/css">
	input[type="text"], textarea {
	outline: none;
	box-shadow:none !important;
	border:1px solid #ccc !important;
	}
</style>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Rekap Harian Jumlah Peserta Tahapan OJT</h3>
							</div>
							<div class="box-body">
								<form method="post" action="<?php echo base_url('OnJobTraining/Monitoring');?>">
									<div class="row">
										<div class="col-lg-2">
											<div class="form-group">
												<input type="text" name="txtTanggalRekapHarian" class="form-control MonitoringOJT-daterangepickersingledate" placeholder="Tanggal Rekap Harian" value="<?php if( !empty($tanggal_rekap) ){echo $tanggal_rekap;}?>" />
											</div>
										</div>
										<div class="col-lg-2">
											<button type="submit" class="btn btn-primary btn-rect">Rekap</button>
										</div>
									</div>
								</form>
								<?php
								if ( count($rekap_kegiatan_harian)>0 )
								{
									?>
									<table class="table table-bordered table-hover" id="MonitoringOJT-rekapKegiatanHarian">
										<thead>
											<tr>
												<th style="text-align: center; vertical-align: middle;">Tahapan</th>
												<th style="text-align: center; vertical-align: middle;">Jumlah Peserta</th>
											</tr>
										</thead>
										<?php
										foreach ($rekap_kegiatan_harian as $rekap)
										{
											?>
											<tr title="Click for Detail" onclick="" type="button" class="view_data_ojt" id="<?php echo $rekap['id_orientasi']; ?>">
												<td style="text-align: center; vertical-align: middle;"><?php echo $rekap['tahapan'];?></td>
												<td style="text-align: center; vertical-align: middle;"><?php echo $rekap['jumlah'];?></td>
											</tr>
											<?php
										}
										?>
									</table>
									<?php
								}
								else
								{
									?>
									<table class="table table-bordered" id="MonitoringOJT-rekapKegiatanHarian">
										<tr>
											<th style="text-align: center; vertical-align: middle;">Tahapan</th>
											<th style="text-align: center; vertical-align: middle;">Jumlah Peserta</th>
										</tr>
										<tr>
											<td style="text-align: center; vertical-align: middle;" colspan="2">Tidak ada kegiatan hari ini.</td>
										</tr>
									</table>
									<?php
								}
								?>
								<div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">Detail Peserta</h4>
											</div>
											<div class="modal-body">
												<!-- Place to print the fetched phone -->
												<div id="phone_result"></div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="box-title" style="vertical-align: middle;">Monitoring Pekerja OJT D3-S1</h3>
								<a style="float:right;margin-right:1%;margin-top:-0.5%; vertical-align: middle;" alt="Tambah Pekerja" title="Tambah Pekerja" >
									<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#tambahPekerjaOJT"><i class="icon-plus icon-2x"></i></button>
								</a>
								<!-- <button class="btn btn-default btn-sm" style="float: right; margin-right: 1%; margin-top: 0.5%"> -->
								<div class="navbar-custom-menu" style="float: right; margin-right: 1%; margin-top: -1%; margin-bottom: -1%; vertical-align: middle;">
									<?php
									$jumlah_notifikasi 	=	count($notifikasi_harian);
									?>
									<ul class="nav navbar-nav">
										<li class="dropdown notifications-menu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<i class="fa fa-bell-o"></i>
												<span class="label label-warning">
													<?php echo $jumlah_notifikasi;?>
												</span>
											</a>
											<ul class="dropdown-menu" style="height: 380px; overflow: auto; resize: vertical;">
												<?php
												if( $jumlah_notifikasi>0 )
												{
													?>
													<li class="header">Anda memiliki <?php echo $jumlah_notifikasi;?> pemberitahuan.</li>
													<?php
												}
												else
												{
													?>
													<li class="header">Bersyukurlah Anda.... Tidak ada notifikasi!</li>
													<?php
												}
												?>
												<li>
													<?php
													if ( $jumlah_notifikasi>0 )
													{
														foreach ($notifikasi_harian as $notifikasi)
														{
															$tanggal_tampil 	=	'';
															$tahapan 			=	$notifikasi['tahapan'];
															$pekerja 			=	$notifikasi['noind'].' - '.$notifikasi['employee_name'];

															if ( strtotime($notifikasi['tanggal_proses_akhir']) > strtotime($notifikasi['tanggal_proses_awal']) )
															{
																$tanggal_tampil 	=	$notifikasi['tanggal_proses_awal'].' s.d. '.$notifikasi['tanggal_proses_akhir'];
															}
															else
															{
																$tanggal_tampil 	=	$notifikasi['tanggal_proses_awal'];
															}
															?>
															<ul class="menu">
																<li>
																	<a>
																		<i class="fa fa-calendar text-red"></i> <?php echo $tanggal_tampil;?><br/>
																		<i class="fa fa-sticky-note-o text-orange"></i> <?php echo $tahapan;?><br/>
																		<i class="fa fa-user text-green"></i> <?php echo $pekerja;?>
																	</a>
																</li>
															</ul>
															<?php
														}
													}
													?>
												</li>
												<!-- <li class="footer"><a href="#">View all</a></li> -->
											</ul>
										</li>
									</ul>
								</div>
								<!-- </button> -->
							</div>
							<div class="box-body">
								<ul class="nav nav-tabs nav-justified">
									<li class="active"><a data-toggle="pill" href="#aktif">Aktif</a></li>
									<li><a data-toggle="pill" href="#tunda">Tertunda</a></li>
									<li><a data-toggle="pill" href="#selesai">Selesai</a></li>
									<li><a data-toggle="pill" href="#keluar">Keluar</a></li>
								</ul>
								<br/>
								<div class="tab-content">
									<div id="aktif" class="tab-pane fade in active">
										<table class="table table-bordered table-hover table-responsive-xs table-sm" id="MonitoringOJT-monitoringPekerjaAktif" style="width: 100%;">
											<thead>
												<tr>
													<th style="white-space: nowrap; text-align: center;">No.</th>
													<th style="white-space: nowrap; text-align: center;">Action</th>
													<th style="white-space: nowrap; text-align: center;">Pekerja</th>
													<th style="white-space: nowrap; text-align: center;">Seksi</th>
													<th style="white-space: nowrap; text-align: center;">Proses Berjalan</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Masuk</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Selesai</th>
													<th style="white-space: nowrap; text-align: center;">Atasan</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Lahir</th>
													<th style="white-space: nowrap; text-align: center;">Latar Belakang Pendidikan</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no 	= 	1;
												foreach ($daftarPekerjaOJT as $pekerja)
												{
													if($pekerja['selesai']=='f' AND $pekerja['keluar']=='f' AND $pekerja['tunda']=='f')
													{
														$pekerja_id 	=	$this->general->enkripsi($pekerja['pekerja_id']);
														?>
														<tr>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle"><?php echo $no;?></td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<a alt="Jadwal" title="Jadwal" href="<?php echo base_url('OnJobTraining/Monitoring/scheduling/'.$pekerja_id);?>">
																	<i class="fa fa-pencil-square-o fa-2x"></i>
																</a>
																<a alt="Cetak Memo" title="Cetak Memo" >
																	<i class="fa fa-sticky-note-o fa-2x"></i>
																</a>
																<a alt="Ubah Alamat E-mail" title="Ubah Alamat E-mail" onclick="MonitoringOJT_ubahEmail(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$pekerja['email_pekerja']."'";?>, <?php echo "'".$pekerja['email_atasan']."'";?>)">
																	<i class="fa fa-envelope fa-2x"></i>
																</a>
																<a alt="Ubah Status Pekerja Menjadi Tertunda" title="Ubah Status Pekerja Menjadi Tertunda" onclick="MonitoringOJT_ubahStatusPekerjaTunda(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$pekerja['noind']."'";?>, <?php echo "'".rtrim($pekerja['nama_pekerja_ojt'])."'";?>)">
																	<i class="fa fa-clock-o fa-2x"></i>
																</a>
																<a alt="Ubah Status Pekerja Menjadi Keluar" title="Ubah Status Pekerja Menjadi Keluar" onclick="MonitoringOJT_ubahStatusPekerjaKeluar(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$pekerja['noind']."'";?>, <?php echo "'".rtrim($pekerja['nama_pekerja_ojt'])."'";?>)">
																	<i class="fa fa-sign-out fa-2x"></i>
																</a>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle;">
																<b><?php echo $pekerja['noind'];?></b><br/>
																<?php echo trim(rtrim($pekerja['nama_pekerja_ojt']));?>
															</td>
															<td style="text-align: justify; vertical-align: middle">
																<?php echo trim($pekerja['seksi_pekerja_ojt']);?>
															</td>
															<td style="white-space: nowrap; text-align: justify; vertical-align: middle">
																<ul>
																	<?php
																	foreach ($proses_berjalan as $proses)
																	{
																		if( $proses['pekerja_id'] == $pekerja['pekerja_id'] )
																		{
																			$warna 				=	'';
																			$tanggal_proses 	=	'';
																			if( strtotime($proses['tgl_akhir']) == strtotime($proses['tgl_awal']) )
																			{
																				$tanggal_proses 	=	$proses['tgl_awal'];
																			}
																			else
																			{
																				$tanggal_proses 	=	$proses['tgl_awal'].' - '.$proses['tgl_akhir'];
																			}

																			if( $proses['selesai'] == 0 AND $proses['overdue'] == 0 )
																			{
																				$warna 	=	'text-yellow';
																			}
																			elseif( $proses['selesai'] == 0 AND $proses['overdue'] == 1 )
																			{
																				$warna 	=	'text-red';
																			}
																			elseif( $proses['selesai'] == 1 AND $proses['overdue'] == 0 )
																			{
																				$warna 	=	'text-green';
																			}
																			?>
																			<li>
																				<b class="<?php echo $warna;?>"><?php echo $proses['tahapan'];?><br/>(<?php echo $tanggal_proses;?>)</b>
																			</li>
																			<?php
																		}
																	}
																	?>
																</ul>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tgl_masuk'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tgl_selesai'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['nama_atasan_pekerja'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tanggal_lahir'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['jenjang_pendidikan_terakhir'].' '.$pekerja['jurusan'].' - '.$pekerja['institusi_pendidikan'];?>
															</td>
														</tr>
														<?php
														$no++;
													}
												}
												?>
											</tbody>
										</table>
									</div>
									<div id="tunda" class="tab-pane fade in">
										<table class="table table-bordered table-hover" id="MonitoringOJT-monitoringPekerjaTunda" style="width: 100%;">
											<thead>
												<tr>
													<th style="white-space: nowrap; text-align: center;">No.</th>
													<th style="white-space: nowrap; text-align: center;">Action</th>
													<th style="white-space: nowrap; text-align: center;">Pekerja</th>
													<th style="white-space: nowrap; text-align: center;">Seksi</th>
													<th style="white-space: nowrap; text-align: center;">Selesai PDCA</th>
													<th style="white-space: nowrap; text-align: center;">Proses Berjalan</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Masuk</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Selesai</th>
													<th style="white-space: nowrap; text-align: center;">Atasan</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Lahir</th>
													<th style="white-space: nowrap; text-align: center;">Latar Belakang Pendidikan</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no 	= 	1;
												foreach ($daftarPekerjaOJT as $pekerja)
												{
													if($pekerja['selesai']=='f' AND $pekerja['keluar']=='f' AND $pekerja['tunda']=='t')
													{
														$pekerja_id 	=	$this->general->enkripsi($pekerja['pekerja_id']);
														?>
														<tr>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle"><?php echo $no;?></td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<a alt="Jadwal" title="Jadwal" href="<?php echo base_url('OnJobTraining/Monitoring/scheduling/'.$pekerja_id);?>">
																	<i class="fa fa-pencil-square-o fa-2x"></i>
																</a>
																<a alt="Ubah Alamat E-mail" title="Ubah Alamat E-mail" onclick="MonitoringOJT_ubahEmail(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$pekerja['email_pekerja']."'";?>, <?php echo "'".$pekerja['email_atasan']."'";?>)">
																	<i class="fa fa-envelope fa-2x"></i>
																</a>
																<a alt="Ubah Status Pekerja Menjadi Keluar" title="Ubah Status Pekerja Menjadi Keluar" onclick="MonitoringOJT_ubahStatusPekerjaKeluar(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$pekerja['noind']."'";?>, <?php echo "'".rtrim($pekerja['nama_pekerja_ojt'])."'";?>)">
																	<i class="fa fa-sign-out fa-2x"></i>
																</a>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle;">
																<b><?php echo $pekerja['noind'];?></b><br/>
																<?php echo trim(rtrim($pekerja['nama_pekerja_ojt']));?>
															</td>
															<td style="text-align: justify; vertical-align: middle">
																<?php echo trim($pekerja['seksi_pekerja_ojt']);?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle;">
																<?php
																if ( $pekerja['tunda_selesai_pdca'] == 't' )
																{
																	?>
																	<b class="text-green">Iyah, selesai</b>
																	<?php
																}
																else
																{
																	?>
																	<b class="text-yellow">Hm... belum</b>
																	<?php
																}
																?>
															</td>
															<td style="white-space: nowrap; text-align: justify; vertical-align: middle">
																<ul>
																	<?php
																	foreach ($proses_berjalan as $proses)
																	{
																		if( $proses['pekerja_id'] == $pekerja['pekerja_id'] )
																		{
																			$warna 				=	'';
																			$tanggal_proses 	=	'';
																			if( strtotime($proses['tgl_akhir']) == strtotime($proses['tgl_awal']) )
																			{
																				$tanggal_proses 	=	$proses['tgl_awal'];
																			}
																			else
																			{
																				$tanggal_proses 	=	$proses['tgl_awal'].' - '.$proses['tgl_akhir'];
																			}

																			if( $proses['selesai'] == 0 AND $proses['overdue'] == 0 )
																			{
																				$warna 	=	'text-yellow';
																			}
																			elseif( $proses['selesai'] == 0 AND $proses['overdue'] == 1 )
																			{
																				$warna 	=	'text-red';
																			}
																			elseif( $proses['selesai'] == 1 AND $proses['overdue'] == 0 )
																			{
																				$warna 	=	'text-green';
																			}
																			?>
																			<li>
																				<b class="<?php echo $warna;?>"><?php echo $proses['tahapan'];?><br/>(<?php echo $tanggal_proses;?>)</b>
																			</li>
																			<?php
																		}
																	}
																	?>
																</ul>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tgl_masuk'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tgl_selesai'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['nama_atasan_pekerja'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tanggal_lahir'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['jenjang_pendidikan_terakhir'].' '.$pekerja['jurusan'].' - '.$pekerja['institusi_pendidikan'];?>
															</td>
														</tr>
														<?php
														$no++;
													}
												}
												?>
											</tbody>
										</table>
									</div>
									<div id="selesai" class="tab-pane fade in">
										<table class="table table-bordered table-hover" id="MonitoringOJT-monitoringPekerjaSelesai">
											<thead>
												<tr>
													<th style="white-space: nowrap; text-align: center;">No.</th>
													<th style="white-space: nowrap; text-align: center;">Action</th>
													<th style="white-space: nowrap; text-align: center;">Pekerja</th>
													<th width="10%" style="white-space: nowrap; text-align: center;">Seksi</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Masuk</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Selesai</th>
													<th style="white-space: nowrap; text-align: center;">Atasan</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Lahir</th>
													<th style="white-space: nowrap; text-align: center;">Latar Belakang Pendidikan</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no 	= 	1;
												foreach ($daftarPekerjaOJT as $pekerja)
												{
													if($pekerja['selesai']=='t' AND $pekerja['keluar']=='f' AND $pekerja['tunda']=='f')
													{
														$pekerja_id 	=	$this->general->enkripsi($pekerja['pekerja_id']);
														?>
														<tr>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle"><?php echo $no;?></td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<a alt="Jadwal" title="Jadwal" href="<?php echo base_url('OnJobTraining/Monitoring/scheduling/'.$pekerja_id);?>">
																	<i class="fa fa-pencil-square-o fa-2x"></i>
																</a>
																<a alt="Ubah Status Pekerja Menjadi Keluar" title="Ubah Status Pekerja Menjadi Keluar" onclick="MonitoringOJT_ubahStatusPekerjaKeluar(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$pekerja['noind']."'";?>, <?php echo "'".rtrim($pekerja['nama_pekerja_ojt'])."'";?>)">
																	<i class="fa fa-sign-out fa-2x"></i>
																</a>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<b><?php echo $pekerja['noind'];?></b><br/>
																<?php echo trim(rtrim($pekerja['nama_pekerja_ojt']));?>
															</td>
															<td style="white-space: nowrap; text-align: justify; vertical-align: middle">
																<?php echo trim($pekerja['seksi_pekerja_ojt']);?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tgl_masuk'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tgl_selesai'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['nama_atasan_pekerja'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tanggal_lahir'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['jenjang_pendidikan_terakhir'].' '.$pekerja['jurusan'].' - '.$pekerja['institusi_pendidikan'];?>
															</td>

														</tr>
														<?php
														$no++;
													}
												}
												?>
											</tbody>
										</table>
									</div>
									<div id="keluar" class="tab-pane fade in">
										<table class="table table-bordered table-hover" id="MonitoringOJT-monitoringPekerjaKeluar" style="width: 100%;">
											<thead>
												<tr>
													<th style="white-space: nowrap; text-align: center;">No.</th>
													<th style="white-space: nowrap; text-align: center;">Action</th>
													<th style="white-space: nowrap; text-align: center;">Pekerja</th>
													<th style="white-space: nowrap; text-align: center;">Seksi</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Masuk</th>
													<th style="white-space: nowrap; text-align: center;">Atasan</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Lahir</th>
													<th style="white-space: nowrap; text-align: center;">Latar Belakang Pendidikan</th>
													<th style="white-space: nowrap; text-align: center;">Tanggal Keluar</th>
													<th style="white-space: nowrap; text-align: center;">Alasan Keluar</th>

												</tr>
											</thead>
											<tbody>
												<?php
												$no 	= 	1;
												foreach ($daftarPekerjaOJT as $pekerja)
												{
													if($pekerja['selesai']=='f' AND $pekerja['keluar']=='t' AND $pekerja['tunda']=='f')
													{
														$pekerja_id 	=	$this->general->enkripsi($pekerja['pekerja_id']);
														?>
														<tr>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle"><?php echo $no;?></td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<a alt="Jadwal" title="Jadwal" href="<?php echo base_url('OnJobTraining/Monitoring/scheduling/'.$pekerja_id);?>">
																	<i class="fa fa-pencil-square-o fa-2x"></i>
																</a>
																<a alt="Ubah Status Pekerja Menjadi Keluar" title="Ubah Status Pekerja Menjadi Keluar" onclick="MonitoringOJT_ubahStatusPekerjaKeluar(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$pekerja['noind']."'";?>, <?php echo "'".rtrim($pekerja['nama_pekerja_ojt'])."'";?>)">
																	<i class="fa fa-sign-out fa-2x"></i>
																</a>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<b><?php echo $pekerja['noind'];?></b><br/>
																<?php echo trim(rtrim($pekerja['nama_pekerja_ojt']));?>
															</td>
															<td style="white-space: nowrap; text-align: justify; vertical-align: middle">
																<?php echo trim($pekerja['seksi_pekerja_ojt']);?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tgl_masuk'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tgl_selesai'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['tanggal_lahir'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['jenjang_pendidikan_terakhir'].' '.$pekerja['jurusan'].' - '.$pekerja['institusi_pendidikan'];?>
															</td>
															<td style="white-space: nowrap; text-align: center; vertical-align: middle">
																<?php echo $pekerja['keluar_tanggal'];?>
															</td>
															<td style="white-space: nowrap; vertical-align: middle">
																<?php echo $pekerja['keluar_alasan'];?>
															</td>

														</tr>
														<?php
														$no++;
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

				<div id="tambahPekerjaOJT" class="modal fade" role="dialog">
					<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/Monitoring/tambahPekerja'); ?>" enctype="multipart/form-data">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Tambah Baru Pekerja OJT</h4>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<div class="col-lg-8">
											<select required style="width: 100%" name="cmbDaftarPekerjaOJT" id="MonitoringOJT-cmbDaftarPekerjaOJT">
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<select required class="select2" style="width: 100%" name="cmbDaftarAtasanPekerja" id="MonitoringOJT-cmbDaftarAtasanPekerja">
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<input type="email" class="form-control" name="txtEmailPekerja" placeholder="E-mail Pekerja (e-mail internal domain quick.com)" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<input type="email" class="form-control" name="txtEmailAtasanPekerja" placeholder="E-mail Atasan Pekerja (e-mail internal domain quick.com)" />
										</select>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12">
										<label  for="" class="col-lg-2 control-label">
											Pilih kegiatan yang diikuti<br/>
											<input onclick="OJT_slcAllERC(this)"  type="button" class="btn btn-warning" id="MonitoringOJT-chkOrientasi-checkAll" value="Pilih Semua" /><br/>
											<input onclick="OJT_delAllERC(this)" type="button" class="btn btn-danger" id="MonitoringOJT-chkOrientasi-uncheckAll" value="Kosongkan Semua" /><br/>
										</label>
										<div class="col-lg-10">
											<?php
											$indeks 			=	0;
											$nomor_orientasi	=	1;
											$total_orientasi 	= 	count($daftarOrientasi);
											?>
											<table class="tabledelERC">
												<tr>
													<?php
													foreach ($daftarOrientasi as $orientasi)
													{
														$id_orientasi_encode 	=	$this->general->enkripsi($orientasi['id_orientasi']);
														?>

														<td class="input-group-text" style="vertical-align: top;">
															<label for="MonitoringOJT-chkOrientasi[<?php echo $indeks; ?>]">
																<input type="checkbox" name="chkOrientasi[]" class="MonitoringOJT-chkOrientasi form-check-input" id="MonitoringOJT-chkOrientasi[<?php echo $indeks; ?>]" value="<?php echo $id_orientasi_encode; ?>"></input>
																<?php echo $nomor_orientasi." - ".$orientasi['tahapan'];?>
															</label>
														</td>
														<?php
														if($nomor_orientasi%3==0 && $nomor_orientasi!=$total_orientasi)
														{
															?>
														</tr>
														<tr>
														<?php
														}
														elseif($nomor_orientasi==$total_orientasi)
														{
															?>
														</tr>
														<?php
													}
													$indeks++;
													$nomor_orientasi++;
												}
												?>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success">Tambah</button>
								<button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/Monitoring/pekerja_keluar'); ?>" enctype="multipart/form-data">
	<div id="MonitoringOJT-ubahStatusPekerjaKeluar" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Ubah Status Pekerja OJT menjadi Keluar</h4>
				</div>
				<div class="modal-body">
					<div class="form-group hidden">
						<label for="MonitoringOJT-monitoring-pekerjaKeluar-txtPekerjaID" class="control-label col-lg-2">Pekerja ID</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" style="width: 100%" name="txtPekerjaID" id="MonitoringOJT-monitoring-pekerjaKeluar-txtPekerjaID" required="" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="MonitoringOJT-monitoring-pekerjaKeluar-txtPekerjaInfo" class="control-label col-lg-2">Pekerja</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" disabled="" style="width: 100%" name="txtMenuName" id="MonitoringOJT-monitoring-pekerjaKeluar-txtPekerjaInfo" required="" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="MonitoringOJT-monitoring-pekerjaKeluar-txtTanggalKeluarPekerja" class="control-label col-lg-2">Tanggal Keluar</label>
						<div class="col-lg-8">
							<input type="text" class="form-control MonitoringOJT-daterangepickersingledate" style="width: 100%" name="txtTanggalKeluarPekerja" id="MonitoringOJT-monitoring-pekerjaKeluar-txtTanggalKeluarPekerja" required="" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="MonitoringOJT-monitoring-pekerjaKeluar-txtAlasanKeluar" class="control-label col-lg-2">Alasan Keluar</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" style="width: 100%; text-transform: uppercase;" name="txtAlasanKeluar" id="MonitoringOJT-monitoring-pekerjaKeluar-txtAlasanKeluar" required="" value="">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><i class="fa fa fa-hdd-o"></i> Proses</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">&times; Tutup</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/Monitoring/ubah_email'); ?>" enctype="multipart/form-data">
	<div id="MonitoringOJT-ubahEmail" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Ubah Alamat E-mail</h4>
				</div>
				<div class="modal-body">
					<div class="form-group hidden">
						<label for="MonitoringOJT-monitoring-ubahEmail-txtPekerjaID" class="control-label col-lg-2">Pekerja ID</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" style="width: 100%" name="txtPekerjaID" id="MonitoringOJT-monitoring-ubahEmail-txtPekerjaID" required="" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="MonitoringOJT-monitoring-ubahEmail-txtEmailPekerja" class="control-label col-lg-2">E-mail Pekerja</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" style="width: 100%" name="txtEmailPekerja" id="MonitoringOJT-monitoring-ubahEmail-txtEmailPekerja" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="MonitoringOJT-monitoring-ubahEmail-txtEmailAtasan" class="control-label col-lg-2">E-mail Atasan Pekerja</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" style="width: 100%" name="txtEmailAtasan" id="MonitoringOJT-monitoring-ubahEmail-txtEmailAtasan" value="">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><i class="fa fa fa-hdd-o"></i> Proses</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">&times; Tutup</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/Monitoring/pekerja_tunda'); ?>" enctype="multipart/form-data">
	<div id="MonitoringOJT-ubahStatusPekerjaTunda" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Ubah Status Pekerja OJT menjadi Tertunda</h4>
				</div>
				<div class="modal-body">
					<div class="form-group hidden">
						<label for="MonitoringOJT-monitoring-pekerjaTunda-txtPekerjaID" class="control-label col-lg-2">Pekerja ID</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" style="width: 100%" name="txtPekerjaID" id="MonitoringOJT-monitoring-pekerjaTunda-txtPekerjaID" required="" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="MonitoringOJT-monitoring-pekerjaTunda-txtPekerjaInfo" class="control-label col-lg-2">Pekerja</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" disabled="" style="width: 100%" name="txtMenuName" id="MonitoringOJT-monitoring-pekerjaTunda-txtPekerjaInfo" required="" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-2"></div>
						<label for="MonitoringOJT-monitoring-pekerjaTunda-chkSelesaiPDCA" class="col-lg-4">
							<input type="checkbox" id="MonitoringOJT-monitoring-pekerjaTunda-chkSelesaiPDCA" name="chkSelesaiPDCA" value="TRUE"/>
							Selesai PDCA
						</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><i class="fa fa fa-hdd-o"></i> Proses</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">&times; Tutup</button>
				</div>
			</div>
		</div>
	</div>
</form>
</section>

<script>
	// Start jQuery function after page is loaded
		        $(document).ready(function(){
		         // Start jQuery click function to view Bootstrap modal when view info button is clicked
		            $('.view_data_ojt').click(function(){
		             // Get the id of selected phone and assign it in a variable called phoneData
		             // +$(this).attr('value')
		                var id = $(this).attr('id');
		                var tuanggal = $('input[name="txtTanggalRekapHarian"]').val();
		                  // alert(id);
		                // Start AJAX function
		                $.ajax({
		                 // Path for controller function which fetches selected phone data
		                    url: "<?php echo base_url() ?>OnJobTraining/Monitoring/detail",
		                    // Method of getting data
		                    method: "POST",
		                    // Data is sent to the server
		                    data: {id:id, tuanggal:tuanggal},
		                    // Callback function that is executed after data is successfully sent and recieved
		                    success: function(data){
		                     // Print the fetched data of the selected phone in the section called #phone_result 
		                     // within the Bootstrap modal
		                     // alert(data);
		                        $('#phone_result').html(data);
		                        // Display the Bootstrap modal
		                        $('#phoneModal').modal('show');
		                    },
		                    error:function(xhr, ajaxOptions, thrownError){
        alert(xhr.status); //===Show Error Message==== 
    }
			             });
			             // End AJAX function
			         });
			     });

	function OJT_slcAllERC(th) { 
	$('.tabledelERC tr').find("td").each(function( i ) {

			// $(this).find('input[name="chkOrientasi[]"]').attr('checked', 'checked');
			// $(this).find('div').addClass('checked');
			// $(this).val(e.target.checked == true);
			$(".form-check-input").iCheck('check');

	});
	}

	function OJT_delAllERC(th) {
	$('.tabledelERC tr').find("td").each(function( i ) {
	// alert('a');	
			// $(this).find('input[name="chkOrientasi[]"]').removeAttr('checked', 'checked');
			// $(this).find('div').removeClass('checked');
			$(".form-check-input").iCheck('uncheck');
	});
	}
</script>