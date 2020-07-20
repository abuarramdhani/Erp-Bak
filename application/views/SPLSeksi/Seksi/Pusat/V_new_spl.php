<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-11">
					<div class="text-right">
						<h1><b>Input Lembur</b></h1>
					</div>
				</div>
				<div class="col-lg-1">
					<div class="text-right hidden-md hidden-sm hidden-xs">
						<a class="btn btn-default btn-lg" href="<?php echo site_url('SPL/Pusat/InputLembur'); ?>">
							<i class="icon-wrench icon-2x"></i>
							<span><br /></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<section class="col-lg-12 connectedSortable">
			<?php if (!empty($result) && !empty($_SESSION['notif'])) { ?>
				<?php if ($result == 1) : ?>
					<div class="callout callout-success">
						<h4>Sukses!</h4>
						<p>Data berhasil di simpan</p>
					</div>
					<?php if (!empty($exist)) : ?>
						<div class="callout callout-danger">
							<h4>Gagal!</h4>
							<p>Noind <?= $exist ?> Sudah memiliki SPL di tanggal tersebut</p>
						</div>
					<?php endif; ?>
				<?php elseif ($result == 3) : ?>
					<div class="callout callout-danger">
						<h4>Gagal!</h4>
						<p>Waktu lembur yang diambil tidak boleh sama !!!</p>
					</div>
				<?php else : ?>
					<div class="callout callout-danger">
						<h4>Gagal!</h4>
						<p>Noind <?= $exist ?> Sudah memiliki SPL di tanggal tersebut</p>
					</div>
				<?php endif; ?>
			<?php } ?>
			<?php if (empty($_SESSION['review'])) : ?>
				<form class="form-horizontal" action="<?php echo site_URL('SPLSeksi/Pusat/C_splseksi/new_spl_submit'); ?>" method="post" enctype="multipart/form-data">
					<div class="box box-primary">
						<div class="box-header">
							<div class="row">
								<div class="col-lg-6">
									<div data-step="1" data-intro="Pilih tanggal awal dan jam awal lembur" class="form-group" style="margin-bottom: 0 !important;">
										<label class="col-sm-2 control-label">Lembur Awal</label>
										<div class="col-sm-5">
											<div class="bootstrap-timepicker">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right spl-date" name="tanggal_0" value="<?php echo date("d-m-Y"); ?>" required>
												</div>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="bootstrap-timepicker">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
													<input type="text" class="form-control spl-time-mask" placeholder="Jam awal" name="waktu_0" required>
												</div>
											</div>
										</div>
									</div>
									<div data-step="2" data-intro="Pilih tanggal akhir dan jam akhir lembur" class="form-group">
										<label class="col-sm-2 control-label">Lembur Akhir</label>
										<div class="col-sm-5">
											<div class="bootstrap-timepicker">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right spl-date" name="tanggal_1" value="<?php echo date("d-m-Y"); ?>" required>
												</div>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="bootstrap-timepicker">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
													<input type="text" class="form-control spl-time-mask" placeholder="Jam akhir" name="waktu_1" required>
												</div>
											</div>
										</div>
									</div>

									<div data-step="3" data-intro="Pilih lembur yang akan diinputkan" class="form-group">
										<label class="col-sm-2 control-label">Jenis</label>
										<div class="col-sm-10">
											<select class="form-control select2" style="width: 100% !important;" data-placeholder="-- silahkan pilih --" name="kd_lembur" required>
												<option value=""></option>
												<?php foreach ($jenis_lembur as $jl) { ?>
													<option value="<?php echo $jl['kd_Lembur']; ?>"><?php echo $jl['nama_lembur']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div data-step="4" data-intro="Apakah saat lembur ada jam break, pilih ya jika ada" class="form-group">
										<label class="col-sm-2 control-label">Break</label>
										<div class="col-sm-2">
											<label style="margin-left:2%; top:+3;">
												<input class="" id="break-ya" type="radio" name="break" value="1" style="transform: scale(1.5); vertical-align:top;" checked>
												Ya
											</label>
										</div>
										<div class="col-sm-8">
											<label style="margin-left:5%; vertical-align:bottom;">
												<input id="break-no" class="" type="radio" name="break" value="2" style="transform: scale(1.5); vertical-align:top;">
												Tidak
											</label>
										</div>
									</div>

									<div data-step="5" data-intro="Apakah saat lembur ada jam istirahat, pilih ya jika ada" class="form-group">
										<label class="col-sm-2 control-label">Istirahat</label>
										<div class="col-sm-2">
											<label style="margin-left:2%; top:+3;">
												<input type="radio" id="istirahat-ya" class="" name="istirahat" value="1" style="transform: scale(1.5); vertical-align:top;" checked>
												Ya
											</label>
										</div>
										<div class="col-sm-8">
											<label style="margin-left:5%; vertical-align:bottom;">
												<input id="istirahat-no" class="" type="radio" name="istirahat" value="2" style="transform: scale(1.5); vertical-align:top;">
												Tidak
											</label>
										</div>
									</div>

									<div data-step="6" data-intro="Masukkan alasan lembur yang akan diinputkan" class="form-group">
										<label class="col-sm-2 control-label">Alasan</label>
										<div class="col-sm-10">
											<textarea class="form-control" style="min-height: 40px; max-height: 120px; resize: vertical;" rows="3" name="alasan" placeholder="Alasan kenapa lembur" class="" required></textarea>
										</div>
									</div>

								</div>
								<div class="col-md-6 text-right">
									<button type="button" class="btn btn-primary" onclick="start_introjs()" style="background-color: #007bff; border-color: #007bff;">
										<i class="fa fa-mouse-pointer"></i>
										Petunjuk Penggunaan Aplikasi
									</button>
								</div>
							</div>
							<!-- hidden input start -->
							<input type="hidden" name="tanggal_0_simpan">
							<input type="hidden" name="tanggal_1_simpan">
							<input type="hidden" name="waktu_0_simpan">
							<input type="hidden" name="waktu_1_simpan">

							<input type="hidden" name="kd_lembur_simpan">
							<input type="hidden" name="istirahat_simpan">
							<input type="hidden" name="break_simpan">
							<input type="hidden" name="alasan_simpan">
							<!-- hidden input end -->
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<div data-step="7" data-intro="Tabel untuk menginputkan pekerja yang lembur" class="col-sm-12">
											<table id="example11" class="table table-responsive table-bordered table-striped text-center">
												<thead style="background:#3c8dbc; color:#fff">
													<tr style="background: #fff; color: #444; border: 0px solid white;">
														<td colspan="9" class="text-center">
															<label class="col-sm-1 control-label">Pekerja</label>
														</td>
														<td>
															<button data-step="13" data-intro="Tombol untuk menambahkan pekerja lain" id="spl_pkj_add" type="button" class="btn btn-primary btn-sm" style="float: right; margin-bottom: 1em;">
																<i class="fa fa-plus"></i>
															</button>
														</td>
													</tr>
													<tr>
														<th width="5%">No.</th>
														<th width="20%">Pekerja</th>
														<th width="8%">Awal Lembur Aktual</th>
														<th width="8%">Akhir Lembur Aktual</th>
														<th width="5%">Estimasi Lembur</th>
														<th width="10%">Target</th>
														<th width="10%">Satuan</th>
														<th width="10%">Realisasi</th>
														<th width="10%">Satuan</th>
														<th colspan="2" width="30%">Pekerjaan</th>
													</tr>
												</thead>
												<tbody>
													<tr class="multiinput parent" data-row="0">
														<td>
															<button disabled type='button' class='btn btn-danger spl-pkj-del'><span class='fa fa-trash'></span></button>
														</td>
														<td data-step="8" data-intro="Pilih pekerja yang lembur">
															<select class="spl-new-pkj-select2 spl-cek" name="noind[]" style="width: 100%" required>
																<!-- select2 -->
															</select>
														</td>
														<td>
															<input type="text" class="form-control" name="lbrawal[]" disabled>
															<input type="hidden" class="form-control" name="lembur_awal[]">
														</td>
														<td>
															<input type="text" class="form-control" name="lbrakhir[]" disabled>
															<input type="hidden" class="form-control" name="lembur_akhir[]">
														</td>
														<td>
															<input type="text" class="form-control" name="overtime" disabled>
														</td>
														<td data-step="9" data-intro="Masukkan berapa target lembur">
															<input type="number" min="1" class="form-control" name="target[0][]" required>
														</td>
														<td data-step="10" data-intro="Masukkan satuan target lembur">
															<select class="form-control target-satuan" name="target_satuan[0][]" required>
																<option value=""></option>
																<option value="Pcs">Pcs</option>
																<option value="%">%</option>
																<option value="Box">Box</option>
																<option value="Kg">Kg</option>
																<option value="Unit">Unit</option>
																<option value="Ton">Ton</option>
																<option value="Flask">Flask</option>
															</select>
														</td>
														<td data-step="11" data-intro="Masukkan berapa realisasi lembur">
															<input type="number" min="1" class="form-control" name="realisasi[0][]" required>
														</td>
														<td>
															<input type="text" class="form-control realisasi-satuan" name="realisasi_satuan[0][]" readonly>
														</td>
														<td data-step="12" data-intro="Masukkan pekerjaan yang dilakukan saat lembur" colspan="2">
															<textarea style="resize: vertical; min-height: 30px;" class="form-control pekerjaan" rows="1" name="pekerjaan[0][]" required></textarea>
														</td>
														<td>
															<!-- <button type="button" onclick="add_jobs_spl($(this))" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></button> -->
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12 pull-left">
											<button data-step="15" data-intro="Tombol untuk reset isian" type="reset" style="margin-right:3px" class="btn btn-primary" onclick="location.reload()"> <i class="fa fa-refresh"></i> Reset</button>
											<button data-step="14" data-intro="Klik tombol ini jika data sudah diisi dengan benar" type="submit" id="submit_spl" class="btn btn-primary"> <i class="fa fa-save"></i> Submit</button>
											<a href="<?= base_url('SPL/Pusat') ?>" class="btn btn-warning"> <i class="fa fa-arrow-circle-left"></i> Kembali</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			<?php else : ?>
				<div class="table-responsive">
					<table class="table table-responsive table-bordered table-striped text-center">
						<thead style="background:#3c8dbc; color:#fff">
							<tr style="border: 0px solid white;">
								<th>No</th>
								<th>Noind</th>
								<th>Nama</th>
								<th>Tanggal Shift</th>
								<th>Jenis</th>
								<th>Awal</th>
								<th>Akhir</th>
								<th>Break</th>
								<th>Istirahat</th>
								<th>Estimasi Jam Lembur</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1;
							foreach ($_SESSION['review'] as $item) : ?>
								<tr>
									<td><?= $i++ ?></td>
									<td><?= $item['noind'] ?></td>
									<td><?= $item['nama'] ?></td>
									<td><?= $item['tanggal_shift'] ?></td>
									<td><?= $item['lembur'] ?></td>
									<td><?= $item['tgl_ses1'] ?></td>
									<td><?= $item['tgl_ses2'] ?></td>
									<!-- <td><?= date('d-m-Y', strtotime($item['tanggal'])) . " " . $item['awal'] ?></td>
										<td><?= (strtotime($item['awal']) > strtotime($item['akhir'])) ? date('d-m-Y', strtotime('+1 day ' . $item['tanggal'])) . " " . $item['akhir'] : date('d-m-Y', strtotime($item['tanggal'])) . " " . $item['akhir'] ?></td> -->
									<td><?= $item['break'] ?></td>
									<td><?= $item['istirahat'] ?></td>
									<td><?= $item['jam_lembur'] ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
				<div class="col-lg-12 text-center">
					<a class="btn btn-success" href="<?= base_url('SPL/Pusat/InputLembur') ?>">
						<i class="fa fa-arrow-circle-left"></i> Kembali
					</a>
				</div>
			<?php endif ?>
		</section>
	</div>
</section>
<script type="text/javascript">
	// need some idea
	// window.onfocus = function() {
	//   console.log('Got focus');
	//   window.location.reload();
	// }

	function start_introjs() {
		introJs().start()
	}

	var timeoutInMiliseconds = 120000;
	var timeoutId;

	function startTimer() {
		// window.setTimeout returns an Id that can be used to start and stop a timer
		timeoutId = window.setTimeout(doInactive, timeoutInMiliseconds)
	}

	function doInactive() {
		// does whatever you need it to actually do - probably signs them out or stops polling the server for info
		window.location.reload();
	}

	function resetTimer() {
		window.clearTimeout(timeoutId)
		startTimer();
	}

	function setupTimers() {
		document.addEventListener("mousemove", resetTimer(), false);
		document.addEventListener("mousedown", resetTimer(), false);
		document.addEventListener("keypress", resetTimer(), false);
		document.addEventListener("touchmove", resetTimer(), false);

		startTimer();
	}

	document.addEventListener("DOMContentLoaded", function(e) {
		// setupTimers();
	});
</script>