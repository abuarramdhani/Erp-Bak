<table class="table table-striped table-bordered table-hover text-left dataTable" style="font-size:12px;">
  <thead class="bg-primary">
    <tr>
      <th style="text-align:center;">No</th>
      <th style="text-align:center;">Action</th>
      <th style="text-align:center;">Nomor Surat</th>
      <th style="text-align:center;">Tanggal Berlaku</th>
      <th style="text-align:center;">Nomor Induk</th>
      <th style="text-align:center;">Nama</th>
      <th style="text-align:center;">Kodesie Lama</th>
      <th style="text-align:center;">Kodesie Baru</th>
      <th style="text-align:center;">Lokasi Kerja Lama</th>
      <th style="text-align:center;">Lokasi Kerja Baru</th>
      <th style="text-align:center;">Tanggal Cetak</th>
      <th style="text-align:center;">Cetak</th>
      <th style="text-align:center;">Deleted By</th>
      <th style="text-align:center;">Deleted At</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($data as $row) :
      $encrypted_string = $this->general->enkripsi($row['no_surat']);
    ?>
      <tr>
        <td align='center'><?php echo $no++; ?></td>
        <td align='center' style="white-space: nowrap;">
          <!-- <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratRotasi/previewcetak/' . $encrypted_string . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
          <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratRotasi/update/' . $encrypted_string . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
          <a href="<?php echo base_url('MasterPekerja/Surat/SuratRotasi/delete/' . $encrypted_string . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a> -->
          <button onclick="restore('<?= $encrypted_string ?>')" class="btn btn-sm btn-success">
            <i class="fa fa-refresh"></i>
            <span> Restore</span>
          </button>
        </td>
        <td><?php echo $row['no_surat']; ?></td>
        <td><?php echo $row['tanggal_berlaku']; ?></td>
        <td><?php echo $row['noind']; ?></td>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['seksi_lama']; ?></td>
        <td><?php echo $row['seksi_baru']; ?></td>
        <td><?php echo $row['lokasi_kerja_lama']; ?></td>
        <td><?php echo $row['lokasi_kerja_baru']; ?></td>
        <td><?php echo $row['tanggal_cetak']; ?></td>
        <td><?php echo $row['cetak']; ?></td>
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
        surat: 'rotasi',
      },
      success() {
        window.location.reload()
      }
    })
  }
</script>