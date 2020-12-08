<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<br><h1><?=$Title ?></h1></div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<?php 
										if (isset($encrypted_id) && !empty($encrypted_id)) {
											$link = "/".$encrypted_id;
										}else{
											$link = "";
										}
										?>
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Simpan'.$link) ?>" target="_blank" onsubmit="setTimeout(function () { window.location.href = baseurl+'Covid/MonitoringCovid'; }, 5000)" id="mpk_frmis">
											<div class="form-group">
												<label class="control-label col-lg-4">Kepada</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerjax slcMPSuratIsolasiMandiriTo" data-placeholder="Ditujukan Kepada" name="slcMPSuratIsolasiMandiriTo" id="slcMPSuratIsolasiMandiriTo" style="width: 100%" required>
														<option></option>
														<?php foreach ($atasan as $k): ?>
															<option value="<?= $k['noind'] ?>" ><?= $k['noind'].' - '.$k['nama'] ?></option>
														<?php endforeach ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tembusan</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerjax slcMPSuratIsolasiMandiriTo" data-placeholder="Tembusan" name="slcMPSuratIsolasiMandiriTembusan" id="slcMPSuratIsolasiMandiriTembusan" style="width: 100%" required>
														<option></option>
														<?php foreach ($atasan as $k): ?>
															<option value="<?= $k['noind'] ?>" ><?= $k['noind'].' - '.$k['nama'] ?></option>
														<?php endforeach ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerja" data-placeholder="Pekerja" name="slcMPSuratIsolasiMandiriPekerja" id="slcMPSuratIsolasiMandiriPekerja" style="width: 100%" required>
														<?php 
														if (isset($data) && !empty($data)) {
															?>
															<option value="<?php echo $data->noind ?>"><?php echo $data->noind.' - '.$data->nama; ?></option>
															<?php
														}
														?>
													</select>
												</div>
											</div>
											<input type="hidden" name="txtMPSuratIsolasiMandiriSurat" id="txtMPSuratIsolasiMandiriSurat">
											<input type="hidden" value="surat_isolasi_mandiri_no_surat" name="txtMPSuratIsolasiMandiriNoSurat" id="txtMPSuratIsolasiMandiriNoSurat">
											<div class="form-group">
												<label class="control-label col-lg-4">Wawancara</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriWawancaraTanggal" id="txtMPSuratIsolasiMandiriWawancaraTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" placeholder="Tanggal Wawancara" required autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Mulai Isolasi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriMulaiIsolasiTanggal" id="txtMPSuratIsolasiMandiriMulaiIsolasiTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" placeholder="Tanggal Mulai Isolasi Mandiri" required autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Selesai Isolasi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal" id="txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" placeholder="Tanggal Selesai Isolasi Mandiri" required autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jumlah Hari</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriJumlahHari" id="txtMPSuratIsolasiMandiriJumlahHari" class="form-control" placeholder="Jumlah Hari" readonly required>
												</div>
											</div>
											<div class="col-md-3"></div>
											<div class="col-md-6">
												<table class="table table-bordered" id="cvd_tbladdAS">
													<thead>
														<tr class="bg-primary">
															<th style="text-align: center;">Tanggal</th>
															<th style="text-align: center;">Status</th>
															<th style="text-align: center;">Alasan</th>
															<th style="text-align: center;"></th>
														</tr>
													</thead>
													<tbody>
														
													</tbody>
												</table>
											</div>
											<div class="col-md-12"></div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Cetak</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriCetakTanggal" id="txtMPSuratIsolasiMandiriCetakTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" placeholder="Tanggal Cetak Surat" required autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary cvd_btncektim cvd_btncekabsen" id="btnMPSuratIsolasiMandiriPreview" type="button" disabled><span class="fa fa-print"></span>&nbsp;Preview</button>
												</div>
											</div>
											<div class="form-group">
                                                <label class="col-lg-2 control-label">Format Surat</label>
                                                <div class="col-lg-8">
                                                    <textarea name="txaMPSuratIsolasiMandiriRedactor" class="form-control" id="txaMPSuratIsolasiMandiriRedactor" disabled required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12 text-center" id="cvd_divtim">
                                                    
                                                </div>
                                                <div class="col-lg-12 text-center" id="cvd_divtim2">
                                                    
                                                </div>
                                            </div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary" id="btnMPSuratIsolasiMandiriSubmit" type="submit" disabled><span class="fa fa-save"></span>&nbsp;Simpan</button>
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
<script>
	var isolasi_id = '';
</script>