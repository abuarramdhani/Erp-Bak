<div class="box box-primary box-solid">
  <div class="box-header with-border text-center">Rekap Pekerja Izin Keluar Pribadi</div>
  <div class="box-body">
    <div id="ikp-ok">
      <table class="table table-striped table-bordered table-hover tabel_rekap" data-export-title="Rekap Pekerja Izin Keluar Pribadi" style="width: 100%">
        <thead>
          <tr>
            <th class="text-center" style="white-space: nowrap;">No</th>
            <th class="text-center" style="white-space: nowrap;">ID Izin</th>
            <th class="text-center" style="white-space: nowrap;">Tanggal Pengajuan</th>
            <th class="text-center" style="white-space: nowrap;">Nama Pekerja</th>
            <th class="text-center" style="white-space: nowrap;">Seksi</th>
            <th class="text-center" style="white-space: nowrap;">Lokasi Kerja</th>
            <th class="text-center" style="white-space: nowrap;">Jenis Izin</th>
            <th class="text-center" style="white-space: nowrap;">Waktu Keluar</th>
            <th class="text-center" style="white-space: nowrap;">Atasan Approved</th>
            <th class="text-center" style="white-space: nowrap; width: 10px !important;">Keterangan</th>
            <th class="text-center" style="white-space: nowrap; width: 10px;">Poin</th>
            <th class="text-center" style="white-space: nowrap;">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          $today = date('Y-m-d');
          foreach ($dataReal as $row) { ?>
            <tr>
              <td style="white-space: nowrap;"><?= $no; ?></td>
              <td style="white-space: nowrap;"><?= $row['id'] ?></td>
              <td style="white-space: nowrap;"><?= date("d F Y", strtotime($row['created_date'])); ?></td>
              <td style="white-space: nowrap;"><?= $row['nama_pkj'] ?></td>
              <td style="white-space: nowrap;"><?= $row['seksi'] ?></td>
              <td style="white-space: nowrap;"><?= $row['lokasi_kerja'] ?></td>
              <td style="text-align: left; white-space: nowrap;"><?= $row['jenis_ijin'] ?></td>
              <td style="text-align: left; white-space: nowrap;"><?= $row['keluar'] ?></td>
              <td style="white-space: nowrap;"><?= $row['atasan'] ?></td>
              <td style="width: 10px !important;"><?= $row['keperluan'] ?></td>
              <td style="width: 10px !important;"><?php
                                                  if ($row['jumlah'] > 1 && $row['point'] > 0) {
                                                    if ($row['jenis_ijin'] == 'IZIN KELUAR PRIBADI') {
                                                      if (date("Y-m-d", strtotime($row['created_date'])) == date("Y-m-d") && empty($row['point'])) {
                                                        echo  '-';
                                                      } elseif (date("Y-m-d", strtotime($row['created_date'])) <= date("Y-m-d") && empty($row['point'])) {
                                                        echo '0';
                                                      } else {
                                                        echo $row['point'];
                                                      }
                                                    } else {
                                                      echo '0';
                                                    }
                                                  } else {
                                                    if (date("Y-m-d", strtotime($row['created_date'])) == date("Y-m-d") && empty($row['point'])) {
                                                      echo '-';
                                                    } elseif (date("Y-m-d", strtotime($row['created_date'])) <= date("Y-m-d") && empty($row['point'])) {
                                                      echo '0';
                                                    } else {
                                                      echo $row['point'];
                                                    }
                                                  } ?></td>
              <td style="white-space: nowrap;"><?= $row['status']; ?></td>
            </tr>
          <?php
            $no++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>