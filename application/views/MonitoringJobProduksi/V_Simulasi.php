<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                        <div class="box-header">
                            <h2 style="font-weight:bold"><i class="fa fa-search"></i> <?= $Title?></h2>
                        </div>
                            <form method="post" action="<?php echo base_url("MonitoringJobProduksi/Monitoring/exportSimulasi")?>">
                            <div class="box-body" style="margin-top:-30px">
                                <div class="panel-body" style="font-size:17px">
                                    <div class="col-md-12">
                                        <div class="col-md-1">
                                            <label>Kategori </label>
                                        </div>
                                        <div class="col-md-3">
                                            : <?= $kategori?>
                                            <input type="hidden" name="kategori" value="<?= $kategori?>">
                                            <input type="hidden" name="tanggal" value="<?= $tanggal?>">
                                            <input type="hidden" name="bulan" value="<?= $bulan?>">
                                            <input type="hidden" id="item" name="item" value="<?= $item?>">
                                            <input type="hidden" name="deskripsi_item" value="<?= $desc?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-1">
                                            <label>Tanggal </label>
                                        </div>
                                        <div class="col-md-3">
                                            : <?= sprintf("%02d", $tanggal);?>/<?= $bulan?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body box box-info box-solid">
                                    <div class="col-md-2">
                                        <label>Kode Item : </label>
                                        <p><?= $item?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Deskripsi Item : </label>
                                        <p><?= $desc?></p>
                                    </div>
                                    <div class="col-md-6">
                                            <label>Qty :</label>
                                        <div class="input-group">
                                            <input type="number" id="qty" name="qty" class="form-control" value="<?= $plan?>">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn bg-orange" style="margin-left:15px" onclick="getSimulasiProduksi('')"><i class="fa fa-search"></i> Calculate</button>
                                            </span>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn bg-blue" style="margin-left:15px" onclick="getSimulasiProduksi('z')"><i class="fa fa-search"></i> Filter Z</button>
                                            </span>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success" style="margin-left:15px" onclick="getSimulasiProduksi('')"><i class="fa fa-refresh"></i> Reset</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" id="tbl_simulasi_produksi">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<form method="post">
<div class="modal fade" id="mdlGDSimulasi" role="dialog">
    <div class="modal-dialog" style="padding-left:5px;width:75%">
      <!-- Modal content-->
      <div class="modal-content">
            <div id="datamdlsimulasi"></div>
        <!-- <div class="modal-header" style="font-size:25px;background-color:#82E5FA">
            <i class="fa fa-list-alt"></i> Detail Gudang
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="datamdlsimulasi"></div>
        </div> -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>