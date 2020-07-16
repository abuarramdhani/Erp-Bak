<table class="table table-bordered dataTable">
  <thead class="bg-primary">
    <tr>
      <th width="5%" class="text-center">No.</th>
      <th class="text-center">Action</th>
      <th class="text-center">Jenis</th>
      <th class="text-center">Periode Cutoff</th>
      <th class="text-center">Tanggal Pembuatan</th>
      <th style="text-align:center;">Deleted By</th>
      <th style="text-align:center;">Deleted At</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no   =  1;
    foreach ($data as $key) { ?>
      <tr>
        <td class="text-center">
          <?php echo $no; ?>
        </td>
        <td class="text-center">
          <!-- <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/gajipekerjacutoff/exportPDF/' . $key['id']); ?>" data-toggle="tooltip" data-placement="bottom" title="Export PDF"><span class="fa fa-file-pdf-o fa-2x"></span></a> -->
          <!-- <a class="fa fa-trash fa-2x deleteMemoCutoff" data-toggle="tooltip" data-placement="bottom" title="Hapus Memo" data-value="<?php echo $key['id'] ?>"></a> -->
          <button onclick="restore('<?= $key['id'] ?>')" class="btn btn-sm btn-success">
            <i class="fa fa-refresh"></i>
            <span> Restore</span>
          </button>
        </td>
        <td class="text-center">
          <?php if ($key['staff'] == 't') {
            $status = 'Staf';
          } elseif ($key['staff'] == 'f') {
            $status = 'Non Staf';
          }
          echo $status; ?>
        </td>
        <td class="text-center"><?php echo $key['periode']; ?></td>
        <td class="text-center"><?php echo $key['update_date']; ?></td>
        <td><?php echo $key['deleted_by'] ?></td>
        <td><?= date('Y-m-d H:i:s', strtotime($key['deleted_date'])) ?></td>
      </tr>
    <?php
      $no++;
    } ?>
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
        surat: 'cutoff',
      },
      success() {
        window.location.reload()
      }
    })
  }
</script>