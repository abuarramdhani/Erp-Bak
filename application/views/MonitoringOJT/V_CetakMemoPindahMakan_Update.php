<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/MemoPindahMakan/saveUpdate/'.$id);?>" enctype="multipart/form-data" id="MonitoringOJT-frmCetakMemoPindahMakan">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/MemoPindahMakan');?>">
										<i class="icon-wrench icon-2x"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
					<?php foreach ($edit_memo as $key) { ?>
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title"></h3>
								</div>
								<div class="box-body">
									<div class="panel-body">
                    <div class="row col-lg-5" style="margin-left:15px;">
                      <div class="form-group">
                        <label for="MonitoringOJT-cmbPekerjaOJT" class="control-label col-lg-4">Jenis Training</label>
                        <div class="col-lg-8">
                          <select style="width: 100%" name="ojt_jenis" class="ojt_jenis form-control" id="ojt_jenis_training" required>
                            <option></option>
                            <option value="Training Public Speaking" <?php if($key['jenis_memo'] == 'Training Public Speaking'){echo 'selected';} ?>>Training Public Speaking</option>
                            <option value="Training PDCA & A3 Report" <?php if($key['jenis_memo'] == 'Training PDCA & A3 Report'){echo 'selected';} ?>>Training PDCA & A3 Report</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="MonitoringOJT-cmbPekerjaOJT" class="control-label col-lg-4">Periode</label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control MonitoringOJT-daterangepicker" name="txtPeriode" id="MonitoringOJT-txtPeriode" value="<?php echo $key['periode_memo'] ?>">
                        </div>
                      </div>
											<div class="form-group">
												<label for="MonitoringOJT-iptNoOJT" class="control-label col-lg-4">No Memo</label>
												<div class="col-lg-8">
													<input type="text" class="form-control" name="txtNoMemo" placeholder="Nomor Memo" value="<?php echo $key['no_memo'] ?>">
												</div>
											</div>
                    </div>
                    <div class="row col-lg-6">
											<div class="form-group">
												<label for="MonitoringOJT-cmbPekerjaOJT" class="control-label col-lg-3">Lokasi</label>
												<div class="col-lg-7">
													<input type="text" class="form-control" name="txtRuangTraining" placeholder="Ruang Training" value="<?php echo $key['ruang_training'] ?>">
												</div>
											</div>
                      <div class="form-group">
                        <label for="MonitoringOJT-cmbtertandaOJT" class="control-label col-lg-3">Tertanda</label>
                        <div class="col-lg-7">
                          <select style="width: 100%;" name="cmbtertandaOJT" class="form-control" id="MonitoringOJT-cmbtertandaOJT"  required>
														<option></option>
														<?php foreach ($pdev as $ka){
															foreach ($tertanda as $val) { ?>
														<option <?php if ($ka['nama'] == $val['nama']){echo "selected";} ?> value="<?php echo $ka['nama'] ?>"><?php echo $ka['noind']." - ".$ka['nama']; ?></option>
													<?php } } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row col-lg-12" style="margin-top: 30px;">
                      <div class="form-group">
                        <button type="button" class="btn btn-primary col-lg-2" id="MonitoringOJT-btnPratinjauPindahMakan">
                          Pratinjau
                        </button>
                        <div class="col-lg-8">
                          <textarea id="MonitoringOJT-txtareaMemoPindahMakan" class="form-control" name="txaIsiMemoPindahMakan"><?php echo $key['memo'] ?></textarea>
                        </div>
                      </div>
                    </div>
										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numLebarKertas" class="control-label col-lg-4">Lebar Kertas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numLebarKertas" value="<?php echo $key['lebar_kertas'];?>" min="0" step="0.01" />
													</div>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numTinggiKertas" class="control-label col-lg-4">Tinggi Kertas (satuan mm)</label>
													<div class="col-lg-4">
														<input type="number" class="form-control" name="numTinggiKertas" value="<?php echo $key['tinggi_kertas'];?>" min="0" step="0.01" />
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiAtas" class="control-label col-lg-6">Tepi Atas (satuan mm)</label>
													<div class="col-xs-6">
														<input type="number" class="form-control" name="numBatasTepiAtas" value="<?php echo $key['margin_atas'] ?>" min="0" step="0.01" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiBawah" class="control-label col-lg-6">Tepi Bawah (satuan mm)</label>
													<div class="col-xs-6">
														<input type="number" class="form-control" name="numBatasTepiBawah" value="<?php echo $key['margin_bawah'] ?>" min="0" step="0.01" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKiri" class="control-label col-lg-6">Tepi Kiri (satuan mm)</label>
													<div class="col-xs-6">
														<input type="number" class="form-control" name="numBatasTepiKiri" value="<?php echo $key['margin_kiri'] ?>" min="0" step="0.01" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKanan" class="control-label col-lg-6">Tepi Kanan (satuan mm)</label>
													<div class="col-xs-6">
														<input type="number" class="form-control" name="numBatasTepiKanan" value="<?php echo $key['margin_kanan'] ?>" min="0" step="0.01" style="width: 100%" />
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <a href="<?php echo base_url('OnJobTraining/MemoPindahMakan');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
			</form>
		</div>
	</div>
</section>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
