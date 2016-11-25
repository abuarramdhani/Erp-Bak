<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Gaji UMP</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/SetGajiUMP/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span><br/></span>
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
                               Read Set Tarif Pekerja Sakit
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtKdTarif" class="control-label col-lg-4">Kode Tarif</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKdTarif" id="txtKdTarif" class="form-control" value="<?php echo $kd_tarif; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtTingkatan" class="control-label col-lg-4">Tingkatan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtTingkatan" id="txtTingkatan" class="form-control" value="<?php echo $tingkatan; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBulanAwal" class="control-label col-lg-4">Bulan Awal</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBulanAwal" id="txtBulanAwal" class="form-control" value="<?php echo $bulan_awal; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBulanAkhir" class="control-label col-lg-4">Bulan Akhir</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBulanAkhir" id="txtBulanAkhir" class="form-control" value="<?php echo $bulan_akhir; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPersentase" class="control-label col-lg-4">Persentase</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPersentase" id="txtPersentase" class="form-control" value="<?php echo $persentase; ?>" readonly/>
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