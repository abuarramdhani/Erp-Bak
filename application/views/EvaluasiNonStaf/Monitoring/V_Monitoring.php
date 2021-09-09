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
						<div class="col-lg-1" style="margin-bottom: 30px;">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('EvaluasiPekerjaNonStaf');?>">
									<i class="icon-home icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
<style type="text/css">
	tr.coloring_tabel {
		background-color: #ebf5dc !important;
	}
	tr.coloring_tabel1 {
		background-color: #f0eee9 !important;
	}

	.blinkblink{
		background: linear-gradient(#cf455c, white);
		background-size: 1800% 1800%;
		animation: danger_position 5s ease-in infinite;
	 }

	 .peringatan_EPNS{
		 background: linear-gradient(#FFA500, white);
		 background-size: 1800% 1800%;
		 animation: danger_position 5s ease-in-out infinite;
	 }

	@-webkit-keyframes danger_position {
		 0%{background-position:10% 70%}
		 50%{background-position:70% 10%}
		 100%{background-position:10% 80%}
	}


}
</style>
				<div class="row">
			        <div class="col-lg-4 col-xs-6">
			          <!-- small box -->
			          <div class="small-box bg-yellow">
			            <div class="inner">
			              <h3><?php echo count($blangko_not_send) ?></h3>

			              <p>Blangko Belum Terkirim</p>
			            </div>
			            <div class="icon" style="z-index:10;">
						  <ul class="nav navbar-nav">
							  <li class="dropdown notifications-menu">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  <i class="fa fa-envelope-o" style="color: #ce840f"></i>
								  </a>
								  <ul class="dropdown-menu"  data-backdrop="false" style="height: 380px; width: 300px; overflow:auto; position: relative; resize: vertical; z-index: 2050;">
									  <?php
									  if( count($blangko_not_send) > 0 )
									  {
										  ?>
										  <li class="header"><?php echo count($blangko_not_send);?> Blangko Belum Terkirim</li>
										  <?php
									  }
									  else
									  {
										  ?>
										  <li class="header">Bersyukurlah Blangko Sudah Terkirim !</li>
										  <?php
									  }
									  ?>
									  <li>
										  <?php
										  if (count($blangko_not_send) > 0) {
											  $today = date('Y-m-d');
											  foreach ($blangko_not_send as $key) {
												  $tanggal_kirim = $key['tgl_krm_blangko'];

												  if ($key['terkirim'] == null || $key['terkirim'] == '') {
													  $peringatan = "Blangko Belum Dikirim";
												  }

												  $warna = "";
												  if ($tanggal_kirim == $today) {
													  $warna = "text-orange";
												  }elseif ($tanggal_kirim < $today) {
													  $warna = "text-red";
												  }
											  ?>
											  <ul class="menu">
												  <li>
													  <a>
														  <i class="fa fa-calendar <?php echo $warna; ?>"></i> <?php echo $tanggal_kirim;?><br/>
														  <i class="fa fa-user text-green"></i> <?php echo $key['noind'].' - '.$key['nama'];?>
													  </a>
												  </li>
											  </ul>
											  <?php }
										  }
										   ?>
									  </li>
								  </ul>
							  </li>
						  </ul>
			            </div>
			            <a href="#EPNS_form_blangko" class="small-box-footer">
			              More info <i class="fa fa-arrow-circle-right"></i>
			            </a>
			          </div>
			        </div>
			        <!-- ./col -->
			        <div class="col-lg-4 col-xs-6">
			          <!-- small box -->
			          <div class="small-box bg-aqua">
			            <div class="inner">
			              <h3><?php echo count($notif_today) ?></h3>

			              <p>Pemberitahuan</p>
			            </div>
						<div class="icon" style="z-index:10;">
						  <ul class="nav navbar-nav">
							  <li class="dropdown notifications-menu">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  <i class="fa fa-bell" style="color: #00add7"></i>
								  </a>
								  <ul class="dropdown-menu"  data-backdrop="false" style="height: 380px; width: 300px; overflow:auto; position: relative; resize: vertical; z-index: 2050;">
									  <?php
									  if( count($notif_today) > 0 )
									  {
										  ?>
										  <li class="header">Anda Memiliki <?php echo count($notif_today);?> Pemberitahuan</li>
										  <?php
									  }
									  else
									  {
										  ?>
										  <li class="header">Bersyukurlah Anda... Tidak Ada Pemberitahuan</li>
										  <?php
									  }
									  ?>
									  <li>
										  <?php
										  if (count($notif_today) > 0) {
											  $today = date('Y-m-d');
											  foreach ($notif_today as $key) {

												  if ($today >= $key['peringatan_1'] && $today < $key['peringatan_2'] && $key['blangko_msk'] == ''){
													  $peringatan = "Peringatan 1";


												  $warna = "";
												  if ($tanggal_kirim == $today) {
													  $warna = "text-orange";
												  }elseif ($tanggal_kirim < $today) {
													  $warna = "text-red";
												  }
											  ?>
											  <ul class="menu">
												  <li>
													  <a>
														  <i class="fa fa-calendar <?php echo $warna; ?>"></i> <?php echo $key['peringatan_1'];?><br/>
														  <i class="fa  fa-exclamation-circle text-orange"></i> <?php echo $peringatan;?><br/>
														  <i class="fa fa-user text-green"></i> <?php echo $key['noind'].' - '.$key['nama'];?>
													  </a>
												  </li>
											  </ul>
										  <?php } }
										  }
										   ?>
									  </li>
								  </ul>
							  </li>
						  </ul>
			            </div>
			            <a href="#EPNS_body_monitoring" class="small-box-footer">
			              More info <i class="fa fa-arrow-circle-right"></i>
			            </a>
			          </div>
			        </div>
			        <!-- ./col -->
			        <div class="col-lg-4 col-xs-6">
			          <!-- small box -->
			          <div class="small-box bg-red">
			            <div class="inner">
			              <h3><?php echo count($flag_today); ?></h3>

			              <p>Peringatan 2</p>
			            </div>
						<div class="icon" style="z-index:10;">
						  <ul class="nav navbar-nav">
							  <li class="dropdown notifications-menu">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  <i class="fa fa-flag-o" style="color: #c74333"></i>
									  <!-- <span class="label label-warning"><?php //echo $jumlah_notif; ?></span> -->
								  </a>
								  <ul class="dropdown-menu"  data-backdrop="false" style="height: 380px; width: 300px; overflow:auto; position: relative; resize: vertical; z-index: 2050;">
									  <?php
									  if( count($flag_today) > 0 )
									  {
										  ?>
										  <li class="header">Anda Memiliki <?php echo count($flag_today);?> Peringatan ke 2</li>
										  <?php
									  }
									  else
									  {
										  ?>
										  <li class="header">Bersyukurlah... Disiplin Tinggi !</li>
										  <?php
									  }
									  ?>
									  <li>
										  <?php
										  if (count($flag_today) > 0) {
											  $today = date('Y-m-d');
											  foreach ($flag_today as $key) {

												  if ($today >= $key['peringatan_2'] && $key['blangko_msk'] == '') {
													  $peringatan = "Peringatan 2";
												  }

												  $warna = "";
												  if ($tanggal_kirim == $today) {
													  $warna = "text-orange";
												  }elseif ($tanggal_kirim < $today) {
													  $warna = "text-red";
												  }
											  ?>
											  <ul class="menu">
												  <li>
													  <a>
														  <i class="fa fa-calendar <?php echo $warna; ?>"></i> <?php echo $key['peringatan_2'];?><br/>
														  <i class="fa  fa-exclamation-circle text-orange"></i> <?php echo $peringatan;?><br/>
														  <i class="fa fa-user text-green"></i> <?php echo $key['noind'].' - '.$key['nama'];?>
													  </a>
												  </li>
											  </ul>
											  <?php }
										  }
										   ?>
									  </li>
								  </ul>
							  </li>
						  </ul>
			            </div>
			            <a href="#EPNS_body_monitoring" class="small-box-footer">
			              More info <i class="fa fa-arrow-circle-right"></i>
			            </a>
			          </div>
			        </div>
			        <!-- ./col -->
			      </div>


				<div class="row" id="EPNS_body_monitoring">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="fa fa-calendar">&emsp;Monitoring Evaluasi Pekerja Non Staf</h3>
								<!-- <div class="navbar-custom-menu" style="margin-right: 1%; margin-top: -1%; margin-bottom: -1%; vertical-align: middle;">
									<?php
										$jumlah_notif_flag = count($flag_today);
									 ?>
									<ul class="nav navbar-nav">
										<li class="dropdown notifications-menu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<i class="fa fa-flag-o"></i>
												<span class="label label-danger"><?php echo $jumlah_notif_flag; ?></span>
											</a>
											<ul class="dropdown-menu" style="height: 380px; width: 300px; overflow: auto; resize: vertical;">
												<?php
												if( $jumlah_notif_flag > 0 )
												{
													?>
													<li class="header">Anda memiliki <?php echo $jumlah_notif_flag;?> Peringatan ke 2.</li>
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
													if ($jumlah_notif_flag > 0) {
														$today = date('Y-m-d');
														foreach ($notif_today as $key) {
															$tanggal_kirim = $key['tgl_krm_blangko'];

															if ($today >= $key['peringatan_2'] && $key['blangko_msk'] == '') {
																$peringatan = "Peringatan 2";
															}
														?>
														<ul class="menu">
															<li>
																<a>
																	<i class="fa fa-calendar text-red"></i> <?php echo $tanggal_kirim;?><br/>
																	<i class="fa  fa-exclamation-circle text-orange"></i> <?php echo $peringatan;?><br/>
																	<i class="fa fa-user text-green"></i> <?php echo $key['noind'].' - '.$key['nama'];?>
																</a>
															</li>
														</ul>
														<?php }
													}
													 ?>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<div class="navbar-custom-menu" style="margin-right: 1%; margin-top: -1%; margin-bottom: -1%; vertical-align: middle;">
									<?php
										$jumlah_notif = count($notif_today);
									 ?>
									<ul class="nav navbar-nav">
										<li class="dropdown notifications-menu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<i class="fa fa-bell-o"></i>
												<span class="label label-warning"><?php echo $jumlah_notif; ?></span>
											</a>
											<ul class="dropdown-menu" style="height: 380px; width: 300px; overflow: auto; resize: vertical;">
												<?php
												if( $jumlah_notif > 0 )
												{
													?>
													<li class="header">Anda memiliki <?php echo $jumlah_notif;?> pemberitahuan.</li>
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
													if ($jumlah_notif > 0) {
														$today = date('Y-m-d');
														foreach ($notif_today as $key) {
															$tanggal_kirim = $key['tgl_krm_blangko'];

															if ($key['terkirim'] == null || $key['terkirim'] == '') {
																$peringatan = "Blangko Belum Dikirim";
															}elseif ($today >= $key['peringatan_1'] && $today < $key['peringatan_2'] && $key['blangko_msk'] == ''){
																$peringatan = "Peringatan 1";
															}elseif ($today >= $key['peringatan_2'] && $key['blangko_msk'] == '') {
																$peringatan = "Peringatan 2";
															}
														?>
														<ul class="menu">
															<li>
																<a>
																	<i class="fa fa-calendar text-red"></i> <?php echo $tanggal_kirim;?><br/>
																	<i class="fa  fa-exclamation-circle text-orange"></i> <?php echo $peringatan;?><br/>
																	<i class="fa fa-user text-green"></i> <?php echo $key['noind'].' - '.$key['nama'];?>
																</a>
															</li>
														</ul>
														<?php }
													}
													 ?>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<div class="navbar-custom-menu" style="margin-right: 1%; margin-top: -1%; margin-bottom: -1%; vertical-align: middle;">
									<?php
										$jumlah_notif = count($notif_today);
									 ?>
									<ul class="nav navbar-nav">
										<li class="dropdown notifications-menu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<i class="fa fa-envelope-o"></i>
												<span class="label label-warning"><?php echo $jumlah_notif; ?></span>
											</a>
											<ul class="dropdown-menu" style="height: 380px; width: 300px; overflow: auto; resize: vertical;">
												<?php
												if( $jumlah_notif > 0 )
												{
													?>
													<li class="header"><?php echo $jumlah_notif;?> Blangko Belum Terkirim</li>
													<?php
												}
												else
												{
													?>
													<li class="header">Bersyukurlah Blangko Sudah Terkirim !</li>
													<?php
												}
												?>
												<li>
													<?php
													if ($jumlah_notif > 0) {
														$today = date('Y-m-d');
														foreach ($notif_today as $key) {
															$tanggal_kirim = $key['tgl_krm_blangko'];

															if ($key['terkirim'] == null || $key['terkirim'] == '') {
																$peringatan = "Blangko Belum Dikirim";
															}elseif ($today >= $key['peringatan_1'] && $today < $key['peringatan_2'] && $key['blangko_msk'] == ''){
																$peringatan = "Peringatan 1";
															}elseif ($today >= $key['peringatan_2'] && $key['blangko_msk'] == '') {
																$peringatan = "Peringatan 2";
															}

															$warna = "";
															if ($tanggal_kirim == $today) {
																$warna = "text-orange";
															}elseif ($tanggal_kirim < $today) {
																$warna = "text-red";
															}
														?>
														<ul class="menu">
															<li>
																<a>
																	<i class="fa fa-calendar <?php echo $warna; ?>"></i> <?php echo $tanggal_kirim;?><br/>
																	<i class="fa fa-user text-green"></i> <?php echo $key['noind'].' - '.$key['nama'];?>
																</a>
															</li>
														</ul>
														<?php }
													}
													 ?>
												</li>
											</ul>
										</li>
									</ul>
								</div> -->
							</div>
							<div class="box-body">
								<ul class="nav nav-tabs nav-justified">
									<li class="active"><a data-toggle="pill" href="#kns">Kontrak Non Staf</a></li>
									<li><a data-toggle="pill" href="#knk">Kontrak Non Staf Khusus</a></li>
									<li><a data-toggle="pill" href="#cabang">Evaluasi Cabang</a></li>
									<li><a data-toggle="pill" href="#ospp">OS / PP</a></li>
									<li><a data-toggle="pill" href="#pkl">PKL</a></li>
								</ul>
								<br>
								<div class="tab-content">
									<!-- Kontrak Non Staf -->
									<div id="kns" class="tab-pane fade in in active">
										<div class="col-lg-12 bg-info text-center" style=" margin-bottom: 30px;">
											<label class="text-center" style="font-size: 16px;">Status : KONTRAK NON STAF</label>
										</div>
										<table class="table table-bordered table-responsive-xs table-sm" style="width: 100%;" id="EPNS_Monitoring_kns">
											<thead>
												<tr style="background-color: #3c8dbc !important; color:white;">
													<th class="text-center" style="white-space: nowrap;">No</th>
													<th class="text-center" style="white-space: nowrap;">Action</th>
													<th class="text-center" style="white-space: nowrap;">No. induk</th>
													<th class="text-center" style="white-space: nowrap;">Nama</th>
													<th class="text-center" style="white-space: nowrap;">Periode Evaluasi</th>
													<th class="text-center" style="white-space: nowrap;">Seksi</th>
													<th class="text-center" style="white-space: nowrap;">Note</th>
													<th class="text-center" style="white-space: nowrap;">Job Desk</th>
													<th class="text-center" style="white-space: nowrap;">Gol</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Sls Orientasi</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Kirim Blangko</th>
													<th class="text-center" style="white-space: nowrap;">Terkirim</th>
													<th class="text-center" style="white-space: nowrap;">Peringatan 1</th>
													<th class="text-center" style="white-space: nowrap;">Peringatan 2</th>
													<th class="text-center" style="white-space: nowrap;">Blangko Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Kesepakatan</th>
													<!-- <th class="text-center" style="white-space: nowrap;">Hubker -> Seleksi</th> -->
													<th class="text-center" style="white-space: nowrap;">Kirim Memo Nilai Training</th>
													<th class="text-center" style="white-space: nowrap;">Alasan Gugur</th>
													<th class="text-center" style="white-space: nowrap;">Perpanjangan</th>
													<th class="text-center" style="white-space: nowrap;" hidden>Order</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (empty($monitoring_nonstaf)) {  }else {
													$no = 1;
													$nowcolor = 0;
													$preview = $monitoring_nonstaf['0']['tgl_masuk'];
													foreach ($monitoring_nonstaf as $key) {
															$encrypt = $this->encrypt->encode($key['id']);
															$encrypt = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypt);
															$color = ['', 'coloring_tabel', 'coloring_tabel1'];
														?>
														<tr class="<?php if ($key['tgl_masuk'] == $preview) {
																				echo $color[$nowcolor];
																		  }else if($key['tgl_masuk'] != $preview) {
																				if($nowcolor == 0){
																					$nowcolor = 1;
																				}elseif($nowcolor == 1){
																					$nowcolor = 2;
																				}else {
																					$nowcolor = 0;
																				}
																				echo $color[$nowcolor];
																		  } ?>

																    <?php if (date('Y-m-d') == $key['peringatan_2'] && $key['blangko_msk'] == null){
																		 echo "blinkblink";
																	 }elseif ((date('Y-m-d') == $key['peringatan_1'] && $key['blangko_msk'] == null) || ($key['terkirim'] == null && $today >= $key['tgl_krm_blangko'])) {
																	 	echo 'peringatan_EPNS';
																	 } ?>">
															<td class="text-center" style="white-space: nowrap;"><?php echo $no ?></td>
															<td class="text-center" style="white-space: nowrap;">
																<a class="fa fa-print fa-2x" target="_blank" href="Monitoring/getExport/<?php echo $encrypt ?>"></a>
															</td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['noind'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['nama'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d F Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-left" style="white-space: nowrap;"><?php echo $key['seksi'] ?></td>
															<td class="text-left" style="white-space: nowrap;">
																	<?php
																	$today = date('Y-m-d');
																	if ($key['terkirim'] == null && $today >= $key['tgl_krm_blangko']) {
																		echo '<li class="text-yellow;">Peringatan Blangko Belum Dikirim</li>';
																	}else {
																		if ($today >= $key['peringatan_1'] && $key['blangko_msk'] == null) {
																			if (date('Y-m-d') >= $key['peringatan_2']) {
																				echo '<li class="text-red;">Peringatan 1</li>';
																				echo '<li class="text-red;">Peringatan 2</li>';
																			}else {
																				echo '<li class="text-red;">Peringatan 1</li>';
																			}
																		}else{
																			echo "-"; 
																		}
																	}?>
																	</td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['job_des'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['gol'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_sls_orientasi'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_krm_blangko'])) ?></td>
															<td class="text-center" style="white-space: nowrap;" class="updateToday">
																	<?php if ($key['terkirim'] == null) { ?>
																		<button type="button" name="button" class="btn btn-success btn_kirim_blangko" onclick="updateToday(<?php echo $key['id'] ?>)">Kirim</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['terkirim']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if (date('Y-m-d') >= $key['peringatan_1'] && $key['blangko_msk'] == null) {
																		echo !empty($key['peringatan_1']) ? date('d/m/Y', strtotime($key['peringatan_1'])) : '';
																	}else {
																		echo "-";
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if (date('Y-m-d') >= $key['peringatan_2'] && $key['blangko_msk'] == null) {
																		echo !empty($key['peringatan_2']) ? date('d/m/Y', strtotime($key['peringatan_2'])) : '';
																	}else {
																		echo "-";
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] == null) { ?>
																		<button type="button" name="button" class="btn btn-info btn_blangko_masuk" onclick="Blangko_masuk(<?php echo $key['id'] ?>)">Masuk</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['blangko_msk']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"></td>
															<!-- <td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['hubker_seleksi'])) { ?>
																		<button type="button" name="button" class="btn btn-warning btn_hubker_seleksi" onclick="hubker_seleksi(<?php echo $key['id'] ?>)">Kirim</button>
																	<?php }else {
																		echo !empty($key['hubker_seleksi']) ? date('d/m/Y', strtotime($key['hubker_seleksi'])) : '';
																	} ?></td> -->
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['nilai_training'])) { ?>
																		<button type="button" name="button" class="btn btn-info btn_kirim_nilai" onclick="kirim_nilai(<?php echo $key['id'] ?>, '<?php echo $key['noind'] ?>')">Kirim</button>
																	<?php }else if(!empty($key['nilai_training'])) { ?>
																		<a class="fa fa-file-text-o fa-2x" target="_blank" href="<?php echo base_url('./assets/upload/EvaluasiNonStaf/Nilai_Training/'.$key['nilai_training'].'')?>"></a>
																	<?php }else{
																		echo '';
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['nilai_training'] != null && empty($key['alasan_gugur'])) { ?>
																		<button type="button" name="button" class="btn btn-success btn_lulus" onclick="lulus_gugur(<?php echo $key['id'] ?>, 'lulus')">Lulus</button>
																		<button type="button" name="button" class="btn btn-danger btn_gugur" onclick="lulus_gugur(<?php echo $key['id'] ?>, 'gugur')">Gugur</button>
																	<?php }else {
																		echo $key['alasan_gugur'] != 'lulus' ? $key['alasan_gugur'] : '-';
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['perpanjangan'] ?></td>
															<td hidden></td>
														</tr>
													<?php $no++; $preview = $key['tgl_masuk'];} } ?>
											</tbody>
										</table>
									</div>

									<!-- EVALUASI CABANG -->
									<div id="cabang" class="tab-pane fade in">
										<div class="col-lg-12 bg-info text-center" style=" margin-bottom: 30px;">
											<label class="text-center" style="font-size: 16px;">Status : EVALUASI CABANG</label>
										</div>
										<table class="table table-bordered" style="width: 100%;" id="EPNS_Monitoring_cabang">
											<thead>
												<tr style="background-color: #3c8dbc !important; color:white;">
													<th class="text-center" style="white-space: nowrap;">No</th>
													<th class="text-center" style="white-space: nowrap;">No. induk</th>
													<th class="text-center" style="white-space: nowrap;">Status</th>
													<th class="text-center" style="white-space: nowrap;">Nama</th>
													<th class="text-center" style="white-space: nowrap;">Seksi</th>
													<th class="text-center" style="white-space: nowrap;">Note</th>
													<th class="text-center" style="white-space: nowrap;">Job Desk</th>
													<th class="text-center" style="white-space: nowrap;">Gol</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Sls Orientasi</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Kirim Blangko</th>
													<th class="text-center" style="white-space: nowrap;">Terkirim</th>
													<th class="text-center" style="white-space: nowrap;">Peringatan 1</th>
													<th class="text-center" style="white-space: nowrap;">Peringatan 2</th>
													<th class="text-center" style="white-space: nowrap;">Blangko Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Kesepakatan</th>
													<!-- <th class="text-center" style="white-space: nowrap;">Hubker -> Seleksi</th> -->
													<th class="text-center" style="white-space: nowrap;">Kirim Memo Nilai Training</th>
													<th class="text-center" style="white-space: nowrap;">Alasan Gugur</th>
													<th class="text-center" style="white-space: nowrap;">Perpanjangan</th>
													<th class="text-center" style="white-space: nowrap;" hidden>Order</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (empty($monitoring_cabang)) {  }else {
													$no = 1;
													foreach ($monitoring_cabang as $key) { ?>
														<tr class="coloring_tabel">
															<td class="text-center" style="white-space: nowrap;"><?php echo $no ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['noind'] ?></td>
															<td class="text-center" style="white-space: nowrap;">Kontrak</td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['nama'] ?></td>
															<td class="text-left" style="white-space: nowrap;"><?php echo $key['seksi'] ?></td>
															<td class="text-left <?php if (date('Y-m-d') >= $key['peringatan_1'] && $key['blangko_msk'] == null){echo "blinkblink";} ?>" style="white-space: nowrap;">
																	<?php
																	$today = date('Y-m-d');
																	if ($key['terkirim'] == null && $today >= $key['tgl_krm_blangko']) {
																		echo '<li class="text-Yellow;">Peringatan Blangko Belum Dikirim</li>';
																	}else {
																		if ($today >= $key['peringatan_1'] && $key['blangko_msk'] == null) {
																						if (date('Y-m-d') >= $key['peringatan_2']) {
																							echo '<li class="text-red;">Peringatan 1</li>';
																							echo '<li class="text-red;">Peringatan 2</li>';
																						}else {
																							echo '<li class="text-red;">Peringatan 1</li>';
																						}
																					}else{
																					echo "-"; }
																	}?>
																	</td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['job_des'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['gol'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_sls_orientasi'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_krm_blangko'])) ?></td>
															<td class="text-center" style="white-space: nowrap;" class="updateToday">
																	<?php if ($key['terkirim'] == null) { ?>
																		<button type="button" name="button" class="btn btn-success btn_kirim_blangko" onclick="updateToday(<?php echo $key['id'] ?>)">kirim</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['terkirim']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['peringatan_1'] != null && date('Y-m-d') >= $key['peringatan_1'] && $key['blangko_msk'] == null) {
																		echo date('d/m/Y', strtotime($key['peringatan_1']));
																	}else {
																		echo "-";
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['peringatan_2'] != null && date('Y-m-d') >= $key['peringatan_2'] && $key['blangko_msk'] == null) {
																		echo date('d/m/Y', strtotime($key['peringatan_2']));
																	}else {
																		echo "-";
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] == null) { ?>
																		<button type="button" name="button" class="btn btn-info btn_blangko_masuk" onclick="Blangko_masuk(<?php echo $key['id'] ?>)">Masuk</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['blangko_msk']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"></td>
															<!-- <td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['nilai_training'] != null && empty($key['hubker_seleksi'])) { ?>
																		<button type="button" name="button" class="btn btn-warning btn_hubker_seleksi" onclick="hubker_seleksi(<?php echo $key['id'] ?>)">Kirim</button>
																	<?php }else {
																		echo !empty($key['hubker_seleksi']) ? date('d/m/Y', strtotime($key['hubker_seleksi'])) : '';
																	} ?></td> -->
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['nilai_training'])) { ?>
																		<button type="button" name="button" class="btn btn-info btn_kirim_nilai" onclick="kirim_nilai(<?php echo $key['id'] ?>, '<?php echo $key['noind'] ?>')">Kirim</button>
																	<?php }else if(!empty($key['nilai_training'])) { ?>
																		<a class="fa fa-file-text-o fa-2x" target="_blank" href="<?php echo base_url('./assets/upload/EvaluasiNonStaf/Nilai_Training/'.$key['nilai_training'].'')?>"></a>
																	<?php }else{
																		echo '';
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['nilai_training'] != null && empty($key['alasan_gugur'])) { ?>
																		<button type="button" name="button" class="btn btn-success btn_lulus" onclick="lulus_gugur(<?php echo $key['id'] ?>, 'lulus')">Lulus</button>
																		<button type="button" name="button" class="btn btn-danger btn_gugur" onclick="lulus_gugur(<?php echo $key['id'] ?>, 'gugur')">Gugur</button>
																	<?php }else {
																		echo $key['alasan_gugur'] != 'lulus' ? $key['alasan_gugur'] : '-';
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['perpanjangan'] ?></td>
															<td hidden></td>
														</tr>
													<?php $no++; }} ?>
											</tbody>
										</table>
									</div>

									<!-- KONTRAK NON STAF KHUSUS -->
									<div id="knk" class="tab-pane fade in in">
										<div class="col-lg-12 bg-info text-center" style=" margin-bottom: 30px;">
											<label class="text-center" style="font-size: 16px;">Status : KONTRAK NON STAF KHUSUS</label>
										</div>
										<table class="table table-bordered" style="width: 100%;" id="EPNS_Monitoring_knk">
											<thead>
												<tr style="background-color: #3c8dbc !important; color:white;">
													<th class="text-center" style="white-space: nowrap;">No</th>
													<!-- <th class="text-center" style="white-space: nowrap;">Action</th> -->
													<th class="text-center" style="white-space: nowrap;">Periode Evaluasi</th>
													<th class="text-center" style="white-space: nowrap;">Status</th>
													<th class="text-center" style="white-space: nowrap;">No. induk</th>
													<th class="text-center" style="white-space: nowrap;">Nama</th>
													<th class="text-center" style="white-space: nowrap;">Seksi</th>
													<th class="text-center" style="white-space: nowrap;">Job Desk</th>
													<th class="text-center" style="white-space: nowrap;">Gol</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Sls Orientasi</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Kirim Blangko</th>
													<th class="text-center" style="white-space: nowrap;">Terkirim</th>
													<th class="text-center" style="white-space: nowrap;">Peringatan 1</th>
													<th class="text-center" style="white-space: nowrap;">Peringatan 2</th>
													<th class="text-center" style="white-space: nowrap;">Blangko Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Kesepakatan</th>
													<!-- <th class="text-center" style="white-space: nowrap;">Hubker -> Seleksi</th> -->
													<th class="text-center" style="white-space: nowrap;">Kirim Memo Nilai Training</th>
													<th class="text-center" style="white-space: nowrap;">Alasan Gugur</th>
													<th class="text-center" style="white-space: nowrap;">Perpanjangan</th>
													<th class="text-center" style="white-space: nowrap;" hidden>Order</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (empty($monitoring_khusus)) {  }else {
													$no = 1;
													foreach ($monitoring_khusus as $key) { 
														$encrypt = $this->encrypt->encode($key['id']);
														$encrypt = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypt);
														?>
														<tr class="coloring_tabel">
															<td class="text-center" style="white-space: nowrap;"><?php echo $no ?></td>
															<!-- <td class="text-center" style="white-space: nowrap;">
																<a class="fa fa-print fa-2x" target="_blank" href="Monitoring/getExport/<?php echo $encrypt ?>"></a>
															</td> -->
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-center" style="white-space: nowrap;">KNS KHUSUS</td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['noind'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['nama'] ?></td>
															<td class="text-left" style="white-space: nowrap;"><?php echo $key['seksi'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['job_des'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['gol'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_sls_orientasi'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_krm_blangko'])) ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['terkirim'] == null) { ?>
																		<button type="button" name="button" class="btn btn-success btn_kirim_blangko" onclick="updateToday(<?php echo $key['id'] ?>)">kirim</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['terkirim']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo !empty($key['peringatan_1']) ? date('d/m/Y', strtotime($key['peringatan_1'])) : '' ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo !empty($key['peringatan_2']) ? date('d/m/Y', strtotime($key['peringatan_2'])) : '' ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] == null) { ?>
																		<button type="button" name="button" class="btn btn-info btn_blangko_masuk" onclick="Blangko_masuk(<?php echo $key['id'] ?>)">Masuk</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['blangko_msk']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"></td>
															<!-- <td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['hubker_seleksi'])) { ?>
																		<button type="button" name="button" class="btn btn-warning btn_hubker_seleksi" onclick="hubker_seleksi(<?php echo $key['id'] ?>)">Kirim</button>
																	<?php }else {
																		echo !empty($key['hubker_seleksi']) ? date('d/m/Y', strtotime($key['hubker_seleksi'])) : '';
																	} ?></td> -->
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['nilai_training'])) { ?>
																		<button type="button" name="button" class="btn btn-info btn_kirim_nilai" onclick="kirim_nilai(<?php echo $key['id'] ?>, '<?php echo $key['noind'] ?>')">Kirim</button>
																	<?php }else if(!empty($key['nilai_training'])) { ?>
																		<a class="fa fa-file-text-o fa-2x" target="_blank" href="<?php echo base_url('./assets/upload/EvaluasiNonStaf/Nilai_Training/'.$key['nilai_training'].'')?>"></a>
																	<?php }else{
																		echo '';
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['nilai_training'] != null && empty($key['alasan_gugur'])) { ?>
																		<button type="button" name="button" class="btn btn-success btn_lulus" onclick="lulus_gugur(<?php echo $key['id'] ?>, 'lulus')">Lulus</button>
																		<button type="button" name="button" class="btn btn-danger btn_gugur" onclick="lulus_gugur(<?php echo $key['id'] ?>, 'gugur')">Gugur</button>
																	<?php }else {
																		echo $key['alasan_gugur'] != 'lulus' ? $key['alasan_gugur'] : '-';
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['perpanjangan'] ?></td>
															<td hidden></td>
														</tr>
													<?php $no++; }} ?>
											</tbody>
										</table>
									</div>

									<!-- OS / PP -->
									<div id="ospp" class="tab-pane fade in">
										<div class="col-lg-12 bg-info text-center" style=" margin-bottom: 30px;">
											<label class="text-center" style="font-size: 16px;">Status : OS / PP</label>
										</div>
										<table class="table table-bordered" style="width: 100%;" id="EPNS_Monitoring_ospp">
											<thead>
												<tr style="background-color: #3c8dbc !important; color:white;">
													<th class="text-center" style="white-space: nowrap;">No</th>
													<th class="text-center" style="white-space: nowrap;">Periode Evaluasi</th>
													<th class="text-center" style="white-space: nowrap;">Status</th>
													<th class="text-center" style="white-space: nowrap;">No. induk</th>
													<th class="text-center" style="white-space: nowrap;">Nama</th>
													<th class="text-center" style="white-space: nowrap;">Seksi</th>
													<th class="text-center" style="white-space: nowrap;">Job Desk</th>
													<th class="text-center" style="white-space: nowrap;">Gol</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Sls Orientasi</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Kirim Blangko</th>
													<th class="text-center" style="white-space: nowrap;">Terkirim</th>
													<th class="text-center" style="white-space: nowrap;">Peringatan 1</th>
													<th class="text-center" style="white-space: nowrap;">Blangko Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Kesepakatan</th>
													<!-- <th class="text-center" style="white-space: nowrap;">Hubker -> Seleksi</th> -->
													<th class="text-center" style="white-space: nowrap;">Kirim Memo Nilai Training</th>
													<th class="text-center" style="white-space: nowrap;">Alasan Gugur</th>
													<th class="text-center" style="white-space: nowrap;">Perpanjangan</th>
													<th class="text-center" style="white-space: nowrap;" hidden>Order</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (empty($monitoring_ospp)) {  }else {
													$no = 1;
													foreach ($monitoring_ospp as $key) { ?>
														<tr class="coloring_tabel">
															<td class="text-center" style="white-space: nowrap;"><?php echo $no ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['asal_outsorcing'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['noind'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['nama'] ?></td>
															<td class="text-left" style="white-space: nowrap;"><?php echo $key['seksi'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['job_des'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_sls_orientasi'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_krm_blangko'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo '-'//$key['tgl_krm_blangko'] ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['terkirim'] == null) { ?>
																		<button type="button" name="button" class="btn btn-success btn_kirim_blangko" onclick="updateToday(<?php echo $key['id'] ?>)">kirim</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['terkirim']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo !empty($key['peringatan_1']) ? date('d/m/Y', strtotime($key['peringatan_1'])) : '' ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] == null) { ?>
																		<button type="button" name="button" class="btn btn-info btn_blangko_masuk" onclick="Blangko_masuk(<?php echo $key['id'] ?>)">Masuk</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['blangko_msk']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"></td>
															<!-- <td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['hubker_seleksi'])) { ?>
																		<button type="button" name="button" class="btn btn-warning btn_hubker_seleksi" onclick="hubker_seleksi(<?php echo $key['id'] ?>)">Kirim</button>
																	<?php }else {
																		echo !empty($key['hubker_seleksi']) ? date('d/m/Y', strtotime($key['hubker_seleksi'])) : '';
																	} ?></td> -->
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['nilai_training'])) { ?>
																		<button type="button" name="button" class="btn btn-info btn_kirim_nilai" onclick="kirim_nilai(<?php echo $key['id'] ?>, '<?php echo $key['noind'] ?>')">Kirim</button>
																	<?php }else if(!empty($key['nilai_training'])) { ?>
																		<a class="fa fa-file-text-o fa-2x" target="_blank" href="<?php echo base_url('./assets/upload/EvaluasiNonStaf/Nilai_Training/'.$key['nilai_training'].'')?>"></a>
																	<?php }else{
																		echo '';
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['nilai_training'] != null && empty($key['alasan_gugur'])) { ?>
																		<button type="button" name="button" class="btn btn-success btn_lulus" onclick="lulus_gugur(<?php echo $key['id'] ?>, 'lulus')">Lulus</button>
																		<button type="button" name="button" class="btn btn-danger btn_gugur" onclick="lulus_gugur(<?php echo $key['id'] ?>, 'gugur')">Gugur</button>
																	<?php }else {
																		echo $key['alasan_gugur'] != 'lulus' ? $key['alasan_gugur'] : '-';
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['perpanjangan'] ?></td>
															<td hidden></td>
														</tr>
													<?php $no++; }} ?>
											</tbody>
										</table>
									</div>

									<!-- PKL -->
									<div id="pkl" class="tab-pane fade in">
										<div class="col-lg-12 bg-info text-center" style=" margin-bottom: 30px;">
											<label class="text-center" style="font-size: 16px;">Status : PKL</label>
										</div>
										<table class="table table-bordered" style="width: 100%;" id="EPNS_Monitoring_pkl">
											<thead>
												<tr style="background-color: #3c8dbc !important; color:white;">
													<th class="text-center" style="white-space: nowrap;">No</th>
													<th class="text-center" style="white-space: nowrap;">Periode Evaluasi</th>
													<th class="text-center" style="white-space: nowrap;">Status</th>
													<th class="text-center" style="white-space: nowrap;">No. induk</th>
													<th class="text-center" style="white-space: nowrap;">Nama</th>
													<th class="text-center" style="white-space: nowrap;">Seksi</th>
													<th class="text-center" style="white-space: nowrap;">Job Desk</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Sls Orientasi</th>
													<th class="text-center" style="white-space: nowrap;">Tgl. Kirim Blangko</th>
													<th class="text-center" style="white-space: nowrap;">Terkirim</th>
													<th class="text-center" style="white-space: nowrap;">Peringatan 1</th>
													<th class="text-center" style="white-space: nowrap;">Blangko Masuk</th>
													<th class="text-center" style="white-space: nowrap;">Kesepakatan</th>
													<!-- <th class="text-center" style="white-space: nowrap;">Hubker -> Seleksi</th> -->
													<th class="text-center" style="white-space: nowrap;">Kirim Memo Nilai Training</th>
													<th class="text-center" style="white-space: nowrap;" hidden>Order</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (empty($monitoring_pkl)) {  }else {
													$no = 1;
													foreach ($monitoring_pkl as $key) { ?>
														<tr class="coloring_tabel">
															<td class="text-center" style="white-space: nowrap;"><?php echo $no ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['gol'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['noind'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['nama'] ?></td>
															<td class="text-left" style="white-space: nowrap;"><?php echo $key['seksi'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo $key['job_des'] ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_sls_orientasi'])) ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo date('d/m/Y', strtotime($key['tgl_krm_blangko'])) ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['terkirim'] == null) { ?>
																		<button type="button" name="button" class="btn btn-success btn_kirim_blangko" onclick="updateToday(<?php echo $key['id'] ?>)">kirim</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['terkirim']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"><?php echo !empty($key['peringatan_1']) ? date('d/m/Y', strtotime($key['peringatan_1'])) : '' ?></td>
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] == null) { ?>
																		<button type="button" name="button" class="btn btn-info btn_blangko_masuk" onclick="Blangko_masuk(<?php echo $key['id'] ?>)">Masuk</button>
																	<?php }else {
																		echo date('d/m/Y', strtotime($key['blangko_msk']));
																	} ?></td>
															<td class="text-center" style="white-space: nowrap;"></td>
															<!-- <td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['hubker_seleksi'])) { ?>
																		<button type="button" name="button" class="btn btn-warning btn_hubker_seleksi" onclick="hubker_seleksi(<?php echo $key['id'] ?>)">Kirim</button>
																	<?php }else {
																		echo !empty($key['hubker_seleksi']) ? date('d/m/Y', strtotime($key['hubker_seleksi'])) : '';
																	} ?></td> -->
															<td class="text-center" style="white-space: nowrap;">
																	<?php if ($key['blangko_msk'] != null && empty($key['nilai_training'])) { ?>
																		<button type="button" name="button" class="btn btn-info btn_kirim_nilai" onclick="kirim_nilai(<?php echo $key['id'] ?>, '<?php echo $key['noind'] ?>')">Kirim</button>
																	<?php }else if(!empty($key['nilai_training'])) { ?>
																		<a class="fa fa-file-text-o fa-2x" target="_blank" href="<?php echo base_url('./assets/upload/EvaluasiNonStaf/Nilai_Training/'.$key['nilai_training'].'')?>"></a>
																	<?php }else{
																		echo '';
																	} ?></td>
															<td hidden></td>
														</tr>
													<?php $no++; }} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row" id="EPNS_form_blangko">
					<div class="col-lg-12">
						<div class="box box-primary box-solid ">
							<div class="box-header with-border">
								<label> FORM KIRIM BLANGKO</label>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="box-body">
								<div class="col-lg-12" style="margin-bottom: 30px;">
									<div class="col-lg-3 text-right">
										<label>Lokasi Kerja : </label>
									</div>
									<div class="col-lg-5">
										<select class="select select2 form-control" id="EPNS_get_cabang">
											<option value="all"></option>
											<option value="01">Pusat</option>
											<option value="02">Tuksono</option>
											<option value="cabang">Cabang</option>
										</select>
										<p style="font-size: 12px; color: red;">*) Kosongkan untuk melihat semua blangko yang belum terkirim</p>
									</div>
									<div class="col-lg-1">
										<button type="button" name="cari_pekerja" class="btn btn-primary glyphicon glyphicon-search" id="EPNS_cari_pekerja"></button>
									</div>
								</div>
								<div class="col-lg-12" id="nambahTabel">

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<form method="post" enctype="multipart/form-data">
<div class="modal fade" id="mdl_kirim_nilai" role="dialog">
    <div class="modal-dialog" style="padding-left:5px;width:60%">
      <!-- Modal content-->
      <div class="modal-content" style="border-radius:10px">
        <div id="data_kirim_nilai"></div>
      </div>
    </div>
</div>
</form>

<script type="text/javascript">
	$(document).ready(function () {
		$('a[data-toggle="pill"]').on( 'shown.bs.tab', function (e) {
	          $.fn.dataTable.tables( { api: true} ).columns.adjust();
	          setTimeout(
	            function () {
	              $('th:contains(Order)').click()
	            }, 200
	          )
				} );
	})
</script>
