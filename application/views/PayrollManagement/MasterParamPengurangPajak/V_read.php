<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Pengurang Pajak</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParamPengurangPajak/');?>">
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
                                Read Set Pengurang Pajak
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
<div class="form-group">
                                            <label for="txtPeriodePengurangPajak" class="control-label col-lg-4">Periode Pengurang Pajak</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPeriodePengurangPajak" id="txtPeriodePengurangPajak" class="form-control" value="<?php echo $periode_pengurang_pajak; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtMaxJab" class="control-label col-lg-4">Max Jab</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtMaxJab" id="txtMaxJab" class="form-control" value="<?php echo $max_jab; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtPersentaseJab" class="control-label col-lg-4">Persentase Jab</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPersentaseJab" id="txtPersentaseJab" class="form-control" value="<?php echo $persentase_jab; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtMaxPensiun" class="control-label col-lg-4">Max Pensiun</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtMaxPensiun" id="txtMaxPensiun" class="form-control" value="<?php echo $max_pensiun; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtPersentasePensiun" class="control-label col-lg-4">Persentase Pensiun</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPersentasePensiun" id="txtPersentasePensiun" class="form-control" value="<?php echo $persentase_pensiun; ?>" readonly/>
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