<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading" style="display: flex; justify-content: space-between;">
          <a href="<?= base_url('MasterPekerja/TanTerKesepakatan/record') ?>">
            <button class="btn btn-warning">
              <span>Record</span>
              <i class="fa fa-server"></i>
            </button>
          </a>
          <h3 style="text-align: right;">Cetak Tanda Terima Kesepakatan</h3>
        </div>
        <div class="panel-body">
          <div class="form-group" style="padding-bottom: 1em;">
            <button class="btn btn-success pull-left">
              <a style="color: white" href="<?php echo base_url('MasterPekerja/TanTerKesepakatan/excel') ?>">
                <i class="fa fa-file-excel-o"></i>
                <span>Export Excel</span>
              </a>
            </button>
            <button class="btn btn-default pull-right text-muted">
              <a class="text-muted" data-toggle="modal" data-target="#modalCetakBPJSKes">Tambah Nama</a>
            </button>
            <a href="<?php echo base_url('MasterPekerja/TanTerKesepakatan/delete_all') ?>" class="btn btn-danger pull-right" style="margin-right: 20px;" onclick="return confirm('Apakah anda yakin ingin mengosongkan tabel ini ?')">Kosongkan Tabel</a>
          </div>
          <br>
          <div>
            <table id="tbl_datacetak" class="table table-hover table-bordered table-responsive">
              <thead>
                <tr>
                  <th style="text-align: center;">No</th>
                  <th style="text-align: center;">No Induk</th>
                  <th style="text-align: center;">Nama</th>
                  <th style="text-align: center;">Seksi</th>
                  <th style="text-align: center;">Tgl Masuk</th>
                  <th style="text-align: center;">Lokasi</th>
                  <th style="text-align: center;">Hapus</th>
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
                    <td><?= date('d-m-Y', strtotime($key['tgl_masuk'])) ?></td>
                    <td><?= $key['lokasi'] ?></td>
                    <td align="center">
                      <a href="<?php echo base_url('MasterPekerja/TanTerKesepakatan/delete' . '/' . $id); ?>"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                  </tr>
                <?php
                  $no++;
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="modalCetakBPJSKes" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>Masukan Pekerja</h3>
                </div>
                <div class="modal-body">
                  <form method="POST" action="<?php echo base_url('MasterPekerja/TanTerKesepakatan/insert'); ?>">
                    <select name="tt_noind" id="cetaktanterbpjs-pekerja_bpjs" class="form-control" style="width: 100%" required="required">

                    </select>
                    <br><br>
                    <button type="submit" class="btn btn-default">Tambahkan</button>
                  </form>
                </div>
                <div class="modal-footer">

                </div>
              </div>
            </div>
          </div>
          <!-- Modal-End-->
        </div>
      </div>
    </div>
  </section>
</body>