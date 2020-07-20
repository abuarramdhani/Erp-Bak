<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;">JTI Input Pembelian</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">NO Dokumen</label>
                <input type="text" class="form-control" id="nomorSPBS" placeholder="Nomor Dokumen">
              </div>
              <div class="form-group">
                <label for="">Nama Driver</label>
                <input type="text" class="form-control" id="namaDriver" placeholder="Nama Driver">
                <input type="hidden" id="no_induk_mu" value="<?php echo $this->session->user;?>">
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Waktu Estimasi</label>
                    <input type="text" class="form-control datepickerJTIP" id="estimasi_jti" name="" placeholder="Waktu Estimasi">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Jenis Dokumen</label>
                    <select class="form-control select2" id="jenis_dokumen" name="type" data-placeholder="Jenis Kegiatan">
                      <option value=""></option>
                      <?php foreach ($jenis_dokumen as $value): ?>
                        <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <center><button type="button" onclick="JTIPembelianInput()" style="font-weight:bold" class="btn btn-success" name="button">Save</button></center>
            </div>
            <div class="col-md-3"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
