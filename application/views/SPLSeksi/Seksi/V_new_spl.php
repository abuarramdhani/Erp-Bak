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
							<a class="btn btn-default btn-lg" href="<?php echo site_url('SPL/InputLembur');?>">
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
					<div class="callout callout-success">
						<h4>Sukses!</h4>
						<p>Data berhasil di simpan</p>
					</div>
				<?php } ?>

				<form class="form-horizontal" action="<?php echo site_URL('SPLSeksi/C_splseksi/new_spl_submit'); ?>" method="post" enctype="multipart/form-data">
					<div class="box box-primary">
						<div class="box-header">
							<div class="row">
								<div class="col-lg-6">

									<div class="form-group">
										<label class="col-sm-2 control-label">Tanggal Bekerja</label>
										<div class="col-sm-10">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control pull-right spl-date" name="tanggal" value="<?php echo date("d-m-Y"); ?>" required>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Waktu Lembur</label>
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
											<select class="form-control select2" name="kd_lembur" required>
												<option value="">-- silahkan pilih --</option>
												<?php foreach($jenis_lembur as $jl){ ?>
													<option value="<?php echo $jl['kd_Lembur']; ?>"><?php echo $jl['nama_lembur']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Istirahat</label>
										<div class="col-sm-2">
											<label style="margin-left:2%; top:+3;"><input type="radio" name="istirahat" value="1" style="transform: scale(1.5); vertical-align:top;" checked> Ya</label>
										</div>
										<div class="col-sm-8">
											<label style="margin-left:5%; vertical-align:bottom;"><input type="radio" name="istirahat" value="2" style="transform: scale(1.5); vertical-align:top;"> Tidak</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Break</label>
										<div class="col-sm-2">
											<label style="margin-left:2%; top:+3;"><input type="radio" name="break" value="1" style="transform: scale(1.5); vertical-align:top;" checked> Ya</label>
										</div>
										<div class="col-sm-8">
											<label style="margin-left:5%; vertical-align:bottom;"><input type="radio" name="break" value="2" style="transform: scale(1.5); vertical-align:top;"> Tidak</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Pekerjaan</label>
										<div class="col-sm-10">
											<textarea class="form-control" rows="3" name="pekerjaan" required></textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Estimasi</label>
										<div class="col-sm-10">
											<span id="estJamLembur">Isi data dengan lengkap</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="col-sm-1 control-label">Pekerja</label>
										<div class="col-sm-12">
											<table id="example11" class="table table-bordered table-striped text-center">
												<thead style="background:#3c8dbc; color:#fff">
													<th width="5%">No.</th>
													<th width="40%">Pekerja</th>
													<th width="10%">Awal Lembur Aktual</th>
													<th width="10%">Akhir Lembur Aktual</th>
													<th width="5%">Target/Pcs/%</th>
													<th width="5%">Realisasi/Pcs/%</th>
													<th width="40%">Alasan Lembur</th>
													<th width="5%">
														<i id="spl_pkj_add" class="fa fa-fw fa-plus-square-o"></i>
													</th>
												</thead>
												<tbody>
													<tr class="multiinput"><td>-</td>
														<td>
															<select class="spl-new-pkj-select2 spl-cek" name="noind[]" style="width: 100%" required>
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
														<td><input type="number" class="form-control" name="target[]"></td>
														<td><input type="number" class="form-control" name="realisasi[]"></td>
														<td colspan="2"><textarea class="form-control" rows="1" name="alasan[]"></textarea></td></tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-12 pull-left">
											<button type="reset" style="margin-right:3px" class="btn btn-primary" onclick="location.reload()"> <i class="fa fa-refresh"></i> Reset</button>
											<button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Submit</button>
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
