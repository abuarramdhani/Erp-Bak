<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Perizinan Dinas Keluar</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanDinas/AtasanApproval/V_Index');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                 <div class="row" style="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <div>
                                    <marquee><label style="font-size: 18px;">Harap dilakukan verifikasi terlebih dahulu sebelum klik APPROVE</label></marquee>
                                </div>
                            </div>
                            <div class="box-body">
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs pull-right">
                                <li class="pull-left header"><i class="fa fa-tag"></i> Approval Izin Dinas</li>
                                <li><a data-toggle="tab" href="#izin-reject">Rejected Izin</a></li>
                                <li><a data-toggle="tab" href="#izin-ok">Approved Izin</a></li>
                                <li><a data-toggle="tab" href="#izin-check">Uncheck izin</a></li>
                                <li class="active"><a data-toggle="tab" href="#izin-all">All Izin</a></li>
                              </ul>
                              <div class="tab-content">
                              <div id="izin-all" class="tab-pane fade in active">
                              <table class="table table-responsive-xs table-sm table-bordered tabel_izin_dinas_all" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center" style="white-space: nowrap">No</th>
                                    <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                    <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
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
                                    ?>
                                    <tr>
                                      <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                      <td style="white-space: nowrap; text-align: center;"><?php  if ($row['status'] == 0) { ?>
                                            <button class="btn btn-warning" onclick="edit_pkj_dinas(<?php echo $row['izin_id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                            <button class="btn btn-success cm_btn_approve" onclick="getApproval('1', <?php echo $row['izin_id'] ?>)" ><span style="color: white" class='fa fa-check'></span></button>
                                            <button class="btn btn-danger cm_btn_reject" onclick="getApproval('2', <?php echo $row['izin_id'] ?>)"><span style="color: white" class='fa fa-close'></span></button>
                                           <?php }elseif ($row['status'] == 1) { ?>
                                                  <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                           <?php }elseif ($row['status'] == 2) { ?>
                                                  <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                           <?php } ?>
                                                </td>
                                      <td style="white-space: nowrap; text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                      <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                      foreach ($noind as $na) {
                                        foreach ($nama as $lue) {
                                          if ($na == $lue['noind']) {
                                            echo $lue['noind'].' - '.$lue['nama'].'<br>';
                                          }
                                        }
                                      }  ?></td>
                                      <td style="white-space: nowrap; text-align: center;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="white-space: nowrap"><?php if ($row['tujuan'] == null || $row['tujuan'] == '') {
                                                                          echo " - ";
                                                                        }else {
                                                                          echo $row['tujuan'];
                                                                        }  ?></td>
                                      <td style="white-space: nowrap"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center;"><?php
                                            if ($row['status'] == 0) { ?>
                                                <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                            <?php } elseif ($row['status'] == 1) { ?>
                                                 <span class="label label-success">Approved</span>
                                            <?php } elseif ($row['status'] == 2) { ?>
                                                <span class="label label-danger">Rejected</span>
                                            <?php } ?>
                                      </td>
                                    </tr>
                                    <?php $no++; } ?>
                                </tbody>
                              </table>
                              </div>

                              <div id="izin-ok" class="tab-pane fade in">
                              <table class="table table-responsive-xs table-sm table-bordered tabel_izin_dinas_approve" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center" style="white-space: nowrap">No</th>
                                    <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                    <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                    <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                    <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Tujuan</th>
                                    <th class="text-center" style="white-space: nowrap">Keterangan</th>
                                    <th class="text-center" style="white-space: nowrap">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($IzinApprove as $row) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center;"><?php echo $no; ?></td>
                                      <td style="text-align: center;"><?php if ($row['status'] == 1) { ?>
                                              <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                       <?php } ?>
                                            </td>
                                      <td style="text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                     <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                     foreach ($noind as $na) {
                                       foreach ($nama as $lue) {
                                         if ($na == $lue['noind']) {
                                           echo $lue['noind'].' - '.$lue['nama'].'<br>';
                                         }
                                       }
                                     }  ?></td>
                                      <td style="white-space: nowrap; text-align: center;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="white-space: nowrap"><?php if ($row['tujuan'] == null || $row['tujuan'] == '') {
                                                                          echo " - ";
                                                                        }else {
                                                                          echo $row['tujuan'];
                                                                        }  ?></td>
                                      <td style="white-space: nowrap"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center;"><?php
                                              if ($row['status'] == 0) { ?>
                                                  <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                              <?php } elseif ($row['status'] == 1) { ?>
                                                   <span class="label label-success">Approved</span>
                                              <?php } elseif ($row['status'] == 2) { ?>
                                                  <span class="label label-danger">Rejected</span>
                                              <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $no++; } ?>
                                </tbody>
                              </table>
                              </div>

                              <div id="izin-check" class="tab-pane fade in">
                              <table class="table table-responsive-xs table-sm table-bordered tabel_izin_dinas_check" style="width: 100%">
                                <thead>
                                   <tr>
                                    <th class="text-center" style="white-space: nowrap">No</th>
                                    <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                    <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                    <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                    <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Tujuan</th>
                                    <th class="text-center" style="white-space: nowrap">Keterangan</th>
                                    <th class="text-center" style="white-space: nowrap">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($IzinUnApprove as $row) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center;"><?php echo $no; ?></td>
                                      <td style="text-align: center; "><?php  if ($row['status'] == 0) { ?>
                                        <button class="btn btn-warning" onclick="edit_pkj_dinas(<?php echo $row['izin_id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                        <button class="btn btn-success cm_btn_approve" onclick="getApproval('1', <?php echo $row['izin_id'] ?>)" ><span style="color: white" class='fa fa-check'></span></button>
                                        <button class="btn btn-danger cm_btn_reject" onclick="getApproval('2', <?php echo $row['izin_id'] ?>)"><span style="color: white" class='fa fa-close'></span></button>
                                       <?php }elseif ($row['status'] == 1) { ?>
                                              <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                       <?php }elseif ($row['status'] == 2) { ?>
                                              <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                         <?php } ?>
                                            </td>
                                      <td style="text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                      <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                      foreach ($noind as $na) {
                                        foreach ($nama as $lue) {
                                          if ($na == $lue['noind']) {
                                            echo $lue['noind'].' - '.$lue['nama'].'<br>';
                                          }
                                        }
                                      }  ?></td>
                                     <td style="white-space: nowrap; text-align: center;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="white-space: nowrap"><?php if ($row['tujuan'] == null || $row['tujuan'] == '') {
                                                                          echo " - ";
                                                                        }else {
                                                                          echo $row['tujuan'];
                                                                        }  ?></td>
                                      <td style="white-space: nowrap"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center;"><?php
                                              if ($row['status'] == 0) { ?>
                                                  <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                              <?php } elseif ($row['status'] == 1) { ?>
                                                   <span class="label label-success">Approved</span>
                                              <?php } elseif ($row['status'] == 2) { ?>
                                                  <span class="label label-danger">Rejected</span>
                                              <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $no++; } ?>
                                </tbody>
                              </table>
                              </div>
                              <div id="izin-reject" class="tab-pane fade in">
                              <table class="table table-responsive-xs table-sm table-bordered tabel_izin_dinas_reject" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center" style="white-space: nowrap">No</th>
                                    <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                    <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                    <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                    <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Tujuan</th>
                                    <th class="text-center" style="white-space: nowrap">Keterangan</th>
                                    <th class="text-center" style="white-space: nowrap">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($IzinReject as $row) {
                                    ?>
                                   <tr>
                                      <td style="text-align: center;"><?php echo $no; ?></td>
                                      <td style="text-align: center;"><?php if ($row['status'] == 2) { ?>
                                              <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                         <?php } ?>
                                            </td>
                                      <td style="text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                      <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                          foreach ($noind as $na) {
                                            foreach ($nama as $lue) {
                                              if ($na == $lue['noind']) {
                                                echo $lue['noind'].' - '.$lue['nama'].'<br>';
                                              }
                                            }
                                          }  ?></td>
                                      <td style="white-space: nowrap; text-align: center;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="white-space: nowrap"><?php if ($row['tujuan'] == null || $row['tujuan'] == '') {
                                                                          echo " - ";
                                                                        }else {
                                                                          echo $row['tujuan'];
                                                                        }  ?></td>
                                      <td style="white-space: nowrap"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center;">
                                          <?php
                                            if ($row['status'] == 0) { ?>
                                              <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                          <?php } elseif ($row['status'] == 1) { ?>
                                               <span class="label label-success">Approved</span>
                                          <?php } elseif ($row['status'] == 2) { ?>
                                              <span class="label label-danger">Rejected</span>
                                          <?php } ?>
                                      </td>
                                    </tr>
                                    <?php $no++; } ?>
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
</section>

