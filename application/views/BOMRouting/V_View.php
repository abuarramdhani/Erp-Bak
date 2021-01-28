<!-- <style media="screen">
  .iCheck-helper{
    height: 20% !important;
    width: 20% !important;
  }
</style> -->
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
                      <form method="post" action="" autocomplete="off">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Nomor Dokumen</label>
                          <input class="form-control" type="text" id="txtNoDokumen" placeholder="Type" required value="<?php echo $headerRow[0]['no_document'] ?>">
                          <input class="form-control" type="hidden" id="txtIdHeader" placeholder="Type" required value="<?php echo $headerRow[0]['id'] ?>">
                        </div>
                        <div class="form-group">
                          <label for="usr">Tanggal Pembuatan</label>
                          <input type="text" class="form-control" id="txtTanggalPembuatan" placeholder="Kode Barang" value="<?php echo $headerRow[0]['tgl_pembuatan'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="usr">Nama Barang:</label>
                          <input type="text" class="form-control" id="txtNamaBarang" placeholder="Nama Barang" value="<?php echo $headerRow[0]['nama_barang'] ?>" required>
                        </div>
                        <div class="form-group">
                          <input type="checkbox" class="numberPBR">
                          <label for="usr">Seksi:</label>
                          <select class="form-control select2" id="txtSeksiHeader" name="txtSeksi" data-placeholder="Seksi">
                              <option></option>
                              <option value="lorem 2" <?php if ($headerRow[0]['seksi'] == 'lorem 2') { echo "selected"; } ?>>lorem 2</option>
                              <option value="lorem" <?php if ($headerRow[0]['seksi'] == 'lorem') { echo "selected"; } ?>>lorem</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <input type="checkbox" class="numberPBR">
                          <label for="usr">Pilih IO</label>
                          <select class="form-control select2" id="txtIO" name="txtIO" data-placeholder="Seksi">
                              <option></option>
                              <option value="lorem 2" <?php if ($headerRow[0]['io'] == 'lorem 2') { echo "selected"; } ?>>lorem 2</option>
                              <option value="lorem" <?php if ($headerRow[0]['io'] == 'lorem') { echo "selected"; } ?>>lorem</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <!-- <button type="button" name="button" id="numberrPBR">a</button> -->
                          <input type="checkbox" class="numberPBR">
                          <label for="usr">Kode Item (Parent)</label>
                          <select class="form-control select2" id="txtKodeParent" data-placeholder="Product" required="">
                            <option></option>
                            <option value="lorem 2" <?php if ($headerRow[0]['kode_item_parent'] == 'lorem 2') { echo "selected"; } ?>>lorem 2</option>
                            <option value="lorem" <?php if ($headerRow[0]['kode_item_parent'] == 'lorem') { echo "selected"; } ?>>lorem</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <input type="checkbox" class="numberPBR">
                          <label for="usr">Deskripsi</label>
                          <textarea rows="3" title="" class="form-control" id="txtDescription" placeholder="Deskripsi MSIB"><?php echo $headerRow[0]['deskripsi'] ?></textarea>
                        </div>
                        <div class="form-group">
                          <input type="checkbox" class="numberPBR">
                          <label for="usr">Tanggal Berlaku</label>
                          <br>
                          <input type="text" class="form-control PBRdate" id="txtTanggalBerlakuHeader" placeholder="" value="<?php echo $headerRow[0]['tgl_berlaku'] ?>">
                        </div>
                        <div class="form-group">
                          <input type="checkbox" class="numberPBR">
                          <label for="usr">Alasan perubahan</label>
                          <textarea rows="3" title="" class="form-control" id="txtPerubahan" placeholder="Alasan perubahan..."><?php echo $headerRow[0]['perubahan'] ?></textarea>
                        </div>
                      </div>

                      <div class="col-md-12" style="padding:15px;margin-bottom:-15px;">
                        <center><button type="button" class="btn btn-primary btn-rect" id="BtnUpdateHeader">Update Data Header</button></center>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <button type="button" onclick="Refresh2()" class="btn btn-info btn-circle btn-sm" style="color:white">
                <i class="fa fa-refresh"></i> Refresh
              </button>
              <br><br>
              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <div style="float:left">
                    <h4>Komponen Penyusun</h4>
                  </div>
                  <div style="float:right">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#MyModal2"><i class="fa fa-plus-circle"></i> </button>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="tab-pane fade in">
                    <table class="table table-bordered display nowrap" id="dataTablePBR2" style="width:100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th><input type="checkbox" class="numberPBR"> Kode Komponen Penyusun</th>
                          <th><input type="checkbox" class="numberPBR"> Deskripsi</th>
                          <th><input type="checkbox" class="numberPBR"> Quantity</th>
                          <th><input type="checkbox" class="numberPBR"> UOM</th>
                          <th><input type="checkbox" class="numberPBR"> Supply Type</th>
                          <th><input type="checkbox" class="numberPBR"> Supply Subinventory</th>
                          <th><input type="checkbox" class="numberPBR"> Supply Locator</th>
                          <th><input type="checkbox" class="numberPBR"> Subinventory Picklist</th>
                          <th><input type="checkbox" class="numberPBR"> Locator Picklist</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <center>
                <button type="button" name="button" class="btn btn-primary btn-lg bg-gradient-primary btn-icon-split" id="btnOracle" disabled>
                  <span class="icon text-white-50">
                    <i class="fa fa-check"></i>
                  </span>
                  <span class="text">Insert to Oracle</span>
                </button>
              </center>
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</section>

