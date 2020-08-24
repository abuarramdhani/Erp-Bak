<table class="table table-striped table-bordered table-hover dataTable">
  <thead class="bg-primary">
    <tr>
      <th>No</th>
      <th style="width: 100px">Action</th>
      <th>No Induk</th>
      <th>Nama</th>
      <th>No Induk baru</th>
      <th>Tanggal Resign</th>
      <th>Sebab Resign</th>
      <th>Diterima HubKer</th>
      <th>DiCutoff</th>
      <th>Dibuat</th>
      <th style="text-align:center;">Deleted By</th>
      <th style="text-align:center;">Deleted At</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($data) && !empty($data)) {
      $nomor = 1;
      foreach ($data as $dt) {
        $id_encrypted = $this->general->enkripsi($dt['pengajuan_id']);
    ?>
        <tr>
          <td><?= $nomor ?></td>
          <td>
            <!-- <a href="<?php echo site_url('MasterPekerja/Surat/SuratResign/edit/' . $id_encrypted) ?>" class="btn btn-primary btn-sm">
              <span class="fa fa-wrench"></span>Edit
            </a>
            <a href="<?php echo site_url('MasterPekerja/Surat/SuratResign/delete/' . $id_encrypted) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?')">
              <span class="fa fa-trash"></span>Hapus
            </a> -->
            <button onclick="restore('<?= $id_encrypted ?>')" class="btn btn-sm btn-success">
              <i class="fa fa-refresh"></i>
              <span> Restore</span>
            </button>
          </td>
          <td><?php echo $dt['noind'] ?></td>
          <td><?php echo $dt['nama'] ?></td>
          <td><?php echo $dt['noind_baru'] ?></td>
          <td><?php echo strftime("%d %B %Y", strtotime($dt['tgl_resign'])) ?></td>
          <td><?php echo $dt['sebab'] ?></td>
          <td><?php echo strftime("%d %B %Y", strtotime($dt['tgl_diterima'])) ?></td>
          <td><?php echo $dt['reffgaji'] ? $dt['reffgaji'] : 'Belum Dihitung' ?></td>
          <td><?php echo strftime("%d %B %Y %X", strtotime($dt['creation_date'])) ?></td>
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
        surat: 'resign',
      },
      success() {
        window.location.reload()
      }
    })
  }
</script>