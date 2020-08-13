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
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Tipe Dokumen</label>
                    <select class="form-control select2" id="jenis_dokumen" name="type" data-placeholder="Jenis Kegiatan">
                      <option value=""></option>
                      <?php foreach ($jenis_dokumen as $value): ?>
                        <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">No Dokumen</label>
                    <input type="text" class="form-control" id="nomorSPBS" placeholder="Nomor Dokumen">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Nama Driver / PIC</label>
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
                    <label for="">Berat Barang </label><small style="margin-top:-9px;margin-left:5px;">*Opsional</small>
                    <div class="row">
                      <div class="col-md-10">
                        <input type="number" class="form-control" id="berat_barang_jti" name="" placeholder="Berat Barang Dalam KG">
                      </div>
                      <div class="col-md-2">
                        <b style="margin-left:-20px;">Kg</b>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <center><button type="button" onclick="JTIPembelianInput()" style="font-weight:bold;width:30%" class="btn btn-success" name="button"> <b class="fa fa-file"></b> Save</button></center>
              <br>
            </div>
            <div class="col-md-3"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
