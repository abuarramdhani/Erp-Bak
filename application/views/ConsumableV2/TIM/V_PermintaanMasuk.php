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
                <input type="hidden" id="consumablepermintaanv2" value="1">
                <div class="nav-tabs-custom">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="nav nav-tabs" style="border-bottom:0.5px solid #e6e6e6">
                        <!-- <li><a href="#monitoring" data-toggle="tab">Monitoring</a></li>
                        <li class="active"><a href="#input" data-toggle="tab">Input Kebutuhan</a></li> -->
                        <li class="pull-right header"><h3 class="text-bold" style="margin:10px 0 10px"><i class="fa fa-cube"></i> Permintaan Masuk</h3></li>
                      </ul>
                    </div>
                  </div>

                  <?php
                    $monthnow = date('m')*1;
                    if ($monthnow > 1 && $monthnow < 12) {
                      $monthnownext = $monthnow + 1;
                    }else if ($monthnow == 12) {
                      $monthnownext = 1;
                    }
                    $monthnownext = DateTime::createFromFormat('!m', $monthnownext);

                  ?>

                  <div class="tab-content">
                    <div class="tab-pane active" id="input">
                      <div class="row pt-3">
                        <div class="col-md-12">
                          <h4 class="text-bold" style="margin-bottom:-11px">Seksi Belum Mengajukan Permintaan</h4>
                          <hr>
                          <div class="table-responsive">
                            <table class="table table-bordered tbl_cst_kebutuhan" style="width:100%;text-align:center">
                              <thead class="bg-primary">
                                <tr>
                                  <th class="text-center" style="width:5%">No</th>
                                  <th class="text-center">Seksi</th>
                                  <th class="text-center">PIC</th>
                                  <th class="text-center">VoIP</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>
                          <br>
                          <h4 class="text-bold" style="margin-bottom:-11px">Approval Pengajuan Kebutuhan</h4>
                          <hr>
                          <div class="table-responsive areaviewapprovalkeb">

                          </div>
                          <br>
                          <h4 class="text-bold" style="margin-bottom:-11px">Approval Pengajuan Item</h4>
                          <hr>
                          <div class="table-responsive areaviewapprovalitem">

                          </div>
                          <br>
                          <h4 class="text-bold" style="margin-bottom:-11px">Pengajuan Seksi</h4>
                          <hr>
                          <div class="table-responsive">
                            <table class="table table-bordered tbl_cst_pengajuan_seksi" style="width:1500px;text-align:center">
                              <thead class="bg-primary">
                                <tr>
                                  <th rowspan="2" class="text-center" style="width:5%">No</th>
                                  <th rowspan="2" class="text-center">Kode Barang</th>
                                  <th rowspan="2" class="text-center">Nama Barang</th>
                                  <th rowspan="2" class="text-center">UOM</th>
                                  <th rowspan="2" class="text-center">IT</th>
                                  <th rowspan="2" class="text-center">MOQ</th>
                                  <th colspan="4" style="border-bottom:0px;" class="text-center">Avaliability</th>
                                  <th rowspan="2" class="text-center">Req. Bln -</th>
                                  <th rowspan="2" class="text-center">Consumed</th>
                                  <th rowspan="2" class="text-center">Sisa Jatah</th>
                                  <th rowspan="2" class="text-center">Req. Bln +</th>
                                  <th rowspan="2" class="text-center">Min Stok</th>
                                  <th rowspan="2" class="text-center">Max Stock</th>
                                  <th rowspan="2" class="text-center">Rekomendasi PP</th>
                                  <th rowspan="2" class="text-center" style="width:8%">Action</th>
                                </tr>
                                <tr>
                                  <th class="text-center">OH</th>
                                  <th class="text-center">PPB</th>
                                  <th class="text-center">PO</th>
                                  <th class="text-center" style="border-right:0.5px solid white">PR</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>Trial</td>
                                  <td>
                                    <button type="button" class="btn" name="button" title="ubah"> <i class="fa fa-edit"></i> </button>
                                    <button type="button" class="btn" name="button" data-toggle="modal" data-target="#detailpengajuan" title="detail"> <i class="fa fa-eye"></i> </button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <br>
                          <center> <button type="submit" class="btn btn-primary btn-lg text-bold" id="prosesCSTtim" disabled name="button"> <i class="fa fa-cogs"></i> Proses Pengajuan Seksi</button> </center>
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

<div class="modal fade bd-example-modal-xl" id="detailpengajuan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Detail Pengajuan <span id="juduldetailpengajuan"></span> </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12 pt-3 pb-3">
                    <div class="table-responsive">
                      <table class="table table-bordered tbl_cst_kebutuhan" style="width:100%;text-align:center">
                        <thead class="bg-primary">
                          <tr>
                            <th class="text-center" style="width:5%">No</th>
                            <th class="text-center">Seksi</th>
                            <th class="text-center">PIC</th>
                            <th class="text-center">Req. Bln <?php echo date('m') ?></th>
                            <th class="text-center">Consumed</th>
                            <th class="text-center">Sisa Jatah</th>
                            <th class="text-center">Req. Bln +</th>
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

<!-- approval detail -->
<div class="modal fade bd-example-modal-xl" id="detailitem-approval-cst" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Approval Pengajuan Kebutuhan <span id="seksiapprovalpengajuan"></span> </h4>
                </div>
                <button type="button" class="btn btn-default" style="float:right;font-weight:bold" data-dismiss="modal" onclick="viewapprovalkeb()"> <i class="fa fa-close"></i> Selesai</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12 pt-3 pb-3">
                    <div class="table-responsive areaapprovalpengajuan">

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
