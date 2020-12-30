<table id="table_viewdata" class="table table-striped table-bordered table-hover">

  <thead class="bg-primary">
    <tr>
      <th width="3%">No</th>
      <th>Pekerja</th>
      <th>Mulai Lembur</th>
      <th>Selesai Lembur</th>

      <th>Nama Lembur</th>
      <th>Pekerjaan</th>
      <th>Makan</th>
      <th>Tempat Makan</th>

      <th>Shift</th>
      <th>Atasan</th>
      <th>Status</th>


    </tr>
  </thead>

  <tbody>
    <?php foreach ($PekerjaLembur as $key => $val) :
      ?>
      <tr>
        <td><?= $key + 1 ?></td>
        <td><?= $val['pekerja_noind'], " - ", $val['pekerja_nama']; ?></td>
        <td><?= $val['mulai']; ?></td>
        <td><?= $val['selesai']; ?></td>

        <td><?= $val['nama_lembur']; ?></td>
        <td><?= $val['pekerjaan']; ?></td>
        <td><?= $val['makan']; ?></td>
        <td><?= $val['tempat_makan']; ?></td>

        <td><?= $val['shift']; ?></td>
        <td><?= $val['atasan_noind'], " - ", $val['atasan_nama']; ?></td>
        <td><?= $val['status']; ?></td>

      </tr>
    <?php endforeach; ?>
  </tbody>

</table>