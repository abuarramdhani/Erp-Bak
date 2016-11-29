<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Status Kerja</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterStatusKerja/');?>">
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
                                Read Master Status Kerja
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtKdStatusKerja" class="control-label col-lg-4">Kode Status Kerja</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKdStatusKerja" id="txtKdStatusKerja" class="form-control" value="<?php echo $kd_status_kerja; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtStatusKerja" class="control-label col-lg-4">Status Kerja</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtStatusKerja" id="txtStatusKerja" class="form-control" value="<?php echo $status_kerja; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtStatusKerjaSingkat" class="control-label col-lg-4">Status Kerja Singkat</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtStatusKerjaSingkat" id="txtStatusKerjaSingkat" class="form-control" value="<?php echo $status_kerja_singkat; ?>" readonly/>
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