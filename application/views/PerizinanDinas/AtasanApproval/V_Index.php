<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right">
                <h1><b>Approval Perizinan</b></h1>
              </div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="<?= site_url('PerizinanDinas/AtasanApproval/V_Index'); ?>">
                  <i class="icon-wrench icon-2x"></i>
                  <br />
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />
        <?php $today = date('Y-m-d'); ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div class="col-lg-12">
                  <a href="<?= site_url('assets/video/approve_perizinan_dinas.webm'); ?>" class="btn btn-warning col-lg-1"><span style="color: white" class='fa fa-2x fa-video-camera'></a>
                  <marquee class="col-lg-11"><label style="font-size: 18px;">Harap dilakukan verifikasi terlebih dahulu sebelum klik APPROVE</label></marquee>
                </div>
              </div>
              <div class="box-body">
                <style type="text/css">
                  @media only screen and (max-width:  700px){
                    input[type=search] {
                      width: 100% !important;
                    }
                  }

                  @media only screen and (max-width:  1200px){
                    input[type=search] {
                      width: 200px !important;
                    }
                  }
                </style>
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="pull-left header"><i class="fa fa-tag"></i> Approval Perizinan</li>
                  </ul>
                  <ul class="nav nav-tabs pull-right" style="-webkit-text-stroke-width: medium;">
                    <li><a data-toggle="tab" href="#izin-ikp">Izin Keluar Pribadi</a></li>
                    <li><a data-toggle="tab" href="#izin-psp">Izin Sakit Perusahaan</a></li>
                    <li><a data-toggle="tab" href="#izin-pid">Izin Dinas Keluar Perusahaan</a></li>
                    <li><a data-toggle="tab" href="#izin-tmp">Perizinan Dinas Tuksono - Mlati - Pusat</a></li>
                    <li class="active"><a data-toggle="tab" href="#izin-all">All Perizinan Unchecked</a></li>
                  </ul>
                  <div class="tab-content">
                    <div id="izin-all" class="tab-pane fade in active">
                      <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                        <thead style="background-color: #eac718">
                          <tr>
                            <th class="text-center" style="white-space: nowrap; background-color: #eac718">No</th>
                            <th class="text-center" style="white-space: nowrap; background-color: #eac718">Keputusan Anda</th>
                            <th class="text-center" style="white-space: nowrap">ID Izin</th>
                            <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                            <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                            <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                            <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                            <th class="text-center" style="white-space: nowrap">Tujuan</th>
                            <th class="text-center" style="white-space: nowrap">Keterangan</th>
                            <th class="text-center" style="white-space: nowrap">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $no = 1;
                          foreach ($izin as $row) {
                            $id = explode('-', $row['izin_id']);
                            if ($id[0] == 'A') {
                              $onclick = "edit_pkj_dinas($id[1])";
                              $approve = "getApproval('1', $id[1])";
                              $reject = "getApproval('2', $id[1])";
                            } else {
                              $onclick = "edit_pkj_ikp($id[1])";
                              $approve = "getApprovalIKP('1', $id[1], " . $row['jenis_ijin'] . ")";
                              $reject = "getApprovalIKP('0', $id[1], " . $row['jenis_ijin'] . ")";
                            }
                          ?>
                            <tr>
                              <td style="white-space: nowrap; text-align: center;"><?= $no; ?></td>
                              <td style="white-space: nowrap; text-align: center;"><?php if ($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) == $today) { ?>
                                  <button class="btn btn-warning" onclick="<?= $onclick; ?>"><span style="color: white" class='fa fa-edit'></button>
                                  <button class="btn btn-success cm_btn_approve" onclick="<?= $approve; ?>"><span style="color: white" class='fa fa-check'></span></button>
                                  <button class="btn btn-danger cm_btn_reject" onclick="<?= $reject; ?>"><span style="color: white" class='fa fa-close'></span></button>
                                <?php } elseif ($row['status'] == 1) { ?>
                                  <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                <?php } elseif ($row['status'] == 2) { ?>
                                  <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                <?php } elseif (($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) < date('Y-m-d')) || $row['status'] == 5) {  ?>
                                  <span class="fa fa-2x fa-exclamation-circle" style="color: grey"></span>
                                <?php } ?>
                              </td>
                              <td style="white-space: nowrap; text-align: center;"><?= $id[1] ?></td>
                              <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                              <td style="white-space: nowrap; text-align: center;"><?php if ($row['berangkat'] == '' || $row['berangkat'] == null) {
                                                                                      echo '-';
                                                                                    } elseif ($row['berangkat'] < '12:00:00') {
                                                                                      echo date('H:i:s', strtotime($row['berangkat'])) . ' AM';
                                                                                    } else {
                                                                                      echo date('H:i:s', strtotime($row['berangkat'])) . ' PM';
                                                                                    } ?></td>
                              <td style="white-space: nowrap"><?php $pekerja = explode(", ", $row['noind']);
                                                              if (!empty($row['pekerja'][0])) {
                                                                foreach ($row['pekerja'] as $val) {
                                                                  if ($val == null || $val == '') {
                                                                    echo " - <br>";
                                                                  } else {
                                                                    echo $val . '<br>';
                                                                  }
                                                                }
                                                              } else {
                                                                foreach ($pekerja as $val) {
                                                                  if ($val == null || $val == '') {
                                                                    echo " - <br>";
                                                                  } else {
                                                                    foreach ($nama as $nem) {
                                                                      if ($nem['noind'] == $val) {
                                                                        echo $val . ' - ' . $nem['nama'] . '<br>';
                                                                      }
                                                                    }
                                                                  }
                                                                }
                                                              }  ?></td>
                              <td style="white-space: nowrap; text-align: center;"><?= $row['jenis_izin'] ?></td>
                              <td style="white-space: nowrap"><?php foreach ($row['tujuan'] as $key) {
                                                                if ($key == null || $key == '') {
                                                                  echo " - <br>";
                                                                } else {
                                                                  echo $key . '<br>';
                                                                }
                                                              }  ?></td>
                              <td><?= $row['keterangan'] ?></td>
                              <td style="text-align: center;"><?php
                                                              if ($row['status'] == 0 || $row['status'] == 5) { ?>
                                  <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                <?php } elseif ($row['status'] == 1) { ?>
                                  <span class="label label-success">Approved</span>
                                <?php } elseif ($row['status'] == 2) { ?>
                                  <span class="label label-danger">Rejected</span>
                                <?php } ?>
                              </td>
                            </tr>
                          <?php $no++;
                          } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="izin-tmp" class="tab-pane fade in">
                      <div class="row">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li class="active"><a href="#tmp-new" data-toggle="tab">New</a></li>
                            <li><a href="#tmp-approved" data-toggle="tab">Approved</a></li>
                            <li><a href="#tmp-rejected" data-toggle="tab">Rejected</a></li>
                            <li><a href="#tmp-expired" data-toggle="tab">Expired</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="tab-content">
                            <div id="tmp-new" class="tab-pane active">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #3ab338;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #3ab338;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #3ab338;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tujuan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($dinasTMP as $row) {
                                      if ($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) == $today) {
                                    ?>
                                      <tr>
                                        <td style="text-align: center;"><?= $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) == $today) { ?>
                                            <button class="btn btn-warning" onclick="edit_pkj_dinas(<?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-edit'></button>
                                            <button class="btn btn-success cm_btn_approve" onclick="getApproval('1', <?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-check'></span></button>
                                            <button class="btn btn-danger cm_btn_reject" onclick="getApproval('2', <?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-close'></span></button>
                                          <?php } elseif ($row['status'] == 1) { ?>
                                            <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                          <?php } elseif ($row['status'] == 2) { ?>
                                            <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                          <?php } elseif (($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) < date('Y-m-d')) || $row['status'] == 5) {  ?>
                                            <span class="fa fa-2x fa-exclamation-circle" style="color: grey"></span>
                                          <?php } ?>
                                        </td>
                                        <td style="text-align: center;"><?= $row['izin_id'] ?></td>
                                        <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['berangkat'] == '' || $row['berangkat'] == null) {
                                                                                                echo '-';
                                                                                              } elseif ($row['berangkat'] < '12:00:00') {
                                                                                                echo date('H:i:s', strtotime($row['berangkat'])) . ' AM';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['berangkat'])) . ' PM';
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php foreach ($row['pekerja'] as $val) {
                                                                          if ($val == null || $val == '') {
                                                                            echo " - <br>";
                                                                          } else {
                                                                            echo $val . '<br>';
                                                                          }
                                                                        }  ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['jenis_izin'] == '1') {
                                                                                                echo "DINAS PUSAT";
                                                                                              } elseif ($row['jenis_izin'] == '2') {
                                                                                                echo "DINAS TUKSONO";
                                                                                              } elseif ($row['jenis_izin'] == '3') {
                                                                                                echo "DINAS MLATI";
                                                                                              } ?>
                                        </td>
                                        <td style="white-space: nowrap"><?php foreach ($row['tujuan'] as $key) {
                                                                          if ($key == null || $key == '') {
                                                                            echo " - <br>";
                                                                          } else {
                                                                            echo $key . '<br>';
                                                                          }
                                                                        }  ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td style="text-align: center;"><?php if ($row['status'] == 1) { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="tmp-approved" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #3ab338;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #3ab338;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #3ab338;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tujuan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($dinasTMP as $row) {
                                      if($row['status'] == 1){
                                    ?>
                                      <tr>
                                        <td style="text-align: center;"><?= $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) == $today) { ?>
                                            <button class="btn btn-warning" onclick="edit_pkj_dinas(<?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-edit'></button>
                                            <button class="btn btn-success cm_btn_approve" onclick="getApproval('1', <?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-check'></span></button>
                                            <button class="btn btn-danger cm_btn_reject" onclick="getApproval('2', <?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-close'></span></button>
                                          <?php } elseif ($row['status'] == 1) { ?>
                                            <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                          <?php } elseif ($row['status'] == 2) { ?>
                                            <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                          <?php } elseif (($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) < date('Y-m-d')) || $row['status'] == 5) {  ?>
                                            <span class="fa fa-2x fa-exclamation-circle" style="color: grey"></span>
                                          <?php } ?>
                                        </td>
                                        <td style="text-align: center;"><?= $row['izin_id'] ?></td>
                                        <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['berangkat'] == '' || $row['berangkat'] == null) {
                                                                                                echo '-';
                                                                                              } elseif ($row['berangkat'] < '12:00:00') {
                                                                                                echo date('H:i:s', strtotime($row['berangkat'])) . ' AM';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['berangkat'])) . ' PM';
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php foreach ($row['pekerja'] as $val) {
                                                                          if ($val == null || $val == '') {
                                                                            echo " - <br>";
                                                                          } else {
                                                                            echo $val . '<br>';
                                                                          }
                                                                        }  ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['jenis_izin'] == '1') {
                                                                                                echo "DINAS PUSAT";
                                                                                              } elseif ($row['jenis_izin'] == '2') {
                                                                                                echo "DINAS TUKSONO";
                                                                                              } elseif ($row['jenis_izin'] == '3') {
                                                                                                echo "DINAS MLATI";
                                                                                              } ?>
                                        </td>
                                        <td style="white-space: nowrap"><?php foreach ($row['tujuan'] as $key) {
                                                                          if ($key == null || $key == '') {
                                                                            echo " - <br>";
                                                                          } else {
                                                                            echo $key . '<br>';
                                                                          }
                                                                        }  ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td style="text-align: center;"><?php if ($row['status'] == 1) { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="tmp-rejected" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #3ab338;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #3ab338;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #3ab338;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tujuan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($dinasTMP as $row) {
                                      if($row['status'] == 2){
                                    ?>
                                      <tr>
                                        <td style="text-align: center;"><?= $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) == $today) { ?>
                                            <button class="btn btn-warning" onclick="edit_pkj_dinas(<?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-edit'></button>
                                            <button class="btn btn-success cm_btn_approve" onclick="getApproval('1', <?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-check'></span></button>
                                            <button class="btn btn-danger cm_btn_reject" onclick="getApproval('2', <?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-close'></span></button>
                                          <?php } elseif ($row['status'] == 1) { ?>
                                            <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                          <?php } elseif ($row['status'] == 2) { ?>
                                            <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                          <?php } elseif (($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) < date('Y-m-d')) || $row['status'] == 5) {  ?>
                                            <span class="fa fa-2x fa-exclamation-circle" style="color: grey"></span>
                                          <?php } ?>
                                        </td>
                                        <td style="text-align: center;"><?= $row['izin_id'] ?></td>
                                        <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['berangkat'] == '' || $row['berangkat'] == null) {
                                                                                                echo '-';
                                                                                              } elseif ($row['berangkat'] < '12:00:00') {
                                                                                                echo date('H:i:s', strtotime($row['berangkat'])) . ' AM';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['berangkat'])) . ' PM';
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php foreach ($row['pekerja'] as $val) {
                                                                          if ($val == null || $val == '') {
                                                                            echo " - <br>";
                                                                          } else {
                                                                            echo $val . '<br>';
                                                                          }
                                                                        }  ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['jenis_izin'] == '1') {
                                                                                                echo "DINAS PUSAT";
                                                                                              } elseif ($row['jenis_izin'] == '2') {
                                                                                                echo "DINAS TUKSONO";
                                                                                              } elseif ($row['jenis_izin'] == '3') {
                                                                                                echo "DINAS MLATI";
                                                                                              } ?>
                                        </td>
                                        <td style="white-space: nowrap"><?php foreach ($row['tujuan'] as $key) {
                                                                          if ($key == null || $key == '') {
                                                                            echo " - <br>";
                                                                          } else {
                                                                            echo $key . '<br>';
                                                                          }
                                                                        }  ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td style="text-align: center;"><?php if ($row['status'] == 1) { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="tmp-expired" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #3ab338;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #3ab338;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #3ab338;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tujuan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($dinasTMP as $row) {
                                      if(($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) < date('Y-m-d')) || $row['status'] == 5){
                                    ?>
                                      <tr>
                                        <td style="text-align: center;"><?= $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) == $today) { ?>
                                            <button class="btn btn-warning" onclick="edit_pkj_dinas(<?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-edit'></button>
                                            <button class="btn btn-success cm_btn_approve" onclick="getApproval('1', <?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-check'></span></button>
                                            <button class="btn btn-danger cm_btn_reject" onclick="getApproval('2', <?= $row['izin_id']; ?>)"><span style="color: white" class='fa fa-close'></span></button>
                                          <?php } elseif ($row['status'] == 1) { ?>
                                            <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                          <?php } elseif ($row['status'] == 2) { ?>
                                            <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                          <?php } elseif (($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) < date('Y-m-d')) || $row['status'] == 5) {  ?>
                                            <span class="fa fa-2x fa-exclamation-circle" style="color: grey"></span>
                                          <?php } ?>
                                        </td>
                                        <td style="text-align: center;"><?= $row['izin_id'] ?></td>
                                        <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['berangkat'] == '' || $row['berangkat'] == null) {
                                                                                                echo '-';
                                                                                              } elseif ($row['berangkat'] < '12:00:00') {
                                                                                                echo date('H:i:s', strtotime($row['berangkat'])) . ' AM';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['berangkat'])) . ' PM';
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php foreach ($row['pekerja'] as $val) {
                                                                          if ($val == null || $val == '') {
                                                                            echo " - <br>";
                                                                          } else {
                                                                            echo $val . '<br>';
                                                                          }
                                                                        }  ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['jenis_izin'] == '1') {
                                                                                                echo "DINAS PUSAT";
                                                                                              } elseif ($row['jenis_izin'] == '2') {
                                                                                                echo "DINAS TUKSONO";
                                                                                              } elseif ($row['jenis_izin'] == '3') {
                                                                                                echo "DINAS MLATI";
                                                                                              } ?>
                                        </td>
                                        <td style="white-space: nowrap"><?php foreach ($row['tujuan'] as $key) {
                                                                          if ($key == null || $key == '') {
                                                                            echo " - <br>";
                                                                          } else {
                                                                            echo $key . '<br>';
                                                                          }
                                                                        }  ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td style="text-align: center;"><?php if ($row['status'] == 1) { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="izin-ikp" class="tab-pane fade in">
                      <div class="row">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li class="active"><a href="#ikp-new" data-toggle="tab">New</a></li>
                            <li><a href="#ikp-approved" data-toggle="tab">Approved</a></li>
                            <li><a href="#ikp-rejected" data-toggle="tab">Rejected</a></li>
                            <li><a href="#ikp-expired" data-toggle="tab">Expired</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="tab-content">
                            <div id="ikp-new" class="tab-pane active">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #2a9c92;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #2a9c92;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #2a9c92;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($ikp as $row) {
                                      if(!in_array($row['appr_atasan'], array('t','f')) && date('Y-m-d', strtotime($row['created_date'])) == date('Y-m-d')){
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td><?php
                                            if ($row['jenis_ijin'] == '1') {
                                              echo "Izin Keluar Pribadi";
                                            } elseif ($row['jenis_ijin'] == '2') {
                                              echo "Izin Sakit Perusahaan";
                                            } elseif ($row['jenis_ijin'] == '3') {
                                              echo "Izin Keluar Perusahaan";
                                            } else {
                                              echo "Izin Apa -_O ?";
                                            }
                                            ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="ikp-approved" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #2a9c92;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #2a9c92;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #2a9c92;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($ikp as $row) {
                                      if ($row['appr_atasan'] == 't') {
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td><?php
                                            if ($row['jenis_ijin'] == '1') {
                                              echo "Izin Keluar Pribadi";
                                            } elseif ($row['jenis_ijin'] == '2') {
                                              echo "Izin Sakit Perusahaan";
                                            } elseif ($row['jenis_ijin'] == '3') {
                                              echo "Izin Keluar Perusahaan";
                                            } else {
                                              echo "Izin Apa -_O ?";
                                            }
                                            ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="ikp-rejected" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #2a9c92;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #2a9c92;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #2a9c92;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($ikp as $row) {
                                      if ($row['appr_atasan'] == 'f') {
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td><?php
                                            if ($row['jenis_ijin'] == '1') {
                                              echo "Izin Keluar Pribadi";
                                            } elseif ($row['jenis_ijin'] == '2') {
                                              echo "Izin Sakit Perusahaan";
                                            } elseif ($row['jenis_ijin'] == '3') {
                                              echo "Izin Keluar Perusahaan";
                                            } else {
                                              echo "Izin Apa -_O ?";
                                            }
                                            ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="ikp-expired" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #2a9c92;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #2a9c92;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #2a9c92;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($ikp as $row) {
                                      if(!in_array($row['appr_atasan'], array('t','f')) && date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')){
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td><?php
                                            if ($row['jenis_ijin'] == '1') {
                                              echo "Izin Keluar Pribadi";
                                            } elseif ($row['jenis_ijin'] == '2') {
                                              echo "Izin Sakit Perusahaan";
                                            } elseif ($row['jenis_ijin'] == '3') {
                                              echo "Izin Keluar Perusahaan";
                                            } else {
                                              echo "Izin Apa -_O ?";
                                            }
                                            ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="izin-pid" class="tab-pane fade in">
                      <div class="row">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li class="active"><a href="#pid-new" data-toggle="tab">New</a></li>
                            <li><a href="#pid-approved" data-toggle="tab">Approved</a></li>
                            <li><a href="#pid-rejected" data-toggle="tab">Rejected</a></li>
                            <li><a href="#pid-expired" data-toggle="tab">Expired</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="tab-content">
                            <div id="pid-new" class="tab-pane active">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #965ace;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #965ace;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #965ace;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($pid as $row) {
                                      if(!in_array($row['appr_atasan'], array('t','f')) && date('Y-m-d', strtotime($row['created_date'])) == date('Y-m-d')){
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php
                                                                                              if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td>
                                          <?php
                                          if ($row['jenis_ijin'] == '1') {
                                            echo "Izin Keluar Pribadi";
                                          } elseif ($row['jenis_ijin'] == '2') {
                                            echo "Izin Sakit Perusahaan";
                                          } elseif ($row['jenis_ijin'] == '3') {
                                            echo "Izin Keluar Perusahaan";
                                          } else {
                                            echo "Izin Apa -_O ?";
                                          }
                                          ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="pid-approved" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #965ace;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #965ace;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #965ace;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($pid as $row) {
                                      if ($row['appr_atasan'] == 't') {
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php
                                                                                              if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td>
                                          <?php
                                          if ($row['jenis_ijin'] == '1') {
                                            echo "Izin Keluar Pribadi";
                                          } elseif ($row['jenis_ijin'] == '2') {
                                            echo "Izin Sakit Perusahaan";
                                          } elseif ($row['jenis_ijin'] == '3') {
                                            echo "Izin Keluar Perusahaan";
                                          } else {
                                            echo "Izin Apa -_O ?";
                                          }
                                          ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="pid-rejected" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #965ace;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #965ace;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #965ace;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($pid as $row) {
                                      if ($row['appr_atasan'] == 'f') {
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php
                                                                                              if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td>
                                          <?php
                                          if ($row['jenis_ijin'] == '1') {
                                            echo "Izin Keluar Pribadi";
                                          } elseif ($row['jenis_ijin'] == '2') {
                                            echo "Izin Sakit Perusahaan";
                                          } elseif ($row['jenis_ijin'] == '3') {
                                            echo "Izin Keluar Perusahaan";
                                          } else {
                                            echo "Izin Apa -_O ?";
                                          }
                                          ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="pid-expired" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #965ace;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #965ace;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #965ace;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($pid as $row) {
                                      if(!in_array($row['appr_atasan'], array('t','f')) && date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')){
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php
                                                                                              if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td>
                                          <?php
                                          if ($row['jenis_ijin'] == '1') {
                                            echo "Izin Keluar Pribadi";
                                          } elseif ($row['jenis_ijin'] == '2') {
                                            echo "Izin Sakit Perusahaan";
                                          } elseif ($row['jenis_ijin'] == '3') {
                                            echo "Izin Keluar Perusahaan";
                                          } else {
                                            echo "Izin Apa -_O ?";
                                          }
                                          ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="izin-psp" class="tab-pane fade in">
                      <div class="row">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li class="active"><a href="#psp-new" data-toggle="tab">New</a></li>
                            <li><a href="#psp-approved" data-toggle="tab">Approved</a></li>
                            <li><a href="#psp-rejected" data-toggle="tab">Rejected</a></li>
                            <li><a href="#psp-expired" data-toggle="tab">Expired</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="tab-content">
                            <div id="psp-new" class="tab-pane active">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #bf4343;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #bf4343;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #bf4343;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($psp as $row) {
                                      if (!in_array($row['appr_atasan'], array('t','f')) && date('Y-m-d', strtotime($row['created_date'])) == date('Y-m-d')) {
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php
                                                                                              if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td>
                                          <?php
                                          if ($row['jenis_ijin'] == '1') {
                                            echo "Izin Keluar Pribadi";
                                          } elseif ($row['jenis_ijin'] == '2') {
                                            echo "Izin Sakit Perusahaan";
                                          } elseif ($row['jenis_ijin'] == '3') {
                                            echo "Izin Keluar Perusahaan";
                                          } else {
                                            echo "Izin Apa -_O ?";
                                          }
                                          ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="psp-approved" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #bf4343;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #bf4343;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #bf4343;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($psp as $row) {
                                      if ($row['appr_atasan'] == 't') {
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php
                                                                                              if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td>
                                          <?php
                                          if ($row['jenis_ijin'] == '1') {
                                            echo "Izin Keluar Pribadi";
                                          } elseif ($row['jenis_ijin'] == '2') {
                                            echo "Izin Sakit Perusahaan";
                                          } elseif ($row['jenis_ijin'] == '3') {
                                            echo "Izin Keluar Perusahaan";
                                          } else {
                                            echo "Izin Apa -_O ?";
                                          }
                                          ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="psp-rejected" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #bf4343;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #bf4343;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #bf4343;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($psp as $row) {
                                      if ($row['appr_atasan'] == 'f') {
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php
                                                                                              if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td>
                                          <?php
                                          if ($row['jenis_ijin'] == '1') {
                                            echo "Izin Keluar Pribadi";
                                          } elseif ($row['jenis_ijin'] == '2') {
                                            echo "Izin Sakit Perusahaan";
                                          } elseif ($row['jenis_ijin'] == '3') {
                                            echo "Izin Keluar Perusahaan";
                                          } else {
                                            echo "Izin Apa -_O ?";
                                          }
                                          ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div id="psp-expired" class="tab-pane">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-x-xs table-sm table-bordered tabel_perizinan" style="width: 100%">
                                  <thead style="background-color: #bf4343;">
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap; background-color: #bf4343;">No</th>
                                      <th class="text-center" style="white-space: nowrap; background-color: #bf4343;">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Kembali</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($psp as $row) {
                                      if (!in_array($row['appr_atasan'], array('t','f')) && date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) {
                                    ?>
                                      <tr>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php
                                                                                              if ($row['appr_atasan'] == 't') { ?>
                                            <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['appr_atasan'] == 'f') { ?>
                                            <span class="label label-danger">Rejected</span>
                                          <?php } else { ?>
                                            <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                              <span class="label label-default">Expired</span>
                                            <?php } else { ?>
                                              <button class="btn btn-warning" onclick="edit_pkj_ikp(<?php echo $row['id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                              <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-check'></span>
                                              </button>
                                              <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                                <span style="color: white" class='fa fa-close'></span>
                                              </button>
                                            <?php } ?>
                                          <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                                        <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                                                        foreach ($noind as $na) {
                                                                          foreach ($nama as $lue) {
                                                                            if ($na == $lue['noind']) {
                                                                              echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                                                            }
                                                                          }
                                                                        }  ?></td>
                                        <td>
                                          <?php
                                          if ($row['jenis_ijin'] == '1') {
                                            echo "Izin Keluar Pribadi";
                                          } elseif ($row['jenis_ijin'] == '2') {
                                            echo "Izin Sakit Perusahaan";
                                          } elseif ($row['jenis_ijin'] == '3') {
                                            echo "Izin Keluar Perusahaan";
                                          } else {
                                            echo "Izin Apa -_O ?";
                                          }
                                          ?>
                                        </td>
                                        <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['wkt_keluar']));
                                                                                              } ?></td>
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null || ($row['kembali'] == 'f' && $row['back_timestamp'] == '00:00:00')) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                if ($row['kembali'] == 't' && $row['back_timestamp'] == '00:00:00') {
                                                                                                  echo '12:00:00';
                                                                                                } else {
                                                                                                  echo date('H:i:s', strtotime($row['back_timestamp']));
                                                                                                }
                                                                                              } ?></td>
                                        <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                                                          echo "-";
                                                                        } else {
                                                                          $diserahkan = explode(', ', $row['diserahkan']);
                                                                          foreach ($diserahkan as $serahin) {
                                                                            if ($serahin != '-') {
                                                                              foreach ($nama as $lue) {
                                                                                if ($serahin == $lue['noind']) {
                                                                                  echo $serahin . ' - ' . $lue['nama'] . '<br>';
                                                                                }
                                                                              }
                                                                            } else if ($serahin == '-' || $serahin == null) {
                                                                              echo "-<br>";
                                                                            }
                                                                          }
                                                                        } ?></td>
                                        <td><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modal-approve-dinas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close hover" data-dismiss="modal">&times;</button>
        <h3>Approval Perizinan Dinas</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <form class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-4">ID Dinas :</label>
                <div class="col-md-6">
                  <input class="form-control" name="id_dinas" id="modal-id_dinas" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Tanggal :</label>
                <div class="col-md-6">
                  <input class="form-control" name="tgl_dinas" id="modal-tgl_dinas" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Akan Keluar :</label>
                <div class="col-md-6">
                  <input class="form-control" name="keluar_dinas" id="modal-keluar_dinas" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Keperluan :</label>
                <div class="col-md-6">
                  <textarea class="form-control" name="kep_dinas" id="modal-kep_dinas" readonly></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-12">
                  <div class="table-responsive">
                    <table border="1" width="500px" style="margin: 0 auto;">
                      <thead>
                        <th style="text-align: center; white-space: nowrap;"><input type="checkbox" id="checkAll_edit"></th>
                        <th style="text-align: center; white-space: nowrap;">No. Induk</th>
                        <th style="text-align: center; white-space: nowrap;">Nama</th>
                        <th style="text-align: center; white-space: nowrap;">Tujuan</th>
                      </thead>
                      <tbody class="eachPekerjaEdit">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="text-align: center;">
        <div>
          <button type="button" class="btn btn-success" id="app_edit_Dinas" value="1">Approve</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal IKP -->
<div class="modal fade" id="modal-approve-ikp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close hover" data-dismiss="modal">&times;</button>
        <h3>Approval Perizinan Pribadi</h3>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-md-4">ID IKP :</label>
            <div class="col-md-6">
              <input class="form-control" name="id_ikp" id="modal-id_ikp" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Tanggal :</label>
            <div class="col-md-6">
              <input class="form-control" name="tgl_ikp" id="modal-tgl_ikp" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Akan Keluar :</label>
            <div class="col-md-6">
              <input class="form-control" name="keluar_ikp" id="modal-keluar_ikp" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Keperluan :</label>
            <div class="col-md-6">
              <input class="form-control"  name="kep_ikp" id="modal-kep_ikp" readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table border="1" width="500px" style="margin: 0 auto;">
                  <thead>
                    <th style="text-align: center; white-space: nowrap;"><input type="checkbox" id="checkAll_edit_ikp"></th>
                    <th style="text-align: center; white-space: nowrap;">No. Induk</th>
                    <th style="text-align: center; white-space: nowrap;">Nama</th>
                  </thead>
                  <tbody class="eachPekerjaEditIKP"></tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="text-align: center;">
        <div>
          <button type="button" class="btn btn-success" id="app_edit_ikp" value="1">Approve</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- selesai -->
<script type="text/javascript">
  $(document).ready(function() {

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      $.fn.dataTable.tables({
        api: true
      }).columns.adjust();
      setTimeout(
        function() {
          $('th:contains(No)').click()
        }, 200
      )
    });

    if(document.body.clientWidth >= 1000){
      $('.tabel_perizinan').DataTable({
        scrollX: true,
        fixedColumns: {
          leftColumns: 2,
        }
      });
    }else{
      $('.tabel_perizinan').DataTable({
        scrollX: true,
      });
    }

  })
</script>