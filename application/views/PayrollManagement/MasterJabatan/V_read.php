<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Jabatan</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterJabatan/');?>">
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
                                Read Master Jabatan
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtKdJabatan" class="control-label col-lg-4">Kode Jabatan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKdJabatan" id="txtKdJabatan" class="form-control" value="<?php echo $kd_jabatan; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtJabatan" class="control-label col-lg-4">Jabatan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtJabatan" id="txtJabatan" class="form-control" value="<?php echo $jabatan; ?>" readonly/>
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