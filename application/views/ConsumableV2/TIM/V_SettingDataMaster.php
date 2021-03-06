<style media="screen">
.pagination > .active a{
  background: #f1f1f1 !important;
  color: black;
  border: 1px solid black;
}

.modal {
text-align: center;
padding: 0!important;
}

.modal:before {
content: '';
display: inline-block;
height: 100%;
vertical-align: middle;
margin-right: -4px; /* Adjusts for spacing */
}

.modal-dialog {
display: inline-block;
text-align: left;
vertical-align: middle;
}

.tbl_lph_mesin td{
  padding-top:10px !important;
}

.datepicker{
  display: none !important;
}

td, th{
  vertical-align: middle !important;
}

</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary color-palette-box">
              <div class="panel-body">
                <input type="hidden" id="consumabletimsettingdatav2" value="1">
                <div class="nav-tabs-custom">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="nav nav-tabs" style="border-bottom:0.5px solid #e6e6e6">
                        <!-- <li><a href="#monitoring" data-toggle="tab">Monitoring</a></li>
                        <li class="active"><a href="#input" data-toggle="tab">Input Kebutuhan</a></li> -->
                        <li class="pull-right header"><h3 class="text-bold" style="margin:10px 0 10px"><i class="fa fa-database"></i> Setting Data Master</h3></li>
                      </ul>
                    </div>
                  </div>
                  <div class="tab-content">
                    <div class="tab-pane active" id="input">
                      <div class="row pt-3">
                        <div class="col-md-12 mt-3">
                          <div style="width:100%;background: #f35325;padding: 8px;color: white;border-radius: 6px;">
                            <div class="row">
                              <div class="col-md-6">
                                <h4 class="">Master Data Seksi</h4>
                              </div>
                              <div class="col-md-6">
                                <button type="button" class="btn mt-1 csttambahdataseksi" onclick="()" style="color:black;float:right;background:white;border:1px solid #a8a8a8" status="+" name="button">Tambah Data Seksi</button>
                              </div>
                            </div>
                          </div>
                          <div class="areacsmmds">
                            <div class="table-responsive mt-3 areadataseksi">

                            </div>
                          </div>
                          <div class="areacsmmdsadd" style="display:none">
                            <form class="savecsmseksi mt-3" action="" method="post">
                              <div class="row">
                                <div class="col-md-6 mb-3">
                                  <label for="">Seksi</label>
                                  <select class="slc_csm_seksi" name="seksi" style="width:100%">
                                    <option value="" selected></option>
                                  </select>
                                  <!-- <input type="text" readonly class="form-control" name="seksi" value=""> -->
                                </div>
                                <div class="col-md-6 mb-3">
                                  <label for="">PIC</label>
                                  <select class="slc_csm_employ" style="width:100%" name="pic">
                                    <option value="" selected></option>
                                  </select>
                                </div>
                                <div class="col-md-12">
                                  <label for="">VOIP</label>
                                  <input type="number" class="form-control csm_voip" placeholder="max length 5" name="voip" value="">
                                </div>
                                <div class="col-md-12 mt-4">
                                  <center> <button type="submit" class="btn text-bold" name="button" style="background: #f35325;color: white;width:130px"> Simpan</button> </center>
                                </div>
                              </div>
                            </form>
                          </div>
                          <hr>
                        </div>
                        <div class="col-md-12 mt-3">
                          <div style="width:100%;background: #81bc06;padding: 8px;color: white;border-radius: 6px;">
                            <div class="row">
                              <div class="col-md-6">
                                <h4 class="">Master Data Item</h4>
                              </div>
                              <div class="col-md-6">
                                <button type="button" class="btn csttambahdataitem pull-right" status="+" style="border: 1px solid #a8a8a8;background: white;color:black" name="button" status="+"> <i class="fa fa-plus"></i> Tambah Data Item</button>
                              </div>
                            </div>
                          </div>
                          <div class="cstmasteritem">
                            <div class="table-responsive mt-3">
                              <table class="table table-bordered tbl_cst_master_item" style="width:100%;text-align:center">
                                <thead style="background:#81bc06;color:white">
                                  <tr>
                                    <th class="text-center" style="width:3%">No</th>
                                    <th class="text-center" style="width:17%">Kode Barang</th>
                                    <th class="text-center" style="width:26%">Nama Barang</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Leadtime</th>
                                    <th class="text-center">MOQ</th>
                                    <th class="text-center">Min Stok</th>
                                    <th class="text-center">Max Stock</th>
                                    <th class="text-center" style="width:8%">Action</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="csttambahitem" style="display:none">
                            <div class="table-responsive mt-3">
                              <form class="savecstitem" action="" method="post">
                                <table class="table table-bordered tblcsttmbi" style="width:100%;text-align:center;">
                                  <thead style="background:#eee">
                                    <tr>
                                      <th class="text-center" style="width:3%">No</th>
                                      <th class="text-center" style="width:19%">Kode Barang</th>
                                      <th class="text-center" style="width:26%">Nama Barang</th>
                                      <th class="text-center">UOM</th>
                                      <th class="text-center">Leadtime</th>
                                      <th class="text-center">MOQ</th>
                                      <th class="text-center">Min Stok</th>
                                      <th class="text-center">Max Stock</th>
                                      <th class="text-center" style="width:4%"><button class="btn btn-default btn-sm" style="border: 1px solid #a8a8a8;background:white" onclick="btnPlusMasterItem()"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                  </thead>
                                  <tbody id="areaaddmsibitem">
                                    <tr>
                                      <td>1</td>
                                      <td>
                                        <input type="hidden" name="item_id[]" class="item_id" value="">
                                        <select class="select2_cstmsib" required style="width:170px" name="kodeitem[]">
                                          <option value="" selected>Pilih Item..</option>
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" readonly class="form-control" name="description" value="">
                                      </td>
                                      <td>
                                        <input type="text" readonly class="form-control" name="uom" value="">
                                      </td>
                                      <td>
                                        <input type="text" readonly class="form-control" name="leadtime" value="">
                                      </td>
                                      <td>
                                       <input type="text" readonly class="form-control" name="moq" value="">
                                      </td>
                                      <td>
                                       <input type="text" readonly class="form-control" name="min_stock" value="">
                                      </td>
                                      <td>
                                       <input type="text" readonly class="form-control" name="max_stock" value="">
                                      </td>
                                      <td>
                                        <button class="btn btn-default btn-sm" onclick="cstitemmin(this)" style="border: 1px solid #a8a8a8;background:white">
                                          <i class="fa fa-minus"></i>
                                        </button>
                                      </td>
                                    </tr>

                                  </tbody>
                                </table>
                                <center> <button type="submit" class="btn " name="button" style="width:130px;background: #81bc06;color:white"> <i class="fa fa-save"></i> Save</button> </center>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>

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
</div>
</section>

