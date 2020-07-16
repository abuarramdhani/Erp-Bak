<table class="table table-striped table-bordered table-hover text-left dataTable" style="font-size:12px;">
  <thead class="bg-primary">
    <tr>
      <th style="text-align:center;">No</th>
      <th style="text-align:center;">Action</th>
      <th style="text-align:center;">Nomor Surat</th>
      <th style="text-align:center;">Nomor Induk</th>
      <th style="text-align:center;">Nama</th>
      <th style="text-align:center;">Seksi</th>
      <th style="text-align:center;">Tanggal Cetak</th>
      <th style="text-align:center;">Update Terakhir</th>
      <th style="text-align:center;">Deleted By</th>
      <th style="text-align:center;">Deleted At</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($data as $row) :
    ?>
      <tr>
        <td align='center'><?php echo $no++; ?></td>
        <td align='center' style="white-space: nowrap;">
          <!-- <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratUsiaLanjut/previewcetak/' . $row['noind'] . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
          <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratUsiaLanjut/update/' . $row['noind'] . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
          <a href="<?php echo base_url('MasterPekerja/Surat/SuratUsiaLanjut/delete/' . $row['noind'] . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a> -->
          <button onclick="restore('<?= $row['noind'] ?>')" class="btn btn-sm btn-success">
            <i class="fa fa-refresh"></i>
            <span> Restore</span>
          </button>
        </td>
        <td>
          <?php echo $row['no_surat'] . '/' . $row['kode'] . '/' . date('m', strtotime($row['tanggal_cetak'])) . '/' . date('Y', strtotime($row['tanggal_cetak'])); ?></td>
        <td style="text-align:center;"><?php echo $row['noind']; ?>
        </td>
        <td>
          <?php echo $row['nama']; ?>
        </td>
        <td>
          <?php echo $row['seksi']; ?>
        </td>
        <td style="text-align:center;">
          <?php echo $row['tanggal_cetak']; ?>
        </td>
        <td style="text-align:center;">
          <?php if (empty($row['terakhir_update'])) {
            echo "Belum Pernah Dirubah";
          } else {
            echo $row['terakhir_update'];
          }; ?>
        </td>
        <td><?php echo $row['deleted_by'] ?></td>
        <td><?= date('Y-m-d H:i:s', strtotime($row['deleted_date'])) ?></td>
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
        surat: 'usiaLanjut',
      },
      success() {
        window.location.reload()
      }
    })
  }
</script>