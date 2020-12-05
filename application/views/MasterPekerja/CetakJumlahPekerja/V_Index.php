<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
          </div>
        </div>
        <br />

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h1 style="text-align:left padding:5px;">Cetak Jumlah Pekerja</h1>
              </div>

              <div class="box-body">
                <div class="nav-tabs-custom" style="position: relative;">

                  <ul class="nav nav-tabs">
                    <li class="active">
                      <a href="#Semua" data-toggle="tab">Semua</a>
                    </li>
                    <li class="">
                      <a href="#Pendidikan" data-toggle="tab">Pendidikan</a>
                    </li>
                  </ul>

                </div>

                <div class="box-header with-border">
                  <h2 class="box-title text-primary"><b>Cari Data</b></h2>
                  <br>
                </div><br>

                <div class="tab-content">
                  <div class="tab-pane active" id="Semua">

                    <div class="col-lg-12">
                      <div class="col-sm-12">
                        <label class="radio-inline control-label"><input value="seksi" type="radio" name="rbtck" class="rbtcjp" checked><b> Per Seksi</b></label>
                        <label class="radio-inline"><input value="unit" type="radio" name="rbtck" class="rbtcjp"><b> Per Unit</b></label>
                        <label class="radio-inline"><input value="departemen" type="radio" name="rbtck" class="rbtcjp"><b> Per Departemen</b></label>
                        <label class="radio-inline"><input value="lokasi" type="radio" name="rbtck" class="rbtcjp"><b> Lokasi Kerja</b></label>
                        <label class="radio-inline"><input value="all" type="radio" name="rbtck" class="rbtcjp" id="CJP_All"><b> Semua</b></label>
                      </div><br><br><br>

                      <div class="col-sm-6" style="padding-left : 40px;">
                        <label class="form-control-label" id="CJP_Txtlabel" style="text-transform:capitalize;">Pilih Seksi :</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="glyphicon glyphicon-briefcase"></i>
                          </div>
                          <select class="form-control" id="CJP_TxtFilter">
                          </select>
                        </div><br><br>
                      </div>

                    </div>
                    <br>
                    <br>
                    <div style="padding-left: 10px;"><button class="btn btn-lg btn-rect btn-primary" id="CJP_viewall">TAMPIL DATA</button></div> &nbsp
                    <div class="box-body bg-white" id="CJP_Table"></div>

                  </div>

                  <div class="tab-pane" id="Pendidikan">
                    <div class="col-lg-12">
                      <div class="col-sm-12">
                        <label class="radio-inline control-label"><input value="seksi" type="radio" name="rbtckp" class="rbtcjpp" checked><b> Per Seksi</b></label>
                        <label class="radio-inline"><input value="unit" type="radio" name="rbtckp" class="rbtcjpp"><b> Per Unit</b></label>
                        <label class="radio-inline"><input value="departemen" type="radio" name="rbtckp" class="rbtcjpp"><b> Per Departemen</b></label>
                        <label class="radio-inline"><input value="lokasi" type="radio" name="rbtckp" class="rbtcjpp"><b> Lokasi Kerja</b></label>
                        <label class="radio-inline"><input value="all" type="radio" name="rbtckp" class="rbtcjpp" id="CJP_Allp"><b> Semua</b></label>
                      </div><br><br><br>

                      <div class="col-sm-6" style="padding-left : 40px;">
                        <label class="form-control-label" id="CJP_Txtlabelp" style="text-transform:capitalize;">Pilih Seksi :</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="glyphicon glyphicon-briefcase"></i>
                          </div>
                          <select class="form-control" id="CJP_TxtFilterp" style="width: 100% !important; ">
                          </select>
                        </div><br><br>
                      </div>

                    </div>
                    <br>
                    <br>
                    <div style="padding-left: 10px;"><button class="btn btn-lg btn-rect btn-primary" id="CJP_viewallp">TAMPIL DATA</button></div> &nbsp;
                    <div class="box-body bg-white" id="CJP_Tablep" style=".dataTables_filter input width: 150px;"></div>
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