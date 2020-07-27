<style>
  html {
    scroll-behavior: smooth;
  }

  .flex-row {
    display: flex;
    flex-direction: row;
  }

  .bold {
    font-weight: bold;
  }

  .mr-2 {
    margin-right: 2em;
  }

  .p-0 {
    padding: 0 !important;
  }

  .navbar-float a div:hover,
  .navbar-float a.active {
    background-color: #3c8dfa !important;
  }

  .with-bg {
    padding: 7px 1em;
    border: 1px solid #d2d6de;
  }

  .m-0 {
    margin: 0;
  }

  table {
    width: 100%;
    margin: 0;
  }

  table.bordered {
    padding: 0;
    border-collapse: collapse;
  }

  table.bordered td {
    border: 1px solid black;
  }

  .centered td,
  .centered th {
    text-align: center;
  }

  table.bordered thead td,
  table.bordered thead th {
    font-weight: bold;
  }

  table.bordered th,
  table.bordered td {
    border: 1px solid black;
  }

  table.header>tr {
    height: 100px;
  }

  .logo {
    width: 60px;
    height: auto;
  }

  /* ------------------------------------------------ */
  .title {
    background-color: #C0C0C0;
    width: 100%;
    font-weight: bold;
  }

  .center {
    text-align: center;
  }

  .text-left {
    text-align: left;
  }

  .text-top-left {
    text-align: left;
    vertical-align: top;
  }

  .bold {
    font-weight: bold;
  }

  [v-cloak] {
    display: none;
  }
</style>
<section id="app">
  <div class="row" style="margin: 1em;">
    <div class="box">
      <div class="box-header">
        <div style="display: flex; justify-content: space-between;">
          <h3>Blanko Evaluasi Non Staf dan Outsourcing</h3>
          <div>

            <a href="<?= base_url('BlankoEvaluasi/NonStaff/') ?>/Create" class="btn btn-primary">
              <i class="fa fa-plus"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table id="tableBlanko" class="table table-bordered table-striped">
            <thead>
              <tr class="bg-primary">
                <th>No</th>
                <th>Cetak</th>
                <th>No Induk</th>
                <th>Nama</th>
                <th>Seksi</th>
                <th>Periode</th>
                <th>Dibuat</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($blanko as $no => $item) : ?>
                <?php
                $decryptId = base64_encode('0000000' . $item['id']);
                ?>
                <tr>
                  <td><?= $no + 1 ?></td>
                  <td>
                    <a href="<?= base_url('BlankoEvaluasi/NonStaff/Blanko') . '?id=' . $decryptId ?>" target="_blank" class="btn btn-sm btn-danger">
                      <i class="fa fa-file-pdf-o"></i>
                    </a>
                  </td>
                  <td><?= $item['noind'] ?></td>
                  <td><?= $item['nama'] ?></td>
                  <td><?= strstr($item['seksi'], ' /', true) ?></td>
                  <td><?= date('d/m/Y', strtotime($item['tanggal_awal'])) . " - " . date('d/m/Y', strtotime($item['tanggal_akhir'])) ?></td>
                  <td><?= date('d/m/Y H:i:s', strtotime($item['created_time'])) ?></td>
                  <td>
                    <form action="<?= base_url('BlankoEvaluasi/NonStaff/Delete') ?>" method="post">
                      <input type="hidden" name="id" value="<?= $decryptId ?>" class="hidden">
                      <button class="handleDelete" type="button">
                        <i class="fa fa-trash"></i>
                        <span>Hapus</span>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- <script src="<?= base_url('assets/plugins/vue/vue@2.6.11.dev.js') ?>"></script> -->
<script>
  // if vanilla can, why not ?
  const d = document
  const w = window
  $(() => {
    $('#tableBlanko').dataTable()
    $('.handleDelete').click(function() {
      const form = $(this).closest('form')

      swal.fire({
        title: 'Yakin untuk menghapus blanko ?',
        text: 'Pastikan tidak salah menghapus',
        type: 'question',
        showCancelButton: true
      }).then(({
        value
      }) => {
        if (value) {
          form.submit()
        }
      })
    })

  })
</script>