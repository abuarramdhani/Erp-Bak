<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/CetakMemoJadwalTraining/update/'.$id);?>" enctype="multipart/form-data" id="MonitoringOJT-frmCetakMemoJadwalTraining">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/CetakMemoJadwalTraining');?>">
										<i class="icon-wrench icon-2x"></i>
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<?php
								foreach ($daftar_cetak_memo_jadwal_training as $memo)
								{
							?>
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Update Memo Jadwal Training</h3>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="form-group">
											<label for="MonitoringOJT-txtPeriode" class="control-label col-lg-2">Periode</label>
											<div class="col-lg-4">
												<input type="text" class="form-control MonitoringOJT-daterangepicker" name="txtPeriode" id="MonitoringOJT-txtPeriode" value="<?php echo $memo['tanggal_periode_awal'].' - '.$memo['tanggal_periode_awal'];?>" />
											</div>
										</div>
										<div class="form-group">
											<label for="MonitoringOJT-cmbPekerjaOJTMemoJadwalTraining" class="control-label col-lg-2">Pekerja OJT</label>
											<div class="col-lg-8">
												<select style="width: 100%" name="cmbPekerjaOJT[]" id="MonitoringOJT-cmbPekerjaOJTMemoJadwalTraining" multiple="multiple" required>
													<?php
														foreach ($daftar_cetak_memo_jadwal_training_ref as $pekerja_ref)
														{
													?>
													<option value="<?php echo $pekerja_ref['id_pekerja'];?>" selected><?php echo $pekerja_ref['noind'].' - 
													'.$pekerja_ref['nama_pekerja_ojt'];?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<button type="button" class="btn btn-primary col-lg-2" id="MonitoringOJT-btnPratinjauMemoJadwalTraining">
												Pratinjau
											</button>
											<div class="col-lg-12">
												<textarea id="MonitoringOJT-txaIsiMemoJadwalTraining" name="txaIsiMemoJadwalTraining" placeholder="[Isi Memo]"><?php echo $memo['memo'];?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="col-lg-2"></div>
											<div class="col-lg-12">
												<textarea id="MonitoringOJT-txaIsiLampiranJadwalTraining" name="txaIsiLampiranJadwalTraining" placeholder="[Isi Lampiran]"><?php echo $memo['lampiran'];?></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numLebarKertas" class="control-label col-lg-4">Posisi Cetak Memo</label>
													<div class="col-lg-4">
														<select style="width: 100%;" name="cmbPosisiCetakMemo" class="select2" required>
															<option value="P" <?php if ($memo['posisi_cetak_memo'] == 'P') {echo 'selected';}?>>Portrait</option>
															<option value="L" <?php if ($memo['posisi_cetak_memo'] == 'L') {echo 'selected';}?>>Landscape</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numLebarKertas" class="control-label col-lg-4">Posisi Cetak Lampiran</label>
													<div class="col-lg-4">
														<select style="width: 100%" name="cmbPosisiCetakLampiran" class="select2" required>
															<option value="P" <?php if ($memo['posisi_cetak_lampiran'] == 'P') {echo 'selected';}?>>Portrait</option>
															<option value="L" <?php if ($memo['posisi_cetak_lampiran'] == 'L') {echo 'selected';}?>>Landscape</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numLebarKertas" class="control-label col-lg-4">Lebar Kertas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numLebarKertas" id="MonitoringOJT-numLebarKertas" value="<?php echo $memo['lebar_kertas'];?>" min="0" step="1" />
													</div>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numTinggiKertas" class="control-label col-lg-4">Tinggi Kertas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numTinggiKertas" id="MonitoringOJT-numTinggiKertas" value="<?php echo $memo['tinggi_kertas'];?>" min="0" step="1" />
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiAtas" class="control-label col-lg-6">Tepi Atas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiAtas" id="MonitoringOJT-numBatasTepiAtas" value="<?php echo $memo['margin_atas'];?>" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiBawah" class="control-label col-lg-6">Tepi Bawah (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiBawah" id="MonitoringOJT-numBatasTepiBawah" value="<?php echo $memo['margin_bawah'];?>" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKiri" class="control-label col-lg-6">Tepi Kiri (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiKiri" id="MonitoringOJT-numBatasTepiKiri" value="<?php echo $memo['margin_kiri'];?>" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKanan" class="control-label col-lg-6">Tepi Kanan (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiKanan" id="MonitoringOJT-numBatasTepiKanan" value="<?php echo $memo['margin_kanan'];?>" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <a href="<?php echo base_url('OnJobTraining/CetakMemoJadwalTraining');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
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