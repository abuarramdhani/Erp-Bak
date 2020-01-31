
<div class="box box-primary box-solid">
    <div class="box-header with-border text-center">Rekap Pekerja Izin Dinas</div>
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
                <th class="text-center" style="white-space: nowrap;">Status Dinas</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($pekerja as $row) { ?>
                <tr>
                  <td style="white-space: nowrap;"><?php echo $no; ?></td>
                  <td style="white-space: nowrap;"><?php echo $row['izin_id'] ?></td>
                  <td style="white-space: nowrap;"><?= date("d F Y", strtotime($row['created_date'])); ?></td>
                  <td style="white-space: nowrap;"><?php echo $row['noind'].' - '.$row['nama']; ?></td>
                  <td style="text-align: center; white-space: nowrap;"><?php if ( $row['jenis_izin'] == '1') {
                                                                  echo "DINAS PUSAT";
                                                                }elseif ( $row['jenis_izin'] == '2') {
                                                                  echo "DINAS TUKSONO";
                                                                }elseif ( $row['jenis_izin'] == '3') {
                                                                  echo "DINAS MLATI";
                                                                } ?>
                  </td>
                  <td style="white-space: nowrap;"><?php foreach ($nama as $key) {
                    if ($row['atasan_aproval'] == $key['noind']) {
                      echo $key['noind'].' - '.$key['nama'];
                    }
                  } ?></td>
                  <td style="white-space: nowrap;"><?php
                    if (empty($row['tujuan'])) {
                      echo '-';
                    }else {
                      echo $row['tujuan'];
                    }?></td>
                  <td style="white-space: nowrap;"><?php echo $row['keterangan']; ?></td>
                  <td style="text-align: center; white-space: nowrap;"><?php
                        if ($row['status_jalan'] == '0') {
                            echo 'Belum Berangkat';
                        }elseif ($row['status_jalan'] == '-') {
                            echo 'Unapproved';
                        }elseif ($row['status_jalan'] == '5') {
                            echo 'Dinas Belum Selesai <br>Auto Reject';
                        }elseif ($row['status_jalan'] == '1') {
                            echo 'Berangkat 1';
                        }elseif ($row['status_jalan'] == '2') {
                            echo 'Sampai Tujuan';
                        }elseif ($row['status_jalan'] == '3') {
                            echo 'Berangkat 2';
                        }elseif ($row['status_jalan'] == '4') {
                            echo 'Dinas Telah Selesai';
                        } ?></td>
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