<div class="modal fade bd-example-modal-xl" id="editmasterseksi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Edit Master Seksi <span id="juduleditmasterseksi" style="color: #f35325"></span> </h4>
                </div>
                <button type="button" class="btn" style="float:right;font-weight:bold;border:1px solid #a8a8a8" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
              </div>
              <div class="box-body">
                <div class="row pt-3 pb-3">
                  <div class="col-md-6 ">
                    <label for="">PIC</label>
                    <input type="hidden" id="edtds_kodesie" value="">
                    <select class="slc_csm_employ_" style="width:100%" id="edtds_pic">
                      <!-- <option value="" selected></option> -->
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="">VOIP</label>
                    <input type="text" class="form-control csm_voip" id="edtds_voip" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn" onclick="updatepicvoip()" style="background: #f35325;color:white;width:100%;margin-top:25px" name="button">Update</button>
                  </div>
                  <div class="col-md-12">
                    <hr>
                    <table class="table table-bordered detailitembyseksi" style="width:100%">
                      <thead style="background: #f35325;color:white">
                        <tr>
                          <th class="text-center" style="width:50px">No</th>
                          <th class="text-center" style="width:150px">Item</th>
                          <th class="text-center" style="width:300px">Desc</th>
                          <!-- <th class="text-center">Qty Req</th> -->
                          <th class="text-center">UOM</th>
                          <th class="text-center">Created By</th>
                          <th class="text-center">Creation Date</th>
                          <th class="text-center">Status</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>

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
