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
                        <!-- <li><a href="#monitoring" data-toggle="tab">Monitoring</a></li>
                        <li class="active"><a href="#input" data-toggle="tab">Input Kebutuhan</a></li> -->
                        <li class="pull-right header"><h3 class="text-bold" style="margin:10px 0 10px"><i class="fa fa-cog"></i> Pengajuan Kebutuhan Consumable Part</h3></li>
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
                                  <input type="text" class="form-control periode_pengajuan" style="width:200px" id="periode_pengajuan" autocomplete="off" placeholder="Periode" />
                                </td>
                                <td class="pl-3">
                                  <button class="btn btn-primary text-bold " style="width:105px" onclick="caridatapengajuan()"><i class="fa fa-search"></i> Cari</button>
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
                                  <th class="text-center">Item</th>
                                  <th class="text-center">Desc</th>
                                  <th class="text-center">Req Bulan -</th>
                                  <th class="text-center">Consumed</th>
                                  <th class="text-center">Sisa Jatah</th>
                                  <th class="text-center">Req Bulan +</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>
                          <center> <button type="submit" class="btn btn-lg btn-primary text-bold" id="pengajuanCST" disabled name="button"> <i class="fa fa-upload"></i> Ajukan</button> </center>
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

<!-- 210515171 -->
