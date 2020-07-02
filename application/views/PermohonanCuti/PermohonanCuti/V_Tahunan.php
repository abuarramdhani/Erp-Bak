<style media="screen">
	label {
		left: 15px;
	}

	.container {
		width: auto;
	}

	h2 {
		font-size: 2.5rem;
	}
</style>
<section class="content">
	<div class="panel-body">
		<div class="row">
			<div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h2 align="center"><strong><?= $Menu ?></strong></h2>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body  bg-info">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
									<text>Nama </text><br>
									<text>No Induk </text><br>
									<text>Seksi </text><br>
									<text>Unit </text><br>
									<text>Departemen </text>
								</div>
								<div class="ccol-lg-11 col-md-10 col-sm-10 col-xs-9">
									<?php foreach ($Info as $key) : ?>
										<text>: <?= $key['nama'] ?></text> <br>
										<text>: <?= $key['noind'] ?> </text><br>
										<text>: <?= $key['seksi'] ?> </text><br>
										<text>: <?= $key['unit'] ?> </text><br>
										<text>: <?= $key['dept'] ?> </text>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="inner">
			<div class="row">
				<form class="form-horizontal" method="POST" action="<?php echo site_url('PermohonanCuti/Tahunan/Insert') ?>">
					<div class="col-lg-12">
						<div class="row">
							<div class="box ">
								<div class="panel-body">
									<div class="col-md-12">
										<button type="button" class="btn btn-primary" onclick="start_introjs()" style="background-color: #007bff; border-color: #007bff;">
											<i class="fa fa-mouse-pointer"></i>
											Intro Aplikasi
										</button>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-md-4">Sisa Cuti Saat Ini</label>
										<div class="col-lg-4 col-md-4" data-intro="Sisa cuti dan tanggal boleh ambil cuti">
											<div class="col-lg-4 col-xs-5">
												<input type="text" class="form-control" name="txtSisaCuti" id="txtSisaCuti" value="<?= (empty($SisaCuti['0']['sisa_cuti'])) ? "0" :	$SisaCuti['0']['sisa_cuti']; ?> Hari" readonly>
											</div>
											<div class="col-lg-8">
												<span class="label label-warning">Tanggal Boleh Ambil Cuti Anda : <?= (!empty($mintglpengambilan['0']['tgl_boleh_ambil'])) ? date("d F Y", strtotime($mintglpengambilan['0']['tgl_boleh_ambil'])) : "---" ?>
												</span>
												<input type="hidden" id="minDateCuti" value="<?= (!empty($mintglpengambilan['0']['tgl_boleh_ambil'])) ? date("d F Y", strtotime($mintglpengambilan['0']['tgl_boleh_ambil'])) : "---" ?>">
											</div>
										</div>
									</div>
									<div class="form-group" data-intro="Pilih jenis cuti yang akan diajukan">
										<label class="control-label col-lg-4 col-md-4">Jenis Cuti</label>
										<div class="col-lg-4 col-md-5">
											<div class="col-lg-12">
												<select class="select select2" name="slc_JenisCutiTahunan" id="slc_JenisCutiTahunan" data-placeholder="-- silahkan pilih --" style="width:100%;" required>
													<option value=""></option>
													<?php foreach ($Cuti as $key) { ?>
														<?php if (isset($_POST['slc_JenisCutiTahunan']) && $_POST['slc_JenisCutiTahunan'] == $key['lm_jenis_cuti_id']) {
															$selected = "selected";
														} else {
															$selected = "";
														} ?>
														<option value="<?php echo $key['lm_jenis_cuti_id'] ?>" <?php echo $selected ?>><?php echo $key['jenis_cuti']; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group slc_Keperluan hidden">
										<label class="control-label col-lg-4 col-md-4">Keperluan</label>
										<div class="col-lg-4 col-md-5">
											<div class="col-lg-12">
												<select class="select select2" name="slc_Keperluan" id="slc_Keperluan" data-placeholder="-- silahkan pilih --" style="width:100%">
													<option value=""></option>
													<?php foreach ($keperluan as $key) { ?>
														<?php if (isset($_POST['slc_Keperluan']) && $_POST['slc_Keperluan'] == $key['keperluan']) {
															$selected = "selected";
														} else {
															$selected = "";
														} ?>
														<option value="<?php echo $key['lm_keperluan_id'] ?>" <?php echo $selected ?>><?php echo $key['keperluan'] ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group txtKeperluan" data-intro="Isi keperluan untuk mengajukan cuti">
										<label class="control-label col-lg-4 col-md-4">Keperluan</label>
										<div class="col-lg-4 col-md-5">
											<div class="col-lg-12">
												<textarea class="form-control" style="resize:none;" name="txtKeperluan" id="txtKeperluan" rows="5" cols="50" placeholder="Isi Keperluan"><?= (isset($_POST['txtKeperluan'])) ?  $_POST['txtKeperluan'] : '' ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-group" data-intro="Pilih tanggal cuti yang akan diajukan">
										<label class="control-label col-lg-4 col-md-4">Tanggal Pengambilan Cuti</label>
										<div class="col-lg-4 col-md-5">
											<div class="col-lg-12 txtTgl">
												<input type="text" value="<?= (isset($_POST['txtPengambilanCuti'])) ? $_POST['txtPengambilanCuti'] : '' ?>" class="form-control" autocomplete="off" name="txtPengambilanCuti" id="txtPengambilanCutiTahunan" placeholder="Tanggal Pengambilan Cuti" data-date-format="yyyy-mm-dd">
											</div>
											<div class="col-lg-12 txtTglSusulan hidden">
												<input type="text" value="<?= (isset($_POST['txtPengambilanCuti'])) ? $_POST['txtPengambilanCuti'] : '' ?>" class="form-control" autocomplete="off" name="txtPengambilanCutiSusulan" id="txtPengambilanCutiTahunanSusulan" placeholder="Tanggal Pengambilan Cuti" data-date-format="yyyy-mm-dd">
											</div>
										</div>
									</div>
									<hr>
									<div class="form-group">
										<div class="form-group">
											<label class="control-label col-lg-4 col-md-4 col-sm-4">Approval</label>
										</div>
										<div class="form-group" data-intro="Pilih atasan langsung untuk mengapprove cuti">
											<label for="approval1" class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12">Atasan Langsung</label>
											<div class="col-lg-3 col-md-4 col-sm-5 col-xs-9">
												<div class="col-lg-12">
													<?php if (!strstr("02,03,04", $kdjbtn1)) { ?>
														<select class="select select2" name="slc_approval1" id="slc_approval1" data-placeholder="Approver 1" style="width:100%;" required>
															<option value=""></option>
															<?php foreach ($approval1 as $appr1) { ?>
																<?php if (isset($_POST['slc_approval1']) && $_POST['slc_approval1'] == $appr1['noind']) {
																	$selected = "selected";
																} else {
																	$selected = "";
																} ?>
																<option value="<?php echo $appr1['noind'] ?>" <?php echo $selected ?>><?php echo $appr1['noind'] . " - " . $appr1['nama'] ?></option>
															<?php } ?>
														</select>
													<?php } else { ?>
														<select class="select select2" name="slc_approval1" data-placeholder="Approver 1" style="width:100%;" required>
															<option value=""></option>
															<?php foreach ($approval1 as $appr1) { ?>
																<?php if (isset($_POST['slc_approval1']) && $_POST['slc_approval1'] == $appr1['noind']) {
																	$selected = "selected";
																} else {
																	$selected = "";
																} ?>
																<option value="<?php echo $appr1['noind'] ?>" <?php echo $selected ?>><?php echo $appr1['noind'] . " - " . $appr1['nama'] ?></option>
															<?php } ?>
														</select>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
									<?php if (!strstr("02,03,04", $kdjbtn1)) { ?>
										<div class="form-group" data-intro="Pilih atasan dari atasan langsung untuk melakukan approve">
											<label for="approval2" class="control-label col-lg-4 col-md-4 col-sm-4">Atasan dari Atasan Langsung</label>
											<div class="col-lg-3 col-md-4 col-sm-5 col-xs-9">
												<div class="col-lg-12">
													<select class="select select2" name="slc_approval2" id="slc_approval2" data-placeholder="Approver 2" style="width:100%;" required>
														<option value=""></option>
													</select>
												</div>
											</div>
										</div>
									<?php } ?>
									<br>
									<div class="panel-footer text-center">
										<button data-intro="Klik tombol jika data sudah diisi dengan benar" type="button" id="submit_tahunan" class="btn btn-success">Simpan</button>
										<button type="submit" id="submit_tahunan2" style="display:none;"></button>
										<a href="<?php echo site_url('PermohonanCuti') ?>" class="btn btn-warning">Batal</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- Modal Loading -->
<div class="modal fade" id="loadingCuti" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
	<div style="transform: translateY(50%);" class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<div class="loader"></div>
				<div clas="loader-txt">
					<center><img class="img-loading" style="width:130px; height:auto" src="<?php echo base_url('assets/img/gif/loadingquick.gif') ?>"></center>
					<p>
						<center>Loading...</center>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<script type="text/javascript">
	function start_introjs() {
		let intro = introJs()
		intro.start()
	}

	$(document).ready(function() {
		var kdExpect = "01,02,03,04,05,18,19,20,21,22,23,24,25";
		var sisacuti = $('#txtSisaCuti').val();
		if (kdExpect.includes("<?= $kd_jabatan ?>")) {
			$('#submit_tahunan').prop('disabled', true);
			Swal.fire({
				title: 'Silahkan Mengisi Form Manual',
				type: 'error',
				text: 'Tidak dapat mengambil cuti'
			}).then((result) => {
				window.location.href = baseurl + "PermohonanCuti";
			});
		} else if (sisacuti == "0 Hari") {
			$('#submit_tahunan').attr('disabled', true);
			Swal.fire({
				title: 'Sisa Cuti = 0',
				type: 'error',
				text: 'Tidak dapat mengambil cuti'
			}).then((result) => {
				window.location.href = baseurl + "PermohonanCuti";
			});
		}
	});
</script>