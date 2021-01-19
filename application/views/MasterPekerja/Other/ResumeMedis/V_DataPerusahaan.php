<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading" style="display: flex; justify-content: space-between;">
          <a style="align-self: center !important;" href="<?= base_url('MasterPekerja/SettingResumeMedis/addPerusahaan') ?>">
            <button style="align-self: center;" class="btn btn-warning">
              <span>Tambah</span>
              <i class="fa fa-plus"></i>
            </button>
          </a>
          <h3 style=" align-self: center;">Data Perusahaan</h3>
        </div>
        <div class="panel-body">
          <div class="form-group" style="overflow-x: auto;">
            <table class="table table-hover table-bordered table-responsive" id="tbl_perusahaan">
              <thead>
                <tr class="info">
                  <th class="text-center">No</th>
                  <th class="text-center">Nama Perusahaan</th>
                  <th class="text-center">Kode Mitra</th>
                  <th class="text-center">Alamat</th>
                  <th class="text-center">No Telp</th>
                  <th class="text-center">Contact Person</th>
                  <th class="text-center">Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="show_dataPerusahaan">
                <?php
                $no = 1;
                foreach ($data_perusahaan as $data) {
                  $id_perusahaan  = $this->general->enkripsi($data->id_perusahaan);
                ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $data->nama_perusahaan; ?></td>
                    <td><?= $data->kode_mitra; ?></td>
                    <td><?= $data->alamat; ?>, Desa <?= $data->desa; ?>, Kecamatan <?= $data->kecamatan; ?>, Kota <?= $data->kota; ?></td>
                    <td><?= $data->no_telp; ?></td>
                    <td><?= $data->contact_person; ?></td>
                    <td><?= $data->keterangan; ?></td>
                    <td style="display: flex; justify-content: space-between;">
                      <a class="btn btn-warning btn-sm" href="<?= base_url('MasterPekerja/SettingResumeMedis/editPerusahaan' . '/' . $id_perusahaan); ?>">Edit</a>
                      <a href="#!" onclick="deleteConfirm('<?= base_url('MasterPekerja/SettingResumeMedis/deletePerusahaan' . '/' . $id_perusahaan); ?>')" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                  </tr>
                <?php $no++;
                } ?>
              </tbody>
            </table>
          </div>

        </div>

      </div>

      <!-- Logout Delete Confirmation-->
      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Data yang dihapus tidak akan bisa dikembalikan.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <a id="btn-delete" class="btn btn-danger" href="#">Delete</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</body>

<script>
  function deleteConfirm(url) {
    $('#btn-delete').attr('href', url);
    $('#deleteModal').modal();
  }
</script>