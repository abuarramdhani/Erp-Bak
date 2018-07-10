<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/CetakUndangan/update/'.$id);?>" enctype="multipart/form-data" id="MonitoringOJT-frmCetakUndangan">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/CetakUndangan');?>">
										<i class="icon-wrench icon-2x"></i>
									</a>
								</div>
							</div>
						</div>
					</div>

					<?php
						foreach ($daftar_cetak_undangan as $cetak_undangan)
						{
					?>
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Update Undangan</h3>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="form-group">
											<label for="MonitoringOJT-cmbFormatUndangan" class="control-label col-lg-2">Format Undangan</label>
											<div class="col-lg-4">
												<select style="width: 100%" name="cmbFormatUndangan" id="MonitoringOJT-cmbFormatUndangan" required>
													<option value="<?php echo $cetak_undangan['id_undangan'];?>"><?php echo $cetak_undangan['judul'];?></option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="MonitoringOJT-cmbPekerjaOJT" class="control-label col-lg-2">Pekerja OJT</label>
											<div class="col-lg-4">
												<select style="width: 100%" name="cmbPekerjaOJT" id="MonitoringOJT-cmbPekerjaOJT" required>
													<option value="<?php echo $cetak_undangan['id_pekerja'];?>"><?php echo $cetak_undangan['noind'].' - '.$cetak_undangan['nama'];?></option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="MonitoringOJT-cmbTahapanOJT" class="control-label col-lg-2">Tahapan</label>
											<div class="col-lg-4">
												<select style="width: 100%" name="cmbTahapanOJT" id="MonitoringOJT-cmbTahapanOJT" required>
													<option value="<?php echo $cetak_undangan['id_proses'];?>"><?php echo $cetak_undangan['tahapan'];?></option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<button type="button" class="btn btn-primary col-lg-2" id="MonitoringOJT-btnPratinjauUndangan">
												Pratinjau
											</button>
											<div class="col-lg-8">
												<textarea id="MonitoringOJT-txaIsiUndangan" name="txaIsiUndangan"><?php echo $cetak_undangan['undangan'];?></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numLebarKertas" class="control-label col-lg-4">Lebar Kertas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numLebarKertas" id="MonitoringOJT-numLebarKertas" value="<?php echo $cetak_undangan[
														'lebar_kertas'];?>" min="0" step="1" />
													</div>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numTinggiKertas" class="control-label col-lg-4">Tinggi Kertas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numTinggiKertas" id="MonitoringOJT-numTinggiKertas" value="<?php echo $cetak_undangan[
														'tinggi_kertas'];?>" min="0" step="1" />
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiAtas" class="control-label col-lg-6">Tepi Atas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiAtas" id="MonitoringOJT-numBatasTepiAtas" value="<?php echo $cetak_undangan[
														'margin_atas'];?>" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiBawah" class="control-label col-lg-6">Tepi Bawah (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiBawah" id="MonitoringOJT-numBatasTepiBawah" value="<?php echo $cetak_undangan[
														'margin_bawah'];?>" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKiri" class="control-label col-lg-6">Tepi Kiri (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiKiri" id="MonitoringOJT-numBatasTepiKiri" value="<?php echo $cetak_undangan[
														'margin_kiri'];?>" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKanan" class="control-label col-lg-6">Tepi Kanan (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiKanan" id="MonitoringOJT-numBatasTepiKanan" value="<?php echo $cetak_undangan[
														'margin_kanan'];?>" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <a href="<?php echo base_url('OnJobTraining/CetakUndangan');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						}
					?>
				</div>
			</form>
		</div>
	</div>
</section>