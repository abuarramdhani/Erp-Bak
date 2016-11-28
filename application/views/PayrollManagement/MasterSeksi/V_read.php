<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Seksi</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterSeksi/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Read Master Seksi
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtKodesie" class="control-label col-lg-4">Kodesie</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKodesie" id="txtKodesie" class="form-control" value="<?php echo $kodesie; ?>" readonly/>
										</div>
									</div>
									<div class="form-group">
                                        <label for="txtDept" class="control-label col-lg-4">Dept</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtDept" id="txtDept" class="form-control" value="<?php echo $dept; ?>" readonly/>
										</div>
									</div>
									<div class="form-group">
                                        <label for="txtBidang" class="control-label col-lg-4">Bidang</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBidang" id="txtBidang" class="form-control" value="<?php echo $bidang; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtUnit" class="control-label col-lg-4">Unit</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtUnit" id="txtUnit" class="form-control" value="<?php echo $unit; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtSeksi" class="control-label col-lg-4">Seksi</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtSeksi" id="txtSeksi" class="form-control" value="<?php echo $seksi; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPekerjaan" class="control-label col-lg-4">Pekerjaan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPekerjaan" id="txtPekerjaan" class="form-control" value="<?php echo $pekerjaan; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtGolkerja" class="control-label col-lg-4">Golkerja</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtGolkerja" id="txtGolkerja" class="form-control" value="<?php echo $golkerja; ?>" readonly/>
                                        </div>
                                    </div>
								</div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>