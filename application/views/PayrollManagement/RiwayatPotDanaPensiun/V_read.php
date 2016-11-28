<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Riwayat Pot Dana Pensiun</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatPotDanaPensiun/');?>">
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
                                Read Riwayat Pot Dana Pensiun
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
<div class="form-group">
                                            <label for="txtTglBerlaku" class="control-label col-lg-4">Tgl Berlaku</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglBerlaku" id="txtTglBerlaku" class="form-control" value="<?php echo $tgl_berlaku; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglTberlaku" class="control-label col-lg-4">Tgl Tberlaku</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglTberlaku" id="txtTglTberlaku" class="form-control" value="<?php echo $tgl_tberlaku; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtPotPensiun" class="control-label col-lg-4">Pot Pensiun</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPotPensiun" id="txtPotPensiun" class="form-control" value="<?php echo $pot_pensiun; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKdPetugas" class="control-label col-lg-4">Kd Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdPetugas" id="txtKdPetugas" class="form-control" value="<?php echo $kd_petugas; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglJamRecord" class="control-label col-lg-4">Tgl Jam Record</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglJamRecord" id="txtTglJamRecord" class="form-control" value="<?php echo $tgl_jam_record; ?>" readonly/>
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