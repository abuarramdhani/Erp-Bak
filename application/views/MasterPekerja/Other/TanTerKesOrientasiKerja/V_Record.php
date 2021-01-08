<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading" style="display: flex; justify-content: space-between;">
          <a href="<?= base_url('MasterPekerja/TanTerKesOrientasiKerja') ?>">
            <button class="btn btn-default">
              <i class="fa fa-arrow-left"></i>
              <span>Kembali</span>
            </button>
          </a>
          <h3 style="text-align: right;">Record Tanda Terima Kesepakatan Orientasi Kerja</h3>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
            <form action="<?= base_url('MasterPekerja/TanTerKesOrientasiKerja/record') ?>" method="GET" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <label for="">Tanggal</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <input type="text" name="tanggal" value="<?= (isset($_GET['tanggal']) && $_GET['tanggal']) ? $_GET['tanggal'] : '' ?>" placeholder="Filter tanggal" autocomplete="off" class="form-control date">
                  <small style="color: red">*Kosongkan untuk tampilkan semua data</small>
                </div>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                  <span>Cari</span>
                  <i class="fa fa-search-choice"></i>
                </button>
              </div>
            </form>
          </div>
          <br>
          <div>
            <table class="table table-hover table-bordered table-responsive">
              <thead>
                <tr>
                  <th style="text-align: center;">No</th>
                  <th style="text-align: center;">No Induk</th>
                  <th style="text-align: center;">Nama</th>
                  <th style="text-align: center;">Seksi</th>
                  <th style="text-align: center;">Tgl Pembuatan</th>
                  <th style="text-align: center;">Lokasi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($data as $key) :
                  $id = bin2hex(base64_encode($key['id']));
                ?>
                  <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td><?= $key['noind'] ?></td>
                    <td><?= $key['nama'] ?></td>
                    <td align="center"><?= $key['seksi'] ?></td>
                    <td><?= date('d-m-Y', strtotime($key['created_timestamp'])) ?></td>
                    <td><?= $key['lokasi'] ?></td>
                  </tr>
                <?php
                  $no++;
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    $(() => {
      $('table').dataTable()
      $('.date').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true
      })
    })
  </script>
</body>