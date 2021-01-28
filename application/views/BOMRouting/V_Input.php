<section class="content">
  <div class="inner">
    <div class="row">
      <form method="post" action="<?php echo base_url('PendaftaranBomRouting/InputBOMRouting/Create') ?>" autocomplete="off">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
              <div class="col-lg-11">
                <div class="text-right">
                  <h1>
                    <b>
                      <?php echo $Title ?>
                    </b>
                  </h1>
                </div>
              </div>
              <div class="col-lg-1 ">
                <div class="text-right hidden-md hidden-sm hidden-xs">
                  <a class="btn btn-default btn-lg" href="">
                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
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
          <br />
          <div class="row">
            <div class="col-lg-12">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <h4>Header</h4>
                </div>
                <div class="panel-body">
                  <div id="1by1" class="tab-pane fade in">
                    <div class="row">
                      <div class="col-md-6">
                        <!-- <div class="form-group">
                          <label>Nomor Dokumen</label>
                          <input class="form-control" type="text" name="txtNoDokumen" id="txtNoDokumen" placeholder="Type">
                        </div> -->
                        <div class="form-group">
                          <label for="usr">Tanggal Pembuatan</label>
                          <input type="text" class="form-control" name="txtTanggalPembuatan" placeholder="Kode Barang" value="<?php echo date('Y-m-d') ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="usr">Nama Barang:</label>
                          <input type="text" class="form-control" name="txtNamaBarang" placeholder="Nama Barang" >
                        </div>
                        <div class="form-group">
                          <label for="usr">Seksi:</label>
                          <select class="form-control select2" id="txtSeksiHeader" name="txtSeksi" data-placeholder="Product">
                            <option>lorem 2</option>
                            <option value="">lorem</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="usr">Pilih IO</label>
                          <select class="form-control select2" id="txtProductIdHeader" name="txtIO" data-placeholder="Product">
                            <option>lorem 2</option>
                            <option value="">lorem</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usr">Kode Item (Parent)</label>
                          <select class="form-control select2" id="" name="txtKodeParent" data-placeholder="Product">
                            <option>lorem 2</option>
                            <option value="">lorem</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="usr">Deskripsi</label>
                          <textarea rows="4" style="height:107.5px;" title="" class="form-control" id="" name="txtDescription" placeholder="Deskripsi MSIB"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="usr">Tanggal Berlaku</label>
                          <input type="text" class="form-control PBRdate" name="txtTanggalBerlaku" placeholder="">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="usr">Alasan perubahan</label>
                          <textarea rows="3" title="" class="form-control" id="" name="txtPerubahan" placeholder="Alasan perubahan..."></textarea>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-lg-12">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <div style="float:left">
                    <h4>Komponen Penyusun</h4>
                  </div>
                  <div style="float:right">
                    <button type="button" class="btn btn-danger" onclick="plus()"><i class="fa fa-plus-circle"></i> </button>
                    <button type="button" class="btn btn-warning" onclick="minBox()"><i class="fa fa-minus-circle"></i> </button>
                  </div>
                </div>
                <div class="panel-body">
                  <div id="sub" class="tab-pane fade in">
                    <div id="boxInput" class="row boxInput">
                      <div class="col-md-6">
                        <input type="hidden" name="noSub[]" value="1">
                        <div class="form-group">
                          <label>Kode Komponen Penyusun</label>
                          <input class="form-control" type="text" name="txtKodePenyusun[]" placeholder="Type" id="kodePenyusun1">
                        </div>
                        <div class="form-group">
                          <label for="usr">Deskripsi</label>
                          <textarea rows="4" title="" class="form-control" id="decrip1" name="txtDescriptionPenyusun[]" placeholder="Deskripsi Komponen Penyusun"></textarea>
                        </div>
                        <div class="form-group">
                          <label>Quantity</label>
                          <input class="form-control" type="number" id="qty1" name="txtQuantity[]" placeholder="Type">
                        </div>
                        <div class="form-group">
                          <label for="usr">OUM</label>
                          <select class="form-control select2" id="oum1" name="txtOUM[]" data-placeholder="">
                            <option></option>
                            <option value="Ton">Ton</option>
                            <option value="Kg">Kg</option>
                            <option value="Hg">Hg</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usr">Supply Type</label>
                          <select class="form-control" onchange="optionSub(1)" id="txtSupplytype1" name="txtSupplytype[]" data-placeholder="Supply Type">
                            <option value=""></option>
                            <option value="Operation Pull (Picklist)">Operation Pull (Picklist)</option>
                            <option value="Operation Pull">Operation Pull</option>
                            <option value="Push">Push</option>
                          </select>
                        </div>
                        <div class="form-group hidden" id="sub11">
                          <label>Supply Subinventory</label>
                          <input class="form-control" id="txtSupplySub1" type="text" name="txtSupplySub[]" placeholder="Type">
                        </div>
                        <div class="form-group hidden" id="sub21">
                          <label>Supply Locator</label>
                          <input class="form-control" id="txtSupplyLocator1" type="text" name="txtSupplyLocator[]" placeholder="Type">
                        </div>
                        <div class="form-group hidden" id="sub31">
                          <label>Subinventory Picklist</label>
                          <input class="form-control" id="txtSubPicklist1" type="text" name="txtSubPicklist[]" placeholder="Type">
                        </div>
                        <div class="form-group hidden" id="sub41">
                          <label>Locator Picklist</label>
                          <input class="form-control" id="txtLocatorPicklist1"  type="text" name="txtLocatorPicklist[]" placeholder="Type" >
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="panel-body">
              <div class="col-md-12" style="padding:15px;margin-bottom:-15px;">
                <center><button type="submit" class="btn btn-primary btn-lg btn-rect" onclick="btnpbr()">Save Data</button></center>
              </div>
              <!-- <div class="col-md-12">
                <a href="<?php echo base_url('PendaftaranBomRouting/InputBOMRouting/sendEmail') ?>">email</a>
              </div> -->
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</section>
