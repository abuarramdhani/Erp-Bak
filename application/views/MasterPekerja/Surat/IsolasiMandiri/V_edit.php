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
										if (isset($data) && !empty($data)) {
											foreach ($data as $dt) {
												?>
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Update/'.$id_encoded.(isset($encrypted_pekerja_id) ? '/'.$encrypted_pekerja_id : '')) ?>" target="_blank" onsubmit="setTimeout(function () { window.location.href = baseurl+'Covid/MonitoringCovid'; }, 2000)" id="mpk_frmis">
											<div class="form-group">
												<label class="control-label col-lg-4">No. Surat</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo $dt['no_surat'] ?>" name="txtMPSuratIsolasiMandiriNoSurat" id="txtMPSuratIsolasiMandiriNoSurat" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kepada</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerjax slcMPSuratIsolasiMandiriTo" data-placeholder="Ditujukan Kepada" name="slcMPSuratIsolasiMandiriTo" id="slcMPSuratIsolasiMandiriTo" style="width: 100%" required>
														<option selected="" value="<?php echo $dt['kepada'] ?>"><?php echo $dt['kepada'].' - '.$dt['kepada_nama'] ?></option>
														<?php foreach ($atasan as $k): ?>
															<option value="<?= $k['noind'] ?>" ><?= $k['noind'].' - '.$k['nama'] ?></option>
														<?php endforeach ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tembusan</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerjax slcMPSuratIsolasiMandiriTo" data-placeholder="Ditujukan Kepada" name="slcMPSuratIsolasiMandiriTembusan" id="slcMPSuratIsolasiMandiriTembusan" style="width: 100%" required>
														<option selected="" value="<?php echo $dt['tembusan'] ?>"><?php echo $dt['tembusan'].' - '.$dt['tembusan_nama'] ?></option>
														<?php foreach ($tembusan as $k): ?>
															<option value="<?= $k['noind'] ?>" ><?= $k['noind'].' - '.$k['nama'] ?></option>
														<?php endforeach ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slcMPSuratIsolasiMandiriPekerja" data-placeholder="Pekerja" name="slcMPSuratIsolasiMandiriPekerja" id="slcMPSuratIsolasiMandiriPekerja" style="width: 100%" required>
														<option value="<?php echo $dt['pekerja'] ?>"><?php echo $dt['pekerja'].' - '.$dt['pekerja_nama'] ?></option>
													</select>
												</div>
											</div>
											<input type="hidden" name="txtMPSuratIsolasiMandiriSurat" id="txtMPSuratIsolasiMandiriSurat" >
											<div class="form-group">
												<label class="control-label col-lg-4">Wawancara</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriWawancaraTanggal" id="txtMPSuratIsolasiMandiriWawancaraTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" value="<?php echo $dt['tgl_wawancara'] ?>" placeholder="Tanggal Wawancara" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Mulai Isolasi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriMulaiIsolasiTanggal" id="txtMPSuratIsolasiMandiriMulaiIsolasiTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" value="<?php echo $dt['tgl_mulai'] ?>" placeholder="Tanggal Mulai Isolasi Mandiri" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Selesai Isolasi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal" id="txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" value="<?php echo $dt['tgl_selesai'] ?>" placeholder="Tanggal Selesai Isolasi Mandiri" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jumlah Hari</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratIsolasiMandiriJumlahHari" id="txtMPSuratIsolasiMandiriJumlahHari" value="<?php echo $dt['jml_hari'] ?>" class="form-control" placeholder="Jumlah Hari" readonly required>
												</div>
											</div>
											<div class="col-md-2"></div>
											<div class="col-md-8">
												<table class="table table-bordered" id="cvd_tbladdAS">
													<thead>
														<tr class="bg-primary">
															<th style="text-align: center;">Tanggal</th>
															<th style="text-align: center; min-width: 100px;">Status</th>
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
													<input type="text" name="txtMPSuratIsolasiMandiriCetakTanggal" id="txtMPSuratIsolasiMandiriCetakTanggal" class="form-control txtMPSuratIsolasiMandiriTanggal" value="<?php echo $dt['tgl_cetak'] ?>" placeholder="Tanggal Cetak Surat" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary cekAbsens cvd_btncektim cvd_btncekabsen" id="btnMPSuratIsolasiMandiriPreview" type="button"><span class="fa fa-print"></span>&nbsp;Preview</button>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<label style="color: red;" id="cvd_lbleditpres"></label>
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
												<?php
											}
										}
										?>
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
	var awal = "<?= $data[0]['tgl_mulai'] ?>";
	var akhir = "<?= $data[0]['tgl_selesai'] ?>";
	var pkj = "<?= $data[0]['pekerja'] ?>";
	var isolasi_id = "<?= $isolasi_id ?>";
	window.addEventListener('load', function () {
		$('#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal').trigger('change');
	});
</script>