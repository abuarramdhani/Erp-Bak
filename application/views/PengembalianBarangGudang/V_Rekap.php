<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-file"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label class="text-right">Tanggal Awal</label>
                                        <input id="tgl_awal" name="tgl_awal" class="form-control pull-right datePBGRekap" placeholder="yyyy-mm-dd" autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-right">Tanggal Akhir</label>
                                        <div class="input-group">
                                            <input id="tgl_akhir" name="tgl-akhir" class="form-control pull-right datePBGRekap" placeholder="yyyy-mm-dd" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button type="button" onclick="SearchRekapPBG(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;">
                                                    <i class="fa fa-2x fa-arrow-circle-right" ></i>
                                                </button>    
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" id="tblRekapPBG">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>