<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:25px"><b><i class="fa fa-support"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <div class="col-md-12 text-center">
                                        <h3>TARGET</h3>
                                        <h3 style="font-weight:bold">100 PCS / Shift</h3>
                                    </div>
                                </div>
                                <div class="panel-body  box box-info box-solid">
                                    <div class="col-md-12 text-center">
                                        <h3>PERSIAPAN</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-9" id="persiapan_line1"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-9" id="persiapan_line2"></div>
                                    </div>
                                </div>
                                <div class="panel-body  box box-success box-solid">
                                    <div class="col-md-12 text-center">
                                        <h3>PASANG BAN</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-9" id="pasang_line1"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-9" id="pasang_line2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>