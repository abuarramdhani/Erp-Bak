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
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPekerja/Surat/SuratTugas/Update/'.$id_encoded) ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slcMPSuratTugasPekerja" name="slcMPSuratTugasPekerja" id="slcMPSuratTugasPekerja" style="width: 100%" required>
														<?php 
															if (isset($data[0]['noind']) && !empty($data[0]['noind'])) {
																?>
																	<option selected value="<?php echo $data[0]['noind'] ?>"><?php echo $data[0]['noind'].' - '.$data[0]['pekerja_nama'] ?></option>
																<?php
															} 
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">No. Surat</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratTugasNomor" id="txtMPSuratTugasNomor" value="<?php echo $data[0]['no_surat'] ? $data[0]['no_surat'] : ''  ?>" class="form-control" placeholder="No. Surat" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Approver</label>
												<div class="col-lg-4">
													<select class="slcMPSuratTugasPekerja" name="slcMPSuratTugasApprover" id="slcMPSuratTugasApprover" style="width: 100%" required>
														<?php 
															if (isset($data[0]['approver']) && !empty($data[0]['approver'])) {
																?>
																	<option selected value="<?php echo $data[0]['approver'] ?>"><?php echo $data[0]['approver'].' - '.$data[0]['approver_nama'] ?></option>
																<?php
															} 
														?>
													</select>
												</div>
											</div>
											<input type="hidden" name="txtMPSuratTugasSurat" id="txtMPSuratTugasSurat">
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Cetak</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratTugasTanggal" id="txtMPSuratTugasTanggal" class="form-control" placeholder="Tanggal Cetak" value="<?php echo $data[0]['tgl_dicetak'] ? $data[0]['tgl_dicetak'] : ''  ?>" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary" id="btnMPSuratTugasPreview" type="button"><span class="fa fa-print"></span>&nbsp;Preview</button>
												</div>
											</div>
											<div class="form-group">
                                                <label class="col-lg-2 control-label">Format Surat</label>
                                                <div class="col-lg-8">
                                                    <textarea name="txaMPSuratTugasRedactor" class="form-control" id="txaMPSuratTugasRedactor" disabled required></textarea>
                                                </div>
                                            </div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary" id="btnMPSuratTugasSubmit" type="submit" disabled><span class="fa fa-save"></span>&nbsp;Simpan</button>
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