<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Parameter Tarif Pph</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParameterTarifPph/');?>">
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
                                Read Master Parameter Tarif Pph
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtKdPph" class="control-label col-lg-4">Kode PPH</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKdPph" id="txtKdPph" class="form-control" value="<?php echo $kd_pph; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBatasBawah" class="control-label col-lg-4">Batas Bawah</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBatasBawah" id="txtBatasBawah" class="form-control" value="<?php echo $batas_bawah; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBatasAtas" class="control-label col-lg-4">Batas Atas</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBatasAtas" id="txtBatasAtas" class="form-control" value="<?php echo $batas_atas; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPersen" class="control-label col-lg-4">Persen</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPersen" id="txtPersen" class="form-control" value="<?php echo $persen; ?>" readonly/>
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