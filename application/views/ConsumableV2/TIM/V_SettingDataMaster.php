<style media="screen">
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

td{
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
                <input type="hidden" id="consumabletimtrackv2" value="1">
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
                        <div class="col-md-12">
                          <h4 class="text-bold" style="margin-bottom:-11px">Master Data Seksi</h4>
                          <hr>
                          <div class="table-responsive">
                            <table class="table table-bordered tbl_cst_kebutuhan" style="width:100%;text-align:center">
                              <thead class="bg-primary">
                                <tr>
                                  <th class="text-center" style="width:5%">No</th>
                                  <th class="text-center">Seksi</th>
                                  <th class="text-center">PIC</th>
                                  <th class="text-center">VoIP</th>
                                  <th class="text-center">Jumlah Item</th>
                                  <th class="text-center" style="width:8%">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>Information Technology Trial</td>
                                  <td>Eren Yeager</td>
                                  <td>123456</td>
                                  <td>4</td>
                                  <td>
                                    <button type="button" class="btn" name="button" data-toggle="modal" data-target="#editmasterseksi"> <i class="fa fa-eye"></i> Edit</button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <br>
                          <h4 class="text-bold" style="margin-bottom:-11px">Master Data Item</h4>
                          <hr>
                          <div class="table-responsive">
                            <table class="table table-bordered tbl_cst_kebutuhan" style="width:100%;text-align:center">
                              <thead class="bg-primary">
                                <tr>
                                  <th class="text-center" style="width:5%">No</th>
                                  <th class="text-center" style="width:15%">Kode Barang</th>
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
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Edit Master Seksi <span id="juduleditmasterseksi">Information Technology Trial</span> </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
              </div>
              <div class="box-body">
                <div class="row pt-3 pb-3">
                  <div class="col-md-4 ">
                    <label for="">Seksi</label>
                    <input type="text" class="form-control" name="" value="">
                  </div>
                  <div class="col-md-4 ">
                    <label for="">PIC</label>
                    <input type="text" class="form-control" name="" value="">
                  </div>
                  <div class="col-md-4 ">
                    <label for="">VOIP</label>
                    <input type="text" class="form-control" name="" value="">
                  </div>
                  <div class="col-md-12">
                    <hr>

                    <table class="table table-bordered tableinputkebutuhan" style="width:100%">
                      <thead class="bg-primary">
                        <tr>
                          <th class="text-center" style="vertical-align:middle;width:52%;">Nama Item</th>
                          <th class="text-center" style="vertical-align:middle;width:25%">Item Code</th>
                          <th class="text-center" style="vertical-align:middle;width:15%">Quantity</th>
                          <th class="text-center" style="width:8%"> <button class="btn btn-default btn-sm" onclick="btnPlusIKCST()"><i class="fa fa-plus"></i></button> </th>
                        </tr>
                      </thead>
                      <tbody id="tambahannya_disini">
                        <tr>
                          <td class="text-center" style="width:50%">
                            <input type="hidden" name="item_id[]" class="item_id" value="">
                            <select class="select2_inpkebutuhan_cst" required style="width:100%" name="description[]">
                              <option value="" selected></option>
                            </select>
                          </td>
                          <td class="text-center" style="width:30%"><input type="text" class="form-control item-code" name="item_code[]" readonly="readonly"></td>
                          <td class="text-center"><input type="number" required class="form-control" id="qty_kebutuhan_consum1" name="qty_kebutuhan[]" required="required"></td>
                          <td class="text-center">
                            <button class="btn btn-default btn-sm" disabled>
                              <i class="fa fa-minus"></i>
                            </button>
                          </td>
                        </tr>
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
