<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">
          <h3><b>Edit Resume Medis</b></h3>
        </div>
        <div class="panel-body">
          <a class="btn btn-default" href="<?= base_url('MasterPekerja/ResumeMedis') ?>"> <i class="fa fa-arrow-left"></i> <span style="margin-left: 2px;">Kembali</span></a>
          <form method="post" action="<?php $id = $this->general->enkripsi($data_resumeMedis[0]['id_rm']);
                                      echo base_url('MasterPekerja/ResumeMedis/updateResumeMedis/' . $id);  ?>">
            <div style="margin-top: 10px;">
              <div class="panel-group">
                <div class="panel panel-primary">
                  <div class="panel-body">
                    <div class="col-md-12">
                      <div class="col-md-5 form-group">
                        <label class="control-label" for="slcPekerja">
                          <h5><b>Pilih Pekerja</b></h5>
                        </label>
                        <select class="form-control" name="slcPekerja" id="slcPekerja" required>
                          <option value="<?= $data_resumeMedis[0]['noind'] ?>" selected><?= $data_resumeMedis[0]['noind'] . ' - ' . $data_resumeMedis[0]['nama'] ?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-5 form-group">
                        <label class="control-label" for="slcCabang">
                          <h5><b>Nama Perusahaan</b></h5>
                        </label>
                        <select class="form-control" name="slcCabang" id="slcCabang" required>
                          <option value="<?= $data_perusahaan[0]['kode_mitra'] ?>" selected><?= $data_perusahaan[0]['kode_mitra'] . ' - ' . $data_perusahaan[0]['kota'] . ' - ' . $data_perusahaan[0]['keterangan'] ?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-3 form-group">
                        <label class="control-label" for="datepicker_laka">
                          <h5><b>Kecelakaan pada tanggal</b></h5>
                        </label>
                        <div class="input-group date" required>
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker_laka" name="datepicker_laka" required value="<?= $data_resumeMedis[0]['tgl_laka'] ?>">
                        </div>
                      </div>
                      <div class="col-md-3 form-group">
                        <label class="control-label" for="datepicker_periksa">
                          <h5><b>Pemeriksaan pada tanggal</b></h5>
                        </label>
                        <div class="input-group date" required>
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker_periksa" name="datepicker_periksa" required value="<?= $data_resumeMedis[0]['tgl_periksa'] ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="btn-group">
                <button id="btn_savePerusahaan" type="submit" class="btn btn-success btn-radius">Simpan</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>