	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b>Edit Lembur</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="#">
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
						<p>Data berhasil di update</p>
					</div>
				<?php } ?>

				<?php if(!empty($lembur)){ foreach($lembur as $l){
					$status = "";
					if ($l['Status'] == '21' or $l['Status'] == '25') {
						$status = "disabled";
					}
					?>

				<form class="form-horizontal" id="form-edit-spl" action="<?php echo site_URL('SPLSeksi/C_splseksi/edit_spl_submit'); ?>" method="post" enctype="multipart/form-data">

					<!-- ID DPL DI EDIT -->
					<input type="text" class="hidden" name="id_spl" value="<?php echo $l['ID_SPL']; ?>">
					<!-- ID DPL DI EDIT -->

					<div class="box box-primary">
						<div class="box-header">
							<div class="row">
								<div class="col-lg-6">

								<div class="form-group" style="margin-bottom: 0 !important;">
										<label class="col-sm-2 control-label">Waktu Lembur</label>
										<div class="col-sm-5">
											<div class="bootstrap-timepicker">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right spl-date" name="tanggal_0" value="<?php echo date_format(date_create($l['Tgl_Lembur']), "d-m-Y"); ?>" disabled>
												</div>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="bootstrap-timepicker">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
													<input type="text" class="form-control spl-time-mask" name="waktu_0" value="<?php echo $l['Jam_Mulai_Lembur']; ?>" <?php echo $status ?> required>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label"></label>
										<div class="col-sm-5">
											<div class="bootstrap-timepicker">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<?php
														//logic for tanggal2
														$tanggal2 = date('d-m-Y', strtotime($l['Tgl_Lembur']));
														$time1 = strtotime($l['Jam_Mulai_Lembur']);
														$time2 = strtotime($l['Jam_Akhir_Lembur']);
														if($time1 > $time2){
															$tanggal2 = date('d-m-Y', strtotime($l['Tgl_Lembur']." +1 days"));
														}
													?>
													<input type="text" class="form-control pull-right spl-date" name="tanggal_1" value="<?= $tanggal2 ?>" required>
												</div>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="bootstrap-timepicker">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
													<input type="text" class="form-control spl-time-mask" name="waktu_1" value="<?php echo $l['Jam_Akhir_Lembur']; ?>" <?php echo $status ?> required>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Jenis</label>
										<div class="col-sm-10">
											<select class="form-control select2" name="kd_lembur" <?php echo $status ?>>
												<option value="">-- silahkan pilih --</option>
												<?php foreach($jenis_lembur as $jl){ ?>
													<?php
													if($jl['kd_Lembur'] == $l['Kd_Lembur']){
														$selected="selected";
													}else{
														$selected="";
													}
													?>

													<option value="<?php echo $jl['kd_Lembur']; ?>" <?php echo $selected; ?>>
														<?php echo $jl['nama_lembur']; ?>
													</option>

												<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Istirahat</label>
										<div class="col-sm-2">
											<label style="margin-left:2%; top:+3;"><input type="radio" name="istirahat" value="1" style="transform: scale(1.5); vertical-align:top;" <?php if($l['Istirahat']=="Y"){ echo "checked"; } ?> <?php echo $status ?>> Ya</label>
										</div>
										<div class="col-sm-8">
											<label style="margin-left:5%; vertical-align:bottom;"><input type="radio" name="istirahat" value="2" style="transform: scale(1.5); vertical-align:top;" <?php if($l['Istirahat']=="N"){ echo "checked"; } ?> <?php echo $status ?>> Tidak</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Break</label>
										<div class="col-sm-2">
											<label style="margin-left:2%; top:+3;"><input type="radio" name="break" value="1" style="transform: scale(1.5); vertical-align:top;" <?php if($l['Break']=="Y"){ echo "checked"; } ?> <?php echo $status ?>> Ya</label>
										</div>
										<div class="col-sm-8">
											<label style="margin-left:5%; vertical-align:bottom;"><input type="radio" name="break" value="2" style="transform: scale(1.5); vertical-align:top;" <?php if($l['Break']=="N"){ echo "checked"; } ?> <?php echo $status ?>> Tidak</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Alasan</label>
										<div class="col-sm-10">
											<textarea class="form-control" rows="3" name="pekerjaan" <?php echo $status ?>><?php echo $l['alasan_lembur']; ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Estimasi</label>
										<div class="col-sm-3" style="border: 1px solid grey; margin-left: 1em; border-radius: 2px; padding-bottom: 5px; padding-top: 5px; width: 6em;">
											<span id="estJamLembur">...</span>
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
													<th width="30%">Pekerja</th>
													<th width="10%">Target</th>
													<th width="10%">Satuan</th>
													<th width="10%">Realisasi</th>
													<th width="10%">Satuan</th>
													<th width="45%">Pekerjaan</th>
												</thead>
												<tbody>
													<tr class="multiinput"><td>-</td>
														<td style="">
															<select class="form-control spl-pkj-select2 spl-cek" name="noind[]" <?php echo $status ?>>
																<option value="<?php echo $l['Noind']; ?>" selected>
																	<?php echo $l['Noind'].' - '.$l['nama']; ?>
																</option>
															</select>
														</td>
														<?php
															if($l['target'] == '-' ||$l['target'] == ''){
																$target = '';
																$target_satuan = '';
															}else{
																$isHaveUnit = explode(' ', trim($l['target']));
																if(count($isHaveUnit) > 1){
																	$target = $isHaveUnit[0];
																	$target_satuan = $isHaveUnit[1];
																}else{
																	$target = $l['target'];
																	$target_satuan = '';
																}
															}
														?>
														<td><input type="number" class="form-control" name="target[]"
															value="<?= $target ?>" <?php echo $status ?>>
														</td>
														<td>
															<select class="form-control" name="target_satuan[]">
																<option value="" <?= $target_satuan == '' ? 'selected' : '' ?>></option>
																<option value="Pcs" <?= $target_satuan == 'Pcs' ? 'selected' : '' ?>>Pcs</option>
																<option value="%" <?= $target_satuan == '%' ? 'selected' : '' ?>>%</option>
															</select>
														</td>
														<?php
															if($l['realisasi'] == '-' ||$l['realisasi'] == ''){
																$target = '';
																$target_satuan = '';
															}else{
																$isHaveUnit = explode(' ', trim($l['realisasi']));
																if(count($isHaveUnit) > 1){
																	$target = $isHaveUnit[0];
																	$target_satuan = $isHaveUnit[1];
																}else{
																	$target = $l['realisasi'];
																	$target_satuan = '';
																}
															}
														?>
														<td><input type="number" class="form-control" name="realisasi[]"
															value="<?php echo $target; ?>" <?php echo $status ?>>
														</td>
														<td>
															<select class="form-control" name="realisasi_satuan[]">
																<option value="" <?= $target_satuan == '' ? 'selected' : '' ?>></option>
																<option value="Pcs" <?= $target_satuan == 'Pcs' ? 'selected' : '' ?>>Pcs</option>
																<option value="%" <?= $target_satuan == '%' ? 'selected' : '' ?>>%</option>
															</select>
														</td>
														<td><textarea style="resize: vertical; min-height: 30px;" class="form-control texarea-vertical" rows="1" name="alasan[]" <?php echo $status ?>><?php echo $l['Pekerjaan']; ?></textarea></td></tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-12 pull-left">
											<button type="reset" style="margin-right:3px" class="btn btn-primary" onclick="location.reload()" <?php echo $status ?>> <i class="fa fa-refresh"></i> Reset</button>
											<button type="submit" class="btn btn-primary" <?php echo $status ?>> <i class="fa fa-save"></i> Submit</button>
											<a href="<?= base_url('SPL/ListLembur') ?>"  class="btn btn-warning"> <i class="fa fa-arrow-circle-left"></i> Kembali</a>
										</div>
									</div>

								</div>

							</div>
						</div>
					</div>
				</form>

				<?php } } ?>

			</section>
		</div>
	</div>
	<script type="text/javascript">
		// need some idea
		window.onfocus = function() {
		  console.log('Got focus');
		  //window.location.reload();
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

		function setupTimers () {
		    document.addEventListener("mousemove", resetTimer(), false);
		    document.addEventListener("mousedown", resetTimer(), false);
		    document.addEventListener("keypress", resetTimer(), false);
		    document.addEventListener("touchmove", resetTimer(), false);

		    startTimer();
		}

		document.addEventListener("DOMContentLoaded",function(e){
			//setupTimers();
		});
	</script>
