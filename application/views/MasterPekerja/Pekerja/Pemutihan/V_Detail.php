<link rel="stylesheet" href="<?= base_url('/assets/plugins/lightgallery.js/dist/css/lightgallery.css') ?>">

<style>
  .iradio_flat-blue {
    margin-right: 0.25em;
  }

  #modal-image-preview {
    transition: ease-in 0.4s;
  }

  .badge {
    padding: 5px 7px;
  }

  .badge-warning {
    background-color: orange;
  }

  .badge-danger {
    background-color: tomato;
  }

  .badge-revision {
    background-color: #72b8ff;
  }

  .badge-success {
    background-color: #24bb1a;
  }

  textarea {
    resize: vertical;
    height: 100px;
    max-height: 150px;
    min-height: 80px;
  }
</style>

<section class="content">
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 style="font-weight: bold;">
          Pengajuan data #id <?= $request->id_req ?>
        </h4>
      </div>
      <div class="panel-body">
        <div class="container">
          <div class="row">
            <?php if ($session !== $user) : ?>
              <div class="col-md-12">
                <div class="p-4 text-black mb-4" style="background-color: #f0d341; font-weight: bold;">
                  <h3>Warning: Halaman ini sedang dibuka oleh user <?= $session ?></h3>
                </div>
              </div>
            <?php endif ?>
            <div class="col-md-12">
              <div class="bg-secondary p-2 mb-4" style="background: #e8e8e8;">
                <a href="<?= $this->input->get('redirect') ? base_url('/MasterPekerja/Pemutihan#' . $this->input->get('redirect')) : base_url('/MasterPekerja/Pemutihan/') ?>" class="btn btn-warning">
                  <i class="fa fa-angle-left"></i>
                  Kembali
                </a>
              </div>
            </div>
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-11">
                  <div class="pt-4">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td>Noind</td>
                          <td><?= $pribadi->noind ?></td>
                        </tr>
                        <tr>
                          <td>Nama</td>
                          <td><?= $pribadi->nama ?></td>
                        </tr>
                        <tr>
                          <td>Seksi</td>
                          <td><?= $pribadi->seksi ?></td>
                        </tr>
                        <tr>
                          <td>Diajukan pada</td>
                          <td>
                            <span style="display: block;">
                              <i class="fa fa-calendar"></i> <?= date('d F Y', strtotime($request->created_at)) ?>
                            </span>
                            <span style="display: block;">
                              <i class="fa fa-clock-o"></i> <?= date('H:i:s', strtotime($request->created_at)) ?>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <?php
                          $statusColor = [
                            'pending' => [
                              'name'  => 'Menunggu verifikasi',
                              'class' => 'badge-warning'
                            ],
                            'revision'  => [
                              'name'  => 'Revisi',
                              'class' => 'badge-revision'
                            ],
                            'accept'  => [
                              'name'  => 'Approved',
                              'class' => 'badge-success'
                            ],
                            'reject'  => [
                              'name'  => 'Rejected',
                              'class' => 'badge-danger'
                            ],
                            'cancel'  => [
                              'name'  => 'Dibatalkan',
                              'class' => 'badge-secondary'
                            ]
                          ];
                          ?>
                          <td>
                            <span class="badge <?= $statusColor[$request->status_req]['class'] ?>"><?= $statusColor[$request->status_req]['name'] ?></span>
                            <?php if ($request->status_update_by) : ?>
                              <span>by <?= ($request->status_update_by == $request->noind && $request->status_req == 'cancel') ? 'User' : $verifier ?></span>
                            <?php endif ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Perubahan status</td>
                          <td>
                            <?php if ($request->status_update_at) : ?>
                              <span style="display: block;">
                                <i class="fa fa-calendar"></i> <?= date('d F Y', strtotime($request->status_update_at)) ?>
                              </span>
                              <span style="display: block;">
                                <i class="fa fa-clock-o"></i> <?= date('H:i:s', strtotime($request->status_update_at)) ?>
                              </span>
                            <?php endif ?>
                          </td>
                        </tr>
                        <?php if ($request->distributed_at) : ?>
                          <tr>
                            <td>Terdistribusi</td>
                            <td>
                              <span style="display: block;">
                                <i class="fa fa-calendar"></i> <?= date('d F Y', strtotime($request->distributed_at)) ?>
                              </span>
                              <span style="display: block;">
                                <i class="fa fa-clock-o"></i> <?= date('H:i:s', strtotime($request->distributed_at)) ?>
                              </span>
                            </td>
                          </tr>
                        <?php endif ?>
                      </tbody>
                    </table>
                  </div>
                  <form action="<?= base_url('MasterPekerja/Pemutihan/Verification') ?>" method="POST" class="rounded px-3" style="border-radius: 5px; padding: 1em; border: 1px solid #e8e8e8;">
                    <input type="hidden" name="id" value="<?= $request->id_req ?>">
                    <input type="hidden" name="redirect" value="<?= $this->input->get('redirect') ? base_url('/MasterPekerja/Pemutihan#' . $this->input->get('redirect')) : base_url('/MasterPekerja/Pemutihan/') ?>">
                    <div class="form-group" style="background-color: #e8d33f; padding: 0.5em 0; border-radius: 5px;">
                      <div class="row">
                        <div class="col-lg-6 text-center">
                          <strong>Perubahan Data</strong>
                        </div>
                        <div class="col-lg-2 text-center">
                          <strong>Lampiran</strong>
                        </div>
                        <div class="col-lg-4 text-center">
                          <strong>Verifikasi</strong>
                        </div>
                      </div>
                    </div>
                    <!-- NAMA -->
                    <?php if ($request->nama) : ?>
                      <div class="form-group">
                        <label for="">Nama</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->nama ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4 pt-2">
                            <label class="checkbox-inline"><input type="radio" name="nama_verify" value="">Option 1</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="nama_verify" value="">Option 2</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- NIK -->
                    <?php if ($request->nik) : ?>
                      <div class="form-group">
                        <label for="">NIK</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->nik ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="nik_verify" value="1" <?= $request->nik_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="nik_verify" value="0" <?= $request->nik_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- NO KK -->
                    <?php if ($request->no_kk) : ?>
                      <div class="form-group">
                        <label for="">No Kartu Keluarga</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->no_kk ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" class="btn btn-secondary attachment-modal-trigger" data-toggle="tooltip" data-attachment-filename="<?= $request->kk_path ?>" title="Kartu Keluarga">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="no_kk_verify" value="1" <?= $request->no_kk_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="no_kk_verify" value="0" <?= $request->no_kk_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- JENKEL -->
                    <?php if ($request->jenkel) : ?>
                      <div class="form-group">
                        <label for="">Jenis Kelamin</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <?php
                            function getGender($key)
                            {
                              if ($key == 'L') return 'Laki - laki';
                              if ($key == 'P') return 'Perempuan';

                              return "-";
                            }
                            ?>
                            <span type="text" class="form-control">
                              <?= getGender($request->jenkel) ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="jenkel_verify" value="1" <?= $request->jenkel_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="jenkel_verify" value="0" <?= $request->jenkel_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- GOL DARAH -->
                    <?php if ($request->goldarah) : ?>
                      <div class="form-group">
                        <label for="">Golongan Darah</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->goldarah ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                            <button role="button" data-attachment-filename="<?= $request->sk_dokter_path ?>" data-toggle="tooltip" title="Surat Keterangan Dokter" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="goldarah_verify" value="1" <?= $request->goldarah_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="goldarah_verify" value="0" <?= $request->goldarah_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- AGAMA -->
                    <?php if ($request->agama) : ?>
                      <div class="form-group">
                        <label for="">Agama</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->agama ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="agama_verify" value="1" <?= $request->agama_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="agama_verify" value="0" <?= $request->agama_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- TEMPAT LAHIR -->
                    <?php if ($request->tempat_lahir) : ?>
                      <div class="form-group">
                        <label for="">Tempat Lahir</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->tempat_lahir ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="tempat_lahir_verify" value="1" <?= $request->tempat_lahir_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="tempat_lahir_verify" value="0" <?= $request->tempat_lahir_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- TANGGAL LAHIR -->
                    <?php if ($request->tgllahir) : ?>
                      <div class="form-group">
                        <label for="">Tanggal Lahir</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= date('d F Y', strtotime($request->tgllahir)) ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="tgllahir_verify" value="1" <?= $request->tgllahir_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="tgllahir_verify" value="0" <?= $request->tgllahir_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- ALAMAT -->
                    <?php if ($request->alamat) : ?>
                      <div class="form-group">
                        <label for="">Alamat (KTP)</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <textarea type="text" class="form-control"><?= $request->alamat ?></textarea>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                            <button role="button" data-attachment-filename="<?= $request->kk_path ?>" data-toggle="tooltip" title="KK" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="alamat_verify" value="1" <?= $request->alamat_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="alamat_verify" value="0" <?= $request->alamat_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- DESA -->
                    <?php if ($request->desa) : ?>
                      <div class="form-group">
                        <label for="">Desa</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->desa ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                            <button role="button" data-attachment-filename="<?= $request->kk_path ?>" data-toggle="tooltip" title="KK" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="desa_verify" value="1" <?= $request->desa_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="desa_verify" value="0" <?= $request->desa_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- KECAMATAN -->
                    <?php if ($request->kec) : ?>
                      <div class="form-group">
                        <label for="">Kecamatan</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->kec ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                            <button role="button" data-attachment-filename="<?= $request->kk_path ?>" data-toggle="tooltip" title="KK" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="kec_verify" value="1" <?= $request->kec_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="kec_verify" value="0" <?= $request->kec_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- KABUPATEN  -->
                    <?php if ($request->kab) : ?>
                      <div class="form-group">
                        <label for="">Kabupaten</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->kab ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                            <button role="button" data-attachment-filename="<?= $request->kk_path ?>" data-toggle="tooltip" title="KK" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="kab_verify" value="1" <?= $request->kab_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="kab_verify" value="0" <?= $request->kab_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- PROVINSI -->
                    <?php if ($request->provinsi) : ?>
                      <div class="form-group">
                        <label for="">Provinsi</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->provinsi ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                            <button role="button" data-attachment-filename="<?= $request->kk_path ?>" data-toggle="tooltip" title="KK" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="provinsi_verify" value="1" <?= $request->provinsi_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="provinsi_verify" value="0" <?= $request->provinsi_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- KODEPOS -->
                    <?php if ($request->kodepos) : ?>
                      <div class="form-group">
                        <label for="">Kode POS</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->kodepos ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->ktp_path ?>" data-toggle="tooltip" title="KTP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                            <button role="button" data-attachment-filename="<?= $request->kk_path ?>" data-toggle="tooltip" title="KK" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="kodepos_verify" value="1" <?= $request->kodepos_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="kodepos_verify" value="0" <?= $request->kodepos_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- ALAMAT KOS -->
                    <?php if ($request->almt_kost) : ?>
                      <div class="form-group">
                        <label for="">Alamat (Kost / Domisili)</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <textarea class="form-control"><?= $request->almt_kost ?></textarea>
                          </div>
                          <div class="col-lg-2">
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="almt_kost_verify" value="1" <?= $request->almt_kost_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="almt_kost_verify" value="0" <?= $request->almt_kost_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- TELEPON -->
                    <?php if ($request->telepon) : ?>
                      <div class="form-group">
                        <label for="">No HP</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->telepon ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="telepon_verify" value="1" <?= $request->telepon_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="telepon_verify" value="0" <?= $request->telepon_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- NO HP -->
                    <?php if ($request->nohp) : ?>
                      <div class="form-group">
                        <label for="">No Whatsapp</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->nohp ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="nohp_verify" value="1" <?= $request->nohp_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="nohp_verify" value="0" <?= $request->nohp_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- EMAIL -->
                    <?php if ($request->email) : ?>
                      <div class="form-group">
                        <label for="">Email</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->email ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="email_verify" value="1" <?= $request->email_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="email_verify" value="0" <?= $request->email_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- STAT NIKAH -->
                    <?php if ($request->statnikah) : ?>
                      <div class="form-group">
                        <label for="">Status Nikah</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <?php
                            function getMarriedStatus($key)
                            {
                              $married_status = [
                                'K' => 'Nikah',
                                'BK' => 'Belum Nikah',
                                'TK' => 'Tidak Nikah',
                                '-' => '-',
                                'KS' => 'Kawin Single'
                              ];
                              if (in_array($key, array_keys($married_status))) return $married_status[$key];
                              else return '';
                            }
                            ?>
                            <span type="text" class="form-control">
                              <?= getMarriedStatus($request->statnikah) ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->akta_nikah_path ?>" data-toggle="tooltip" title="Akta Nikah" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="statnikah_verify" value="1" <?= $request->statnikah_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="statnikah_verify" value="0" <?= $request->statnikah_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- TANGGAL NIKAH -->
                    <?php if ($request->tglnikah) : ?>
                      <div class="form-group">
                        <label for="">Tanggal Nikah</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->tglnikah ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->akta_nikah_path ?>" data-toggle="tooltip" title="Akta Nikah" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="tglnikah_verify" value="1" <?= $request->tglnikah_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="tglnikah_verify" value="0" <?= $request->tglnikah_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- NPWP -->
                    <?php if ($request->npwp) : ?>
                      <div class="form-group">
                        <label for="">NPWP</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->npwp ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->npwp_path ?>" data-toggle="tooltip" title="NPWP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="npwp_verify" value="1" <?= $request->npwp_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="npwp_verify" value="0" <?= $request->npwp_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- STAT PAJAK -->
                    <?php if ($request->statpajak) : ?>
                      <div class="form-group">
                        <label for="">Stat Pajak</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <?php
                            function getTaxStatus($key)
                            {
                              $tax_status = [
                                'K' => 'Kawin',
                                'BK' => 'Belum Kawin',
                                'TK' => 'Tidak Kawin',
                                '-' => '-'
                              ];
                              if (in_array($key, array_keys($tax_status))) return $tax_status[$key];
                              else return '';
                            }

                            ?>
                            <span type="text" class="form-control">
                              <?= getTaxStatus($request->statpajak) ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->npwp_path ?>" data-toggle="tooltip" title="NPWP" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="statpajak_verify" value="1" <?= $request->statpajak_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="statpajak_verify" value="0" <?= $request->statpajak_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- NO BPJS KETENAGA KERJAAN -->
                    <?php if ($request->no_peserta_bpjsket) : ?>
                      <div class="form-group">
                        <label for="">No BPJS Ketenagakerjaan</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->no_peserta_bpjsket ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->bpjsket_path ?>" data-toggle="tooltip" title="BPJS Ketenagakerjaan" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="no_peserta_bpjsket_verify" value="1" <?= $request->no_peserta_bpjsket_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="no_peserta_bpjsket_verify" value="0" <?= $request->no_peserta_bpjsket_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>

                    <!-- NO BPJS KESEHATAN -->
                    <?php if ($request->no_peserta_bpjskes) : ?>
                      <div class="form-group">
                        <label for="">No BPJS Kesehatan</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <span type="text" class="form-control">
                              <?= $request->no_peserta_bpjskes ?>
                            </span>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $request->bpjskes_path ?>" data-toggle="tooltip" title="BPJS Kesehatan" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                          <div class="col-lg-4">
                            <label class="checkbox-inline pl-0"><input type="radio" name="no_peserta_bpjskes_verify" value="1" <?= $request->no_peserta_bpjskes_verify  == 't' ? 'checked' : '' ?>>Ok</label>
                            <label class="checkbox-inline ml-2"><input type="radio" name="no_peserta_bpjskes_verify" value="0" <?= $request->no_peserta_bpjskes_verify  != 't' ? 'checked' : '' ?>>Not Ok</label>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>
                    <?php if (count($family)) : ?>
                      <div class="table-responsive">
                        <h3>
                          Keluarga
                          <button role="button" class="btn btn-secondary attachment-modal-trigger" data-toggle="tooltip" data-attachment-filename="<?= $request->kk_path ?>" title="Kartu Keluarga">
                            <i class="fa fa-image"></i>
                          </button>
                        </h3>

                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <td>Nama</td>
                              <td>Jenis Anggota</td>
                              <td>Tgllahir</td>
                              <td>NIK</td>
                              <td>Serumah</td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($family as $i => $people) : ?>
                              <tr>
                                <td><?= $people->nama ?></td>
                                <td><?= $people->jenisanggota ?></td>
                                <td><?= date('d/m/Y', strtotime($people->tgllahir)); ?></td>
                                <td><?= $people->nik ?></td>
                                <td><?php 
                                
                                switch ($people->serumah) {
                                  case 't':
                                    $isi = "fa-check";
                                    $color = "green";
                                    break;
                                  case 'f':
                                    $isi = "fa-times";
                                    $color = "red";
                                    break;
                                  default:
                                    $isi = "fa-question";
                                    $color = "grey";
                                    break;
                                }
                                echo "<span class='fa $isi' style='color: $color'></span>";
                                ?></td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                    <?php endif ?>
                    <?php 
                    if (isset($vaccination) && !empty($vaccination)) {
                      foreach ($vaccination as $vac) {
                        ?>
                        <div class="form-group">
                        <label for="">Data Vaksinasi (<?= $vac['status_changes'] ?>)</label>
                        <div class="row">
                          <div class="col-lg-10">
                            <div class="form-group">
                              <label class="control-label col-lg-4">NIK</label>
                              <div class="col-lg-8">
                                <span type="text" class="form-control">
                                  <?php 
                                    echo $vac['nik'];
                                  ?>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-lg-4">Nama</label>
                              <div class="col-lg-8">
                                <span type="text" class="form-control">
                                  <?php 
                                    echo $vac['nama'];
                                  ?>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-lg-4">Kelompok</label>
                              <div class="col-lg-8">
                                <span type="text" class="form-control">
                                  <?php 
                                    echo $vac['kelompok_vaksin'];
                                  ?>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-lg-4">Tanggal</label>
                              <div class="col-lg-8">
                                <span type="text" class="form-control">
                                  <?php 
                                    echo $vac['tanggal_vaksin'];
                                  ?>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-lg-4">Jenis</label>
                              <div class="col-lg-8">
                                <span type="text" class="form-control">
                                  <?php 
                                    echo $vac['jenis_vaksin'];
                                  ?>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-lg-4">Lokasi</label>
                              <div class="col-lg-8">
                                <span type="text" class="form-control">
                                  <?php 
                                    echo $vac['lokasi_vaksin'];
                                  ?>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-lg-4">Dosis Ke</label>
                              <div class="col-lg-8">
                                <span type="text" class="form-control">
                                  <?php 
                                    echo $vac['vaksin_ke']; 
                                  ?>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-2">
                            <button role="button" data-attachment-filename="<?= $vac['path_kartu_vaksin'] ?>" data-toggle="tooltip" title="Kartu Vaksin" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                            <br>
                            <br>
                            <button role="button" data-attachment-filename="<?= $vac['path_sertifikat_vaksin'] ?>" data-toggle="tooltip" title="Sertifikat Vaksin" class="btn btn-secondary attachment-modal-trigger">
                              <i class="fa fa-image"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                        <?php
                      }
                    } 
                    ?>
                    <?php if ($request->status_req == 'pending') : ?>
                      <hr>
                      <div>
                        <h3>Berikan feedback</h3>
                        <textarea class="form-control" style="height: 80px; max-height: 80px; min-height: 80px;" name="feedback" id="" cols="30" rows="5" placeholder="Lampiran lengkap / Data sudah sesuai"><?= $request->feedback ?></textarea>
                        <h3>Keputusan</h3>
                        <select name="decide" id="" class="form-control">
                          <option value="revision">Revisi</option>
                          <option value="accept" selected>Approve</option>
                          <option value="reject">Reject</option>
                        </select>
                        <button type="submit" id="verification-submit" class="btn btn-success btn-block mt-4 mx-auto px-3" style="width: 50%; border-radius: 20px;">
                          <h3 class="m-0" style="font-weight: bold;">Verifikasi</h3>
                        </button>
                      </div>
                    <?php else : ?>
                      <div>
                        <h3>Feedback</h3>
                        <textarea disabled class="form-control" style="height: 80px; max-height: 80px; min-height: 80px;" name="feedback" id="" cols="30" rows="5" placeholder="Lampiran lengkap / Data sudah sesuai"><?= $request->feedback ?></textarea>
                      </div>
                    <?php endif ?>
                  </form>
                </div>
                <div class="col-md-2">
                  <!-- whitespace -->
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="photo-wrapper p-4" style="border: 5px dotted #e8e8e8;">
                <div class="img-wrapper" style="
                  height: 4cm; 
                  width: 3cm; 
                  margin: 0 auto;
                  background-color: #e8e8e8; 
                  background-image: url('<?= $pribadi->photo ?>');
                  background-size: cover;
                  background-position: center;
                ">
                </div>
              </div>
              <!-- <img style="max-height: 200px; background-color: #e8e8e8;" src="" alt=""> -->
              <h3>Daftar Lampiran</h3>
              <div>
                <?php
                $arrayOfAttachment = [
                  [
                    'attachment_name' => "KTP",
                    'attachment_filename' => $request->ktp_path
                  ],
                  [
                    'attachment_name' => "Kartu Keluarga",
                    'attachment_filename' => $request->kk_path
                  ],
                  [
                    'attachment_name' => "Surat Keterangan Dokter",
                    'attachment_filename' => $request->sk_dokter_path
                  ],
                  [
                    'attachment_name' => "Akta Nikah",
                    'attachment_filename' => $request->akta_nikah_path
                  ],
                  [
                    'attachment_name' => "NPWP",
                    'attachment_filename' => $request->npwp_path
                  ],
                  [
                    'attachment_name' => "BPJS Ketenagakerjaan",
                    'attachment_filename' => $request->bpjsket_path
                  ],
                  [
                    'attachment_name' => "BPJS Kesehatan",
                    'attachment_filename' => $request->bpjskes_path
                  ]
                ];

                $attached = array_filter($arrayOfAttachment, function ($item) {
                  return !empty($item['attachment_filename']);
                });
                ?>
                <?php if (count($attached)) : ?>
                  <div id="lightgallery">
                    <?php foreach ($attached as $item) : ?>
                      <h4><?= $item['attachment_name'] ?></h4>
                      <a href="<?= $attachment_path . trim($item['attachment_filename']) ?>">
                        <img src="<?= $attachment_path . trim($item['attachment_filename']) ?>" alt="Kartu keluarga" class="img-fluid img-rounded attachment" style="background-color: #e8e8e8; width: 100%; border: 1px solid #e8e8e8;">
                      </a>
                    <?php endforeach ?>
                  </div>
                <?php else : ?>
                  <div class="text-center">
                    <span>Tidak ada lampiran</span>
                  </div>
                <?php endif ?>
              </div>
            </div>
            <!-- Back button on bottom -->
            <div class="col-md-12 mt-4">
              <div class="bg-secondary p-2 mb-4" style="background: #e8e8e8;">
                <a href="<?= $this->input->get('redirect') ? base_url('/MasterPekerja/Pemutihan#' . $this->input->get('redirect')) : base_url('/MasterPekerja/Pemutihan/') ?>" class="btn btn-warning">
                  <i class="fa fa-angle-left"></i>
                  Kembali
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal" id="modal-image">
  <div class="modal-dialog" style="width: 1000px;">
    <div class="modal-content mx-auto" style="width: 1000px; min-width: 600px; max-width: 100%;" role="document">
      <div class="modal-body p-4" style="position: relative;">
        <a style="position: absolute; right: -2em; top: -1.5em; color: white;" data-dismiss="modal">
          <i class="fa fa-times fa-2x"></i>
        </a>
        <!-- FAILED EXPERIMENTAL -->
        <!-- <div style="position: absolute; bottom: 0; width: 200px; z-index: 999; left: 50%;">
          <button role="button" id="rotate-left" class="btn">
            <i class="fa fa-rotate-left"></i>
          </button>
          <button role="button" id="rotate-right" class="btn">
            <i class="fa fa-rotate-right"></i>
          </button>
        </div> -->
        <div class="mb-4 mx-4 p-2 text-center">
          <h2 id="modal-image-label" class="m-0" style="font-weight: 600;"></h2>
          <h4 id="modal-image-value"></span>
        </div>
        <img data-dismiss="modal" title="Klik gambar untuk menutup popup" class="img-responsive img-rounded" id="modal-image-preview" src="" alt="">
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('/assets/plugins/lightgallery.js/dist/js/lightgallery.min.js') ?>"></script>
<script src="<?= base_url('/assets/plugins/lightgallery.js/modules/lg-rotate.min.js') ?>"></script>
<script src="<?= base_url('/assets/plugins/lightgallery.js/modules/lg-zoom.min.js') ?>"></script>
<script src="<?= base_url('/assets/plugins/lightgallery.js/modules/lg-hash.min.js') ?>"></script>
<script>
  <?php if ($request->status_req !== 'pending') : ?>
    $('input[type=radio]').prop('readonly', true)
  <?php endif ?>

  $(document).ready(function() {
    $("#lightgallery").lightGallery();
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<script>
  // on leave page
  window.onbeforeunload = function(e) {
    e.preventDefault()
    <?php if ($session === $user) : ?>
      $.ajax({
        method: 'POST',
        data: {
          id: '<?= $request->id_req ?>'
        },
        url: baseurl + 'MasterPekerja/Pemutihan/api/list/detail/leavepage',
        complete() {
          e.returnValue = ''
        }
      })
    <?php endif ?>
  }
</script>
<script>
  !(function() {
    const attachment_base_link = "<?= $attachment_path ?>"

    $('img.attachment').click(function() {
      return
      const img_path = $(this).attr('src')

      $('#modal-image').find('img').attr('src', img_path)
      $('#modal-image').modal('toggle')
      // $('#modal-image img#modal-image-preview').css('transform', 'rotate(0deg)');
    });

    // the radio should be "Ya", or it will return false
    // ini ngecek apakah ada yg dicentang TIDAK, jika tidak maka bakal return true
    const checkIsHasNotValidRadio = () => {
      let arrayOfNo = []
      $('input[type=radio]:checked').each(function() {
        const val = $(this).val()
        if (val == 0) {
          arrayOfNo.push(val)
        }
      })

      return arrayOfNo.length > 0; // boolean
    }

    // checking radio when submit
    $('form').submit(function(e) {
      $('#verification-submit').prop('disabled', true)
      const decide = $('select[name=decide]').val()
      // cek apakah ^read atas
      if (checkIsHasNotValidRadio() && decide === 'accept') {
        Swal.fire({
          title: 'Tidak dapat mengapprove',
          text: 'Ada verifikasi yang tidak OK',
          type: 'warning'
        })

        return false; // return false will cancel submit event
      }
    })

    // attachment button
    $('button.attachment-modal-trigger').click(function(e) {
      e.preventDefault()
      const attachment_name = $(this).data('attachment-name')
      const attachment_filename = $(this).data('attachment-filename')
      const label = $(this).closest('.form-group').find('label').first().text()
      const value = $(this).closest('.form-group').find('.form-control').text()

      if (!attachment_filename) return alert("Lampiran kosong")

      $('#modal-image').find('img').attr('src', attachment_base_link + attachment_filename)
      $('#modal-image').find('#modal-image-label').text(label + ' :')
      $('#modal-image').find('#modal-image-value').text(value)
      $('#modal-image').modal('toggle')
    });

    // rotate image
    (function() {
      const $imgElement = $('#modal-image img#modal-image-preview')
      let degree = 0;
      $('#modal-image').find('button#rotate-left').click(function() {
        degree += 90;
        $imgElement.css('transform', `rotate(${degree}deg)`)
      })
      $('#modal-image').find('button#rotate-right').click(function() {
        degree += -90;
        $imgElement.css('transform', `rotate(${degree}deg)`)
      })
    })();
  })();
</script>