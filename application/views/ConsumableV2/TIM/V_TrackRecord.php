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
                        <li class="pull-right header"><h3 class="text-bold" style="margin:10px 0 10px"><i class="fa fa-cube"></i> Track Record</h3></li>
                      </ul>
                    </div>
                  </div>
                  <div class="tab-content">
                    <div class="tab-pane active" id="input">
                      <div class="row pt-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="">Periode</label>
                            <table>
                              <tr>
                                <td>
                                  <input type="text" class="form-control periode_track" autocomplete="off" placeholder="Periode" />
                                </td>
                                <td class="pl-3">
                                  <b class="text-center">s/d</b>
                                </td>
                                <td class="pl-3">
                                  <input type="text" class="form-control periode_track" autocomplete="off" placeholder="Periode" />
                                </td>
                                <td class="pl-3">
                                  <button class="btn btn-primary text-bold" style="width:105px" onclick="caridatapengajuan()"> <i class="fa fa-search"></i> Cari</button>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <hr>
                          <div class="table-responsive">
                            <table class="table table-bordered tbl_cst_kebutuhan" style="width:100%;text-align:center">
                              <thead class="bg-primary">
                                <tr>
                                  <th class="text-center" style="width:5%">No</th>
                                  <th class="text-center" style="width:15%">Kode Barang</th>
                                  <th class="text-center" style="width:26%">Nama Barang</th>
                                  <th class="text-center">Min Stok</th>
                                  <th class="text-center">Stok Akhir</th>
                                  <th class="text-center">PP</th>
                                  <th class="text-center">Req</th>
                                  <th class="text-center">Used</th>
                                  <th class="text-center">Outstanding</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>
                          <br>
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
