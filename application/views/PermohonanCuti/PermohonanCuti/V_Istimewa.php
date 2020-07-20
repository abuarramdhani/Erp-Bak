<style media="screen">
	label {
		left: 15px;
	}

	.container {
		width: auto;
	}

	h2 {
		font-size: 3rem;
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
				<form class="form-horizontal" method="POST" action="<?php echo base_url('PermohonanCuti/Istimewa/Insert') ?>">
					<div class="col-lg-12">
						<div class="row">
							<div class="box ">
								<div class="panel-body">
									<div class="col-md-12">
										<button type="button" class="btn btn-primary" onclick="start_introjs()" style="background-color: #007bff; border-color: #007bff;">
											<i class="fa fa-mouse-pointer"></i>
											Petunjuk Penggunaan Aplikasi
										</button>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-md-4 col-sm-4">Jenis Cuti</label>
										<div class="col-lg-4 col-md-5 col-sm-7">
											<div class="col-lg-12" data-intro="Pilih jenis cuti istimewa yang akan diajukan">
												<select class="select select2" name="slc_JenisCutiIstimewa" id="slc_JenisCutiIstimewa" data-placeholder="Jenis Cuti" style="width:100%;" required>
													<option value=""></option>
													<?php foreach ($Cuti as $key) { ?>
														<option value="<?php echo $key['lm_jenis_cuti_id'] ?>"><?php echo $key['jenis_cuti']; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group txtPerkiraanLahir hidden">
										<label class="control-label col-lg-4 col-md-4 col-sm-4">Hari Perkiraan Lahir</label>
										<div class="col-lg-4 col-md-5 col-sm-7">
											<div class="col-lg-12">
												<input type="text" class="form-control txtPerkiraanLahir" name="txtPerkiraanLahir" id="txtPerkiraanLahir" placeholder="Tanggal Perkiraan Lahir" data-date-format="dd-mm-yyyy">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12">Hak Cuti</label>
										<div class="col-lg-5 col-md-2 col-sm-3 col-xs-6">
											<div class="col-lg-4" data-intro="Jumlah hari yang dapat dilakukan pengajuan cuti sesuai jenis cuti yang dipilih">
												<div class="input-group">
													<input type="text" style="text-align: center;" class="form-control" name="txtHakCuti" id="txtHakCuti" readonly>
													<span class="input-group-addon" readonly>Hari</span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group txtSebelumLahir hidden">
										<label class="control-label col-lg-4 col-sm-4 col-md-4">Sebelum Melahirkan</label>
										<div class="col-lg-4 col-md-5 col-sm-7">
											<div class="col-lg-5 col-xs-5">
												<div class="input-group">
													<input type="tel" class="form-control" name="txtSebelumLahir" id="txtSebelumLahir" placeholder="">
													<span class="input-group-addon">Hari</span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group txtSetelahLahir hidden">
										<label class="control-label col-lg-4 col-sm-4 col-md-4">Setelah Melahirkan</label>
										<div class="col-lg-4 col-md-5 col-sm-7">
											<div class="col-lg-5 col-xs-5">
												<div class="input-group">
													<input type="tel" class="form-control" name="txtSetelahLahir" id="txtSetelahLahir" placeholder="">
													<span class="input-group-addon">Hari</span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group txtPengambilanCuti" data-intro="Pilih tanggal pengambilan cuti istimewa">
										<label class="control-label col-lg-4 col-md-4 col-sm-4">Tanggal Pengambilan Cuti</label>
										<div class="col-lg-4 col-md-5 col-sm-7">
											<div class="col-lg-12">
												<input type="text" class="form-control" autocomplete="off" name="txtPengambilanCuti" id="txtPengambilanCutiIstimewa" placeholder="Tanggal Pengambilan Cuti" data-date-format="yyyy-mm-dd">
											</div>
										</div>
									</div>
									<!-- <div class="form-group txtAlamat hidden">
										<label class="control-label col-lg-4 col-md-4 col-sm-4">Alamat</label>
										<div class="col-lg-4 col-md-5 col-sm-7">
											<div class="col-lg-12">
												<textarea class="form-control" style="resize:none;" name="txtAlamat" id="txtAlamat" rows="5" cols="50" placeholder="Alamat Rumah"></textarea>
											</div>
										</div>
									</div> -->
									<hr>
									<!-- <div class="row"> -->
									<div class="form-group">
										<div class="form-group">
											<label class="control-label col-lg-4 col-md-4 col-sm-4">Approval</label>
										</div>
										<div class="form-group" data-intro="Pilih atasan langsung untuk mengapprove pengajuan cuti">
											<label for="approval1" class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12">Atasan Langsung</label>
											<div class="col-lg-3 col-md-3 col-sm-5 col-xs-9">
												<div class="col-lg-12 col-lg-12 col-md-12 col-xs-12">
													<?php if (!strstr("02,03,04", $kdjbtn1)) { ?>
														<select class="select select2" name="slc_approval1" id="slc_approval1" data-placeholder="Approver 1" style="width:100%;" required>
															<option value=""></option>
															<?php foreach ($approval1 as $appr1) { ?>
																<?php if (isset($_POST['slc_approval1']) && $_POST['slc_approval1'] == $appr1['noind']) {
																	$selected = "selected";
																} else {
																	$selected = "";
																} ?>
																<option value="<?= $appr1['noind'] ?>" <?php echo $selected ?>><?php echo $appr1['noind'] . " - " . $appr1['nama'] ?></option>
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
																<option value="<?= $appr1['noind'] ?>" <?php echo $selected ?>><?php echo $appr1['noind'] . " - " . $appr1['nama'] ?></option>
															<?php } ?>
														</select>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
									<?php if (!strstr("02,03,04", $kdjbtn1)) { ?>
										<div class="form-group" data-intro="Pilih atasan dari atasan langsung untuk mengapprove pengajuan cuti">
											<label for="approval2" class="control-label col-lg-4 col-md-4 col-sm-4">Atasan dari Atasan Langsung</label>
											<div class="col-lg-3 col-md-3 col-sm-5 col-xs-9">
												<div class="col-lg-12">
													<select class="select select2" name="slc_approval2" id="slc_approval2" data-placeholder="Approver 2" style="width:100%;" required>
														<option value=""></option>
													</select>
												</div>
											</div>
										</div>
									<?php } ?>
									<!-- </div> -->
								</div>
							</div>
							<div class="panel-footer text-center">
								<input type="hidden" name="emptyapp" value="<?= $emptyapp ?>">
								<button type="button" data-intro="Klik tombol jika data sudah diisi dengan benar" id="submit_istimewa" class="btn btn-success">Simpan</button>
								<button type="button" id="submit_hpl" class="btn btn-success hidden">Simpan</button>
								<button type="submit" id="submit_istimewa2" class="btn btn-success" style="display:none;"></button>
								<a href="<?php echo site_url('PermohonanCuti') ?>" class="btn btn-warning">Batal</a>
							</div>
						</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	function start_introjs() {
		let intro = introJs()
		intro.start()
	}
	$(document).ready(function() {
		var kdExpect = "01,02,03,04,05,18,19,20,21,22,23,24,25";
		if (kdExpect.includes("<?= $kd_jabatan ?>")) {
			$('#submit_istimewa').prop('disabled', true);
			Swal.fire({
				title: 'Silahkan Mengisi Form Manual',
				type: 'error',
				text: 'Tidak dapat mengambil cuti'
			}).then((result) => {
				window.location.href = baseurl + "PermohonanCuti";
			});
			return false;
		}
	});
</script>