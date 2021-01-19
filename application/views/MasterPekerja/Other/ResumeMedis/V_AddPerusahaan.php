<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading" style="display: flex; justify-content: space-between;">
          <a style="align-self: center;" href="<?= base_url("MasterPekerja/SettingResumeMedis") ?>">
            <button class="btn btn-default"><i class="fa fa-arrow-left"></i><span style="margin-left: 5px;">Kembali</span></button>
          </a>
          <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success" role="alert">
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php endif; ?>
          <h3>Masukan Data</h3>
        </div>
        <div class="panel-body">
          <form method="post" action="<?php echo base_url('MasterPekerja/SettingResumeMedis/addPerusahaan'); ?>" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputNamaPerusahaan" class="control-label">Nama Perusahaan</label>
                  <input class="form-control <?= form_error('txt_namaPerusahaan') ? 'is-invalid' : '' ?>" type="text" name="txt_namaPerusahaan" id="KecelakaanKerja-inputNamaPerusahaan" placeholder="Nama Perusahaan">
                  <div class="invalid-feedback">
                    <?php echo form_error('txt_namaPerusahaan') ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputKodeMitraPerusahaan" class="control-label">Kode Mitra</label>
                  <input class="form-control <?= form_error('txt_kodeMitraPerusahaan') ? 'is-invalid' : '' ?>" type="text" name="txt_kodeMitraPerusahaan" id="KecelakaanKerja-inputKodeMitraPerusahaan" placeholder="L1231200">
                  <div class="invalid-feedback">
                    <?php echo form_error('txt_kodeMitraPerusahaan') ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputAlamatPerusahaan" class="control-label">Alamat</label>
                  <input class="form-control <?= form_error('txt_alamatPerusahaan') ? 'is-invalid' : '' ?>" type="text" name="txt_alamatPerusahaan" id="KecelakaanKerja-inputAlamatPerusahaan" placeholder="Jl.yogyakarta">
                  <div class="invalid-feedback">
                    <?php echo form_error('txt_alamatPerusahaan') ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputDesaPerusahaan" class="control-label">Desa</label>
                  <input class="form-control <?= form_error('txt_desaPerusahaan') ? 'is-invalid' : '' ?>" type="text" name="txt_desaPerusahaan" id="KecelakaanKerja-inputDesaPerusahaan" placeholder="Desa">
                  <div class="invalid-feedback">
                    <?php echo form_error('txt_desaPerusahaan') ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputKecamatanPerusahaan" class="control-label">Kecamatan</label>
                  <input class="form-control <?= form_error('txt_kecamatanPerusahaan') ? 'is-invalid' : '' ?>" type="text" name="txt_kecamatanPerusahaan" id="KecelakaanKerja-inputKecamatanPerusahaan" placeholder="Kecamatan">
                  <div class="invalid-feedback">
                    <?php echo form_error('txt_kecamatanPerusahaan') ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputKotaPerusahaan" class="control-label">kota</label>
                  <input class="form-control <?= form_error('txt_kotaPerusahaan') ? 'is-invalid' : '' ?>" type="text" name="txt_kotaPerusahaan" id="KecelakaanKerja-inputKotaPerusahaan" placeholder="Kota">
                  <div class="invalid-feedback">
                    <?php echo form_error('txt_kotaPerusahaan') ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  <label class="control-label" for="it_noTelpPerusahaan">No. Telp Perusahaan :</label>
                  <input class="form-control  <?= form_error('txt_noTelpPerusahaan') ? 'is-invalid' : '' ?>" type="text" name="txt_noTelpPerusahaan" id="it_noTelpPerusahaan" placeholder="08888888">
                  <div class="invalid-feedback">
                    <?php echo form_error('txt_noTelpPerusahaan') ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  <label class="control-label" for="it_namaKontakPersonilPerusahaan">Nama Kontak Personil Perusahaan :</label>
                  <input class="form-control <?= form_error('txt_namaKontakPersonilPerusahaan') ? 'is-invalid' : '' ?>" type="text" name="txt_namaKontakPersonilPerusahaan" id="it_namaKontakPersonilPerusahaan" placeholder="nama kontak">
                  <div class="invalid-feedback">
                    <?php echo form_error('txt_namaKontakPersonilPerusahaan') ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  <label class="control-label" for="it_keteranganPerusahaan">Keterangan :</label>
                  <input class="form-control" type="text" name="txt_keteranganPerusahaan" id="it_keteranganPerusahaan" placeholder="nama daerah(spasi)NONSTAFF/STAFF">
                </div>
              </div>
            </div>
            <div class="row">
              <br>
              <div class="col-lg-2">
                <button class="btn btn-success" type="submit" id="KecelakaanKerja-btn_SubmitPerusahaan">Simpan</button>
              </div>
            </div>
          </form>

        </div>

        <div class="panel-footer small text-muted">
          * required fields
        </div>

      </div>
    </div>
  </section>
</body>