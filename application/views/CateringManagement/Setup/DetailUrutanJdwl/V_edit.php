<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('CateringManagement/DetailUrutanJdwl') ?>" class="btn btn-default btn-lg">
									<span class="icon-wrench icon-2x"></span>
								</a>
							</div>
						</div>
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
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/DetailUrutanJdwl/Edit/'.$linkdata) ?>">
											<?php if (isset($isi)){?>
											<div class="form-group text-center">
												<label class="label label-danger" style="font-size: 15pt;">Data Hari Dan Urutan Tersebut Sudah Ada</label>
											</div>
											<?php } ?>
											<div class="form-group">
												<label class="control-label col-lg-4">Hari</label>
												<div class="col-lg-4">
													<input type="text" name="txtHari" class="form-control" value="<?php
													$hari = array("","Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
													 echo $hari[$DetailUrutanJdwl['0']['fs_hari']]; ?>" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Urutan Jadwal</label>
												<div class="col-lg-4">
													<input type="text" name="txtUrutan" class="form-control" value="<?php echo $DetailUrutanJdwl['0']['fn_urutan_jadwal']; ?>" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Shift Yang Dilayani</label>
												<div class="col-lg-4 input-group">
													<div class="col-lg-4">
														<input type="checkbox" <?php if($DetailUrutanJdwl['0']['fs_tujuan_shift1'] == '1'){ echo "checked";} ?> name="txtShift1" value="1">Shift 1
													</div>
													<div class="col-lg-4">
														<input type="checkbox" <?php if($DetailUrutanJdwl['0']['fs_tujuan_shift2'] == '1'){ echo "checked";} ?> name="txtShift2" value="1">Shift 2
													</div>
													<div class="col-lg-4">
														<input type="checkbox" <?php if($DetailUrutanJdwl['0']['fs_tujuan_shift3'] == '1'){ echo "checked";} ?> name="txtShift3" value="1">Shift 3
													</div>
													<!-- txtrun untuk submit ketika uncheck semua tidak bisa di submit -->
													<input type="hidden" name="txtrun">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<a href="javascript:history.back(1);" class="btn btn-primary">Back</a>
													<button class="btn btn-primary" type="submit">Submit</button>
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