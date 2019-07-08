<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11"></div>
						<div class="col-lg-1"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<?php foreach ($data as $key) { ?>
											<form method="POST" class="form-horizontal" action="<?php echo site_url('SPLSeksi/C_splseksi/submit_memo') ?>" id='spl-memopresensi'>
												<div class="form-group">
													<label class="control-label col-lg-2">No. Induk</label>
													<div class="col-lg-3" style="padding-top: 7px">
														<?php echo $key['noind'] ?>
														<input type="hidden" id="noi" name="txtNoind" value="<?php echo $key['noind'] ?>">
													</div>
													<label class="control-label col-lg-1">Nama</label>
													<div class="col-lg-3" style="padding-top: 7px">
														<?php echo $key['nama'] ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-2">Seksi</label>
													<div class="col-lg-3" style="padding-top: 7px">
														<?php echo $key['seksi'] ?>
													</div>
													<label class="control-label col-lg-1">Unit</label>
													<div class="col-lg-3" style="padding-top: 7px">
														<?php echo $key['unit'] ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-2">hari/Tgl.</label>
													<div class="col-lg-3" style="padding-top: 7px">
														<?php 
														$bulan = array(
															'1' => 'JANUARI',
															'2' => 'FEBRUARI',
															'3' => 'MARET',
															'4' => 'APRIL',
															'5' => 'MEI',
															'6' => 'JUNI',
															'7' => 'JULI',
															'8' => 'AGUSTUS',
															'9' => 'SEPTEMBER',
															'10' => 'OKTOBER',
															'11' => 'NOVEMBER',
															'12' => 'DESEMBER'
														);
														$hari = array(
															'1' => 'MINGGU',
															'2' => 'SENIN',
															'3' => 'SELASA',
															'4' => 'RABU',
															'5' => 'KAMIS',
															'6' => 'JUMAT',
															'7' => 'SABTU'
														);
														 ?>
														<?php echo $hari[$key['hari']].' / '.$key['tgl'].' '.$bulan[$key['bln']].' '.$key['thn'] ?>
														<input type="hidden" name="txtTanggal" id="txtTanggal" value="<?php echo $key['tanggal'] ?>">
													</div>
													<label class="control-label col-lg-1">Shift</label>
													<div class="col-lg-3">
														<select name="txtShift" class="spl-shift-select2" style="width: 100%" required></select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-2">Jam Masuk</label>
													<div class="col-lg-3">
														<input type="text" name="txtMasuk" class="form-control spl-time-mask" required>
													</div>
													<label class="control-label col-lg-1" style="padding-left: 0px">Jam Pulang</label>
													<div class="col-lg-3">
														<input type="text" name="txtKeluar" class="form-control spl-time-mask" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-2">Alasan</label>
													<div class="col-lg-7">
														<div class="col-lg-6" style="padding-left: 0px">
															<?php  
															$b = count($alasan);
															for($i = 0;$i < ceil($b/2);$i++) { ?>
																<?php if (isset($alasan[$i])) { ?>
																	<div class="row">
																		<div class="col-lg-2">
																			<input type="checkbox" name="txtAlasan[]" value="<?php echo $alasan[$i]['alasan_id'] ?>">
																		</div>
																		<div class="col-lg-10" style="padding-left: 0px">
																			<?php echo $alasan[$i]['alasan'] ?>
																			<?php if ($alasan[$i]['perlu_info'] == '1') { ?>
																				<textarea name="txtAlasanInfo[<?php echo $alasan[$i]['alasan_id'] ?>]" style="width: 100%"></textarea>
																			<?php } ?>
																		</div> 
																<?php } ?>
																	</div>
															<?php
															} ?>
														</div>
														<div class="col-lg-6" style="padding-right: 0px">
															<?php  
															$b = count($alasan);
															for($i = 0;$i < ceil($b/2);$i++) { ?>
																<?php if (isset($alasan[$i+ceil($b/2)])) { ?>
																	<div class="row">
																		<div class="col-lg-2">
																			<input type="checkbox" name="txtAlasan[]" value="<?php echo $alasan[$i+ceil($b/2)]['alasan_id'] ?>">
																		</div>
																		<div class="col-lg-10" style="padding-left: 0px">
																			<?php echo $alasan[$i+ceil($b/2)]['alasan'] ?>
																			<?php if ($alasan[$i+ceil($b/2)]['perlu_info'] == '1') { ?>
																				<textarea name="txtAlasanInfo[<?php echo $alasan[$i+ceil($b/2)]['alasan_id'] ?>]" style="width: 100%"></textarea>
																			<?php } ?>
																		</div>
																	</div>
																<?php } ?>
															<?php
															} ?>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-2">Atasan Langsung</label>
													<div class="col-lg-3">
														<select name="txtAtasan" class="spl-pkj-select22" required style="width: 100%"></select>
														<br>
														<p style="color: red">Minimal Kepala Seksi</p>
													</div>
													<label class="control-label col-lg-1" style="padding-left: 0px">Atasan dari Atasan Langsung</label>
													<div class="col-lg-3">
														<select name="txtAtasan2" class="spl-pkj-select22" <?php if ($key['atasan'] == '1') {echo "requeired";} ?> style="width: 100%"></select>
														<br>
														<p style="color: red">Minimal Ass/Ka. Unit, jika lebih dari 3 hari, masuk seksi Hubungan Kerja.</p>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-2">Saksi</label>
													<div class="col-lg-3">
														<input type="text" name="txtSaksi" class="form-control" required>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-5 text-right">
														<button type="submit" class="btn btn-primary">Cetak</button>
													</div>
												</div>
											</form>
										<?php } ?>
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