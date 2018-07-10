<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/CetakMemoPDCA/create');?>" enctype="multipart/form-data" id="MonitoringOJT-frmCetakMemoPDCA">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/CetakMemoPDCA');?>">
										<i class="icon-wrench icon-2x"></i>
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Daftar Memo Pelaksanaan PDCA</h3>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="form-group">
											<label for="MonitoringOJT-cmbPekerjaOJT" class="control-label col-lg-2">Pekerja OJT</label>
											<div class="col-lg-6">
												<select style="width: 100%" name="cmbPekerjaOJT" id="MonitoringOJT-cmbPekerjaOJT" required>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="MonitoringOJT-txtTanggalPDCA1" class="control-label col-lg-2">Tanggal Memo PDCA 1</label>
											<div class="col-lg-6">
												<select style="width: 100%" name="txtTanggalPDCA[]" class="MonitoringOJT-txtTanggalPDCA" id="MonitoringOJT-txtTanggalPDCA1" required>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="MonitoringOJT-txtTanggalPDCA2" class="control-label col-lg-2">Tanggal Memo PDCA 2</label>
											<div class="col-lg-6">
												<select style="width: 100%" name="txtTanggalPDCA[]" class="MonitoringOJT-txtTanggalPDCA" id="MonitoringOJT-txtTanggalPDCA2" required>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="MonitoringOJT-txtTanggalPDCA3" class="control-label col-lg-2">Tanggal Memo PDCA 3</label>
											<div class="col-lg-6">
												<select style="width: 100%" name="txtTanggalPDCA[]" class="MonitoringOJT-txtTanggalPDCA" id="MonitoringOJT-txtTanggalPDCA3" required>
												</select>
											</div>
										</div>
										<div class="form-group">
											<button type="button" class="btn btn-primary col-lg-2" id="MonitoringOJT-btnPratinjauMemoPDCA">
												Pratinjau
											</button>
											<div class="col-lg-8">
												<textarea id="MonitoringOJT-txaIsiMemoPDCA" name="txaIsiMemoPDCA" placeholder="[Isi Memo]"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numLebarKertas" class="control-label col-lg-4">Lebar Kertas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numLebarKertas" id="MonitoringOJT-numLebarKertas" value="216" min="0" step="1" />
													</div>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numTinggiKertas" class="control-label col-lg-4">Tinggi Kertas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numTinggiKertas" id="MonitoringOJT-numTinggiKertas" value="330" min="0" step="1" />
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiAtas" class="control-label col-lg-6">Tepi Atas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiAtas" id="MonitoringOJT-numBatasTepiAtas" value="15" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiBawah" class="control-label col-lg-6">Tepi Bawah (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiBawah" id="MonitoringOJT-numBatasTepiBawah" value="15" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKiri" class="control-label col-lg-6">Tepi Kiri (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiKiri" id="MonitoringOJT-numBatasTepiKiri" value="15" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKanan" class="control-label col-lg-6">Tepi Kanan (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numBatasTepiKanan" id="MonitoringOJT-numBatasTepiKanan" value="15" min="0" step="1" style="width: 100%" />
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <a href="<?php echo base_url('OnJobTraining/CetakMemoPDCA');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
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