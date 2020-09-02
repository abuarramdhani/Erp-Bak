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
            <th class="text-center" style="white-space: nowrap;">Jenis Izin</th>
            <!-- <th class="text-center" style="white-space: nowrap;">Pekerjaan Diserahkan</th> -->
            <th class="text-center" style="white-space: nowrap;">Atasan Approved</th>
            <th class="text-center" style="white-space: nowrap;">Keterangan</th>
            <th class="text-center" style="white-space: nowrap;">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($IzinApprove as $row) { ?>
            <tr>
              <td style="white-space: nowrap;"><?= $no; ?></td>
              <td <?= $hiden; ?> style="white-space: nowrap;" id="tdCheckManual<?= $no; ?>">
                <?php if ($row['manual'] == 't') { ?>
                  <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                <?php } else { ?>
                  <input type="checkbox" class="checkChildPribadi" data-id="checkValManual<?= $no; ?>" value="<?= $row['id']; ?>">
                <?php } ?>
              </td>
              <td style="white-space: nowrap;"><?= $row['id'] ?></td>
              <td style="white-space: nowrap;"><?= date("d F Y", strtotime($row['created_date'])); ?></td>
              <td style="white-space: nowrap;">
                <?php foreach (explode(',', $row['nama_pkj']) as $key) : ?>
                  <p><?= $key ?></p>
                <?php endforeach ?>
              </td>
              <td style="text-align: left; white-space: nowrap;"><?= $row['jenis_ijin'] ?></td>
              <td style="white-space: nowrap;"><?= $row['atasan'] . ' - ' . $row['nama_atasan'] ?></td>
              <td style="white-space: nowrap;"><?= $row['ket_pekerja'] ?></td>
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