<!-- modal area -->
<div class="modal fade bd-example-modal-xl" id="MyModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
      <div class="panel-body">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
          <h3 class="modal-title" style="text-align:center" id="exampleModalLabel">Update Data Komponen Penyusun</h3>
        </div>
          <form action="" method="post">
            <div class="p-5">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Kode Komponen Penyusun</label>
                    <input class="form-control" type="text" id="txtKodePenyusun" placeholder="Type">
                    <input type="hidden" id="txt_id" value="">
                  </div>
                  <div class="col-sm-6">
                    <label for="">Quantity</label>
                    <input class="form-control" type="number" id="txtQuantity" placeholder="Type">
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Deskripsi</label>
                    <textarea rows="2" title="" class="form-control" id="txtDeskripsi" placeholder="Deskripsi Komponen Penyusun"></textarea>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">UOM</label> <br>
                    <select class="form-control select2" id="txtOUM" data-placeholder="">
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label for="">Supply Type</label>
                    <select class="form-control" onchange="optionSub()" id="txtSupplytypeRev" data-placeholder="Supply Type">
                      <!-- <option></option> -->
                      <option value="Operation Pull (Picklist)">Operation Pull (Picklist)</option>
                      <option value="Operation Pull">Operation Pull</option>
                      <option value="Push">Push</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Supply Subinventory</label>
                    <input class="form-control" type="text" id="txtSupplySub" placeholder="Type">
                    <input type="hidden" id="txt_id" value="">
                  </div>
                  <div class="col-sm-6">
                    <label for="">Supply Locator</label>
                    <input class="form-control" type="text" id="txtSupplyLocator" placeholder="Type">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Subinventory Picklist</label>
                    <input class="form-control" type="text" id="txtSubPicklist" placeholder="Type">
                  </div>
                  <div class="col-sm-6">
                    <label for="">Locator Picklist</label>
                    <input class="form-control" type="text" id="txtLocatorPicklist" placeholder="Type">
                  </div>
                </div>
            </div>
          </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" name="button" class="btn btn-primary bg-gradient-primary btn-icon-split" id="UpdateComp">
            <span class="icon text-white-50">
              <i class="fa fa-check"></i>
            </span>
            <span class="text">Save Change</span>
          </button>
        </div>
      </div>
		</div>
	</div>
</div>

<!-- modal area -->
<div class="modal fade bd-example-modal-xl" id="MyModal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4>Tambah Komponen Penyusun</h4>
                </div>
                <div style="float:right">
                  <button type="button" class="btn btn-danger" onclick="plus()"><i class="fa fa-plus-circle"></i> </button>
                  <button type="button" class="btn btn-warning" onclick="minBox()"><i class="fa fa-minus-circle"></i> </button>
                </div>
              </div>
              <form method="post" action="<?php echo base_url('PendaftaranBomRouting/InputBOMRouting/updateAddPenyusun/'.$headerRow[0]['id']) ?>" autocomplete="off">
                <div class="panel-body">
                  <div id="sub" class="tab-pane fade in">
                    <div id="boxInput" class="row boxInput">
                      <div class="col-md-6">
                        <input type="hidden" name="noSub[]" value="1">
                        <div class="form-group">
                          <label>Kode Komponen Penyusun</label>
                          <input class="form-control" type="text" name="txtKodePenyusun[]" id="kodePenyusun1" placeholder="Type">
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
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="button" class="btn btn-primary bg-gradient-primary btn-icon-split" id="UpdateComp">
              <span class="icon text-white-50">
                <i class="fa fa-check"></i>
              </span>
              <span class="text">Save</span>
            </button>
          </div>
        </form>
      </div>
		</div>
	</div>
</div>
