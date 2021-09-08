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
                <input type="hidden" id="mon_agt_2021" value="1">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs pull-right">
                    <li><a href="#lph-data-alatbantu" data-toggle="tab" onclick="laporanpemakaianalatbantu()">Pemakaian Alat Bantu</a></li>
                    <li class="active"><a href="#lph-tambah-mesin" data-toggle="tab">Tambah Alat Bantu</a></li>
                    <li class="pull-left header"><b class="fa fa-cog"></b> Setting Alat Bantu</li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="lph-tambah-mesin">
                      <div class="row pt-3">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                          <form class="" action="#" method="post" id="form_lph_add_alat_bantu">
                            <table style="width:100%" class="tbl_lph_mesin">
                              <tr>
                                <td style="width:25%">Kode Alat Bantu</td>
                                <td> <input type="text" required class="form-control" placeholder="ex: AAUA43901" name="kode_alat_bantu" value=""> </td>
                              </tr>
                              <tr>
                                <td>Umur pakai</td>
                                <td> <input type="text" required class="form-control" placeholder="ex: 50000" name="umur_pakai" value=""> </td>
                              </tr>
                              <tr>
                                <td>Toleransi</td>
                                <td> <input type="text" required class="form-control" placeholder="ex: 500" name="toleransi" value=""> </td>
                              </tr>
                              <tr>
                                <td>Proses</td>
                                <td> <input type="text" required class="form-control" placeholder="ex: Trimming AFA00CA031" name="proses" value=""> </td>
                              </tr>
                            </table>
                            <br>
                            <center>
                              <button type="submit" class="btn btn-primary" name="button"> <i class="fa fa-save"></i> Submit</button>
                            </center>
                          </form>
                        </div>
                        <div class="col-md-3">

                        </div>
                      </div>
                      <br>
                      <h4 class="text-bold"> <i class="fa fa-database"></i> Data Alat Bantu</h4>
                      <hr style="margin: 0 0 20px;">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table table-bordered tbl_lph_alat_bantu" style="width:100%;text-align:center">
                              <thead class="bg-primary">
                                <tr>
                                  <td style="width:30px">No</td>
                                  <td style="width:100px">Action</td>
                                  <td>Kode Alat Bantu</td>
                                  <td>Umur pakai</td>
                                  <td>Toleransi</td>
                                  <td>Proses</td>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane" id="lph-data-alatbantu">
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="alert bg-primary alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">
                                <i class="fa fa-close"></i>
                              </span>
                            </button>
                            <strong>Sekilas Info! </strong> Klik 2 kali jika hanya memilih 1 tanggal atau kosongi alat bantu untuk memunculkan semua alat bantu yang terpakai.</strong>
                          </div>
                        </div>
                        <form id="lph_search_alat_bantu" action="index.html" method="post">
                          <div class="col-md-5">
                            <label for="">Filter By Date Range</label>
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              <input type="text" required name="range_date" class="form-control tanggal_lph_99" placeholder="Select Yout Current Date" >
                            </div>
                          </div>
                          <div class="col-md-5">
                            <label for="">Pilih Alat Bantu</label>
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-cog"></i></div>
                              <select class="lph_alat_bantu_97" name="shift" style="width:380px">
                                <option value="" selected>Pilih...</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <label for="" style="color:transparent">Ini Filter</label>
                            <button type="submit" style="font-size:15px" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Filter</strong> </button>
                          </div>
                        </form>
                      </div>
                      <hr>
                      <div class="lph-data-alatbantu">

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

<!-- 210515171 -->
