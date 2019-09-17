<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/LembarKeputusan/submitUndangan/'.$id);?>" enctype="multipart/form-data" id="MonitoringOJT-frmCetakUndangan">
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
											<label for="MonitoringOJT-cmbPekerjaOJT" class="control-label col-lg-2">Pekerja OJT</label>
											<div class="col-lg-4">
												<select style="width: 100%" name="cmbPekerjaOJT" id="MonitoringOJT-cmbPekerjaOJT" required>
													<option selected="" value="<?php echo $cetak_undangan['id_pekerja'] ?>"><?php echo $cetak_undangan['noind'].' - '.$cetak_undangan['employee_name']; ?></option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="MonitoringOJT-cmbPekerjaOJT" class="control-label col-lg-2">Periode</label>
											<div class="col-lg-4">
												<select style="width: 100%" name="ojt_pr" class="ojt_periode" required>
												<?php $arr = array('3','6'); ?>
												<?php foreach ($arr as $key): ?>
													<option <?php echo ($key == $cetak_undangan['periode']) ? 'selected':''; ?> value="<?php echo $key ?>"><?php echo $key.' Bulan' ?></option>
												<?php endforeach ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<button type="button" class="btn btn-primary col-lg-2" id="MonitoringOJT-btnPratinjauKeputusan">
												Pratinjau
											</button>
											<div class="col-lg-8">
												<textarea id="MonitoringOJT-txaIsiUndangan" name="txaIsiUndangan"><?php echo $cetak_undangan['memo'];?></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numLebarKertas" class="control-label col-lg-4">Lebar Kertas (satuan mm)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numLebarKertas" id="MonitoringOJT-numLebarKertas" value="<?php echo $cetak_undangan[
														'lebar_kertas'];?>" min="0" step="0.01" />
													</div>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label for="MonitoringOJT-numTinggiKertas" class="control-label col-lg-4">Tinggi Kertas (satuan mm)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numTinggiKertas" id="MonitoringOJT-numTinggiKertas" value="<?php echo $cetak_undangan[
														'tinggi_kertas'];?>" min="0" step="0.01" />
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiAtas" class="control-label col-lg-6">Tepi Atas (satuan mm)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numBatasTepiAtas" id="MonitoringOJT-numBatasTepiAtas" value="<?php echo $cetak_undangan[
														'margin_atas'];?>" min="0" step="0.01" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiBawah" class="control-label col-lg-6">Tepi Bawah (satuan mm)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numBatasTepiBawah" id="MonitoringOJT-numBatasTepiBawah" value="<?php echo $cetak_undangan[
														'margin_bawah'];?>" min="0" step="0.01" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKiri" class="control-label col-lg-6">Tepi Kiri (satuan mm)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numBatasTepiKiri" id="MonitoringOJT-numBatasTepiKiri" value="<?php echo $cetak_undangan[
														'margin_kiri'];?>" min="0" step="0.01" style="width: 100%" />
													</div>
												</div>
											</div>
											<div class="col-xs-3">
												<div class="form-group">
													<label for="MonitoringOJT-numBatasTepiKanan" class="control-label col-lg-6">Tepi Kanan (satuan mm)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="numBatasTepiKanan" id="MonitoringOJT-numBatasTepiKanan" value="<?php echo $cetak_undangan[
														'margin_kanan'];?>" min="0" step="0.01" style="width: 100%" />
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <a href="<?php echo base_url('OnJobTraining/LembarKeputusan');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
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
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>