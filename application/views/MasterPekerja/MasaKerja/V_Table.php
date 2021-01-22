<table id="cmktable" class="table table-striped table-bordered table-hover">

  <thead class="bg-primary">
    <tr>
      <th width="3%">No</th>
      <th>Noind</th>
      <th>Nama</th>
      <th width="30%">Seksi</th>
      <th>Masuk Kerja</th>
      <th>Masa Kerja</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($MasaKerja as $key => $val) :
      ?>
      <tr>
        <td><?= $key + 1 ?></td>
        <td><?= $val['noind']; ?></td>
        <td><?= $val['nama']; ?></td>
        <td><?= $val['seksi']; ?></td>
        <td><?= $val['masukkerja']; ?></td>
        <td><?php $date1 = $val['pucek'];
              $date2 = "$januck";

              $diff = abs(strtotime($date2) - strtotime($date1));

              $years = floor($diff / (365 * 60 * 60 * 24));
              $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
              $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

              printf("%d Tahun, %d Bulan, %d Hari\n", $years, $months, $days);
              ?></td>

      </tr>
    <?php endforeach; ?>
  </tbody>

</table>