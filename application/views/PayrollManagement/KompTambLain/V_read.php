<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Komp Tamb</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/KompTamb/');?>">
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
                                Read Komp Tamb
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
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTambahan" class="control-label col-lg-4">Tambahan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTambahan" id="txtTambahan" class="form-control" value="<?php echo $tambahan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtStat" class="control-label col-lg-4">Stat</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtStat" id="txtStat" class="form-control" value="<?php echo $stat; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtDesc" class="control-label col-lg-4">Desc </label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtDesc" id="txtDesc" class="form-control" value="<?php echo $desc_; ?>" readonly/>
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