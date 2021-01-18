<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <br />

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h1 style="text-align:left padding:5px;">Export Jumlah Pesanan</h1>
              </div>

              <div class="box-body">
                <div class="col-lg-12">
                  <form class="form-horizontal" method="POST" id="frm_jmlpesanan">

                    <div class="form-group">
                      <label class="control-label col-lg-4">Tanggal</label>
                      <div class="col-lg-4">
                        <input type="text" name="txtPeriodeJmlPesan" class="form-control cmdaterange">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-lg-4">Lokasi</label>
                      <div class="col-lg-4">
                        <select class="select select2" name="txtLokasiJmlPesan" required style="width: 100%;" autocomplete="off">
                          <option value=" ">Semua Lokasi</option>
                          <option value="1">Pusat Mlati</option>
                          <option value='2'>Tuksono</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-lg-4">Shift</label>
                      <div class="col-lg-4">
                        <select class="select select2" name="txtShiftJmlPesan" required style="width: 100%;" autocomplete="off">
                          <option value=" ">Semua Shift</option>
                          <option value="1">Shift 1 & Umum</option>
                          <option value='2'>Shift 2</option>
                          <option value='3'>Shift 3</option>
                        </select>
                      </div>
                    </div>
                    <br>

                    <div class="text-center">
                      <button type="button" id="btn_viewjumlahpesanan" class="btn btn-lg btn-primary">LIHAT</button>&nbsp;
                    </div>

                  </form>
                </div>
                <div class="clearfix"></div><br><br>

                <div class="col-lg-12" id="div_viewjumlahpesanan"></div>

              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>