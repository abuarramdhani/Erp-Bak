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
                                <form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/RecordData/SimpanTimbanganSampah'); ?>">
                                    <div class="col-md-6 text-center">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Nomor Urut</label>
                                            <div class="col-md-8" align="center">
                                                <input type="text" class="form-control" name="txtNoUrut">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Tanggal Timbangan</label>
                                            <div class="col-md-8" align="center">
                                                <input required type="text" id="sm-tanggal" class="form-control sm-tgl" name="txtTglTimbang" placeholder="YYYY-MM-DD" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">No Kendaraan</label>
                                            <div class="col-md-8" align="center">
                                                <input type="text" class="form-control toupper" name="txtNoKendaraan">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Asal Sampah</label>
                                            <div class="col-md-8" align="center">
                                                <input type="text" class="form-control" name="txtAsalSampah">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Jenis Mobil</label>
                                            <div class="col-md-8" align="center">
                                                <input type="text" class="form-control toupper" name="txtJenisMobil">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Sopir</label>
                                            <div class="col-md-8" align="center">
                                                <input type="text" class="form-control" name="txtSopir">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Berat Timbangan 1 (kg)</label>
                                            <div class="col-md-8" align="center">
                                                <input type="text" class="form-control num" name="txtBerat1">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Berat Timbangan 2 (kg)</label>
                                            <div class="col-md-8" align="center">
                                                <input type="text" class="form-control num" name="txtBerat2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Berat Timbangan Netto (kg)</label>
                                            <div class="col-md-8" align="center">
                                                <input type="text" class="form-control num" name="txtBeratNetto">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Waktu Timbangan</label>
                                            <div class="col-md-8" align="center">
                                                <input required type="text" class="form-control sm-wktim" placeholder="__:__:__" data-inputmask="'mask': '99:99:99'" name="txtWktTimbangan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center panel-footer" style="margin-top: 30px">
                                        <button type="submit" class="btn btn-primary btn-lg pull-right">Simpan</button>
                                        <a href="<?php echo site_url('SiteManagement/RecordData/TimbanganSampah'); ?>" class="btn btn-warning btn-lg pull-right" style="margin-right: 5px">Back</a>
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