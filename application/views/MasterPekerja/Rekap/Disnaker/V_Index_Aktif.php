<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-5">
                            <div class="text-right"><h1><b><?=$Title?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    
                                        <div class="col-md-4">
                                            <div class="col-md-5">
                                                <label style="margin-top: 5px;">Lokasi Kerja</label>
                                            </div>
                                            <div class="col-md-7">
                                            <select class="form-control mpk_dpaslc" style="width: 100%" name="lokasi">
                                                    <option value="00">SEMUA LOKASI</option>
                                                    <?php foreach ($loker as $key): ?>
                                                        <option value="<?=$key->id_?>"><?=$key->lokasi_kerja?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Tanggal</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control mpk_rknopr" name="tanggal">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-primary mpk_btnajxdisn" value="aktif">
                                            Lihat
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" hidden="" id="tbl_divdishidd">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body" id="mpk_divftbldis">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif'); ?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>