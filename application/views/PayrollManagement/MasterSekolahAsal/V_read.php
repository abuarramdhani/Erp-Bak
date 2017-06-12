<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Sekolah Asal</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterSekolahAsal/');?>">
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
                                Read Master Sekolah Asal
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtNoInd" class="control-label col-lg-4">No Induk</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtNoInd" id="txtNoInd" class="form-control" value="<?php echo $noind; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPendidikan" class="control-label col-lg-4">Pendidikan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPendidikan" id="txtPendidikan" class="form-control" value="<?php echo $pendidikan; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtSekolah" class="control-label col-lg-4">Sekolah</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtSekolah" id="txtSekolah" class="form-control" value="<?php echo $sekolah; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtJurusan" class="control-label col-lg-4">Jurusan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtJurusan" id="txtJurusan" class="form-control" value="<?php echo $jurusan; ?>" readonly/>
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