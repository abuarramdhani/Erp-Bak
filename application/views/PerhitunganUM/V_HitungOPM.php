<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
							<div class="text-right">
								<h1><b>Perhitungan Utilitas Mesin OPM</b></h1>
							</div>
						</div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="HitungOPM/">
                                    <i aria-hidden="true" class="fa fa-refresh fa-2x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
								<h3><b><center>SELECT DATA PERHITUNGAN UTILITAS MESIN OPM</center></b></h3>
							</div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
									<label style="font-size: 15px"><?php echo date("l, d F Y") ?></label>
								</div>
                                <div class="form-group col-lg-12">
                                    <div class="col-md-4" style="text-align: right;">
										<label >Routing Class :</label>
									</div>
                                    <div class="col-md-4">
										<select id="routclass" name="routclass" class="form-control select2 slcRoclas" data-placeholder="Pilih Routing Class">
											<option></option>
                                            <option value="SHMT">SHMT</option>
											<option value="PTAS">PTAS</option>
										</select>
									</div>
                                </div>
                                <div class="form-group col-lg-12">
									<div class="col-md-4" style="text-align: right;">
										<label >Plan :</label>
									</div>
									<div class="col-md-4">
										<select id="planopm" name="planopm" class="form-control select2" data-placeholder="Pilih Plan">
											<option></option>
											<option value="5">Plan 1</option>
											<option value="1">Plan 2</option>
											<option value="4">Plan 3</option>
										</select>
									</div>
								</div>
                                <div class="form-group col-lg-12">
                                    <div class="col-md-4" style="text-align: right;">
										<label >Resource Code :</label>
									</div>
                                    <div class="col-md-4">
                                        <select id="rsrc" name="rsrc" class="form-control select2 slcRsrc" data-placeholder="Pilih Resource Code">
											<option></option>
										</select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <center>
                                            <button class="btn btn-warning btn-lg" id="findPUMopm" onclick="getPUMopm(this)" disabled="disabled">
                                                <i class="fa fa-search"></i> Find 
                                            </button>
                                        </center>
                                    </div>
							    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
					<div class="col-md-12" id="ResultPUMopm"></div>
				</div>
            </div>
        </div>
    </div>
</section>