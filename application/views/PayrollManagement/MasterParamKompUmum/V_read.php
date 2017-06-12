<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Komponen Gaji Umum</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParamKompUmum/');?>">
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
                                Read Set Komponen Gaji Umum
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
<div class="form-group">
                                            <label for="txtUm" class="control-label col-lg-4">UM</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtUm" id="txtUm" class="form-control" value="<?php echo $um; ?>" readonly/>
                                            </div>
                                        </div>

<div class="form-group">
                                            <label for="txtUbt" class="control-label col-lg-4">UBT</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtUbt" id="txtUbt" class="form-control" value="<?php echo $ubt; ?>" readonly/>
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