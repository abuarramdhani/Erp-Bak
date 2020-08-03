<table class="table table-striped table-bordered table-hover table-responsive datatable" style="width:100%; font-size:12px; overflow-x: scroll;">
  <thead class="bg-primary">
    <tr>
      <th style="text-align:center;">No</th>
      <th style="text-align:center; min-width: 80px;">Action</th>
      <th style="text-align:center;">Nomor Induk</th>
      <th style="text-align:center;">Nama</th>
      <th style="text-align:center;">Jabatan</th>
      <th style="text-align:center;">Departemen / Bidang / Unit / Seksi</th>
      <th style="text-align:center;">Tanggal Cetak</th>
      <th style="text-align:center;">Cetak</th>
      <th style="text-align:center;">Deleted By</th>
      <th style="text-align:center;">Deleted At</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($data as $surat) :
      $parameter = $this->general->enkripsi($surat['bap_id']);
    ?>
      <tr>
        <td style="text-align: center;"><?= $no++ . '.' ?></td>
        <td style="text-align: center;">
          <!-- <a target="_blank" style="margin-right:4px" href="<?= base_url('MasterPekerja/Surat/BAPSP3/previewcetak/' . $parameter . ''); ?>" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
          <a style="margin-right:4px" href="<?= base_url('MasterPekerja/Surat/BAPSP3/update/' . $parameter . ''); ?>" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
          <a href="<?= base_url('MasterPekerja/Surat/BAPSP3/delete/' . $parameter . ''); ?>" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a> -->
          <button onclick="restore('<?= $parameter ?>')" class="btn btn-sm btn-success">
            <i class="fa fa-refresh"></i>
            <span> Restore</span>
          </button>
        </td>
        <td><?= $surat['noind']; ?></td>
        <td><?= $surat['employee_name']; ?></td>
        <td><?= $surat['pekerjaan_jabatan']; ?></td>
        <td><?= $surat['section']; ?></td>
        <td style="text-align: center;"><?= $surat['tgl']; ?></td>
        <td style="text-align: center;">-</td>
        <td style="text-align: center;"><?= $surat['deleted_by'] ?></td>
        <td style="text-align: center;"><?= $surat['deleted_date'] ?></td>
      </tr>
    <?php endforeach; ?>
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
        surat: 'bapsp3',
      },
      success() {
        window.location.reload()
      }
    })
  }
</script>