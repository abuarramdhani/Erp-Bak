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
									<div class=" col-md-4">
										<div class="box-header with-border" style="margin-top: 10px">
									      <h3 class="box-title"><i class="fa fa-calendar-check-o"></i>   PELATIHAN</h3>
									    </div>
									   <div class="row" style="margin: 10px 10px">
											<div class="form-group">
												<label class="col-md-3 control-label">Judul Training</label>
												<div class="col-md-9">
													<select class="form-control js-slcNamaTraining select2" name="nama" id="nama"></select>
												</div>
											</div>
										</div>
										<div class="row" style="margin: 10px 10px">
											<div class="form-group">
												<label class="col-md-3 control-label">Tanggal</label>
												<div class="col-md-9">
													<input name="tanggal_custom_report" id="tanggal_custom_report" class="form-control singledateADM_Range" title="RANGE TANGGAL TIDAK BOLEH DISET HARI INI" placeholder="Masukkan Tanggal" >
												</div>
											</div>
										</div>
										<div class="row" style="margin: 10px 10px">
											<div class="form-group">
												<label class="col-md-3 control-label">Seksi</label>
												<div class="col-md-9">
													<select name="slcReportSection" class="form-control js-slcReportSection select2" id="slcReportSection">
													</select>
												</div>
											</div>
										</div>
										<div class="row" style="margin: 10px 10px">
											<div class="form-group">
												<label class="col-md-3 control-label">Nomor Induk</label>
												<div class="col-md-9">
													<select name="slcReportEmployee" class="form-control js-slcReportEmployee select2" id="slcReportEmployee"></select>
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
									<div class="col-md-8">
										<div class="box-header with-border" style="margin-top: 10px">
									     	<h3 class="box-title"><i class="fa fa-check-square-o"></i>   DATA YANG DITAMPILKAN</h3>
									    </div>
									    <div class="col-md-4">
											<div class="checkbox">
												<label><input type="checkbox" name="chk_nama_pekerja" value="1"> Nama Pekerja</label><br>
												<label><input type="checkbox" name="chk_nomor_induk" value="1"> Nomor Induk</label><br>
												<label><input type="checkbox" name="chk_seksi" value="1"> Seksi</label><br>
												<label><input type="checkbox" name="chk_unit" value="1"> Unit</label><br>
												<label><input type="checkbox" name="chk_departemen" value="1"> Departemen</label><br>
												<label><input type="checkbox" name="chk_nama_pelatihan" value="1"> Nama Pelatihan</label><br>
												<label><input type="checkbox" name="chk_trainer" value="1"> Trainer</label><br>
												<label><input type="checkbox" name="chk_eval_pembelajaran" value="1"> Pembelajaran</label><br>
												<label><input type="checkbox" name="chk_eval_perilaku" value="1"> Perilaku</label><br>
												<label><input type="checkbox" name="chk_tanggal" value="1"> Tanggal</label><br>
											</div>
									    </div>
									    <div class="col-md-4">
											<label>KHUSUS SEKSI PELATIHAN</label>
											<div class="checkbox">
												<label><input type="checkbox" name="chk_eval_reaksi1" value="1"><font color="green"> Eval Reaksi</font></label><br>
												<label><input type="checkbox" name="chk_eval_reaksi2" value="1"><font color="green"> Nama Pelatihan</font></label><br>
												<label><input type="checkbox" name="chk_eval_reaksi3" value="1"><font color="green"> Tanggal</font></label><br>
												<label><input type="checkbox" name="chk_eval_reaksi4" value="1"><font color="green"> Trainer</font></label><br>
											</div>
									    </div>
									    <div class="col-md-4">
									    	<label>KETERANGAN LAIN</label>
									    	<br>
											<label> Nama Pembuat Report
											<input class="form-group" type="text" name="txt_Nama_Pe_report"></label>
											<label> Jabatan Pembuat Report
											<input class="form-group" type="text" name="txt_Jabatan_Pe_report"></label>
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