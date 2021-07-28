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
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary color-palette-box">
              <div class="panel-body">
                <input type="hidden" id="consumablev2" value="1">
                <div class="nav-tabs-custom">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="nav nav-tabs" style="border-bottom:0.5px solid #e6e6e6">
                        <!-- <li><a href="#monitoring" data-toggle="tab">Monitoring</a></li> -->
                        <!-- <li class="active"><a href="#input" data-toggle="tab">Input Kebutuhan</a></li> -->
                        <li class="pull-right"><h3 class="text-bold" style="margin:10px 0 10px;"><i class="fa fa-cog"></i> Input Standar Kebutuhan</h3></li>
                        <li class="pull-left"><button type="button" class="btn btn-primary text-bold" data-toggle="modal" data-target="#tambahitemcst" name="button"> <i class="fa fa-plus"></i> Tambah</button></li>
                      </ul>
                    </div>
                  </div>

                  <div class="row pt-5">
                    <div class="col-md-12">
                      <div class="table-responsive pb-3">
                        <table class="table table-bordered tbl_cst_kebutuhan_ss" style="width:100%;text-align:center">
                          <thead class="bg-primary">
                            <tr>
                              <th class="text-center" style="width:5%">No</th>
                              <th class="text-center" style="width:15%">Item</th>
                              <th class="text-center" style="width:35%">Desc</th>
                              <th class="text-center">Qty Req</th>
                              <th class="text-center">UOM</th>
                              <th class="text-center">Created By</th>
                              <th class="text-center">Creation Date</th>
                              <th class="text-center">Status</th>
                              <th class="text-center">Action</th>
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
  </div>
</div>
</section>

<div class="modal fade bd-example-modal-xl" id="tambahitemcst" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Input Kebutuhan</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12 pt-3 pb-3">
                    <form class="saveinputkebutuhan" action="" method="post">
                      <div class="col-md-12" style="padding:0">
                        <table class="table table-bordered tableinputkebutuhan" style="width:100%">
                          <thead class="bg-primary">
                            <tr>
                              <th class="text-center" style="vertical-align:middle;width:40%;">Nama Item</th>
                              <th class="text-center" style="vertical-align:middle;width:25%">Item Code</th>
                              <th class="text-center" style="vertical-align:middle;width:15%">Quantity</th>
                              <th class="text-center" style="vertical-align:middle;width:12%">UOM</th>
                              <th class="text-center" style="width:8%"> <button class="btn btn-default btn-sm" onclick="btnPlusIKCST()"><i class="fa fa-plus"></i></button> </th>
                            </tr>
                          </thead>
                          <tbody id="tambahannya_disini">
                            <tr>
                              <td class="text-center" style="width:50%">
                                <input type="hidden" name="item_id[]" class="item_id" value="">
                                <select class="select2_inpkebutuhan_cst" required style="width:380px" name="description[]">
                                  <option value="" selected></option>
                                </select>
                              </td>
                              <td class="text-center"><input type="text" class="form-control item-code" name="item_code[]" readonly="readonly"></td>
                              <td class="text-center"><input type="number" required class="form-control" id="qty_kebutuhan_consum1" name="qty_kebutuhan[]" required="required"></td>
                              <td class="text-center"><input type="text" class="form-control uom" readonly="readonly"></td>
                              <td class="text-center">
                                <button class="btn btn-default btn-sm" disabled>
                                  <i class="fa fa-minus"></i>
                                </button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <center> <button type="submit" class="btn btn-primary text-bold" name="button" style="width:130px"> <i class="fa fa-save"></i> Save</button> </center>
                      </div>
                    </form>
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

<!-- 210515171 -->
