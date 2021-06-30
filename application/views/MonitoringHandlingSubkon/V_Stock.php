<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-exchange"></i> <?= $Title?></b></div>
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
                                            <p style="margin: 5px 0 20px 0;"><label>Nama Subkon</label></p>
                                            <p style="margin: 5px 0 5px 0;"><label>Jenis Handling</label></p>
                                        </div>
                                        <div class="col-md-5">
                                            <p>
                                                <select class="form-control select2 jenisSub" name="slcSubStock" id="slcSubStock" style="width: 450px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <p>
                                                <select class="form-control select2 jenisHS" name="slcHanStock" id="slcHanStock" style="width: 450px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <!-- <a id="linkCetak" target="_blank" class="btn btn-primary" style="float: right;" onclick="cetak()">
                                                <i class="fa fa-file-pdf-o"> Cetak</i>
                                            </a> -->
                                            <button type="button" class="btn btn-primary" style="float: right;" onclick="checkStock()">
                                                <i class="fa fa-search"></i> Check
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="loadingArea2" style="display: none;">
                                  <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div id="tb_stock">
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade bd-example-modal-xl" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 50%;">
    <div class="modal-content" style="border-radius: 5px !important; background-color: transparent !important; box-shadow: none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float: left">
                  <h4 style="font-weight: bold;">EDIT SALDO AWAL</h4>
                  <input type="hidden" name="editLoc" id="editLoc">
                  <input type="hidden" name="editHanId" id="editHanId">
                </div>
                <button type="button" class="btn btn-danger" style="float: right; font-weight: bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <h4 id="editSubkon" style="font-weight: bold;"></h4>
                <h5 id="editNamaHandling"></h5><br>
                <div class="col-md-2">
                    <p style="margin: 5px 0 5px 0;"><label>Saldo Awal</label></p>
                </div>
                <div class="col-md-4">
                    <p>
                        <input type="number" name="txtEditSaldo" id="txtEditSaldo" class="form-control" required>
                    </p>
                </div>
              </div>
              <div class="box-footer with-border">
                <button type="button" class="btn btn-warning" style="float: right; font-weight: bold" onclick="editSaldo()">Edit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>