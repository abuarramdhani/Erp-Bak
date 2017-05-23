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
										<div class="col-md-2">
											<label class="control-label">Status Karyawan</label>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<div class="input-group">
													<select class="form-control" name="slcStatus" id="slcStatus" required>
														<option value="0" selected>Aktif</option>
														<option value="1">Keluar</option>
													</select>
												</div>
											</div>
										</div>
									</div>								
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-2">
											<label class="control-label">Periode</label>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														From
													</div>
												<input type="text" id="rekapBegin" class="form-control" name="rekapBegin" required>
												</div>
											</div>
										</div>
										<div class="col-md-5">
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
										<div class="col-md-2">
											<label class="control-label">Pekerja</label>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select class="form-control js-slcNoInduk" name="slcNoInduk[]" id="slcNoInduk" multiple="multiple" required>
														<option value=""></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px;vertical-align: middle">
										<div class="col-md-8">
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
											<span id="submit-filter-no-induk" class="btn btn-primary pull-right" style="vertical-align: middle">
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