<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SiteManagement');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>Tambah Data</b>
                            </div>
                            <div class="box-body">
                                <form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/RecordData/SimpanSedotWC'); ?>">
                                    <div class="col-md-12 text-center">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Tanggal</label>
                                            <div class="col-md-4" align="center">
                                                <input type="text" id="sm-tanggal" class="form-control sm-tgl" name="txtTanggal" placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Hari</label>
                                            <div class="col-md-4" align="center">
                                                <input readonly type="text" class="form-control sm-hari" name="txtHari">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Lokasi</label>
                                            <div class="col-md-4" align="center">
                                                <!-- <input type="text" class="form-control" name="txtSeksi"> -->
                                                <select class="form-control sm-pilihlokasi" name="txtLokasi">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Seksi Pemakai</label>
                                            <div class="col-md-4" align="center">
                                                <!-- <input type="text" class="form-control" name="txtSeksi"> -->
                                                <select class="form-control sm-pilihSeksi" name="txtSeksi">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Jumlah Sedot WC</label>
                                            <div class="col-md-4" align="center">
                                                <input type="text" class="form-control" name="txtJumlah">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Pemberi Order</label>
                                            <div class="col-md-4" align="center">
                                                <input type="text" class="form-control" name="txtOrder">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center panel-footer" style="margin-top: 30px">
                                        <button type="submit" class="btn btn-primary btn-lg pull-right">Simpan</button>
                                        <a href="<?php echo site_url('SiteManagement/RecordData/JasaSedotWC'); ?>" class="btn btn-warning btn-lg pull-right" style="margin-right: 5px">Back</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>