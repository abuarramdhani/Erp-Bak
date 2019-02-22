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
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/DetailUrutanJdwl/Create') ?>">
											<?php if (isset($isi)){?>
											<div class="form-group text-center">
												<label class="label label-danger" style="font-size: 15pt;">Data Hari Dan Urutan Hersebut Sudah Ada</label>
											</div>
											<?php } ?>
											<div class="form-group">
												<label class="control-label col-lg-4">Hari</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtHariUrutanJdwl" style="width: 100%" data-placeholder="Hari" required>
														<option></option>
														<option value="1">Minggu</option> 
														<option value="2">Senin</option> 
														<option value="3">Selasa</option> 
														<option value="4">Rabu</option> 
														<option value="5">Kamis</option> 
														<option value="6">Jumat</option> 
														<option value="7">Sabtu</option> 
														<option value="L">Hari Libur</option> 
														<option value="P">Puasa</option> 
														<option value="PL">Libur Saat Puasa</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Urutan Jadwal</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtUrutanJdwl" style="width: 100%" data-placeholder="Urutan Jadwal" required>
														<option></option>
														<?php for ($i=1; $i <= $urutan['0']['jml']; $i++) { ?>
															<option value="<?php echo $i ?>"><?php echo $i ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Shift Yang Dilayani</label>
												<div class="col-lg-4 input-group">
													<div class="col-lg-4">
														<input type="checkbox" name="txtShift1" value="1">Shift 1
													</div>
													<div class="col-lg-4">
														<input type="checkbox" name="txtShift2" value="1">Shift 2
													</div>
													<div class="col-lg-4">
														<input type="checkbox" name="txtShift3" value="1">Shift 3
													</div>
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