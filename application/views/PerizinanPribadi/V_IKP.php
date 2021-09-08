<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right">
                <h1><b>Approval Atasan</b></h1>
              </div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanPribadi/V_Index'); ?>">
                  <i class="icon-wrench icon-2x"></i>
                  <br />
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="nav-tabs-custom">
                  <div class="row">
                    <div class="col-lg-12">
                      <ul class="nav nav-tabs">
                        <!-- <li class="pull-left header"><i class="fa fa-tag"></i> Approval Perizinan</li> -->
                        <li class="active"><a data-toggle="tab" href="#izin-all">All Perizinan</a></li>
                        <li><a data-toggle="tab" href="#izin-sakit">Izin Sakit</a></li>
                        <li><a data-toggle="tab" href="#izin-dinas">Izin Dinas Keluar</a></li>
                        <li><a data-toggle="tab" href="#izin-pribadi">Izin Keluar Pribadi</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="tab-content" style="border: 1px solid #3c8dbc;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
                    <div id="izin-all" class="tab-pane fade in active">
                      <div class="row">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li><a href="#all-all" data-toggle="tab">All</a></li>
                            <li class="active"><a href="#all-new" data-toggle="tab">New</a></li>
                            <li><a href="#all-approved" data-toggle="tab">Approved</a></li>
                            <li><a href="#all-rejected" data-toggle="tab">Rejected</a></li>
                            <li><a href="#all-expired" data-toggle="tab">Expired</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="tab-content">
                            <div class="tab-pane" id="all-all">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_all table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($izin as $row) {
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane active" id="all-new">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_all table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($izin as $row) {
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="all-approved">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_all table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($izin as $row) {
                                      if($row['appr_atasan'] == 't'){
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="all-rejected">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_all table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($izin as $row) {
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="all-expired">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_all table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($izin as $row) {
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
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
                    <div id="izin-pribadi" class="tab-pane fade">
                      <div class="row">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li class="active"><a href="#pribadi-new" data-toggle="tab">New</a></li>
                            <li><a href="#pribadi-approved" data-toggle="tab">Approved</a></li>
                            <li><a href="#pribadi-rejected" data-toggle="tab">Rejected</a></li>
                            <li><a href="#pribadi-expired" data-toggle="tab">Expired</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="tab-content">
                            <div class="tab-pane active" id="pribadi-new">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_pribadi table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($IzinPribadi as $row) {
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="pribadi-approved">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_pribadi table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($IzinPribadi as $row) {
                                      if($row['appr_atasan'] == 't'){
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="pribadi-rejected">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_pribadi table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($IzinPribadi as $row) {
                                      if($row['appr_atasan'] == 'f'){
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="pribadi-expired">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_pribadi table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($IzinPribadi as $row) {
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
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
                    <div id="izin-dinas" class="tab-pane fade">
                       <div class="row">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li class="active"><a href="#dinas-new" data-toggle="tab">New</a></li>
                            <li><a href="#dinas-approved" data-toggle="tab">Approved</a></li>
                            <li><a href="#dinas-rejected" data-toggle="tab">Rejected</a></li>
                            <li><a href="#dinas-expired" data-toggle="tab">Expired</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="tab-content">
                            <div class="tab-pane active" id="dinas-new">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_dinas table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($IzinDinas as $row) {
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="dinas-approved">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_dinas table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($IzinDinas as $row) {
                                      if($row['appr_atasan'] == 't'){
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="dinas-rejected">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_dinas table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($IzinDinas as $row) {
                                      if($row['appr_atasan'] == 'f'){
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="dinas-expired">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_dinas table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
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
                                    foreach ($IzinDinas as $row) {
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
                                        <td style="white-space: nowrap; text-align: center;"><?php if ($row['back_timestamp'] == '' || $row['back_timestamp'] == null) {
                                                                                                echo '-';
                                                                                              } else {
                                                                                                echo date('H:i:s', strtotime($row['back_timestamp']));
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
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
                    <div id="izin-sakit" class="tab-pane fade">
                      <div class="row">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li class="active"><a href="#sakit-new" data-toggle="tab">New</a></li>
                            <li><a href="#sakit-approved" data-toggle="tab">Approved</a></li>
                            <li><a href="#sakit-rejected" data-toggle="tab">Rejected</a></li>
                            <li><a href="#sakit-expired" data-toggle="tab">Expired</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="tab-content">
                            <div class="tab-pane active" id="sakit-new">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_sakit table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($IzinSakit as $row) {
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
                                        <td style="white-space: nowrap">
                                          <?php $noind = explode(', ', $row['noind']);
                                          foreach ($noind as $na) {
                                            foreach ($nama as $lue) {
                                              if ($na == $lue['noind']) {
                                                echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                              }
                                            }
                                          }  ?>
                                        </td>
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="sakit-approved">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_sakit table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($IzinSakit as $row) {
                                      if($row['appr_atasan'] == 't'){
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
                                        <td style="white-space: nowrap">
                                          <?php $noind = explode(', ', $row['noind']);
                                          foreach ($noind as $na) {
                                            foreach ($nama as $lue) {
                                              if ($na == $lue['noind']) {
                                                echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                              }
                                            }
                                          }  ?>
                                        </td>
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="sakit-rejected">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_sakit table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($IzinSakit as $row) {
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
                                        <td style="white-space: nowrap">
                                          <?php $noind = explode(', ', $row['noind']);
                                          foreach ($noind as $na) {
                                            foreach ($nama as $lue) {
                                              if ($na == $lue['noind']) {
                                                echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                              }
                                            }
                                          }  ?>
                                        </td>
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                        <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                                      </tr>
                                    <?php $no++;
                                      }
                                    } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="tab-pane" id="sakit-expired">
                              <div class="table-responsive-x">
                                <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_sakit table-hover" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th class="text-center" style="white-space: nowrap">No</th>
                                      <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                      <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                      <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                      <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                      <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                                      <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                                      <th class="text-center" style="white-space: nowrap">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no = 1;
                                    foreach ($IzinSakit as $row) {
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
                                        <td style="white-space: nowrap">
                                          <?php $noind = explode(', ', $row['noind']);
                                          foreach ($noind as $na) {
                                            foreach ($nama as $lue) {
                                              if ($na == $lue['noind']) {
                                                echo $lue['noind'] . ' - ' . $lue['nama'] . '<br>';
                                              }
                                            }
                                          }  ?>
                                        </td>
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
                                        <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
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
              <div class="table-responsive-x">
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

    $('.tabel_ikp_all').DataTable({
      scrollX: true,
      fixedColumns: {
        leftColumns: 5,
      }
    });
    $('.tabel_ikp_pribadi').DataTable({
      scrollX: true,
      fixedColumns: {
        leftColumns: 5,
      }
    });
    $('.tabel_ikp_dinas').DataTable({
      scrollX: true,
      fixedColumns: {
        leftColumns: 5,
      }
    });
    $('.tabel_ikp_sakit').DataTable({
      scrollX: true,
      fixedColumns: {
        leftColumns: 5,
      }
    });
  })
</script>