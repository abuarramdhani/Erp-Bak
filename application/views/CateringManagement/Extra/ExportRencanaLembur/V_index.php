<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
        </div>
        <br />

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h1 style="text-align:left padding:5px;">Export Rencana Lembur</h1>
              </div>
              <div class="box-body">
                <div class="col-lg-12">
                  <form class="form-horizontal" method="POST" id="frm_lembur">
                    <div class="form-group">
                      <label class="control-label col-lg-4">Tanggal</label>
                      <div class="col-lg-4">
                        <input type="text" name="txtTanggalLembur" class="form-control cmsingledate-mycustom" value="<?php echo date("Y-m-d", strtotime("+ 1 day")); ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-4">Lokasi Tempat Makan</label>
                      <div class="col-lg-4">
                        <select class="select select2" name="txtTempatMakan" required style="width: 100%;" autocomplete="off">
                          <option value="1">Yogyakarta</option>
                          <option value="2">Tuksono</option>
                          <option value='all'>Semua Lokasi</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-4">Status Makan</label>
                      <div class="col-lg-4">
                        <select class="select select2" name="txtStatusMakan" required style="width: 100%;" autocomplete="off">
                          <option value="1">Makan</option>
                          <option value="0">Tidak Makan</option>
                          <option value='all'>Semua status</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-4">Status Approval</label>
                      <div class="col-lg-4">
                        <select class="select select2" name="txtStatusApprov" required style="width: 100%;" autocomplete="off">
                          <option value="1">Disetujui</option>
                          <option value="2">Tidak Disetujui</option>
                          <option value="0">Belum Diproses Atasan</option>
                          <option value='all'>Semua Status</option>
                        </select>
                      </div>
                    </div>
                    <br>

                    <div class="text-center">
                      <button type="button" id="btn_viewlembur" class="btn btn-lg btn-primary">LIHAT</button>&nbsp;
                      <button type="button" id="btn_excellembur" class="btn btn-lg btn-success">EXCEL</button>&nbsp;
                      <button type="button" id="btn_pdflembur" class="btn btn-lg btn-danger">PDF</button>&nbsp;
                    </div>

                  </form>
                </div>
                <div class="clearfix"></div><br><br>

                <div class="col-lg-12" id="div_viewdata"></div>
              </div>


            </div>
          </div>



        </div>
      </div>
    </div>
  </div>
</section>