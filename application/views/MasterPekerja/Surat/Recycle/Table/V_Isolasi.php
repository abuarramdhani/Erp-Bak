<table class="table table-striped table-hover table-bordered dataTable">
  <thead class="bg-primary">
    <tr>
      <th>No.</th>
      <th>Action</th>
      <th>No. Surat</th>
      <th>Pekerja</th>
      <th>Tanggal Wawancara</th>
      <th>Tanggal Cetak</th>
      <th style="text-align:center;">Deleted By</th>
      <th style="text-align:center;">Deleted At</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($data) && !empty($data)) {
      $nomor = 1;
      foreach ($data as $dt) {
        $encrypted_string = $this->general->enkripsi($dt['id_isolasi_mandiri']);
    ?>
        <tr>
          <td><?php echo $nomor ?></td>
          <td style="text-align: center">
            <!-- <a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Ubah/' . $encrypted_string) ?>" class="btn btn-primary">Edit</a>
            <a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/PDF/' . $encrypted_string) ?>" target="_blank" class="btn btn-warning">PDF</a>
            <a href="<?php echo site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Hapus/' . $encrypted_string) ?>" class="btn btn-danger" onclick="return confirm('apakah anda yakin ingin menghapus data ini ?')">Delete</a> -->
            <button onclick="restore('<?= $encrypted_string ?>')" class="btn btn-sm btn-success">
              <i class="fa fa-refresh"></i>
              <span> Restore</span>
            </button>
          </td>
          <td><?php echo $dt['no_surat'] ?></td>
          <td><?php echo $dt['pekerja'] ?></td>
          <td><?php echo $dt['tgl_wawancara'] ?></td>
          <td><?php echo $dt['tgl_cetak'] ?></td>
          <td><?php echo $dt['deleted_by'] ?></td>
          <td><?= date('Y-m-d H:i:s', strtotime($dt['deleted_date'])) ?></td>
        </tr>
    <?php
        $nomor++;
      }
    }
    ?>
  </tbody>
</table>
<script>
  function restore(id) {
    const conf = confirm('Yakin untuk restore surat ini ?')
    if (!conf) return

    $.ajax({
      url: '<?= base_url('MasterPekerja/Surat/Recycle/Restore') ?>',
      method: 'POST',
      data: {
        id: id,
        surat: 'isolasi',
      },
      success() {
        window.location.reload()
      }
    })
  }
</script>