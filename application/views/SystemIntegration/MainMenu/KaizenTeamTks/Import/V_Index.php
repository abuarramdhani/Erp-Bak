<section class="content">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div style="display: flex; justify-content: flex-end;">
        <h1>Import Excel</h1>
      </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <?php if ($this->session->flashdata('inserted_amount')) : ?>
            <div class="alert alert-success">
              Sukses mengimport <?= $this->sesion->flashdata('inserted_amount') ?> kaizen tervalidasi
            </div>
          <?php elseif ($this->session->flashdata('failed')) : ?>
            <div class="alert alert-danger">
              <?= $this->session->flashdata('failed') ?>
            </div>
          <?php elseif ($this->session->flashdata('not_valid')) : ?>
            <div class="alert alert-danger">
              <?= $this->session->flashdata('not_valid') ?>
            </div>
          <?php endif ?>
        </div>
        <div class="col-md-4">
          <form action="<?= base_url('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import/doImport') ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label class="label-control" for="">Tahun</label>
              <input type="text" class="form-control js-year-picker" value="<?= date('Y') ?>" name="year" <?= isset($import_result_data)  ? 'disabled' : '' ?>>
            </div>
            <div class="form-group">
              <label class="label-control" for="">File excel</label>
              <input type="file" name="file" id="" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" <?= isset($import_result_data) ? 'disabled' : '' ?>>
              <small class="text-danger">*) Max ukuran 1 MB</small>
            </div>
            <button class="btn btn-primary btn-block" <?= isset($import_result_data) ? 'disabled' : '' ?>>
              Preview
            </button>
          </form>
        </div>
        <?php if (isset($import_result_data)) : ?>
          <div class="col-md-8">
            <div class="bordered rounded pt-4" style="display: flex; justify-content: center; align-items: center;">
              <form action="<?= base_url('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import/executeImport') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="year" value="<?= isset($year) && !empty($year) ? $year : '' ?>">
                <div class="p-2 border">
                  <button class="btn btn-success mt-4" style="font-size: 15px;">
                    Import Sekarang
                    <i class="fa fa-upload"></i>
                  </button>
                  <br>
                  <div class="mt-3 text-center">
                    <a class="block text-danger" href="./">Batal</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <?php endif ?>
        <?php if (isset($import_result_data)) : ?>
          <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-header">
                Preview Excel
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table-preview" class="table table-bordered">
                    <thead>
                      <tr>
                        <?php foreach ($import_result_data['head'] as $title) : ?>
                          <td><?= $title ?></td>
                        <?php endforeach ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($import_result_data['body'] as $row) : ?>
                        <tr>
                          <?php foreach ($row as $cell) : ?>
                            <td><?= $cell ?></td>
                          <?php endforeach ?>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php else : ?>
          <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-header">
                Riwayat Import
              </div>
              <div class="card-body">
                <?php if ($this->session->flashdata('delete.success')) : ?>
                  <div class="alert alert-success">
                    <?= $this->session->flashdata('delete.success') ?>
                  </div>
                <?php elseif ($this->session->flashdata('delete.error')) : ?>
                  <div class="alert alert-danger">
                    <?= $this->session->flashdata('delete.error') ?>
                  </div>
                <?php endif ?>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Batch</th>
                        <th>Jumlah kaizen</th>
                        <th>User</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($importHistory) && count($importHistory) > 0) : ?>
                        <?php foreach ($importHistory as $history) : ?>
                          <tr>
                            <td><?= $history->import_at ?></td>
                            <td><?= $history->import_batch_id ?></td>
                            <td><?= $history->amount ?></td>
                            <td><?= $history->import_by . " - " . $history->import_by_name ?></td>
                            <td>
                              <a href="<?= base_url('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import/History/' . $history->import_batch_id) ?>" class="btn btn-primary">Lihat</a>
                            </td>
                          </tr>
                        <?php endforeach ?>
                      <?php else : ?>
                        <tr>
                          <td class="text-center" colspan="5">Belum ada histori import</td>
                        </tr>
                      <?php endif ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>

<script>
  $(() => {
    // window.setTimeout(function() {
    //   $(".alert").fadeTo(2000, 0).slideUp(2000, function() {
    //     $(this).remove();
    //   });
    // }, 5000);

    $('.js-year-picker').datepicker({
      format: 'yyyy',
      minViewMode: 'years',
      viewMode: 'years'
    })
    $('#table-preview').DataTable()
  })
</script>