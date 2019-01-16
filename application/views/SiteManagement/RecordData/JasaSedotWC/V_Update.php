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
                                <form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/RecordData/UpdateSedotWC'); ?>">
                                <?php foreach ($editwc as $key) { ?>
                                    <div class="col-md-12 text-center">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Tanggal</label>
                                            <div class="col-md-4" align="center">
                                                <input type="text" class="form-control sm-tgl" name="txtTanggal" value="<?php echo $key['tanggal']; ?>">
                                                <input hidden type="text" class="" name="txtId" value="<?php echo $key['id']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Hari</label>
                                            <div class="col-md-4" align="center">
                                                <input readonly type="text" class="form-control sm-hari" name="txtHari" value="<?php echo $key['hari']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Lokasi</label>
                                            <div class="col-md-4" align="center">
                                                <!-- <input type="text" class="form-control" name="txtSeksi"> -->
                                                <select class="form-control sm-pilihlokasi" name="txtLokasi">
                                                    <option selected value="<?php echo $key['lokasi']; ?>"><?php echo $key['lokasi']; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Seksi Pemakai</label>
                                            <div class="col-md-4" align="center">
                                                <!-- <input type="text" class="form-control" name="txtSeksi" value="<?php echo $key['seksi']; ?>"> -->
                                                <select class="form-control sm-pilihSeksi" name="txtSeksi">
                                                    <option selected value="<?php echo $key['seksi']; ?>"><?php echo $key['seksi']; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Jumlah Sedot WC</label>
                                            <div class="col-md-4" align="center">
                                                <input type="text" class="form-control" name="txtJumlah" value="<?php echo $key['jumlah']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Pemberi Order</label>
                                            <div class="col-md-4" align="center">
                                                <input type="text" class="form-control" name="txtOrder" value="<?php echo $key['pemberi_order']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
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