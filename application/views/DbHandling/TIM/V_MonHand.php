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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DbHandling/MonitoringHandling'); ?>">
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
                        <div class="box box-warning">
                            <div class="box-header with-border" style="font-weight: bold;">REQUEST HANDLING</div>
                            <div class="box-body">
                                <div class="col-md-12" style="font-weight: bold;text-align:center">
                                    <h4>BARU</h4>
                                </div>
                                <div class="col-md-12" id="tabel_reqhand"></div>
                                <div class="col-md-12" style="font-weight: bold;text-align:center">
                                    <h4>REVISI</h4>
                                </div>
                                <div class="col-md-12" id="tabel_reqhand2"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border" style="font-weight: bold;">DATA SARANA HANDLING</div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-3"><input type="text" class="form-control input-sm" id="searchboxdatatable" placeholder="Search By ...."></div>
                                    <div class="col-md-3">
                                        <select class="form-control input-sm select2" id="filterselected" data-placeholder="Filter By" onchange="showfilter()">
                                            <option></option>
                                            <option value="1">By Produk</option>
                                            <option value="2">By Sarana</option>
                                            <option value="3">By Seksi</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3" style="display: none;" id="showifbyprod">
                                        <select style="width: 100%;" onchange="onchangefilter()" class="form-control input-sm select2 selectajah" id="filterproduk" data-placeholder="Filter By Produk">
                                            <option></option>
                                            <?php foreach ($filterbyproduk as $key => $value) { ?>
                                                <option value="<?= $value['kode_produk'] ?>"><?= $value['nama_produk'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="display: none;" id="showifbysarana">
                                        <select style="width: 100%;" onchange="onchangefilter()" class="form-control input-sm select2 selectajah" id="filtersarana" data-placeholder="Filter By Sarana Handling">
                                            <option></option>
                                            <?php foreach ($filterbysarana as $key => $value) { ?>
                                                <option value="<?= $value['id_master_handling'] ?>"><?= $value['kode'] ?> - <?= $value['nama'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="display: none;" id="showifbyseksi">
                                        <select style="width: 100%;" onchange="onchangefilter()" class="form-control input-sm select2 selectajah" id="filterseksi" data-placeholder="Filter By Seksi">
                                            <option></option>
                                            <?php foreach ($filterbyseksi as $key => $value) { ?>
                                                <option value="<?= $value['seksi'] ?>"><?= $value['seksi'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2"><button class="btn btn-danger btn-sm" onclick="reset()">Reset</button></div>

                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" id="tabel_datahand"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
<!-- Modal Img Carousel -->
<div class="modal fade" id="modalcarousel" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Foto Handling</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="imgcar"></div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Proses Handling -->
<div class="modal fade" id="modalproseshandling" role="dialog">
    <div class="modal-dialog" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Proses</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="prosess"></div>
            </div>
        </div>

    </div>
</div>