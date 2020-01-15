
<div class="box box-primary box-solid">
    <div class="box-header with-border text-center">Rekap Izin Keluar Pribadi</div>
        <div class="box-body">
          <div id="ikp-ok">
          <table class="table table-striped table-bordered table-hover tabel_rekap" data-export-title="Rekap Izin Keluar Pribadi" style="width: 100%">
            <thead>
              <tr>
                <th class="text-center" style="white-space: nowrap;">No</th>
                <th class="text-center" style="white-space: nowrap;">ID Izin</th>
                <th class="text-center" style="white-space: nowrap;">Tanggal Pengajuan</th>
                <th class="text-center" style="white-space: nowrap;">Nama Pekerja</th>
                <th class="text-center" style="white-space: nowrap;">Jenis Izin</th>
                <th class="text-center" style="white-space: nowrap;">Pekerjaan Diserahkan</th>
                <th class="text-center" style="white-space: nowrap;">Atasan Approved</th>
                <th class="text-center" style="white-space: nowrap;">Keterangan</th>
                <th class="text-center" style="white-space: nowrap;">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($IzinApprove as $row) { ?>
                <tr>
                  <td style="white-space: nowrap;"><?php echo $no; ?></td>
                  <td style="white-space: nowrap;"><?php echo $row['id'] ?></td>
                  <td style="white-space: nowrap;"><?= date("d F Y", strtotime($row['created_date'])); ?></td>
                  <td style="white-space: nowrap;"><?php $noind = explode(', ', $row['noind']);
                   foreach ($noind as $kalue) {
                     foreach ($nama as $kuy) {
                       if ($kalue == $kuy['noind']) {
                         echo $kuy['noind'].' - '.$kuy['nama'].'<br>';
                       }
                     }
                   } ?></td>
                  <td style="text-align: center; white-space: nowrap;"><p>Pribadi</p></td>
                  <td style="text-align: center; white-space: nowrap;"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                            echo "-";
                        } else {
                            echo $row['diserahkan'];
                        } ?></td>
                  <td style="white-space: nowrap;"><?php foreach ($nama as $key) {
                    if ($row['atasan'] == $key['noind']) {
                      echo $key['noind'].' - '.$key['nama'];
                    }
                  } ?></td>
                  <td style="white-space: nowrap;"><?php echo $row['keperluan'] ?></td>
                    <td><?php
                          if ($row['status'] == 0) { ?>
                              <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                          <?php } elseif ($row['status'] >= 1) { ?>
                               <span class="label label-success">Approved</span>
                          <?php } elseif ($row['status'] == 5) { ?>
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
