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
							<a class="btn btn-default btn-lg" href="<?php echo site_url('SPL/Pusat/InputLembur');?>">
								<i class="icon-wrench icon-2x"></i>
								<span><br/></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<section class="col-lg-12 connectedSortable">
				<?php if(!empty($result)){ ?>
					<?php if($result == 1): ?>
						<div class="callout callout-success">
							<h4>Sukses!</h4>
							<p>Data berhasil di simpan</p>
						</div>
						<?php if(!empty($exist)): ?>
							<div class="callout callout-danger">
								<h4>Gagal!</h4>
								<p>Noind <?=$exist ?> Sudah memiliki SPL di tanggal tersebut</p>
							</div>
						<?php endif; ?>
					<?php elseif($result == 3): ?>
						<div class="callout callout-danger">
							<h4>Gagal!</h4>
							<p>Waktu lembur yang diambil tidak boleh sama !!!</p>
						</div>
					<?php else: ?>
						<div class="callout callout-danger">
							<h4>Gagal!</h4>
							<p>Noind <?=$exist ?> Sudah memiliki SPL di tanggal tersebut</p>
						</div>
					<?php endif; ?>
				<?php } ?>

				<form class="form-horizontal" action="<?php echo site_URL('SPLSeksi/Pusat/C_splseksi/new_spl_submit'); ?>" method="post" enctype="multipart/form-data">
					<div class="box box-primary">
						<div class="box-header">
							<div class="row">
								<div class="col-lg-6">

									<div class="form-group" style="margin-bottom: 0 !important;">
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
													<input type="text" class="form-control spl-time-mask" name="waktu_0" required>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
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
													<input type="text" class="form-control spl-time-mask" name="waktu_1" required>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Jenis</label>
										<div class="col-sm-10">
											<select class="form-control select2" style="width: 100% !important;" name="kd_lembur" required>
												<option value="">-- silahkan pilih --</option>
												<?php foreach($jenis_lembur as $jl){ ?>
													<option value="<?php echo $jl['kd_Lembur']; ?>"><?php echo $jl['nama_lembur']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-group">
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

									<div class="form-group">
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

									<div class="form-group">
										<label class="col-sm-2 control-label">Alasan</label>
										<div class="col-sm-10">
											<textarea class="form-control" rows="3" name="alasan" class="" required></textarea>
										</div>
									</div>

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
										<div class="col-sm-12">
											<table id="example11" class="table table-responsive table-bordered table-striped text-center">
												<thead style="background:#3c8dbc; color:#fff">
													<tr style="background: #fff; color: #444; border: 0px solid white;">
														<td colspan="9" class="text-center">
															<label class="col-sm-1 control-label">Pekerja</label>
														</td>
														<td>
														<button id="spl_pkj_add" type="button" class="btn btn-primary btn-sm" style="float: right; margin-bottom: 1em;">
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
													<tr class="multiinput parent">
														<td>
															-
														</td>
														<td>
															<select class="spl-new-pkj-select2 spl-cek" name="noind[]" style="width: 100%" required>
																<!-- select2 -->
															</select>
														</td>
														<td>
															<input type="text" class="form-control" name="lbrawal[]" disabled>
															<input type="hidden" class="form-control" name="lembur_awal[]" >
														</td>
														<td>
															<input type="text" class="form-control" name="lbrakhir[]" disabled>
															<input type="hidden" class="form-control" name="lembur_akhir[]" >
														</td>
														<td>
															<input type="text" class="form-control" name="overtime" disabled>
														</td>
														<td>
															<input type="number" class="form-control" name="target[0][]" required>
														</td>
														<td>
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
														<td>
															<input type="number" class="form-control" name="realisasi[0][]" required>
														</td>
														<td>
															<select class="form-control realisasi-satuan" name="realisasi_satuan[0][]" disabled>
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
														<td colspan="2">
															<textarea style="resize: vertical; min-height: 30px;" class="form-control pekerjaan" rows="1" name="pekerjaan[0][]" required></textarea>
														</td>
														<td>
															<button type="button" onclick="add_jobs_spl($(this), 0)" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-12 pull-left">
											<button type="reset" style="margin-right:3px" class="btn btn-primary" onclick="location.reload()"> <i class="fa fa-refresh"></i> Reset</button>
											<button type="submit" id="submit_spl" class="btn btn-primary"> <i class="fa fa-save"></i> Submit</button>
											<a href="<?=base_url('SPL/Pusat')?>" class="btn btn-warning"> <i class="fa fa-arrow-circle-left"></i> Kembali</a>
										</div>
									</div>

								</div>

							</div>
						</div>
					</div>
				</form>

			</section>
		</div>
	</div>
	<script type="text/javascript">
		// need some idea
		// window.onfocus = function() {
		//   console.log('Got focus');
		//   window.location.reload();
		// }

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

		function setupTimers () {
		    document.addEventListener("mousemove", resetTimer(), false);
		    document.addEventListener("mousedown", resetTimer(), false);
		    document.addEventListener("keypress", resetTimer(), false);
		    document.addEventListener("touchmove", resetTimer(), false);

		    startTimer();
		}

		// document.addEventListener("DOMContentLoaded",function(e){
		// 	setupTimers();
		// });
	</script>