<!-- Modal -->
<div class="modal fade" id="modal-approve-dinas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 600px">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close hover" data-dismiss="modal">&times;</button>
        <h3>Approval Perizinan Dinas</h3>
      </div>
      <div class="modal-body" style="width: 100%; text-align: center;">
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">ID Dinas</label><label class="col-lg-1">:</label>
            <input  class="form-control col-lg-8" name="id_dinas" id="modal-id_dinas" readonly  style="width: 55%">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">Tanggal</label><label class="col-lg-1">:</label>
            <input  class="form-control col-lg-8" name="tgl_dinas" id="modal-tgl_dinas" readonly  style="width: 55%">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">Keperluan</label><label class="col-lg-1">:</label>
            <textarea class="form-control col-lg-8" name="kep_dinas" id="modal-kep_dinas" readonly  style="width: 55%"></textarea>
          </div>
        </div>
        <br>
        <div class="row">
            <table border="1" width="500px" style="margin-left: 50px;">
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
        <br>
          <div class="modal-footer" style="text-align: center;">
            <div>
              <button type="button" class="btn btn-success" id="app_edit_Dinas" value="1">Approve</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>

<!-- selesai -->
<script type="text/javascript">
  $(document).ready(function () {

    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( { api: true} ).columns.adjust();
        setTimeout(
          function () {
            $('th:contains(No)').click()
          }, 200
        )
    } );

    $('.tabel_izin_dinas_all').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 5,
      }
    });
    $('.tabel_izin_dinas_approve').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 5,
      }
    });
    $('.tabel_izin_dinas_check').DataTable();
    $('.tabel_izin_dinas_reject').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 5,
      }
    });
  })
</script>
