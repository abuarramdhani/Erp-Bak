<input type="hidden" id="app_his_bppbg_2021" value="">
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-television"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <p style="margin: 5px 0 20px 0;"><label>Subinventory</label></p>
                                            <p style="margin: 5px 0 20px 0;"><label>Item</label></p>
                                            <p style="margin: 5px 0 20px 0;"><label>Status</label></p>
                                            <p style="margin: 5px 0 5px 0;"><label>Tanggal</label></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>
                                                <select class="form-control select2 subinv" name="slcSubinv" id="slcSubinv" style="width: 200px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <p>
                                                <select class="form-control select2 item_his_bppbg" name="slcItem" id="slcItem" style="width: 700px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <p>
                                                <select class="form-control select2" name="slcStatus" id="slcStatus" style="width: 300px;" required>
                                                    <option value="SEMUA">SEMUA</option>
                                                    <option value="O">TRANSACT BERHASIL</option>
                                                    <option value="X">TRANSACT BERMASALAH</option>
                                                    <option value="S">TRANSACT SEBAGIAN</option>
                                                    <option value="B">BON BARU & BELUM DI-TRANSACT</option>
                                                </select>
                                            </p>
                                            <p>
                                                <input type="text" class="date form-control" name="slcDate" id="slcDate" style="width: 300px;" autocomplete="off">
                                            </p>
                                            <button type="button" class="btn btn-primary" style="float: right;" onclick="cari()">
                                                <i class="fa fa-search"></i> Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="loadingArea" style="display: none;">
                                  <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div id="tb_monitoring">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL -->
<div class="modal fade bd-example-modal-xl" id="detailBon" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 90%;">
    <div class="modal-content" style="border-radius: 5px !important; background-color: transparent !important; box-shadow: none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float: left">
                  <h4 style="font-weight: bold;">DETAIL BON <span id="noBon"></span></h4>
                </div>
                <button type="button" class="btn btn-danger" style="float: right; font-weight: bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                  <div id="loadingAreaDetail" style="display: none;">
                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                  </div>
                  </center>
                  <div id="tb_detail">

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
