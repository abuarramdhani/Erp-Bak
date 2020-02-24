
<div class="box box-primary box-solid">
    <div class="box-header with-border text-center">Rekap Perizinan Dinas</div>
        <div class="box-body">
          <div id="izin-ok">
          <table class="table table-striped table-bordered table-hover tabel_rekap" style="width: 100%">
            <thead>
              <tr>
                <th class="text-center" style="white-space: nowrap;">No</th>
                <th class="text-center" style="white-space: nowrap;">ID Izin</th>
                <th class="text-center" style="white-space: nowrap;">Tanggal Pengajuan</th>
                <th class="text-center" style="white-space: nowrap;">Nama Pekerja</th>
                <th class="text-center" style="white-space: nowrap;">Jenis Izin</th>
                <th class="text-center" style="white-space: nowrap;">Atasan Approved</th>
                <th class="text-center" style="white-space: nowrap;">Tempat Makan</th>
                <th class="text-center" style="white-space: nowrap;">Keterangan</th>
                <th class="text-center" style="white-space: nowrap;">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($IzinApprove as $row) { ?>
                <tr>
                  <td style="white-space: nowrap;"><?php echo $no; ?></td>
                  <td style="white-space: nowrap;"><?php echo $row['izin_id'] ?></td>
                  <td style="white-space: nowrap;"><?= date("d F Y", strtotime($row['created_date'])); ?></td>
                  <td style="white-space: nowrap;"><?php foreach ($row['pekerja'] as $val) {
                         if ($val == null || $val == '') {
                           echo " - <br>";
                         }else {
                           echo $val.'<br>';
                         }
                   } ?></td>
                  <td style="text-align: center; white-space: nowrap;"><?php echo $row['to_dinas'] ?></td>
                  <td style="white-space: nowrap;"><?php echo $row['atasan'] ?></td>
                  <td style="white-space: nowrap;"><?php foreach ($row['tujuan'] as $key) {
                        if ($key == null || $key == '') {
                          echo " - <br>";
                        }else {
                          echo $key.'<br>';
                        }
                  } ?></td>
                  <td style="white-space: nowrap;"><?php echo $row['keterangan'] ?></td>
                    <td><?php
                          if ($row['status'] == 0 || $row['status'] == 5) { ?>
                              <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                          <?php } elseif ($row['status'] == 1) { ?>
                               <span class="label label-success">Approved</span>
                          <?php } elseif ($row['status'] == 2) { ?>
                              <span class="label label-danger">Rejected</span>
                          <?php } ?></td>
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
