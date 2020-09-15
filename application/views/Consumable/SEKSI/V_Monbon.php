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
                                <a class="btn btn-default btn-lg">
                                    <i class="fa fa-list fa-2x">
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
                        <div class="box box-info">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-1"><label>Seksi</label></div>
                                        <div class="col-md-4"><input type="text" class="form-control" id="seksibonseksi" value="<?= $seksi ?>" readonly /></div>
                                        <div class="col-md-1"><label>Periode</label></div>
                                        <div class="col-md-3"><input id="periodebonseksi" type="text" class="form-control periodebonn" autocomplete="off" placeholder="Periode Bon" required /></div>
                                        <div class="col-md-2"><button class="btn btn-default" onclick="caridatabonseksi()">Lihat</button></div>
                                    </div>
                                </div>
                                <div class="panel-body" id="tblmonitor"></div>
                                <div class="row">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>