<div class="box box-primary box-solid">
  <div class="box-header with-border text-center">Rekap Perizinan</div>
  <div class="box-body">
    <div id="ikp-ok">
      <table class="table table-striped table-bordered table-hover tabel_rekap" data-export-title="Rekap Izin Keluar Pribadi" style="width: 100%">
        <thead>
          <tr>
            <th class="text-center" style="white-space: nowrap;">No</th>
            <th <?= $hiden; ?> class="text-center" style="white-space: nowrap;">Manual</th>
            <th class="text-center" style="white-space: nowrap;">ID Izin</th>
            <th class="text-center" style="white-space: nowrap;">Tanggal Pengajuan</th>
            <th class="text-center" style="white-space: nowrap;">Nama Pekerja</th>
            <th class="text-center" style="white-space: nowrap;">Seksi</th>
            <th class="text-center" style="white-space: nowrap;">Jenis Izin</th>
            <th class="text-center" style="white-space: nowrap;">Atasan Approved</th>
            <th class="text-center" style="white-space: nowrap;">Keterangan</th>
            <th class="text-center" style="white-space: nowrap;">Status</th>
            <th class="text-center" style="white-space: nowrap;">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($IzinApprove as $row) { ?>
            <tr>
              <td style="white-space: nowrap;"><?= $no; ?></td>
              <td <?= $hiden; ?> style="white-space: nowrap; text-align: center;">
                <?php if ($row['manual'] == null) { ?>
                  <button class="btn btn-success fa fa-check checkChildPribadi" onClick="cekManualPerizinan(1, <?= $row['id']; ?>)"></button>
                  <button class="btn btn-danger fa fa-close checkChildPribadi" onClick="cekManualPerizinan(2, <?= $row['id']; ?>)"></button>
                <?php } elseif ($row['manual'] == 't') { ?>
                  <a><span style="color: green" class='fa fa-check fa-2x'></span></a><br>
                  <?= $row['set_manual'] ?>
                <?php } else if ($row['manual'] == 'f') { ?>
                  <a><span style="color: red" class='fa fa-close fa-2x'></span></a><br>
                  <?= $row['set_manual'] ?>
                <?php } else {
                  echo 'aaa'; ?>

                <?php } ?>
              </td>
              <td style="white-space: nowrap;"><?= $row['id'] ?></td>
              <td style="white-space: nowrap;"><?= date("d F Y", strtotime($row['created_date'])); ?></td>
              <td style="white-space: nowrap;">
                <?php foreach (explode(',', $row['nama_pkj']) as $key) : ?>
                  <p><?= $key ?></p>
                <?php endforeach ?>
              </td>
              <td style="white-space: nowrap;">
                <?php foreach (explode(',', $row['kodesie']) as $key) :
                  foreach ($seksi as $value) {
                    if ($key == $value['kodesie']) { ?>
                      <p><?= $value['kodesie'] . ' - ' . $value['seksi'] ?></p>
                <?php }
                  }
                endforeach ?>
              </td>
              <td style="text-align: left; white-space: nowrap;"><?= $row['jenis_ijin'] ?></td>
              <td style="white-space: nowrap;"><?= $row['atasan'] ?></td>
              <td><?= $row['keperluan'] ?></td>
              <td style="white-space: nowrap;"><?= $row['status']; ?></td>
              <td style="white-space: nowrap;">
                <?php if (date('Y-m-d') == date('Y-m-d', strtotime($row['created_date']))) { ?>
                  <button class="btn btn-danger fa fa-trash" onClick="childPribadiDelete(<?= $row['id'] ?>)"></button>
                <?php } else {
                  echo '-';
                } ?>
              </td>
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