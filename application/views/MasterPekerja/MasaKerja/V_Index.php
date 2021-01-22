<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <br>

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h1 style="text-align:left padding:5px;">Cetak Masa Pekerja</h1>
              </div>

              <div class="box-body">
                <br><br>

                <div class="col-sm-12">

                  <div class="form-group row">
                    <div class="col-sm-2 ">
                      <label class="pull-right"> Periode Tgl :</label>
                    </div>

                    <div class="col-sm-2">
                      <div class="input-group ">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="CMP_tgl">
                      </div>
                    </div>

                    <div class="col-sm-1 ">
                      <label> Pekerja :</label>
                    </div>

                    <div class="col-sm-2">
                      <select class="form-control" id="CMP_kodeind">
                        <option value="'J','H'" selected>Kontrak</option>
                        <option value="'K','P'">OS</option>
                        <option value="'A','B'">Tetap</option>
                      </select>
                    </div>

                    <div class="col-sm-4">
                      <button style="margin-left:50px;" class="btn btn-md btn-primary" id="CMP_CETAK">Cetak Masa Kerja</button> &nbsp;

                    </div><br><br><br>
                    <hr>
                    <div id="Div_cmktable"></div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>