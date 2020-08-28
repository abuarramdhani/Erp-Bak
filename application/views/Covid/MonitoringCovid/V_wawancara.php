<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<b><h1><?=$Title ?></h1></b>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form method="POST" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url('Covid/MonitoringCovid/simpanWawancara/'.$id) ?>">
											<div class="form-group">
												<label class="control-label col-lg-2">Pekerja</label>
												<div class="col-lg-4">
													<input type="text" class="form-control"  value="<?php echo (isset($data) && !empty($data)) ? $data->noind." - ".$data->nama : ''; ?>" disabled placeholder="Pekerja">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Seksi</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->seksi : ''; ?>" class="form-control" disabled placeholder="Seksi Pekerja">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Departemen</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->dept : ''; ?>" class="form-control"disabled placeholder="Departemen Pekerja">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Kasus</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->kasus : ''; ?>" class="form-control" disabled placeholder="kasus">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Tanggal Interaksi</label>
												<div class="col-lg-2">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->tgl_interaksi : ''; ?>" class="form-control" disabled placeholder="Tanggal Interaksi">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Periode Isolasi</label>
												<div class="col-lg-2">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->mulai_isolasi : ''; ?>" class="form-control" disabled placeholder="Mulai Isolasi">
												</div>
												<div class="col-lg-2">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->selesai_isolasi : ''; ?>" class="form-control" disabled placeholder="Selesai Isolasi">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Keterangan</label>
												<div class="col-lg-4">
													<textarea class="form-control" disabled><?php 
														echo (isset($data) && !empty($data)) ? $data->keterangan : ''; 
													?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Detail Wawancara</label>
												<div class="col-lg-8">
													<input type="hidden" name="idWawancara" value="<?php echo isset($wawancara) && !empty($wawancara) ? $wawancara->wawancara_id : '' ?>">
													<textarea class="form-control" name="hasilWawancara" required placeholder="Masukkan Detail Wawancara..." style="height: 300px;"><?php 
														if (isset($wawancara) && !empty($wawancara)) {
															echo $wawancara->hasil_wawancara;
														} 
													?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Lampiran</label>
												<div class="col-lg-8">
													<div class="div-CVD-MonitoringCovid-Wawancara-Lampiran" style="margin-bottom: 5px;margin-top: 5px;">
														<?php 
														if (isset($lampiran) && !empty($lampiran)) {
															foreach ($lampiran as $key_lamp => $val_lamp) {
																?>
																<a target="_blank" href="<?php echo base_url($val_lamp['lampiran_path']) ?>"  class="label label-info" style="margin: 5px;"><?php echo $val_lamp['lampiran_nama'] ?></a>
																<?php 
															}
														}
														?>
														<input type="file" class="form-control file-CVD-MonitoringCovid-Wawancara-Lampiran" name="lampiranWawancara[]" style="display: none;">
													</div>
													<button class="btn btn-success btn-CVD-MonitoringCovid-Wawancara-Lampiran" type="button"><span class="fa fa-upload"></span> Tambah Lampiran</button>
												</div>
											</div>
											<div class="form-group text-center">
												<div class="col-lg-12 text-center">
													<button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
												</div>
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