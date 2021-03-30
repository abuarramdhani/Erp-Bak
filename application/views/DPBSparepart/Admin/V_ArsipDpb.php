<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringPelayananSPB/Arsip/'); ?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>Arsip</b></div>
                            <div class="box-body" id="view_arsippp">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time() + 60 * 60 * 7) ?></label>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-1"><label>Tanggal</label></div>
                                    <div class="col-md-2"><input class="form-control datespbeh" placeholder="Tgl Selesai Packing" type="text" id="dtfrmsp"></div>
                                    <div class="col-md-1"><label>Sampai</label></div>
                                    <div class="col-md-2"><input class="form-control datespbeh" placeholder="Tgl Selesai Packing" type="text" id="dtotsp"></div>
                                    <div class="col-md-1"><button class="btn btn-info" onclick="SearchArsSPBDO()">Search</button></div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div id="arsipDepebeh">
                                        </div>
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