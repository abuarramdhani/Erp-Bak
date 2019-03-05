<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h3><b><?=$Title ?></b></h3>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="<?php echo base_url('PNBP') ?>" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-3">Periode</label>
												<div class="col-lg-6">
													<select class="select2 selectPeriodeQuestionerPNBP" data-placeholder="Periode" style="width: 100%">
														<option></option>
														<?php if (isset($periode) and !empty($periode)) { 
															foreach($periode as $prd){?>
															<option value="<?php echo $prd['id_periode'] ?>"><?php echo $prd['periode_awal']." - ".$prd['periode_akhir'] ?></option>
														<?php } } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Departemen</label>
												<div class="col-lg-6">
													<select class="select select2 selectPNBPDept" data-placeholder="Departemen" name="txtDepartmentUser" style="width: 100%">
														<option></option>
														<?php 
															foreach ($dept as $dpt) { ?>
																<option value="<?php echo $dpt['kd_dept'] ?>"><?php echo $dpt['dept'] ?></option>
															<?php }
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Seksi / Unit</label>
												<div class="col-lg-6">
													<select class="selectPNBPSeksi" name="txtSeksiUser" style="width: 100%"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Masa Kerja</label>
												<div class="col-lg-6">
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="1" id="txtMasaKerjaOpt1"> < 1 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="2" id="txtMasaKerjaOpt2"> 1 - 3 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="3" id="txtMasaKerjaOpt3"> 4 - 6 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtMasaKerja" value="4" id="txtMasaKerjaOpt4"> > 6 Tahun
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Jenis Kelamin</label>
												<div class="col-lg-6">
													<div class="col-lg-6">
														<input type="radio" name="txtJenKel" value="L" id="txtJenKelOpt1"> Laki - Laki
													</div>
													<div class="col-lg-6">
														<input type="radio" name="txtJenKel" value="P" id="txtJenKelOpt2"> Perempuan
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Usia</label>
												<div class="col-lg-6">
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="1" id="txtUsiaOpt1"> < 20 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="2" id="txtUsiaOpt2"> 20-29 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="3" id="txtUsiaOpt3"> 30-39 Tahun
													</div>
													<div class="col-lg-3">
														<input type="radio" name="txtUsia" value="4" id="txtUsiaOpt4"> ≥ 40 Tahun
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Suku</label>
												<div class="col-lg-6">
													<select class="select select2 selectPNBPSuku" name="txtSuku" style="width: 100%">
														<option></option>
														<?php if (isset($suku) and !empty($suku)) {
															foreach ($suku as $val) { ?>
																<option value="<?php echo $val['id_suku'] ?>"><?php echo $val['nama_suku']." - ".$val['asal'] ?></option>
															<?php }
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Status Kerja</label>
												<div class="col-lg-6">
													<select class="selectStatusJabatan" name="txtJabatanUser" style="width: 100%"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Pendidikan Terakhir</label>
												<div class="col-lg-6">
													<select class="select select2 selectPendidikanAkhir" name="txtPendidikanAkhir" style="width: 100%">
														<option></option>
														<?php if (isset($pendidikan) and !empty($pendidikan)) {
															foreach ($pendidikan as $val) { ?>
																<option value="<?php echo $val['id_pendidikan'] ?>"><?php echo $val['pendidikan'] ?></option>
															<?php }
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-9 text-right">
													<button type="button" class="btn btn-primary" id="btnSubmitChartPNBP">Proses</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row PNBPHiddenReport" hidden="true">
									<div class="col-lg-12">
										<div class="panel panel-primary">
											<div class="panel-heading">
												<div class="row">
													<div class="col-lg-1 col-lg-offset-10">
														<form target="_blank" method="POST" action="<?php echo site_url('PNBP/Report/Pdf') ?>">
															<input type="hidden" name="txtPeriodeHiddenPNBP">
															<input type="hidden" name="txtSeksiHiddenPNBP">
															<input type="hidden" name="txtDeptHiddenPNBP">
															<input type="hidden" name="txtMasaKerjaHiddenPNBP">
															<input type="hidden" name="txtJenkelHiddenPNBP">
															<input type="hidden" name="txtUsiaHiddenPNBP">
															<input type="hidden" name="txtSukuHiddenPNBP">
															<input type="hidden" name="txtStatusHiddenPNBP">
															<input type="hidden" name="txtPendidikanHiddenPNBP">
															<input type="hidden" name="imgChartPNBP">
															<button type="button" class="btn btn-danger" onclick="reportPNBP()"><i class="fa fa-file-pdf-o fa-2x"></i></button>
															<button type="submit" class="hidden" id="SubmitReportPNBP"></button>
														</form>
													</div>
													<div class="col-lg-1">
														<form target="_blank" method="POST" action="<?php echo site_url('PNBP/Report/Excel') ?>">
															<input type="hidden" name="txtPeriodeHiddenPNBP">
															<input type="hidden" name="txtSeksiHiddenPNBP">
															<input type="hidden" name="txtDeptHiddenPNBP">
															<input type="hidden" name="txtMasaKerjaHiddenPNBP">
															<input type="hidden" name="txtJenkelHiddenPNBP">
															<input type="hidden" name="txtUsiaHiddenPNBP">
															<input type="hidden" name="txtSukuHiddenPNBP">
															<input type="hidden" name="txtStatusHiddenPNBP">
															<input type="hidden" name="txtPendidikanHiddenPNBP">
															<input type="hidden" name="imgChartPNBP">
															<button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o fa-2x"></i></button>
														</form>
													</div>
												</div>	
											</div>
											<div class="panel-body" id="fieldReportPNBP">
												<div class="row" style="margin-top: 100px">
													<div class="col-lg-12 text-center">
														<b>
															<h3>
																PENGUKURAN INTERNALISASI BUDAYA PERUSAHAAN
																<br>
																CV. KARYA HIDUP SENTOSA
															</h3>
														</b>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-10 col-lg-offset-1" style="color: black">
														<h4 id="PNBPPeriodePenarikan">Periode Penarikan Data : </h4>
														<h4 id="PNBPPartisipan">Jumlah Partisipan : </h4>
														<h4 id="PNBPPilih">Sorted By : </h4>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12" id="chartBig">
														<canvas id="canvasReportPNBP"></canvas>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-10 col-lg-offset-1">
														<table class="table" style="border-collapse: collapse;border:3px solid #8e24aa" border="1">
															<tr>
																<th rowspan="2" class="text-center" style="vertical-align: middle;border-top: 3px solid #8e24aa;border-right: 3px solid #8e24aa">Kepuasan Kerja</th>
																<th class="text-center" style="vertical-align: middle;border-top: 3px solid #8e24aa;border-right: 3px solid #8e24aa">Rata - Rata</th>
																<th class="text-center" style="vertical-align: middle;border-top: 3px solid #8e24aa;">Presentase</th>
															</tr>
															<tr>
																<th id="PNBPKepuasanRata" class="text-center" style="vertical-align: middle;border-top: 3px solid #8e24aa;border-right: 3px solid #8e24aa" id="KepuasanRata">Rata - Rata</th>
																<th id="PNBPKepuasanPersen" class="text-center" style="vertical-align: middle;border-top: 3px solid #8e24aa;" id="KepuasanPersen">Presentase</th>
															</tr>
														</table>
													</div>
												</div>
											</div>
										</div>
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