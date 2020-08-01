<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border" style="font-weight: bold;"></div>
                            <div class="box-body">
                                <form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: right;"><label>Last Rev Date : 06 Juni 2020</label></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Next Rev No</label></div>
                                        <div class="col-md-4" style="text-align: left;">00</div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Kode Komponen</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Nama Dokumen</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Status Komponen</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Produk</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Sarana</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Qty / Handling</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Berat</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Seksi</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Proses</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-6" style="text-align: left;">
                                            <button formaction="<?php echo base_url('DbHandling/MonitoringHandling'); ?>" class="btn btn-default">Back</button>
                                        </div>
                                        <div class="col-md-6" style="text-align: right;">
                                            <a onclick="reject()" class="btn btn-danger">Reject</a>
                                            <a onclick="acc()" class="btn btn-success">Acc</a>
                                        </div>
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