<section class="content">
  <div class="panel panel-primary">
    <div class="panel-heading" style="display: flex; justify-content: space-between;">
      <div>
        <a href="<?= base_url('/SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import') ?>" class="btn btn-warning">
          <i class="fa fa-arrow-left"></i>
          Kembali
        </a>
      </div>
      <h1 class="m-0">Riwayat Import Batch <?= $batch_id ?></h1>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <div class="pull-right">
            <form action="<?= base_url('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import/deleteBatch') ?>" method="POST">
              <input type="hidden" name="batch_id" value="<?= $batch_id ?>">
              <button role="button" id="js-delete-batch" class="btn btn-danger" title="Menghapus semua data import batch">
                <i class="fa fa-trash"></i>
                Hapus Batch
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="table-responsive mt-2">
        <table id="table-batch" class="table table-bordered">
          <thead>
            <tr>
              <td>No</td>
              <td>Tanggal</td>
              <td>Seksi</td>
              <td>Unit</td>
              <td>No induk</td>
              <td>Nama</td>
              <td>Judul Kaizen</td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($batchKaizen as $i => $kaizen) : ?>
              <tr>
                <td class="text-center"><?= $i + 1 ?></td>
                <td nowrap><?= date('Y-m-d', strtotime($kaizen->created_at)) ?></td>
                <td><?= $kaizen->section ?></td>
                <td><?= $kaizen->unit ?></td>
                <td><?= $kaizen->no_ind ?></td>
                <td><?= $kaizen->name ?></td>
                <td><?= $kaizen->kaizen_title ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<script>
  $(() => {
    $('#table-batch').DataTable()
    $('#js-delete-batch').on('click', (e) => {
      e.preventDefault();

      Swal.fire({
        title: "Apakah anda yakin untuk menghapus seluruh kaizen ?",
        text: "Data akan terhapus permanen",
        type: "warning",
        showCancelButton: true
      }).then(({
        value
      }) => {
        if (value) {
          $('form').submit()
        }
      })
    })
  })
</script>