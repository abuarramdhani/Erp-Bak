<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b>Custom Report</b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Report/rekap');?>">
									<i class="icon-wrench icon-2x"></i>
									<span><br/></span>	
								</a>
							</div>
						</div>
					</div>
				</div>

				<br>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Custom Report</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="box-body">
								<form method="post" action="<?php echo base_url('ADMPelatihan/Report/prosesCustomReport')?>">
									<div class=" col-md-8">
										<div class="box-header with-border" style="margin-top: 10px">
									    	<h3 class="box-title"><i class="fa fa-calendar-check-o"></i>   PELATIHAN</h3>
									    </div>
									    <div class="col-md-6">
									    	<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Nama Pelatihan*</label>
													<div class="col-md-9">
														<select class="form-control js-slcNamaTraining select2" name="nama" id="nama"></select>
													</div>
												</div>
											</div>
											<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Tanggal*</label>
													<div class="col-md-9">
														<input name="tanggal_custom_report" id="tanggal_custom_report" class="form-control singledateADM_Range" title="RANGE TANGGAL TIDAK BOLEH DISET HARI INI" placeholder="Masukkan Tanggal" >
													</div>
												</div>
											</div>
											<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Seksi*</label>
													<div class="col-md-9">
														<select name="slcReportSection" class="form-control js-slcReportSection select2" id="slcReportSection">
														</select>
													</div>
												</div>
											</div>
											<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Unit*</label>
													<div class="col-md-9">
														<select name="slcReportUnit" class="form-control js-slcReportUnit select2" id="slcReportUnit">
														</select>
													</div>
												</div>
											</div>
											<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Departemen*</label>
													<div class="col-md-9">
														<select name="slcReportDepartemen" class="form-control js-slcReportDepartemen select2" id="slcReportDepartemen">
														</select>
													</div>
												</div>
											</div>
									    	<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Nomor Induk / Nama Pekerja*</label>
													<div class="col-md-9">
														<select name="slcReportEmployee" class="form-control js-slcReportEmployee select2" id="slcReportEmployee"></select>
													</div>
												</div>
											</div>
									    </div>
									    <div class="col-md-6">
											<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Trainer*</label>
													<div class="col-md-9">
														<select name="slcReportTrainer" class="form-control js-slcReportTrainer select2" id="slcReportTrainer"></select>
													</div>
												</div>
											</div>
											<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Nama Pembuat Report</label>
													<div class="col-md-9">
														<input type="text" name="txt_Nama_Pe_report" class="form-control">
													</div>
												</div>
											</div>
											<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<label class="col-md-3 control-label">Jabatan Pembuat Report</label>
													<div class="col-md-9">
														<input type="text" name="txt_Jabatan_Pe_report" class="form-control">
													</div>
												</div>
											</div>
											<div class="row" style="margin: 10px 10px">
												<div class="form-group">
													<div class="col-md-12" style="text-align: center">
														<button type="submit" class="btn btn-info btn btn-flat">Proses</button>
													</div>
												</div>
											</div>
									    </div>
									</div>
									<div class="col-md-4">
										<div class="row">	
											<div class="box-header with-border" style="margin-top: 10px">
										     	<h3 class="box-title"><i class="fa fa-check-square-o"></i>   DATA YANG DITAMPILKAN</h3>
										    </div>
										    <div class="col-md-4">
										    	<div class="checkbox">
													<label><input type="checkbox" name="chk_eval_pembelajaran" value="1"> Pembelajaran</label><br>
													<label><input type="checkbox" name="chk_eval_perilaku" value="1"> Perilaku</label><br>
												</div>
										    </div>
										</div>
										<div class="row">
										    <div class="box-header with-border" style="margin-top: 10px">
										     	<h3 class="box-title"><i class="fa fa-check-square-o"></i>   KHUSUS SEKSI PELATIHAN</h3>
										    </div>
										    <div class="col-md-4">
											    <div class="checkbox">
													<label><input type="checkbox" name="chk_eval_reaksi1" value="1"><font color="green"> Eval Reaksi</font></label><br>
													<label><input type="checkbox" name="chk_eval_reaksi2" value="1"><font color="green"> Nama Pelatihan</font></label><br>
													<label><input type="checkbox" name="chk_eval_reaksi3" value="1"><font color="green"> Tanggal</font></label><br>
													<label><input type="checkbox" name="chk_eval_reaksi4" value="1"><font color="green"> Trainer</font></label><br>
												</div>
												*boleh dikosongkan
											</div>
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
</section>