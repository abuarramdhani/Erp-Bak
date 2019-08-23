<section class="content">
			<!-- Content Header (Page header) -->
					<div class="row">
						<div class="col-lg-12 bg-primary">
							<h3 align="center"><?=$Menu ?></h3>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 bg-info">
							<div class="row">
								<div class="col-lg-1">
									<text>Nama 			  </text><br>
									<text>No Induk	  </text><br>
									<text>Seksi 		  </text><br>
									<text>Unit			  </text><br>
									<text>Departemen  </text>
								</div>
								<div class="col-lg-11">
									<?php foreach ($Info as $key): ?>
										<text>: <?=$key['nama']?></text> <br>
										<text>: <?=$key['noind']?> </text><br>
										<text>: <?=$key['seksi']?> </text><br>
										<text>: <?=$key['unit']?> </text><br>
										<text>: <?=$key['dept']?> </text>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="inner">
						<div class="row">
							<form class="form-horizontal" method="post" action="<?php echo site_url('PermohonanCuti/Tahunan/Insert') ?>">
								<div class="col-lg-12">
									<div class="row">
										<div class="box ">
											<div class="panel-body">
													<div class="form-group">
														<label class="control-label col-lg-4">Sisa Cuti Saat Ini</label>
														<div class="col-lg-4">
															<div class="col-lg-4">
																<?php foreach ($SisaCuti as $key): ?>
																<?php endforeach; ?>
																	<input type="text" class="form-control" name="txtSisaCuti" id="txtSisaCuti" value="<?php if (empty($key['sisa_cuti'])) { echo "0";} else { echo $key['sisa_cuti'];} ?> Hari" readonly>
																	<span class="label label-info">Tanggal Boleh Ambil Cuti : <?php if(!empty($mintglpengambilan['0']['tgl_boleh_ambil'])){ echo date("d M Y",strtotime($mintglpengambilan['0']['tgl_boleh_ambil']));}else{ echo "Tidak Memiliki Cuti";} ?> </span>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-lg-4">Jenis Cuti</label>
														<div class="col-lg-4">
															<div class="col-lg-12">
																<select class="select select2" name="slc_JenisCutiTahunan" id="slc_JenisCutiTahunan" data-placeholder="-- silahkan pilih --" style="width:100%;" required>
																	<option value=""></option>
																	<?php foreach ($Cuti as $key){ ?>
																		<?php if (isset($_POST['slc_JenisCutiTahunan']) && $_POST['slc_JenisCutiTahunan'] == $key['lm_jenis_cuti_id']) { $selected = "selected";}else{$selected ="";} ?>
																		<option value="<?php echo $key['lm_jenis_cuti_id'] ?>" <?php echo $selected ?>><?php echo $key['jenis_cuti']; ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
													<div class="form-group slc_Keperluan">
														<label class="control-label col-lg-4">Keperluan</label>
														<div class="col-lg-4">
															<div class="col-lg-12">
																<select class="select select2" name="slc_Keperluan" id="slc_Keperluan" data-placeholder="-- silahkan pilih --" style="width:100%">
																	<option value=""></option>
																	<?php foreach ($keperluan as $key){ ?>
																		<?php if (isset($_POST['slc_Keperluan']) && $_POST['slc_Keperluan'] == $key['keperluan']) { $selected = "selected";}else{$selected ="";} ?>
																		<option value="<?php echo $key['lm_keperluan_id'] ?>" <?php echo $selected ?>><?php echo $key['keperluan'] ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
													<div class="form-group txtKeperluan">
														<label class="control-label col-lg-4">Keperluan</label>
														<div class="col-lg-4">
															<div class="col-lg-12">
																<textarea class="form-control" style="resize:none;" name="txtKeperluan" id="txtKeperluan" rows="5" cols="50" placeholder="Isi Keperluan"><?php if (isset($_POST['txtKeperluan'])){ echo $_POST['txtKeperluan'];} ?></textarea>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-lg-4">Tanggal Pengambilan Cuti</label>
														<div class="col-lg-4">
															<div class="col-lg-12">
																<input type="text" value="<?php if (isset($_POST['txtPengambilanCuti'])){ echo $_POST['txtPengambilanCuti'];} ?>" class="form-control" autocomplete="off" name="txtPengambilanCuti" id="txtPengambilanCuti" placeholder="Tanggal Pengambilan Cuti" data-date-format="yyyy-mm-dd" required>
															</div>
														</div>
													</div>
												<hr>
												<div class="row">
													<div class="form-group">
														<div class="form-group">
															<label class="control-label col-lg-4">Approval</label>
														</div>
														<label for="approval1" class="control-label col-lg-4">Atasan Langsung</label>
														<div class="col-lg-3">
															<div class="col-lg-12">
																<select class="select select2" name="slc_approval1" id="slc_approval1" data-placeholder="Approver 1" style="width:100%;">
																	<option value=""></option>
																	<?php foreach ($approval as $appr1) { ?>
																		<?php if (isset($_POST['slc_approval1']) && $_POST['slc_approval1'] == $appr1['noind']){ $selected = "selected";}else{$selected ="";} ?>
																		<option value="<?php echo $appr1['noind'] ?>" <?php echo $selected ?>><?php echo $appr1['noind']." - ".$appr1['nama'] ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label for="approval2" class="control-label col-lg-4">Atasan dari Atasan Langsung</label>
														<div class="col-lg-3">
															<div class="col-lg-12">
																<select class="select select2" name="slc_approval2" id="slc_approval2" data-placeholder="Approver 2" style="width:100%;">
																	<option value=""></option>
																	<?php foreach ($approval as $appr2) { ?>
																		<?php if (isset($_POST['slc_approval2']) && $_POST['slc_approval2'] == $appr2['noind']){ $selected = "selected";}else{$selected ="";} ?>
																		<option value="<?php echo $appr2['noind'] ?>" <?php echo $selected ?>><?php echo $appr2['noind']." - ".$appr2['nama'] ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12 text-center">
															<input type="hidden" name="notifikasi" id="notifikasi" value="<?php if(isset($notif)){echo $notif;}  ?>">
															<?php if(isset($notif)){ ?>
																<span class="label label-warning"><?php if(isset($notif)) {
																	 if ($notif == "0a Hari") {
															  		echo 'Sisa Cuti = 0';
																	}else if ($notif == "2"){
																		echo 'Pekerja Belum Memiliki Cuti';
																	}else if ($notif == "3"){
																		echo 'Pengajuan Cuti Tahunan min. H-6 pengambilan cuti';
																	}else if ($notif == "4"){
																		echo 'Bukan Merupakan Cuti Mendadak';
																	}else if ($notif == "5"){
																		echo 'Bukan Merupakan Cuti Susulan';
																	}else if ($notif == "6"){
																		echo 'Jumlah Pengambilan Cuti Melebihi Sisa Cuti';
																	}else if ($notif == "7"){
																		echo 'Bukan kejadian yang Terencana';
																	}else if ($notif == "8"){
																		echo 'Harus mengirimkan Dokumen(Bukti) ke seksi Hubker';
																	}else if ($notif == "9"){
																		echo 'Jumlah Cuti Melebihi Ketentuan';
																	}else if ($notif == "10"){
																		echo 'Bukan termasuk acara mendadak (Acara yang terencana)';
																	}else if ($notif == "11"){
																		echo 'Harap mengirimkan surat HPL dari Dokter / Rumah sakit';
																	}else if ($notif == "12"){
																		echo 'Membuat surat pernyatan siap menanggung resiko';
																	}}
																	 ?>
																</span>
															<?php } ?>
														</div>
													</div>
													<br>
											<div class="panel-footer text-center">
												<button type="a" name="submit_tahunan" class="btn btn-success" id="submit_tahunan">Simpan</button>
												<button type="submit" id="submit_tahunan2" style="display:none;"></button>
												<a href="javascript:history.back(1);" class="btn btn-warning">Batal</a>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
</section>
