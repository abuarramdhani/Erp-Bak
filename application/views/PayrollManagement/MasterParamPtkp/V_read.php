<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Tarif Ptkp</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParamPtkp/');?>">
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
                                Read Set Tarif Ptkp
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtPeriode" class="control-label col-lg-4">Periode</label>
                                        <div class="col-lg-4">
											<input type="text" name="txtPeriode" id="txtPeriode" class="form-control" value="<?php echo $periode; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtStatusPajak" class="control-label col-lg-4">Status Pajak</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtStatusPajak" id="txtStatusPajak" class="form-control" value="<?php echo $status_pajak; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPtkpPerTahun" class="control-label col-lg-4">PTKP Per Tahun</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPtkpPerTahun" id="txtPtkpPerTahun" class="form-control" value="<?php echo $ptkp_per_tahun; ?>" readonly/>
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