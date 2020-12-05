<style>
	.cvd_bg_trans{
		background-color: transparent;
	}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" id="frm-CVD-MonitoringCovid-Tambah" method="POST" enctype="multipart/form-data" action="<?php echo base_url('Covid/MonitoringCovid/simpan') ?>">
											<div class="form-group">
												<label class="control-label col-lg-2">Pekerja</label>
												<div class="col-lg-4">
													<select id="slc-CVD-MonitoringCovid-Tambah-Pekerja" name="slc-CVD-MonitoringCovid-Tambah-Pekerja" style="width: 100%" data-placeholder="Pilih Pekerja">
														<?php 
														if (isset($data) && !empty($data)) {
															?>
															<option value="<?php echo $data->noind ?>"><?php echo $data->noind." - ".$data->nama ?></option>
															<?php
														}
														?>
													</select>
													<input type="hidden" id="txt-CVD-MonitoringCovid-Tambah-PekerjaId" name="txt-CVD-MonitoringCovid-Tambah-PekerjaId" value="<?php echo (isset($data) && !empty($data)) ? $data->cvd_pekerja_id : ''; ?>">
															
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Seksi</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->seksi : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Seksi" name="txt-CVD-MonitoringCovid-Tambah-Seksi" readonly placeholder="Seksi Pekerja">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Departemen</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->dept : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Departemen" name="txt-CVD-MonitoringCovid-Tambah-Departemen" readonly placeholder="Departemen Pekerja">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Kasus</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->kasus : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Kasus" name="txt-CVD-MonitoringCovid-Tambah-Kasus" placeholder="Kasus">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Tanggal Interaksi</label>
												<div class="col-lg-2">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->tgl_interaksi : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-TanggalInteraksi" name="txt-CVD-MonitoringCovid-Tambah-TanggalInteraksi" placeholder="Tanggal Interaksi">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Keterangan</label>
												<div class="col-lg-8">
													<textarea 
														class="form-control" 
														id="txt-CVD-MonitoringCovid-Tambah-Keterangan" 
														name="txt-CVD-MonitoringCovid-Tambah-Keterangan" 
														placeholder="Keterangan"
														><?php 
														echo (isset($data) && !empty($data)) ? $data->keterangan : ''; 
													?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Detail Wawancara</label>
												<div class="col-lg-8">
													<textarea 
														class="form-control" 
														id="txa-CVD-MonitoringCovid-Tambah-Wawancara" 
														name="txa-CVD-MonitoringCovid-Tambah-Wawancara" 
														required 
														placeholder="Masukkan Detail Wawancara..." 
														><?php 
														if (isset($wawancara) && !empty($wawancara)) {
															echo $wawancara->hasil_wawancara;
														} 
													?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Lampiran</label>
												<div class="col-lg-8">
													<div class="div-CVD-MonitoringCovid-Tambah-Lampiran" style="margin-bottom: 5px;margin-top: 5px;">
														<?php 
														if (isset($lampiran) && !empty($lampiran)) {
															foreach ($lampiran as $key_lamp => $val_lamp) {
																?>
																<div class="btn-group">
																<a type="button" target="_blank" href="<?php echo base_url($val_lamp['lampiran_path']) ?>"  class="btn btn-info btn-xs cvd_popoverAttc"><?php echo $val_lamp['lampiran_nama'] ?></a>
																<button value="<?= $val_lamp['lampiran_id'] ?>" text="<?= $val_lamp['lampiran_nama'] ?>" type="button" class="btn btn-danger btn-xs cvd_btndelAttc"><i class="fa fa-trash"></i></button>
																</div>
																<?php 
															}
														}
														?>
														<input type="file" class="form-control file-CVD-MonitoringCovid-Tambah-Lampiran" name="file-CVD-MonitoringCovid-Tambah-Lampiran[]" style="display: none;">
													</div>
													<button class="btn btn-success btn-CVD-MonitoringCovid-Tambah-Lampiran" type="button"><span class="fa fa-upload"></span> Tambah Lampiran</button>
												</div>
											</div>
											<div class="form-group text-center">
												<button type="submit" class="btn btn-primary" id="btn-CVD-MonitoringCovid-Tambah-Simpan"><span class="fa fa-save"></span> Simpan</button>
											</div>
										</form>
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