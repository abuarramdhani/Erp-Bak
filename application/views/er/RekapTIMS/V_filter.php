<section class="content-header">
	<h1>
		Rekap TIMS Kebutuhan Promosi Pekerja
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="table-responsive">
					<fieldset class="row2">
						<div class="box-body with-border">
							<form id="filter-rekap" method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/show-data')?>">
								<div class="form-group">
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Periode</label>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														From
													</div>
												<input type="text" id="rekapBegin" class="form-control" name="rekapBegin" required>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														To
													</div>
												<input type="text" id="rekapEnd" class="form-control" name="rekapEnd" required>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Status Hubungan Kerja</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-briefcase"></i>
													</div>
													<select data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name ="statushubker" required>
														<option value=""><option>
														<?php foreach ($status as $status_item){
														?>
															<option value="<?php echo $status_item['fs_noind'];?>"><?php echo $status_item['fs_noind'].' - '.$status_item['fs_ket'];?></option>
													<?php } ?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Departemen</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select id="departemen_select" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="departemen" required>
														<option value=""></option>
														<option value="All">ALL</option>
														<?php foreach ($dept as $dept_item){
														?>
															<option value="<?php echo $dept_item['Dept'];?>"><?php echo $dept_item['Dept'];?></option>
													<?php } ?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Bidang</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select id="bidang_select" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="bidang" required disabled>
														<option value=""></option>
														

													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Unit</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select id="unit_select" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="unit" required disabled>
														<option value=""></option>
														
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-3">
											<label class="control-label">Seksi</label>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select id="section_select" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="section" required disabled>
														<option value=""></option>
														<option value="0" disabled>Pilih Unit terlebih dahulu</option>
														
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px;vertical-align: middle">
										<div class="col-md-7">
											<div id="loadingAjax"></div>
										</div>
										<div class="col-md-3">
											<div class="form-group" style="vertical-align: middle">
												<div class="checkbox">
													<label>
														<input id="toggle_button" name="detail" type="checkbox" value="1">
														Tampilkan Detail Data TIMS
													</label>
												</div>
											</div>
										</div>
										<div class="col-md-1">
											<span id="submit-filter-rekap" class="btn btn-primary pull-right" style="vertical-align: middle">
												PROSES
											</span>
										</div>
									</div>
								</div>
							</form>
							<div id="table-div">
								
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</section>